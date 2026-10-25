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
        $averageRating = Review::avg('rating') ?: 5.0;

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'publishedCount',
            'averageRating'
        ));
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
