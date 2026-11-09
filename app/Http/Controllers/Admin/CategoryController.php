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
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
        ]);

        $slugBase = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
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
            'image' => !empty($validated['image']) ? $validated['image'] : '/images/categories/cat-belts.jpg',
            'sort_order' => Category::count() + 1,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('toast_success', "Category '{$validated['name']}' created successfully.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
        ]);

        $slugBase = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $slug = $slugBase;
        $count = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = "{$slugBase}-{$count}";
            $count++;
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?? null,
            'image' => !empty($validated['image']) ? $validated['image'] : $category->image,
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
