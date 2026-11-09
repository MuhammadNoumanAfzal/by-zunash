<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Inventory & Stock Management View
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category_slug', $request->input('category'));
        }

        // Status filter: all, low, out, on_demand, adequate
        $filter = $request->input('status', 'all');
        if ($filter === 'low') {
            $query->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0);
        } elseif ($filter === 'out') {
            $query->where('stock_quantity', '<=', 0);
        } elseif ($filter === 'on_demand') {
            $query->where('availability', 'on_demand');
        } elseif ($filter === 'adequate') {
            $query->where('stock_quantity', '>', 5);
        }

        $products = $query->orderBy('stock_quantity', 'asc')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        $totalInventory = Product::sum('stock_quantity');
        $lowStockCount = Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();
        $onDemandCount = Product::where('availability', 'on_demand')->count();
        $totalSkus = Product::count();

        return view('admin.inventory.index', compact(
            'products',
            'categories',
            'totalInventory',
            'lowStockCount',
            'outOfStockCount',
            'onDemandCount',
            'totalSkus',
            'filter'
        ));
    }

    /**
     * Fast AJAX/Form Stock Quantity & Availability Update
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
            'availability' => 'nullable|string|in:in_stock,on_demand,out_of_stock',
            'lead_time' => 'nullable|string|max:100',
        ]);

        $product->stock_quantity = $validated['stock_quantity'];
        
        if (!empty($validated['availability'])) {
            $product->availability = $validated['availability'];
        } else {
            if ($validated['stock_quantity'] == 0 && $product->availability !== 'on_demand') {
                $product->availability = 'out_of_stock';
            } elseif ($validated['stock_quantity'] > 0 && $product->availability === 'out_of_stock') {
                $product->availability = 'in_stock';
            }
        }

        if ($request->has('lead_time')) {
            $product->lead_time = trim($request->input('lead_time')) ?: null;
        }

        $product->in_stock = ($product->stock_quantity > 0) && ($product->availability !== 'out_of_stock');
        $product->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Stock and availability for '{$product->name}' updated.",
                'stock' => $product->stock_quantity,
                'availability' => $product->availability,
                'lead_time' => $product->lead_time,
                'in_stock' => $product->in_stock,
            ]);
        }

        return back()->with('toast_success', "Inventory status for '{$product->name}' updated successfully.");
    }
}
