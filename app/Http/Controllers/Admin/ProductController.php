<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products with rich search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search query
        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('category_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category_slug', $request->input('category'));
        }

        // Stock status filter
        if ($request->filled('stock')) {
            $stock = $request->input('stock');
            if ($stock === 'in_stock') {
                $query->where('in_stock', true)->where('stock_quantity', '>', 5);
            } elseif ($stock === 'low_stock') {
                $query->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0);
            } elseif ($stock === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($stock === 'on_demand') {
                $query->where('availability', 'on_demand');
            }
        }

        // Badge filter
        if ($request->filled('badge') && $request->input('badge') !== 'all') {
            $b = $request->input('badge');
            if ($b === 'bestseller') {
                $query->where('is_bestseller', true);
            } elseif ($b === 'new') {
                $query->where('is_new', true);
            }
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'stock_low':
                $query->orderBy('stock_quantity', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // Key stats for top pills
        $totalCount = Product::count();
        $activeCount = Product::where('in_stock', true)->count();
        $lowStockCount = Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'totalCount',
            'activeCount',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_slug' => 'required|string|exists:categories,slug',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'badge' => 'nullable|string|max:50',
            'is_bestseller' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'availability' => 'required|string|in:in_stock,out_of_stock,on_demand',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        $category = Category::where('slug', $validated['category_slug'])->first();

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $sku = $validated['sku'] ?: ('BZ-' . strtoupper(substr($validated['category_slug'], 0, 3)) . '-' . rand(100, 999));

        Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $category?->id,
            'category_slug' => $validated['category_slug'],
            'category_name' => $category?->name,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'sku' => $sku,
            'badge' => $validated['badge'] ?? null,
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_new' => $request->boolean('is_new'),
            'in_stock' => $validated['stock_quantity'] > 0 && $validated['availability'] !== 'out_of_stock',
            'availability' => $validated['availability'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'] ?? $validated['short_description'],
            'image' => $validated['image'] ?: '/images/products/prod-reversible-belt.jpg',
            'gallery' => [$validated['image'] ?: '/images/products/prod-reversible-belt.jpg'],
            'rating' => 5.0,
            'reviews_count' => 0,
        ]);

        return redirect()->route('admin.products.index')
            ->with('toast_success', "Product '{$validated['name']}' has been added to the atelier catalogue.");
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_slug' => 'required|string|exists:categories,slug',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'badge' => 'nullable|string|max:50',
            'is_bestseller' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'availability' => 'required|string|in:in_stock,out_of_stock,on_demand',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        $category = Category::where('slug', $validated['category_slug'])->first();

        $product->update([
            'name' => $validated['name'],
            'category_id' => $category?->id,
            'category_slug' => $validated['category_slug'],
            'category_name' => $category?->name,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'sku' => $validated['sku'] ?: $product->sku,
            'badge' => $validated['badge'] ?? null,
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_new' => $request->boolean('is_new'),
            'in_stock' => $validated['stock_quantity'] > 0 && $validated['availability'] !== 'out_of_stock',
            'availability' => $validated['availability'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'] ?? $product->description,
            'image' => $validated['image'] ?: $product->image,
        ]);

        return redirect()->route('admin.products.index')
            ->with('toast_success', "Product '{$product->name}' updated successfully.");
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('toast_success', "Product '{$name}' removed from catalogue.");
    }
}
