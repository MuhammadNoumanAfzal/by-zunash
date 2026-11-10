<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'order');
        match ($sort) {
            'latest' => $query->latest(),
            'oldest' => $query->oldest(),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'products_desc' => $query->orderBy('products_count', 'desc'),
            default => $query->orderBy('sort_order')->latest(),
        };

        $categories = $query->paginate(9)->withQueryString();
        $totalCategories = Category::count();

        return view('admin.categories.index', compact('categories', 'totalCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,avif|max:5120',
        ]);

        $imagePath = '/images/categories/cat-belts.jpg';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = 'cat-' . Str::slug($validated['name']) . '-' . time() . '.' . $extension;
            $destinationPath = public_path('images/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = '/images/categories/' . $filename;
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$count}";
            $count++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?? null,
            'image' => $imagePath,
            'sort_order' => Category::count() + 1,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Category '{$validated['name']}' created successfully.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,avif|max:5120',
        ]);

        $imagePath = $category->image;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = 'cat-' . Str::slug($validated['name']) . '-' . time() . '.' . $extension;
            $destinationPath = public_path('images/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = '/images/categories/' . $filename;
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $slug = $category->slug;
        if (empty($slug) || $category->name !== $validated['name']) {
            $slugBase = Str::slug($validated['name']);
            $slug = $slugBase;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = "{$slugBase}-{$count}";
                $count++;
            }
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Category '{$category->name}' updated successfully.");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Category '{$name}' deleted successfully.");
    }
}
