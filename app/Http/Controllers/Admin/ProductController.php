<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products with rich search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory']);

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
        $subcategories = Subcategory::with('category')->orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'category_slug' => 'nullable|string',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'badge' => 'nullable|string|max:50',
            'is_bestseller' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'availability' => 'nullable|string|in:in_stock,out_of_stock,on_demand',
            'lead_time' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,avif|max:5120',
            'gallery_raw' => 'nullable|string',
            'features_raw' => 'nullable|string',
            'colors_json' => 'nullable|string',
            'spec_material' => 'nullable|string|max:255',
            'spec_hardware' => 'nullable|string|max:255',
            'spec_dimensions' => 'nullable|string|max:255',
            'spec_sizes' => 'nullable|string|max:255',
            'spec_care' => 'nullable|string|max:255',
        ]);

        $category = null;
        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
        } elseif (!empty($validated['category_slug'])) {
            $category = Category::where('slug', $validated['category_slug'])->first();
        }

        if (!$category) {
            $category = Category::first();
        }

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $availability = $validated['availability'] ?? ($validated['stock_quantity'] > 0 ? 'in_stock' : 'out_of_stock');
        $sku = !empty($validated['sku']) ? $validated['sku'] : ('BZ-' . strtoupper(substr($category->slug, 0, 3)) . '-' . rand(100, 999));
        $primaryImage = !empty($validated['image']) ? $validated['image'] : '/images/products/prod-reversible-belt.jpg';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'prod-' . $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('images/products');
            if (!file_exists($destDir)) {
                @mkdir($destDir, 0755, true);
            }
            $file->move($destDir, $filename);
            $primaryImage = '/images/products/' . $filename;
        }

        $leadTime = !empty($validated['lead_time']) ? trim($validated['lead_time']) : null;
        if ($availability === 'on_demand' && empty($leadTime)) {
            $leadTime = '7–10 Working Days';
        }

        $colors = $this->parseColors($request);
        $features = $this->parseFeatures($request);
        $specifications = $this->parseSpecifications($request);
        $gallery = $this->parseGallery($request, $primaryImage);

        Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'category_id' => $category->id,
            'category_slug' => $category->slug,
            'category_name' => $category->name,
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'sku' => $sku,
            'badge' => $validated['badge'] ?? null,
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_new' => $request->boolean('is_new'),
            'in_stock' => $validated['stock_quantity'] > 0 && $availability !== 'out_of_stock',
            'availability' => $availability,
            'lead_time' => $leadTime,
            'short_description' => $validated['short_description'],
            'description' => !empty($validated['description']) ? $validated['description'] : $validated['short_description'],
            'image' => $primaryImage,
            'gallery' => $gallery,
            'colors' => $colors,
            'features' => $features,
            'specifications' => $specifications,
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
        $subcategories = Subcategory::with('category')->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'category_slug' => 'nullable|string',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'badge' => 'nullable|string|max:50',
            'is_bestseller' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'availability' => 'nullable|string|in:in_stock,out_of_stock,on_demand',
            'lead_time' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,avif|max:5120',
            'gallery_raw' => 'nullable|string',
            'features_raw' => 'nullable|string',
            'colors_json' => 'nullable|string',
            'spec_material' => 'nullable|string|max:255',
            'spec_hardware' => 'nullable|string|max:255',
            'spec_dimensions' => 'nullable|string|max:255',
            'spec_sizes' => 'nullable|string|max:255',
            'spec_care' => 'nullable|string|max:255',
        ]);

        $category = null;
        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
        } elseif (!empty($validated['category_slug'])) {
            $category = Category::where('slug', $validated['category_slug'])->first();
        }

        if (!$category) {
            $category = $product->category ?: Category::first();
        }

        $availability = $validated['availability'] ?? ($validated['stock_quantity'] > 0 ? 'in_stock' : 'out_of_stock');
        $primaryImage = !empty($validated['image']) ? $validated['image'] : $product->image;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'prod-' . $product->slug . '-' . time() . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('images/products');
            if (!file_exists($destDir)) {
                @mkdir($destDir, 0755, true);
            }
            $file->move($destDir, $filename);
            $primaryImage = '/images/products/' . $filename;
        }

        $leadTime = !empty($validated['lead_time']) ? trim($validated['lead_time']) : $product->lead_time;
        if ($availability === 'on_demand' && empty($leadTime)) {
            $leadTime = '7–10 Working Days';
        }

        $colors = $this->parseColors($request, $product->colors);
        $features = $this->parseFeatures($request, $product->features);
        $specifications = $this->parseSpecifications($request, $product->specifications);
        $gallery = $this->parseGallery($request, $primaryImage, $product->gallery);

        $product->update([
            'name' => $validated['name'],
            'category_id' => $category?->id,
            'category_slug' => $category?->slug,
            'category_name' => $category?->name,
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? $product->original_price,
            'stock_quantity' => $validated['stock_quantity'],
            'sku' => !empty($validated['sku']) ? $validated['sku'] : $product->sku,
            'badge' => $validated['badge'] ?? $product->badge,
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_new' => $request->boolean('is_new'),
            'in_stock' => $validated['stock_quantity'] > 0 && $availability !== 'out_of_stock',
            'availability' => $availability,
            'lead_time' => $leadTime,
            'short_description' => $validated['short_description'],
            'description' => !empty($validated['description']) ? $validated['description'] : $product->description,
            'image' => $primaryImage,
            'gallery' => $gallery,
            'colors' => $colors,
            'features' => $features,
            'specifications' => $specifications,
        ]);

        return redirect()->route('admin.products.index')
            ->with('toast_success', "Product '{$product->name}' updated successfully.");
    }

    /**
     * Parse leather tone colors from request.
     */
    protected function parseColors(Request $request, ?array $fallback = null): array
    {
        if ($request->filled('colors_json')) {
            $decoded = json_decode($request->input('colors_json'), true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        if ($request->has('preset_colors') && is_array($request->input('preset_colors'))) {
            $presets = [
                'Espresso & Obsidian Black' => '#24160F',
                'Cognac Tan & Coffee' => '#A87548',
                'Midnight Espresso' => '#120E0C',
                'Oxblood Burgundy' => '#581825',
                'Saddle Brown' => '#5D3A1A',
                'Antique Gold' => '#C5A16B',
                'Classic Black' => '#0D0A09',
            ];
            $colors = [];
            foreach ($request->input('preset_colors') as $cName) {
                if (isset($presets[$cName])) {
                    $colors[] = ['name' => $cName, 'hex' => $presets[$cName], 'stock' => true];
                }
            }
            if (!empty($colors)) {
                return $colors;
            }
        }

        return $fallback ?? [
            ['name' => 'Midnight Espresso', 'hex' => '#120E0C', 'stock' => true],
            ['name' => 'Cognac Tan', 'hex' => '#976239', 'stock' => true],
        ];
    }

    /**
     * Parse features from newline-delimited text or HTML rich editor.
     */
    protected function parseFeatures(Request $request, ?array $fallback = null): array
    {
        if ($request->filled('features_raw')) {
            $raw = trim($request->input('features_raw'));
            $features = [];

            // If HTML containing <li> items from rich text editor
            if (preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $raw, $matches)) {
                foreach ($matches[1] as $item) {
                    $cleaned = trim(strip_tags($item, '<b><strong><i><em><span>'));
                    $cleaned = trim(ltrim($cleaned, " \t\n\r\0\x0B•-*"));
                    if ($cleaned !== '') {
                        $features[] = $cleaned;
                    }
                }
            } elseif (preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $raw, $matches)) {
                foreach ($matches[1] as $item) {
                    $cleaned = trim(strip_tags($item, '<b><strong><i><em><span>'));
                    $cleaned = trim(ltrim($cleaned, " \t\n\r\0\x0B•-*"));
                    if ($cleaned !== '') {
                        $features[] = $cleaned;
                    }
                }
            } else {
                $lines = preg_split('/\r\n|\r|\n/', strip_tags($raw));
                foreach ($lines as $line) {
                    $trimmed = trim(ltrim($line, " \t\n\r\0\x0B•-*"));
                    if ($trimmed !== '') {
                        $features[] = $trimmed;
                    }
                }
            }

            if (!empty($features)) {
                return $features;
            }
        }

        return $fallback ?? [
            '100% Full-grain vegetable tanned leather',
            'Hand-stitched perimeter with waxed thread',
            'Solid brass hardware with antique satin finish',
            'Presented in signature By Zunash embossed gift box',
        ];
    }

    /**
     * Parse key-value specifications.
     */
    protected function parseSpecifications(Request $request, ?array $fallback = null): array
    {
        $hasAnySpec = $request->filled('spec_material') || $request->filled('spec_hardware') ||
                      $request->filled('spec_dimensions') || $request->filled('spec_sizes') ||
                      $request->filled('spec_care');

        if ($hasAnySpec) {
            $specs = [];
            if ($request->filled('spec_material')) $specs['Material'] = trim($request->input('spec_material'));
            if ($request->filled('spec_hardware')) $specs['Hardware'] = trim($request->input('spec_hardware'));
            if ($request->filled('spec_dimensions')) $specs['Width'] = trim($request->input('spec_dimensions'));
            if ($request->filled('spec_sizes')) $specs['Available Sizes'] = trim($request->input('spec_sizes'));
            if ($request->filled('spec_care')) $specs['Care'] = trim($request->input('spec_care'));
            return $specs;
        }

        return $fallback ?? [
            'Material' => '100% Full-Grain Vegetable Tanned Leather',
            'Hardware' => 'Solid Antique Brass Finish',
            'Width' => '34 mm (1.35 inches)',
            'Available Sizes' => '30, 32, 34, 36, 38, 40, 42 inches',
            'Care' => 'Wipe with soft cotton cloth; treat with neutral leather balm periodically',
        ];
    }

    /**
     * Parse gallery images.
     */
    protected function parseGallery(Request $request, string $primaryImage, ?array $fallback = null): array
    {
        if ($request->filled('gallery_raw')) {
            $lines = preg_split('/\r\n|\r|\n/', trim($request->input('gallery_raw')));
            $gallery = [];
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    $gallery[] = $trimmed;
                }
            }
            if (!empty($gallery)) {
                if (!in_array($primaryImage, $gallery)) {
                    array_unshift($gallery, $primaryImage);
                }
                return array_values(array_unique($gallery));
            }
        }

        if (!empty($fallback)) {
            if (!in_array($primaryImage, $fallback)) {
                array_unshift($fallback, $primaryImage);
            }
            return array_values(array_unique($fallback));
        }

        return [$primaryImage];
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
