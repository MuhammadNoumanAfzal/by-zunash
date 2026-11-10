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

        // 30 Most recent audit trail records
        $auditLogs = \App\Models\InventoryLog::latest()->take(30)->get();

        // Low stock run-out forecast predictions
        $predictions = Product::where('stock_quantity', '<=', 8)
            ->where('availability', '!=', 'on_demand')
            ->orderBy('stock_quantity', 'asc')
            ->take(6)
            ->get()
            ->map(function ($p) {
                $dailyRate = $p->price > 10000 ? 0.5 : 1.2;
                $runoutDays = max(1, round($p->stock_quantity / $dailyRate));
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'stock' => $p->stock_quantity,
                    'runout_days' => $runoutDays,
                    'urgency' => $runoutDays <= 3 ? 'CRITICAL' : 'MODERATE',
                ];
            });

        return view('admin.inventory.index', compact(
            'products',
            'categories',
            'totalInventory',
            'lowStockCount',
            'outOfStockCount',
            'onDemandCount',
            'totalSkus',
            'filter',
            'auditLogs',
            'predictions'
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
            'reason' => 'nullable|string|max:255',
        ]);

        $prevStock = $product->stock_quantity;
        $newStock = $validated['stock_quantity'];
        $diff = $newStock - $prevStock;

        $product->stock_quantity = $newStock;
        
        if (!empty($validated['availability'])) {
            $product->availability = $validated['availability'];
        } else {
            if ($newStock == 0 && $product->availability !== 'on_demand') {
                $product->availability = 'out_of_stock';
            } elseif ($newStock > 0 && $product->availability === 'out_of_stock') {
                $product->availability = 'in_stock';
            }
        }

        if ($request->has('lead_time')) {
            $product->lead_time = trim($request->input('lead_time')) ?: null;
        }

        $product->in_stock = ($product->stock_quantity > 0) && ($product->availability !== 'out_of_stock');
        $product->save();

        // Create Stock History Audit Log
        $adminName = auth('admin')->check() ? auth('admin')->user()->name : 'Admin Atelier';
        $reason = $validated['reason'] ?? null;

        if (empty($reason)) {
            if ($diff > 0) {
                $reason = "Admin {$adminName} restocked: +{$diff}";
            } elseif ($diff < 0) {
                $reason = "Admin {$adminName} adjusted stock: {$diff}";
            } elseif ($product->availability === 'on_demand') {
                $reason = "Switched to Made-to-Order ({$product->lead_time})";
            } else {
                $reason = "Admin {$adminName} updated availability status";
            }
        }

        \App\Models\InventoryLog::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'sku' => $product->sku,
            'admin_name' => $adminName,
            'change_type' => $diff > 0 ? 'restock' : ($diff < 0 ? 'manual_adjustment' : 'status_update'),
            'quantity_change' => $diff,
            'previous_stock' => $prevStock,
            'new_stock' => $newStock,
            'reason' => $reason,
        ]);

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

    /**
     * 1-Click Switch Out-of-Stock product to Bespoke / Made-to-Order with custom lead time.
     */
    public function switchBespoke(Request $request, Product $product)
    {
        $validated = $request->validate([
            'lead_time' => 'required|string|max:100',
        ]);

        $adminName = auth('admin')->check() ? auth('admin')->user()->name : 'Admin Atelier';

        $product->update([
            'availability' => 'on_demand',
            'in_stock' => true,
            'lead_time' => $validated['lead_time'],
        ]);

        \App\Models\InventoryLog::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'sku' => $product->sku,
            'admin_name' => $adminName,
            'change_type' => 'bespoke_switch',
            'quantity_change' => 0,
            'previous_stock' => $product->stock_quantity,
            'new_stock' => $product->stock_quantity,
            'reason' => "Switched to Made-to-Order (Lead Time: {$validated['lead_time']})",
        ]);

        return back()->with('toast_success', "Product '{$product->name}' switched to Made-to-Order ({$validated['lead_time']}).");
    }
}
