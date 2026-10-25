@extends('admin.layouts.app')

@section('title', 'Add New Luxury Creation | By Zunash Atelier')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Breadcrumbs -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-[#8F8379] mb-1">
                <a href="{{ route('admin.products.index') }}" class="hover:text-tan-600 transition-colors">Products</a>
                <span>/</span>
                <span class="text-espresso-950 dark:text-white font-medium">Add New Creation</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Create New Product
            </h1>
        </div>

        <a 
            href="{{ route('admin.products.index') }}" 
            class="px-4 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#201A18] transition-colors"
        >
            Cancel
        </a>
    </div>

    <!-- Creation Form Card -->
    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
        @csrf

        <!-- Section 1: Basic Information -->
        <div>
            <h2 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                1. Product Identification & Category
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                
                <!-- Product Name -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Product Name <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="e.g. Signature Reversible Full-Grain Belt"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Collection Category <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="category_id" 
                        required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                        <option value="">Select Primary Collection</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcategory -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Subcategory (Optional)
                    </label>
                    <select 
                        name="subcategory_id" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                        <option value="">No Subcategory</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }} ({{ $sub->category->name ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        SKU Reference <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="sku" 
                        value="{{ old('sku') }}" 
                        required
                        placeholder="BZ-BELT-001"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono uppercase"
                    >
                </div>

                <!-- Badge -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Atelier Highlight Badge
                    </label>
                    <input 
                        type="text" 
                        name="badge" 
                        value="{{ old('badge') }}" 
                        placeholder="e.g. Bespoke Edition, 2-in-1 Design"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

            </div>
        </div>

        <!-- Section 2: Pricing & Stock -->
        <div>
            <h2 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                2. Valuation, Inventory & Status
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                
                <!-- Retail Price (Rs.) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Retail Price (PKR / Rs.) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        name="price" 
                        value="{{ old('price', 4950) }}" 
                        required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono font-bold"
                    >
                </div>

                <!-- Original / Compare Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Original Compare Price (PKR / Rs.)
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        name="original_price" 
                        value="{{ old('original_price') }}" 
                        placeholder="Optional discount anchor"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Stock Quantity (Units) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="stock_quantity" 
                        value="{{ old('stock_quantity', 15) }}" 
                        required 
                        min="0"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >
                </div>

                <!-- Availability Type -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Availability Type
                    </label>
                    <select 
                        name="availability" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                        <option value="in_stock" {{ old('availability') === 'in_stock' ? 'selected' : '' }}>In Stock Ready to Dispatch</option>
                        <option value="on_demand" {{ old('availability') === 'on_demand' ? 'selected' : '' }}>On Demand / Bespoke Commission</option>
                        <option value="out_of_stock" {{ old('availability') === 'out_of_stock' ? 'selected' : '' }}>Sold Out / Archival</option>
                    </select>
                </div>

                <!-- Boolean Flags (Bestseller, New, Active) -->
                <div class="sm:col-span-2 flex flex-wrap items-center gap-6 pt-5">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>Bestseller / Flagship</span>
                    </label>

                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white">
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new', 1) ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>Mark as New Arrival</span>
                    </label>

                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>Live in Storefront</span>
                    </label>
                </div>

            </div>
        </div>

        <!-- Section 3: Media & Descriptions -->
        <div>
            <h2 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                3. Imagery & Craft Story
            </h2>
            <div class="space-y-4 mt-4">
                
                <!-- Primary Image URL -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Primary Image Asset Path or URL <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="image" 
                        value="{{ old('image', '/images/products/prod-reversible-belt.jpg') }}" 
                        placeholder="/images/products/prod-reversible-belt.jpg"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Short Description -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Short Summary <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="short_description" 
                        rows="2" 
                        required
                        placeholder="Brief summary appearing on cards and catalog listings..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >{{ old('short_description') }}</textarea>
                </div>

                <!-- Long Description -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Full Atelier Craftsmanship Story
                    </label>
                    <textarea 
                        name="description" 
                        rows="4" 
                        placeholder="Detailed narrative describing leather grade, tanning process, hardware accents..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >{{ old('description') }}</textarea>
                </div>

            </div>
        </div>

        <!-- Submit Button Bar -->
        <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-end gap-3">
            <a 
                href="{{ route('admin.products.index') }}" 
                class="px-5 py-2.5 rounded-xl border border-[#DFD6CB] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
                Cancel
            </a>

            <button 
                type="submit" 
                class="px-6 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-all active:scale-95 flex items-center gap-2 border border-gold-400/20"
            >
                <i data-lucide="check" class="w-4 h-4 text-gold-400"></i>
                <span>Publish Product to Catalogue</span>
            </button>
        </div>

    </form>

</div>

@endsection
