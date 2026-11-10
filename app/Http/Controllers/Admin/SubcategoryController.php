<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::with('category')->withCount('products');

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category_id', $request->input('category'));
        }

        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'products_desc' => $query->orderBy('products_count', 'desc'),
            default => $query->latest(),
        };

        $subcategories = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $totalSubcategories = Subcategory::count();

        return view('admin.subcategories.index', compact('subcategories', 'categories', 'totalSubcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $count = 1;
        while (Subcategory::where('slug', $slug)->exists()) {
            $slug = "{$slugBase}-{$count}";
            $count++;
        }

        Subcategory::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.subcategories.index')
            ->with('toast_success', "Subcategory '{$validated['name']}' added.");
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $slug = $subcategory->slug;
        if (empty($slug) || $subcategory->name !== $validated['name']) {
            $slugBase = Str::slug($validated['name']);
            $slug = $slugBase;
            $count = 1;
            while (Subcategory::where('slug', $slug)->where('id', '!=', $subcategory->id)->exists()) {
                $slug = "{$slugBase}-{$count}";
                $count++;
            }
        }

        $subcategory->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.subcategories.index')
            ->with('toast_success', "Subcategory '{$subcategory->name}' updated.");
    }

    public function destroy(Subcategory $subcategory)
    {
        $name = $subcategory->name;
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')
            ->with('toast_success', "Subcategory '{$name}' deleted.");
    }
}
