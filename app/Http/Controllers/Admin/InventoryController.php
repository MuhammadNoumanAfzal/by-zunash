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

        // Status filter: all, low, out, adequate
        $filter = $request->input('status', 'all');
        if ($filter === 'low') {
            $query->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0);
        } elseif ($filter === 'out') {
            $query->where('stock_quantity', '<=', 0);
        } elseif ($filter === 'adequate') {
            $query->where('stock_quantity', '>', 5);
        }

        $products = $query->orderBy('stock_quantity', 'asc')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        $totalInventory = Product::sum('stock_quantity');
        $lowStockCount = Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();
        $totalSkus = Product::count();

        return view('admin.inventory.index', compact(
            'products',
            'categories',
            'totalInventory',
            'lowStockCount',
            'outOfStockCount',
            'totalSkus',
            'filter'
        ));
    }

    /**
     * Fast AJAX/Form Stock Quantity Update
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product->stock_quantity = $validated['stock_quantity'];
        $product->in_stock = $validated['stock_quantity'] > 0;
        if ($validated['stock_quantity'] == 0 && $product->availability !== 'on_demand') {
            $product->availability = 'out_of_stock';
        } elseif ($validated['stock_quantity'] > 0 && $product->availability === 'out_of_stock') {
            $product->availability = 'in_stock';
        }
        $product->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Stock updated to {$product->stock_quantity} units.",
                'stock' => $product->stock_quantity,
                'in_stock' => $product->in_stock,
            ]);
        }

        return back()->with('toast_success', "Stock for {$product->name} updated to {$product->stock_quantity} units.");
    }
}
