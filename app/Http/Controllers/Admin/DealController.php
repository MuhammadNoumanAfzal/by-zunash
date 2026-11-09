<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DealController extends Controller
{
    /**
     * Display a listing of deals and bundles.
     */
    public function index(Request $request)
    {
        $query = Deal::with('products')->withCount('products');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('badge', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $deals = $query->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total' => Deal::count(),
            'active' => Deal::where('is_active', true)->count(),
            'featured' => Deal::where('is_featured', true)->count(),
            'avg_savings' => Deal::where('is_active', true)->get()->avg(function ($deal) {
                return $deal->savings_amount;
            }) ?? 0,
        ];

        return view('admin.deals.index', compact('deals', 'stats'));
    }

    /**
     * Show the form for creating a new deal.
     */
    public function create()
    {
        $products = Product::where('in_stock', true)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'price', 'original_price', 'image', 'category_name', 'sku']);

        return view('admin.deals.create', compact('products'));
    }

    /**
     * Store a newly created deal in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:deals,slug',
            'tagline' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'deal_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'sort_order' => 'nullable|integer|min:0',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'nullable|integer|min:1',
        ]);

        $slug = !empty($validated['slug']) 
            ? Str::slug($validated['slug']) 
            : Str::slug($validated['title']);

        // Check if slug exists and make unique
        $originalSlug = $slug;
        $counter = 1;
        while (Deal::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        // Handle image upload or image path
        $imagePath = $validated['image'] ?? null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'deal_' . time() . '_' . Str::slug(substr($validated['title'], 0, 20)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/deals'), $fileName);
            $imagePath = '/images/deals/' . $fileName;
        }

        // Default image from first product if none provided
        if (empty($imagePath)) {
            $firstProduct = Product::find($validated['products'][0]['id'] ?? 0);
            $imagePath = $firstProduct ? $firstProduct->image : '/images/brand/artisan-craft.jpg';
        }

        // Calculate original price from selected products if not provided
        $calculatedOriginal = 0;
        $attachData = [];
        foreach ($validated['products'] as $p) {
            $productModel = Product::find($p['id']);
            $qty = isset($p['quantity']) && (int)$p['quantity'] > 0 ? (int)$p['quantity'] : 1;
            if ($productModel) {
                $calculatedOriginal += ((float)$productModel->price) * $qty;
                $attachData[$productModel->id] = ['quantity' => $qty];
            }
        }

        $originalPrice = !empty($validated['original_price']) && (float)$validated['original_price'] > 0
            ? (float)$validated['original_price']
            : $calculatedOriginal;

        $deal = Deal::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'deal_price' => (float)$validated['deal_price'],
            'original_price' => $originalPrice,
            'discount_percentage' => !empty($validated['discount_percentage']) 
                ? (int)$validated['discount_percentage'] 
                : ($originalPrice > 0 ? (int)round((($originalPrice - (float)$validated['deal_price']) / $originalPrice) * 100) : 0),
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured', false),
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'sort_order' => (int)($validated['sort_order'] ?? 0),
        ]);

        $deal->products()->sync($attachData);

        return redirect()->route('admin.deals.index')
            ->with('toast_success', "Atelier Deal '{$deal->title}' has been successfully created with " . count($attachData) . " creations.");
    }

    /**
     * Show the form for editing the specified deal.
     */
    public function edit(Deal $deal)
    {
        $deal->load('products');
        $products = Product::where('in_stock', true)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'price', 'original_price', 'image', 'category_name', 'sku']);

        return view('admin.deals.edit', compact('deal', 'products'));
    }

    /**
     * Update the specified deal in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:deals,slug,' . $deal->id,
            'tagline' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'deal_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'sort_order' => 'nullable|integer|min:0',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'nullable|integer|min:1',
        ]);

        $imagePath = $validated['image'] ?? $deal->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'deal_' . time() . '_' . Str::slug(substr($validated['title'], 0, 20)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/deals'), $fileName);
            $imagePath = '/images/deals/' . $fileName;
        }

        $calculatedOriginal = 0;
        $attachData = [];
        foreach ($validated['products'] as $p) {
            $productModel = Product::find($p['id']);
            $qty = isset($p['quantity']) && (int)$p['quantity'] > 0 ? (int)$p['quantity'] : 1;
            if ($productModel) {
                $calculatedOriginal += ((float)$productModel->price) * $qty;
                $attachData[$productModel->id] = ['quantity' => $qty];
            }
        }

        $originalPrice = !empty($validated['original_price']) && (float)$validated['original_price'] > 0
            ? (float)$validated['original_price']
            : $calculatedOriginal;

        $deal->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'tagline' => $validated['tagline'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'deal_price' => (float)$validated['deal_price'],
            'original_price' => $originalPrice,
            'discount_percentage' => !empty($validated['discount_percentage']) 
                ? (int)$validated['discount_percentage'] 
                : ($originalPrice > 0 ? (int)round((($originalPrice - (float)$validated['deal_price']) / $originalPrice) * 100) : 0),
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured', false),
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'sort_order' => (int)($validated['sort_order'] ?? 0),
        ]);

        $deal->products()->sync($attachData);

        return redirect()->route('admin.deals.index')
            ->with('toast_success', "Atelier Deal '{$deal->title}' has been successfully updated.");
    }

    /**
     * Remove the specified deal from storage.
     */
    public function destroy(Deal $deal)
    {
        $title = $deal->title;
        $deal->products()->detach();
        $deal->delete();

        return redirect()->route('admin.deals.index')
            ->with('toast_info', "Atelier Deal '{$title}' has been removed.");
    }

    /**
     * Toggle deal active status.
     */
    public function toggleStatus(Deal $deal)
    {
        $deal->update([
            'is_active' => !$deal->is_active,
        ]);

        $statusText = $deal->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('toast_success', "Deal '{$deal->title}' is now {$statusText}.");
    }
}

