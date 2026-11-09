@extends('admin.layouts.app')

@section('title', 'Categories Management | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Collection Categories
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Organize handcrafted leather articles into signature By Zunash collections.
            </p>
        </div>

        <button 
            type="button" 
            onclick="document.getElementById('addCategoryModal').showModal()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
            <span>Add New Category</span>
        </button>
    </div>

    <!-- Category Grid Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($categories as $category)
            <div class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-6 flex flex-col justify-between group hover:border-tan-500 transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FAF6F2] dark:bg-[#2A1D1A] flex items-center justify-center border border-tan-200 dark:border-[#3A2824] overflow-hidden">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="layers" class="w-6 h-6 text-tan-600"></i>
                            @endif
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#FAF6F2] dark:bg-[#2A1D1A] text-tan-700 dark:text-gold-300 border border-tan-200 dark:border-[#3E2A24]">
                            {{ $category->products_count }} Articles
                        </span>
                    </div>

                    <h2 class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white group-hover:text-tan-600 transition-colors">
                        {{ $category->name }}
                    </h2>
                    <div class="font-mono text-[10px] text-gray-400 mt-0.5">
                        /category/{{ $category->slug }}
                    </div>

                    <p class="text-xs text-[#7A6E64] dark:text-[#A89C91] mt-2.5 line-clamp-2 leading-relaxed">
                        {{ $category->tagline ?: 'Handcrafted leather collection tailored to luxury sartorial standards.' }}
                    </p>
                </div>

                <div class="pt-4 mt-4 border-t border-[#F0EAE1] dark:border-[#28201C] flex items-center justify-between">
                    <a 
                        href="{{ route('admin.products.index', ['category' => $category->slug]) }}" 
                        class="text-xs font-semibold text-tan-600 hover:text-tan-700 flex items-center gap-1"
                    >
                        <span>Filter Products</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>

                    <div class="flex items-center gap-1">
                        <!-- Edit Button -->
                        <button 
                            type="button" 
                            onclick="openEditCategoryModal({{ json_encode($category) }})"
                            class="p-1.5 text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] rounded-lg transition-colors" 
                            title="Edit Category"
                        >
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category? Any associated products will remain unassigned.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition-colors" title="Delete Category">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Add Category Modal Dialog -->
<dialog id="addCategoryModal" class="rounded-3xl p-0 shadow-2xl max-w-md w-full bg-white dark:bg-[#1A1513] text-espresso-900 dark:text-white border border-[#ECE6DE] dark:border-[#2C2420]">
    <div class="p-6">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Add Collection Category</h3>
            <button type="button" onclick="document.getElementById('addCategoryModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold mb-1">Category Title <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Travel Duffles & Luggage" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Slug URL (Optional - auto-generated if omitted)</label>
                <input type="text" name="slug" placeholder="e.g. travel-duffles" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tagline</label>
                <input type="text" name="tagline" placeholder="Brief poetic description of the collection" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Banner Image URL</label>
                <input type="text" name="image" placeholder="/images/categories/cat-belts.jpg" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('addCategoryModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- Edit Category Modal Dialog -->
<dialog id="editCategoryModal" class="rounded-3xl p-0 shadow-2xl max-w-md w-full bg-white dark:bg-[#1A1513] text-espresso-900 dark:text-white border border-[#ECE6DE] dark:border-[#2C2420]">
    <div class="p-6">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Edit Collection Category</h3>
            <button type="button" onclick="document.getElementById('editCategoryModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editCategoryForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1">Category Title <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_category_name" name="name" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Slug URL</label>
                <input type="text" id="edit_category_slug" name="slug" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tagline</label>
                <input type="text" id="edit_category_tagline" name="tagline" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Banner Image URL</label>
                <input type="text" id="edit_category_image" name="image" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('editCategoryModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-espresso-900 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
function openEditCategoryModal(category) {
    document.getElementById('editCategoryForm').action = '/admin/categories/' + category.id;
    document.getElementById('edit_category_name').value = category.name || '';
    document.getElementById('edit_category_slug').value = category.slug || '';
    document.getElementById('edit_category_tagline').value = category.tagline || '';
    document.getElementById('edit_category_image').value = category.image || '';
    document.getElementById('editCategoryModal').showModal();
}

// Automatically open Add Category if URL hash is #add-category
function checkCategoryHash() {
    if (window.location.hash === '#add-category' || window.location.hash === '#addCategoryModal') {
        const modal = document.getElementById('addCategoryModal');
        if (modal) modal.showModal();
    }
}
document.addEventListener('DOMContentLoaded', checkCategoryHash);
window.addEventListener('hashchange', checkCategoryHash);
</script>
@endpush

@endsection
