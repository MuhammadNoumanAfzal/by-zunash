<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Unified Admin Search Page
     */
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $products = collect();
        $orders = collect();
        $categories = collect();
        $subcategories = collect();
        $customers = collect();

        if ($query !== '') {
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->orWhere('category_name', 'like', "%{$query}%")
                ->latest()
                ->take(12)
                ->get();

            $orders = Order::where('order_number', 'like', "%{$query}%")
                ->orWhere('customer_name', 'like', "%{$query}%")
                ->orWhere('customer_email', 'like', "%{$query}%")
                ->orWhere('customer_phone', 'like', "%{$query}%")
                ->orWhere('city', 'like', "%{$query}%")
                ->latest()
                ->take(12)
                ->get();

            $categories = Category::where('name', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->latest()
                ->take(8)
                ->get();

            $subcategories = Subcategory::with('category')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->latest()
                ->take(8)
                ->get();

            $customers = Customer::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('city', 'like', "%{$query}%")
                ->latest()
                ->take(8)
                ->get();
        }

        $totalMatches = $products->count() + $orders->count() + $categories->count() + $subcategories->count() + $customers->count();

        return view('admin.search', compact('query', 'products', 'orders', 'categories', 'subcategories', 'customers', 'totalMatches'));
    }

    /**
     * Live Ajax Autocomplete Search
     */
    public function live(Request $request)
    {
        $query = trim($request->input('q', ''));

        if ($query === '' || strlen($query) < 1) {
            return response()->json([
                'products' => [],
                'orders' => [],
                'categories' => [],
                'customers' => [],
                'total' => 0
            ]);
        }

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->orWhere('category_name', 'like', "%{$query}%")
            ->orWhere('category_slug', 'like', "%{$query}%")
            ->orWhere('badge', 'like', "%{$query}%")
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'category' => $p->category_name ?: ucfirst($p->category_slug),
                    'price' => 'Rs. ' . number_format($p->price),
                    'image' => $p->image ?: '/images/products/prod-reversible-belt.jpg',
                    'stock' => $p->stock_quantity,
                    'url' => route('admin.products.edit', $p->id),
                ];
            });

        $orders = Order::where('order_number', 'like', "%{$query}%")
            ->orWhere('customer_name', 'like', "%{$query}%")
            ->orWhere('customer_email', 'like', "%{$query}%")
            ->orWhere('customer_phone', 'like', "%{$query}%")
            ->orWhere('city', 'like', "%{$query}%")
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($o) {
                return [
                    'id' => $o->id,
                    'order_number' => $o->order_number,
                    'customer' => $o->customer_name,
                    'city' => $o->city,
                    'total' => 'Rs. ' . number_format($o->total),
                    'status' => ucfirst($o->order_status ?? 'pending'),
                    'url' => route('admin.orders.show', $o->id),
                ];
            });

        $categories = Category::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'slug' => $c->slug,
                    'url' => route('admin.categories.index', ['q' => $c->name]),
                ];
            });

        $subcategories = Subcategory::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'category' => $s->category?->name ?? 'Collection',
                    'url' => route('admin.subcategories.index', ['q' => $s->name]),
                ];
            });

        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'email' => $c->email,
                    'phone' => $c->phone,
                    'url' => route('admin.customers.index', ['q' => $c->email]),
                ];
            });

        $total = $products->count() + $orders->count() + $categories->count() + $subcategories->count() + $customers->count();

        return response()->json([
            'products' => $products,
            'orders' => $orders,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'customers' => $customers,
            'total' => $total,
        ]);
    }
}
