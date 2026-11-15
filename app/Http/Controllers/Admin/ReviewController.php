<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('author', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rating') && $request->input('rating') !== 'all') {
            $query->where('rating', $request->input('rating'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $reviews = $query->latest()->paginate(10)->withQueryString();

        $totalReviews = Review::count();
        $publishedCount = Review::where('status', 'published')->count();
        $averageRating = Review::avg('rating') ? round(Review::avg('rating'), 1) : 0;

        $allProducts = \App\Models\Product::orderBy('name')->get();

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'publishedCount',
            'averageRating',
            'allProducts'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:100',
            'city' => 'nullable|string|max:100',
            'product_name' => 'required|string|max:200',
            'product_slug' => 'nullable|string|max:200',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:200',
            'comment' => 'required|string|max:2000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_whatsapp' => 'nullable|boolean',
            'verified' => 'nullable|boolean',
            'status' => 'nullable|string|in:published,pending',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = \App\Services\ImageOptimizer::processUpload(
                $request->file('image_file'),
                'images/reviews',
                'review-' . time(),
                1200
            );
        }

        $initials = collect(explode(' ', trim($validated['author'])))
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->take(2)
            ->implode('');

        $slug = $validated['product_slug'] ?? null;
        $category = 'belts';
        if (!empty($slug)) {
            $p = \App\Models\Product::where('slug', $slug)->first();
            if ($p) {
                $category = $p->category_slug ?? 'belts';
                $validated['product_name'] = $p->name;
            }
        }

        Review::create([
            'author' => $validated['author'],
            'city' => $validated['city'] ?? 'Pakistan',
            'initials' => $initials ?: 'BZ',
            'category' => $category,
            'product_name' => $validated['product_name'],
            'product_slug' => $slug,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? 'Verified Purchase Feedback',
            'comment' => $validated['comment'],
            'image' => $imagePath,
            'helpful' => rand(15, 60),
            'verified' => $request->boolean('verified', true),
            'is_whatsapp' => $request->boolean('is_whatsapp', false),
            'status' => $validated['status'] ?? 'published',
        ]);

        return back()->with('toast_success', 'Review / WhatsApp Chat feedback published successfully.');
    }

    public function togglePublish(Review $review)
    {
        $review->status = $review->status === 'published' ? 'pending' : 'published';
        $review->save();

        $status = $review->status === 'published' ? 'published' : 'hidden';
        return back()->with('toast_success', "Review is now {$status}.");
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('toast_success', 'Review deleted.');
    }
}
