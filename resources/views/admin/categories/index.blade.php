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

    <!-- Search & Filter Controls -->
    <div class="bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] p-3.5 sm:p-4 shadow-card">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3">
            
            <!-- Search Input -->
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Search collection name, tagline, or slug..." 
                    style="padding-left: 2.5rem !important;"
                    class="w-full pl-10 pr-8 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white placeholder-[#A89C91] focus:outline-hidden focus:border-tan-500 transition-colors"
                >
                @if(request('q'))
                    <a href="{{ route('admin.categories.index', request()->except('q')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>

            <!-- Sort By -->
            <div class="w-full sm:w-52 shrink-0">
                <select 
                    name="sort" 
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
                >
                    <option value="order" {{ request('sort', 'order') === 'order' ? 'selected' : '' }}>Custom Atelier Order</option>
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest Created</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest Created</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A &rarr; Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z &rarr; A</option>
                    <option value="products_desc" {{ request('sort') === 'products_desc' ? 'selected' : '' }}>Most Articles</option>
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-center gap-2 shrink-0">
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white text-xs font-semibold shadow-2xs transition-colors flex items-center gap-1.5"
                >
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'sort']))
                    <a 
                        href="{{ route('admin.categories.index') }}" 
                        class="px-3 py-2 rounded-xl text-xs font-medium text-gray-500 hover:text-espresso-900 dark:hover:text-white border border-[#E0D7CB] dark:border-[#382D27] hover:bg-gray-50 dark:hover:bg-[#241D1A] transition-colors"
                        title="Clear all filters"
                    >
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Category Grid Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($categories as $category)
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

                    <h2 class="font-bold text-xl text-espresso-950 dark:text-white group-hover:text-tan-600 transition-colors">
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
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-8 shadow-card space-y-2">
                <div class="w-12 h-12 rounded-full bg-tan-50 dark:bg-[#201815] text-tan-600 mx-auto flex items-center justify-center mb-2">
                    <i data-lucide="search-x" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-sm text-espresso-950 dark:text-white">No collections found</h3>
                <p class="text-xs text-gray-400 max-w-sm mx-auto">No categories matched your search query. Try clearing your filters or adding a new category.</p>
                @if(request()->hasAny(['q', 'sort']))
                    <a href="{{ route('admin.categories.index') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-espresso-900 text-white text-xs font-semibold">
                        Clear All Filters
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    @if($categories->hasPages())
        <div class="p-4 bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
            {{ $categories->links() }}
        </div>
    @endif

</div>

<!-- Add Category Modal Dialog -->
<dialog id="addCategoryModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Add Collection Category</h3>
            <button type="button" onclick="document.getElementById('addCategoryModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold mb-1">Category Title <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Travel Duffles & Luggage" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tagline</label>
                <input type="text" name="tagline" placeholder="Brief poetic description of the collection" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Banner Image</label>
                <div class="p-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-dashed border-[#DFD6CB] dark:border-[#382D27] flex items-center gap-3.5">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-espresso-950/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#382D27] shrink-0 flex items-center justify-center">
                        <img id="add_category_preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <i id="add_category_preview_icon" data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs cursor-pointer transition-colors shadow-2xs">
                            <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-gold-400"></i>
                            <span>Upload from Computer</span>
                            <input type="file" id="add_category_file" name="image_file" accept="image/*" class="hidden" onchange="previewAddCatImage(this)">
                        </label>
                        <p class="text-[10px] text-[#8F8379] mt-1 truncate" id="add_category_file_name">
                            PNG, JPG, WEBP up to 5MB
                        </p>
                    </div>
                </div>

                <div class="mt-2">
                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5">Or use Image URL / Path</label>
                    <input type="text" id="add_category_image" name="image" placeholder="/images/categories/cat-belts.jpg" oninput="previewAddCatUrl(this.value)" class="w-full px-3 py-1.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
                </div>
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
<dialog id="editCategoryModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Edit Collection Category</h3>
            <button type="button" onclick="document.getElementById('editCategoryModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editCategoryForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1">Category Title <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_category_name" name="name" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tagline</label>
                <input type="text" id="edit_category_tagline" name="tagline" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Banner Image</label>
                <div class="p-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-dashed border-[#DFD6CB] dark:border-[#382D27] flex items-center gap-3.5">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-espresso-950/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#382D27] shrink-0 flex items-center justify-center">
                        <img id="edit_category_preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <i id="edit_category_preview_icon" data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs cursor-pointer transition-colors shadow-2xs">
                            <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-gold-400"></i>
                            <span>Upload from Computer</span>
                            <input type="file" id="edit_category_file" name="image_file" accept="image/*" class="hidden" onchange="previewEditCatImage(this)">
                        </label>
                        <p class="text-[10px] text-[#8F8379] mt-1 truncate" id="edit_category_file_name">
                            PNG, JPG, WEBP up to 5MB
                        </p>
                    </div>
                </div>

                <div class="mt-2">
                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5">Or use Image URL / Path</label>
                    <input type="text" id="edit_category_image" name="image" placeholder="/images/categories/cat-belts.jpg" oninput="previewEditCatUrl(this.value)" class="w-full px-3 py-1.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
                </div>
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
function previewAddCatImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('add_category_file_name').textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('add_category_preview');
            img.src = e.target.result;
            img.classList.remove('hidden');
            document.getElementById('add_category_preview_icon').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewAddCatUrl(url) {
    const img = document.getElementById('add_category_preview');
    const icon = document.getElementById('add_category_preview_icon');
    if (url && url.trim().length > 0) {
        img.src = url;
        img.classList.remove('hidden');
        icon.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        icon.classList.remove('hidden');
    }
}

function previewEditCatImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('edit_category_file_name').textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('edit_category_preview');
            img.src = e.target.result;
            img.classList.remove('hidden');
            document.getElementById('edit_category_preview_icon').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewEditCatUrl(url) {
    const img = document.getElementById('edit_category_preview');
    const icon = document.getElementById('edit_category_preview_icon');
    if (url && url.trim().length > 0) {
        img.src = url;
        img.classList.remove('hidden');
        icon.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        icon.classList.remove('hidden');
    }
}

function openEditCategoryModal(category) {
    document.getElementById('editCategoryForm').action = '/admin/categories/' + category.id;
    document.getElementById('edit_category_name').value = category.name || '';
    document.getElementById('edit_category_tagline').value = category.tagline || '';
    document.getElementById('edit_category_image').value = category.image || '';
    document.getElementById('edit_category_file').value = '';
    document.getElementById('edit_category_file_name').textContent = 'PNG, JPG, WEBP up to 5MB';

    const img = document.getElementById('edit_category_preview');
    const icon = document.getElementById('edit_category_preview_icon');
    if (category.image) {
        img.src = category.image;
        img.classList.remove('hidden');
        icon.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        icon.classList.remove('hidden');
    }

    document.getElementById('editCategoryModal').showModal();
    if (window.lucide) lucide.createIcons();
}

// Automatically open Add Category if URL hash is #add-category
function checkCategoryHash() {
    if (window.location.hash === '#add-category' || window.location.hash === '#addCategoryModal') {
        const modal = document.getElementById('addCategoryModal');
        if (modal) modal.showModal();
        if (window.lucide) lucide.createIcons();
    }
}
document.addEventListener('DOMContentLoaded', checkCategoryHash);
window.addEventListener('hashchange', checkCategoryHash);
</script>
@endpush

@endsection
