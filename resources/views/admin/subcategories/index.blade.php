@extends('admin.layouts.app')

@section('title', 'Subcategories Management | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Subcategories & Silhouettes
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Manage granular cuts, silhouettes, and hardware sub-classifications across By Zunash collections.
            </p>
        </div>

        <button 
            type="button" 
            onclick="document.getElementById('addSubcatModal').showModal()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
            <span>Add Subcategory</span>
        </button>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] p-3.5 sm:p-4 shadow-card">
        <form action="{{ route('admin.subcategories.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center gap-3">
            
            <!-- Search Input -->
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Search subcategory name..." 
                    class="w-full pl-9.5 pr-8 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white placeholder-[#A89C91] focus:outline-hidden focus:border-tan-500 transition-colors"
                >
                @if(request('q'))
                    <a href="{{ route('admin.subcategories.index', request()->except('q')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>

            <!-- Parent Category Filter -->
            <div class="w-full sm:w-56 shrink-0">
                <select 
                    name="category" 
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
                >
                    <option value="all">All Collections ({{ $categories->count() }})</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort Selector -->
            <div class="w-full sm:w-44 shrink-0">
                <select 
                    name="sort" 
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
                >
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
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

                @if(request()->hasAny(['q', 'category', 'sort']))
                    <a 
                        href="{{ route('admin.subcategories.index') }}" 
                        class="px-3 py-2 rounded-xl text-xs font-medium text-gray-500 hover:text-espresso-900 dark:hover:text-white border border-[#E0D7CB] dark:border-[#382D27] hover:bg-gray-50 dark:hover:bg-[#241D1A] transition-colors"
                        title="Clear all filters"
                    >
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Subcategories Table & Mobile Cards -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        
        <!-- Mobile Clean Card View (Visible on screens < 640px) -->
        <div class="block sm:hidden divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
            @forelse($subcategories as $subcat)
                <div class="p-4 hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors space-y-2.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <h3 class="font-bold text-sm text-espresso-950 dark:text-white truncate">
                                {{ $subcat->name }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#FAF6F2] dark:bg-[#2A1D1A] text-tan-700 dark:text-gold-300 border border-tan-200 dark:border-[#3E2A24]">
                                    {{ $subcat->category?->name ?? 'None' }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium">
                                    {{ $subcat->products_count }} {{ Str::plural('article', $subcat->products_count) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-[#F0EAE1] dark:border-[#28201C] flex items-center justify-end gap-2">
                        <button 
                            type="button" 
                            onclick="openEditSubcatModal({{ json_encode($subcat) }})"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white hover:border-tan-500 transition-colors flex items-center gap-1.5"
                        >
                            <i data-lucide="edit-3" class="w-3.5 h-3.5 text-tan-600"></i>
                            <span>Edit</span>
                        </button>

                        <form action="{{ route('admin.subcategories.destroy', $subcat) }}" method="POST" onsubmit="return confirm('Delete this subcategory?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-rose-200 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors flex items-center gap-1.5"
                            >
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-xs text-gray-400 space-y-2">
                    <div class="w-10 h-10 rounded-full bg-tan-50 dark:bg-[#201815] text-tan-600 mx-auto flex items-center justify-center">
                        <i data-lucide="search-x" class="w-5 h-5"></i>
                    </div>
                    <div class="font-semibold text-espresso-950 dark:text-white">No subcategories found</div>
                    <p class="text-[11px] text-gray-400">Try adjusting your search query or collection filter.</p>
                    @if(request()->hasAny(['q', 'category', 'sort']))
                        <a href="{{ route('admin.subcategories.index') }}" class="inline-block mt-2 px-3 py-1.5 rounded-lg bg-espresso-900 text-white text-[11px] font-semibold">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Desktop / Tablet Table View (Visible on >= 640px) -->
        <div class="hidden sm:block overflow-x-auto w-full max-w-full">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4 whitespace-nowrap">NAME</th>
                        <th class="py-3 px-4 whitespace-nowrap">PARENT COLLECTION</th>
                        <th class="py-3 px-4 whitespace-nowrap">ARTICLES</th>
                        <th class="py-3 px-4 text-right whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($subcategories as $subcat)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-3.5 px-4 font-bold text-espresso-950 dark:text-white whitespace-nowrap">
                                {{ $subcat->name }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#FAF6F2] dark:bg-[#2A1D1A] text-tan-700 dark:text-gold-300 border border-tan-200 dark:border-[#3E2A24]">
                                    {{ $subcat->category?->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                    {{ $subcat->products_count }} {{ Str::plural('article', $subcat->products_count) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <button 
                                        type="button" 
                                        onclick="openEditSubcatModal({{ json_encode($subcat) }})"
                                        class="p-1.5 text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] rounded-lg transition-colors"
                                        title="Edit Subcategory"
                                    >
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <form action="{{ route('admin.subcategories.destroy', $subcat) }}" method="POST" onsubmit="return confirm('Delete this subcategory?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition-colors" title="Delete Subcategory">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-xs text-gray-400 space-y-2">
                                <div class="w-10 h-10 rounded-full bg-tan-50 dark:bg-[#201815] text-tan-600 mx-auto flex items-center justify-center mb-2">
                                    <i data-lucide="search-x" class="w-5 h-5"></i>
                                </div>
                                <div class="font-semibold text-espresso-950 dark:text-white">No subcategories found</div>
                                <p class="text-[11px] text-gray-400">Try adjusting your search query or collection filter.</p>
                                @if(request()->hasAny(['q', 'category', 'sort']))
                                    <a href="{{ route('admin.subcategories.index') }}" class="inline-block mt-2 px-3 py-1.5 rounded-lg bg-espresso-900 text-white text-[11px] font-semibold">
                                        Clear All Filters
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $subcategories->links() }}
        </div>
    </div>

</div>

<!-- Add Subcategory Modal -->
<dialog id="addSubcatModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Add Subcategory</h3>
            <button type="button" onclick="document.getElementById('addSubcatModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.subcategories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold mb-1">Parent Category <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Subcategory Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Formal Dress Belts" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('addSubcatModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Save Subcategory
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- Edit Subcategory Modal -->
<dialog id="editSubcatModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Edit Subcategory</h3>
            <button type="button" onclick="document.getElementById('editSubcatModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editSubcatForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1">Parent Category <span class="text-rose-500">*</span></label>
                <select id="edit_subcat_category_id" name="category_id" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Subcategory Name <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_subcat_name" name="name" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('editSubcatModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
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
function openEditSubcatModal(subcat) {
    document.getElementById('editSubcatForm').action = '/admin/subcategories/' + subcat.id;
    document.getElementById('edit_subcat_category_id').value = subcat.category_id || '';
    document.getElementById('edit_subcat_name').value = subcat.name || '';
    document.getElementById('editSubcatModal').showModal();
}

// Automatically open Add Subcategory if URL hash is #add-subcat
function checkSubcatHash() {
    if (window.location.hash === '#add-subcat' || window.location.hash === '#addSubcatModal') {
        const modal = document.getElementById('addSubcatModal');
        if (modal) modal.showModal();
    }
}
document.addEventListener('DOMContentLoaded', checkSubcatHash);
window.addEventListener('hashchange', checkSubcatHash);
</script>
@endpush

@endsection
