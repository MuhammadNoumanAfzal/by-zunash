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

    <!-- Subcategories Table -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">NAME</th>
                        <th class="py-3 px-4">PARENT COLLECTION</th>
                        <th class="py-3 px-4">SLUG</th>
                        <th class="py-3 px-4">DESCRIPTION</th>
                        <th class="py-3 px-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($subcategories as $subcat)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-3.5 px-4 font-bold text-espresso-950 dark:text-white">
                                {{ $subcat->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#FAF6F2] text-tan-700 border border-tan-200">
                                    {{ $subcat->category?->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-[11px] text-gray-500">
                                {{ $subcat->slug }}
                            </td>
                            <td class="py-3.5 px-4 text-gray-500 max-w-sm truncate">
                                {{ $subcat->description ?: '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
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
                            <td colspan="5" class="py-8 text-center text-gray-400">
                                No subcategories registered.
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
<dialog id="addSubcatModal" class="rounded-3xl p-0 shadow-2xl max-w-md w-full bg-white dark:bg-[#1A1513] text-espresso-900 dark:text-white border border-[#ECE6DE] dark:border-[#2C2420]">
    <div class="p-6">
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

            <div>
                <label class="block text-xs font-semibold mb-1">Slug URL (Optional)</label>
                <input type="text" name="slug" placeholder="e.g. formal-dress-belts" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Description</label>
                <input type="text" name="description" placeholder="Optional details..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
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
<dialog id="editSubcatModal" class="rounded-3xl p-0 shadow-2xl max-w-md w-full bg-white dark:bg-[#1A1513] text-espresso-900 dark:text-white border border-[#ECE6DE] dark:border-[#2C2420]">
    <div class="p-6">
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

            <div>
                <label class="block text-xs font-semibold mb-1">Slug URL (Optional)</label>
                <input type="text" id="edit_subcat_slug" name="slug" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Description</label>
                <input type="text" id="edit_subcat_description" name="description" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
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
    document.getElementById('edit_subcat_slug').value = subcat.slug || '';
    document.getElementById('edit_subcat_description').value = subcat.description || '';
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
