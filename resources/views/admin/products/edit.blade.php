@extends('admin.layouts.app')

@section('title', 'Edit ' . $product->name . ' | By Zunash Atelier')

@section('content')

@php
    $existingColors = is_array($product->colors) && count($product->colors) > 0 ? $product->colors : [
        ['name' => 'Midnight Espresso', 'hex' => '#120E0C', 'stock' => true],
        ['name' => 'Cognac Tan', 'hex' => '#976239', 'stock' => true]
    ];
    // Map with active flag for UI checkboxes
    $initialColors = array_map(function($c) {
        $c['active'] = true;
        return $c;
    }, $existingColors);

    $featuresList = is_array($product->features) ? $product->features : [];
    $cleanFeatures = array_map(function ($f) {
        $c = html_entity_decode($f, ENT_QUOTES, 'UTF-8');
        $c = preg_replace('/<span[^>]*>.*?<\/span>/is', '', $c);
        $c = preg_replace('/&lt;span.*?&lt;\/span&gt;/is', '', $c);
        $c = preg_replace('/<span[^>]*\/?>/is', '', $c);
        $c = preg_replace('/&lt;span[^\&]*\/&gt;/is', '', $c);
        $c = preg_replace('/&lt;span[^\&]*&gt;/is', '', $c);
        $c = preg_replace('/&lt;\/span&gt;/is', '', $c);
        $c = str_ireplace(['ql-ui', 'contenteditable="false"', 'contenteditable=\'false\''], '', $c);
        return trim(strip_tags($c, '<b><strong><i><em>'));
    }, $featuresList);
    $cleanFeatures = array_values(array_filter($cleanFeatures, fn($f) => $f !== ''));
    $featuresRaw = implode("\n", $cleanFeatures);
    $featuresHtml = !empty($cleanFeatures) ? '<ul>' . implode('', array_map(fn($f) => '<li>' . $f . '</li>', $cleanFeatures)) . '</ul>' : '';
    $galleryList = is_array($product->gallery) ? $product->gallery : [];
    // If first item matches product->image, show remaining in textarea
    $additionalGallery = array_filter($galleryList, fn($img) => $img !== $product->image);
    $galleryRaw = implode("\n", $additionalGallery);

    $specs = is_array($product->specifications) ? $product->specifications : [];
    $specMaterial = $specs['Material'] ?? '';
    $specHardware = $specs['Hardware'] ?? '';
    $specDimensions = $specs['Width & Dimensions'] ?? ($specs['Width'] ?? ($specs['Dimensions'] ?? ''));
    $specSizes = $specs['Available Sizes'] ?? '';
    $specCare = $specs['Care'] ?? '';
    $specOrigin = $specs['Origin'] ?? '';
    $specPackaging = $specs['Packaging'] ?? '';
@endphp

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    availability: '{{ old('availability', $product->availability ?? 'in_stock') }}',
    leadTime: '{{ old('lead_time', $product->lead_time ?? '') }}',
    colors: {{ json_encode($initialColors) }},
    customColorName: '',
    customColorHex: '#8B4513',
    swatchFeedback: '',
    addCustomColor() {
        let name = this.customColorName ? this.customColorName.trim() : '';
        if (!name) {
            name = 'Custom Tone ' + (this.colors.length + 1) + ' (' + this.customColorHex.toUpperCase() + ')';
        }
        this.colors.push({
            name: name,
            hex: this.customColorHex,
            stock: true,
            active: true
        });
        this.customColorName = '';
        this.swatchFeedback = 'Added: ' + name;
        setTimeout(() => { this.swatchFeedback = ''; }, 3000);
    },
    removeColor(index) {
        this.colors.splice(index, 1);
    },
    toggleAll(select) {
        this.colors.forEach(c => c.active = select);
    },
    get activeColorsJson() {
        return JSON.stringify(this.colors.filter(c => c.active).map(c => ({ name: c.name, hex: c.hex, stock: c.stock })));
    }
}">

    <!-- Header & Breadcrumbs -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-[#8F8379] mb-1">
                <a href="{{ route('admin.products.index') }}" class="hover:text-tan-600 transition-colors">Products</a>
                <span>/</span>
                <span class="text-espresso-950 dark:text-white font-medium">Edit Product</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Edit: {{ $product->name }}
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('product.details', $product->slug) }}" 
                target="_blank"
                class="px-3.5 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#201A18] transition-colors flex items-center gap-1.5"
            >
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                <span>Storefront View</span>
            </a>

            <a 
                href="{{ route('admin.products.index') }}" 
                class="px-4 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#201A18] transition-colors"
            >
                Back to Catalogue
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-8">
        @csrf
        @method('PUT')

        <!-- Hidden input for dynamic colors JSON -->
        <input type="hidden" name="colors_json" :value="activeColorsJson">

        <!-- Section 1: Basic Information -->
        <div>
            <div class="flex items-center gap-2 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-6 h-6 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">1</span>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                    Product Identification & Category
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <!-- Product Name -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Product Name <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name', $product->name) }}" 
                        required 
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
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
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
                            <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
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
                        value="{{ old('sku', $product->sku) }}" 
                        required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono uppercase"
                    >
                </div>

                <!-- Highlight Badge -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Atelier Highlight Badge
                    </label>
                    <input 
                        type="text" 
                        name="badge" 
                        value="{{ old('badge', $product->badge) }}" 
                        placeholder="e.g. Bespoke Edition, 2-in-1 Design"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>
            </div>
        </div>

        <!-- Section 2: Valuation, Inventory & Production Mode -->
        <div>
            <div class="flex items-center gap-2 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-6 h-6 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">2</span>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                    Valuation, Inventory & Production Mode
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                <!-- Retail Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Retail Price (PKR / Rs.) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        name="price" 
                        value="{{ old('price', $product->price) }}" 
                        required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono font-bold"
                    >
                </div>

                <!-- Compare Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Original Compare Price (PKR / Rs.)
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        name="original_price" 
                        value="{{ old('original_price', $product->original_price) }}" 
                        placeholder="Optional discount anchor"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Ready Stock Quantity (Units) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="stock_quantity" 
                        value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                        required 
                        min="0"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >
                </div>

                <!-- Availability Type (Frontend dynamic state) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Availability Status <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="availability" 
                        x-model="availability"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-medium"
                    >
                        <option value="in_stock">In Stock — Ready to Dispatch</option>
                        <option value="on_demand">On Demand — Made to Order</option>
                        <option value="out_of_stock">Out of Stock — Sold Out / Concierge Notice</option>
                    </select>
                </div>

                <!-- Lead Time (Visible & highlighted for On Demand) -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Production & Dispatch Lead Time</span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400" x-show="availability === 'on_demand'">Recommended for On Demand</span>
                    </label>
                    <input 
                        type="text" 
                        name="lead_time" 
                        x-model="leadTime"
                        placeholder="e.g. 7–10 Working Days or 2–3 Weeks"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                        :class="availability === 'on_demand' ? 'border-amber-400 dark:border-amber-500/50 bg-amber-50/20' : ''"
                    >
                </div>

                <!-- Bestseller / New Arrival Flags -->
                <div class="sm:col-span-3 flex flex-wrap items-center gap-6 pt-3">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>Bestseller / Flagship Collection</span>
                    </label>

                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white">
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>Mark as New Arrival</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Section 3: Leather Tone Variations (Colors) -->
        <div>
            <div class="flex items-center justify-between pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">3</span>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Leather Tone & Swatch Variations
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-semibold text-tan-600 dark:text-gold-400" x-text="colors.filter(c => c.active).length + ' selected'"></span>
                    <button type="button" @click="toggleAll(true)" class="text-[11px] text-gray-500 hover:text-tan-600 underline">Select All</button>
                    <button type="button" @click="toggleAll(false)" class="text-[11px] text-gray-500 hover:text-tan-600 underline">Clear</button>
                </div>
            </div>

            <!-- Active Swatch Tiles -->
            <div class="mt-4 space-y-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    <template x-for="(color, idx) in colors" :key="color.name + '-' + idx">
                        <div 
                            class="p-2.5 rounded-2xl border transition-all flex items-center justify-between gap-2.5 cursor-pointer select-none"
                            :class="color.active 
                                ? 'bg-[#FAF8F5] dark:bg-[#2A201C] border-tan-500 dark:border-gold-500 ring-1 ring-tan-500/30 shadow-xs' 
                                : 'bg-gray-50/60 dark:bg-[#1E1816]/60 border-gray-200 dark:border-gray-800 opacity-60 hover:opacity-90'"
                            @click="if ($event.target.closest('button')) return; color.active = !color.active"
                        >
                            <div class="flex items-center gap-2.5 flex-1 min-w-0">
                                <input 
                                    type="checkbox" 
                                    x-model="color.active" 
                                    @click.stop 
                                    class="rounded border-gray-300 dark:border-gray-600 text-tan-600 focus:ring-tan-500 shrink-0 cursor-pointer"
                                >
                                <span 
                                    class="w-6 h-6 rounded-full border border-black/20 dark:border-white/30 shrink-0 shadow-xs ring-1 ring-black/10" 
                                    :style="{ backgroundColor: color.hex }"
                                ></span>
                                <span class="text-xs font-semibold text-espresso-950 dark:text-white truncate" x-text="color.name"></span>
                            </div>
                            
                            <button 
                                type="button" 
                                @click.stop="removeColor(idx)" 
                                class="text-gray-400 hover:text-rose-500 p-1 rounded-md shrink-0 transition-colors"
                                title="Remove Swatch"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Add Custom Swatch Input Row -->
                <div class="p-3.5 rounded-2xl bg-[#FAF8F5] dark:bg-[#201A18] border border-[#E0D7CB] dark:border-[#342823] space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="flex items-center gap-2 flex-1 min-w-[220px]">
                            <label class="relative cursor-pointer shrink-0" title="Click to pick custom color">
                                <input type="color" x-model="customColorHex" class="w-9 h-9 rounded-xl cursor-pointer border border-gray-300 dark:border-gray-700 p-0.5 bg-transparent shrink-0">
                            </label>
                            <input 
                                type="text" 
                                x-model="customColorName" 
                                placeholder="Enter leather tone name (e.g. Havana Chestnut, Navy Blue)" 
                                class="px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-[#2A201C] border border-[#DFD6CB] dark:border-[#42322C] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500 w-full"
                                @keydown.enter.prevent="addCustomColor()"
                            >
                        </div>

                        <button 
                            type="button" 
                            @click="addCustomColor()" 
                            class="px-4 py-2 text-xs font-semibold rounded-xl bg-tan-600 hover:bg-tan-700 active:scale-95 text-white transition-all flex items-center gap-1.5 shadow-2xs shrink-0"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Add Swatch</span>
                        </button>
                    </div>

                    <!-- Instant Feedback Message -->
                    <div x-show="swatchFeedback" x-transition class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-medium pt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span x-text="swatchFeedback"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Specifications & Dimensions -->
        <div>
            <div class="flex items-center gap-2 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-6 h-6 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">4</span>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                    Technical Specifications & Sizing
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <!-- Leather Material -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Material Grade
                    </label>
                    <input 
                        type="text" 
                        name="spec_material" 
                        value="{{ old('spec_material', $specMaterial) }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Hardware -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Buckle / Hardware
                    </label>
                    <input 
                        type="text" 
                        name="spec_hardware" 
                        value="{{ old('spec_hardware', $specHardware) }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Width / Dimensions -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Width & Dimensions
                    </label>
                    <input 
                        type="text" 
                        name="spec_dimensions" 
                        value="{{ old('spec_dimensions', $specDimensions) }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Available Sizes -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Available Sizes (Belts / Tailored)
                    </label>
                    <input 
                        type="text" 
                        name="spec_sizes" 
                        value="{{ old('spec_sizes', $specSizes) }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Care Guide -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Leather Care & Preservation Note
                    </label>
                    <input 
                        type="text" 
                        name="spec_care" 
                        value="{{ old('spec_care', $specCare) }}" 
                        placeholder="e.g. Wipe with soft cotton cloth; treat with neutral organic leather balm periodically"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Origin -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Craft Origin (Optional)
                    </label>
                    <input 
                        type="text" 
                        name="spec_origin" 
                        value="{{ old('spec_origin', $specOrigin) }}" 
                        placeholder="e.g. Handcrafted in Pakistan (Lahore Workshop)"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Packaging -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Packaging & Presentation (Optional)
                    </label>
                    <input 
                        type="text" 
                        name="spec_packaging" 
                        value="{{ old('spec_packaging', $specPackaging) }}" 
                        placeholder="e.g. By Zunash Magnetic Hard Box & Dust Pouch"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500"
                    >
                </div>
            </div>
        </div>

        <!-- Section 5: Artisanal Highlights / Features -->
        <div>
            <div class="flex items-center justify-between pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">5</span>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Artisanal Highlights (Bullet Points)
                    </h2>
                </div>
                <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                    <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                </span>
            </div>

            <div class="mt-4">
                <textarea 
                    name="features_raw" 
                    id="prod_edit_features_raw"
                    class="hidden"
                >{{ old('features_raw', $featuresHtml) }}</textarea>
                <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                    <div 
                        data-rich-editor="highlights" 
                        data-target="#prod_edit_features_raw" 
                        data-placeholder="Click the bullet icon above or type bullet points (e.g. 100% full-grain calfskin, solid antique brass hardware...)"
                        style="min-height: 110px;"
                    >{!! old('features_raw', $featuresHtml) !!}</div>
                </div>
            </div>
        </div>

        <!-- Section 6: Media, Atelier Gallery & Narrative -->
        <div>
            <div class="flex items-center gap-2 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-6 h-6 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">6</span>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                    Imagery, Gallery & Atelier Craft Story
                </h2>
            </div>

            <div class="space-y-4 mt-4">
                <!-- Primary Image -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Primary Creation Image <span class="text-rose-500">*</span>
                    </label>

                    <div class="p-3.5 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-dashed border-[#DFD6CB] dark:border-[#382D27] flex items-center gap-3.5">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-espresso-950/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#382D27] shrink-0 flex items-center justify-center">
                            <img id="prod_preview" src="{{ old('image', $product->image ?: '/images/products/prod-reversible-belt.jpg') }}" alt="Preview" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 min-w-0">
                            <label class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs cursor-pointer transition-colors shadow-2xs">
                                <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-gold-400"></i>
                                <span>Upload from Computer</span>
                                <input type="file" name="image_file" accept="image/*" class="hidden" onchange="previewProductImage(this)">
                            </label>
                            <p class="text-[10px] text-[#8F8379] mt-1 truncate" id="prod_file_name">
                                PNG, JPG, WEBP, AVIF up to 5MB
                            </p>
                        </div>
                    </div>

                    <div class="mt-2.5">
                        <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5">Or use Image URL / Existing Asset Path</label>
                        <input 
                            type="text" 
                            id="prod_image_url"
                            name="image" 
                            value="{{ old('image', $product->image) }}" 
                            oninput="previewProductUrl(this.value)"
                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                        >
                    </div>
                </div>

                <!-- Additional Atelier Gallery (Multi-upload & URLs) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Additional Atelier Gallery (Multiple Images)</span>
                        <span class="text-[11px] text-[#8F8379]">Upload photos or add image paths</span>
                    </label>

                    <!-- Multi-Image Upload Box -->
                    <div class="p-3.5 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-dashed border-[#DFD6CB] dark:border-[#382D27]">
                        <div class="flex flex-wrap items-center gap-3">
                            <label class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs cursor-pointer transition-colors shadow-2xs">
                                <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-gold-400"></i>
                                <span>Upload Images from Computer</span>
                                <input type="file" name="gallery_files[]" multiple accept="image/*" class="hidden" onchange="previewGalleryFiles(this)">
                            </label>
                            <span class="text-[11px] text-[#8F8379]" id="gallery_upload_status">
                                Select one or multiple photos to add to gallery (PNG, JPG, WEBP, AVIF up to 5MB each)
                            </span>
                        </div>

                        <!-- Live Selected Files Preview Grid -->
                        <div id="gallery_preview_grid" class="hidden mt-3 pt-3 border-t border-[#EAE3D9] dark:border-[#2E2420] grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5">
                            <!-- Injected dynamically via previewGalleryFiles -->
                        </div>
                    </div>

                    <!-- Current Existing Additional Gallery Thumbnails (if any) -->
                    @php
                        $existingAdditional = array_values(array_filter($galleryList, fn($img) => $img !== $product->image));
                    @endphp
                    @if(count($existingAdditional) > 0)
                        <div class="mt-3 p-3 rounded-xl bg-[#FAF8F5] dark:bg-[#221B18] border border-[#E0D7CB] dark:border-[#382D27]">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[11px] font-semibold text-espresso-900 dark:text-white flex items-center gap-1.5">
                                    <i data-lucide="images" class="w-3.5 h-3.5 text-gold-500"></i>
                                    <span>Current Additional Photos ({{ count($existingAdditional) }})</span>
                                </span>
                                <span class="text-[10px] text-[#8F8379]">Click &times; to remove from gallery</span>
                            </div>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5" id="existing_gallery_container">
                                @foreach($existingAdditional as $idx => $imgUrl)
                                    <div class="relative group rounded-xl overflow-hidden bg-black/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#3A2F29] aspect-square" data-gallery-item="{{ $imgUrl }}">
                                        <img src="{{ $imgUrl }}" alt="Gallery image {{ $idx + 1 }}" class="w-full h-full object-cover">
                                        <button 
                                            type="button" 
                                            onclick="removeExistingGalleryImage('{{ addslashes($imgUrl) }}', this)" 
                                            class="absolute top-1 right-1 w-5 h-5 rounded-full bg-rose-600/90 hover:bg-rose-600 text-white flex items-center justify-center text-xs shadow-md transition-transform hover:scale-110"
                                            title="Remove image from gallery"
                                        >&times;</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-2.5">
                        <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5 flex items-center justify-between">
                            <span>Or edit Image URLs / Existing Paths (One per line)</span>
                            <span class="text-[10px] text-[#8F8379]">Synced with photos above</span>
                        </label>
                        <textarea 
                            id="gallery_raw_input"
                            name="gallery_raw" 
                            rows="2" 
                            placeholder="/images/hero/slide-belt.jpg
/images/brand/stitch-detail.jpg"
                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                        >{{ old('gallery_raw', $galleryRaw) }}</textarea>
                    </div>
                </div>

                <!-- Short Summary -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Short Summary (Catalog Cards & Meta) <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                            <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                        </span>
                    </label>
                    <textarea 
                        name="short_description" 
                        id="prod_edit_short_desc"
                        class="hidden"
                    >{{ old('short_description', $product->short_description) }}</textarea>
                    <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                        <div 
                            data-rich-editor="compact" 
                            data-target="#prod_edit_short_desc" 
                            data-placeholder="e.g. Handcrafted in supple vegetable-tanned full-grain leather with a versatile dual-tone finish..."
                            style="min-height: 90px;"
                        >{!! old('short_description', $product->short_description) !!}</div>
                    </div>
                </div>

                <!-- Full Craft Story -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Full Atelier Craft Narrative & Heritage</span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                            <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                        </span>
                    </label>
                    <textarea 
                        name="description" 
                        id="prod_edit_desc"
                        class="hidden"
                    >{{ old('description', $product->description) }}</textarea>
                    <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                        <div 
                            data-rich-editor="full" 
                            data-target="#prod_edit_desc" 
                            data-placeholder="e.g. Detailed narrative describing hide selection, vegetable tanning, artisan edge burnishing, and heirloom durability..."
                            style="min-height: 140px;"
                        >{!! old('description', $product->description) !!}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button Bar -->
        <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
            <a 
                href="{{ route('admin.products.index') }}" 
                class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#DFD6CB] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-center"
            >
                Cancel
            </a>

            <button 
                type="submit" 
                class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 border border-gold-400/20"
            >
                <i data-lucide="check" class="w-4 h-4 text-gold-400"></i>
                <span>Save Changes & Sync Storefront</span>
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
function previewProductImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const nameEl = document.getElementById('prod_file_name');
        if (nameEl) nameEl.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('prod_preview');
            if (img) img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
function previewProductUrl(url) {
    const img = document.getElementById('prod_preview');
    if (img && url && url.trim().length > 0) {
        img.src = url;
    }
}
function previewGalleryFiles(input) {
    const grid = document.getElementById('gallery_preview_grid');
    const status = document.getElementById('gallery_upload_status');
    if (!grid) return;

    if (!input.files || input.files.length === 0) {
        grid.classList.add('hidden');
        grid.innerHTML = '';
        if (status) status.innerText = 'Select one or multiple photos to add to gallery (PNG, JPG, WEBP, AVIF up to 5MB each)';
        return;
    }

    grid.innerHTML = '';
    grid.classList.remove('hidden');
    if (status) {
        status.innerText = `${input.files.length} photo${input.files.length > 1 ? 's' : ''} selected to add`;
    }

    Array.from(input.files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const card = document.createElement('div');
            card.className = 'relative rounded-xl overflow-hidden bg-black/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#3A2F29] aspect-square flex items-center justify-center';
            card.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                <span class="absolute bottom-1 right-1 bg-black/75 text-[9px] text-white px-1 py-0.5 rounded font-mono">
                    ${Math.round(file.size / 1024)}KB
                </span>
            `;
            grid.appendChild(card);
        };
        reader.readAsDataURL(file);
    });
}

function removeExistingGalleryImage(url, btn) {
    const rawInput = document.getElementById('gallery_raw_input');
    if (rawInput) {
        const lines = rawInput.value.split('\n').map(l => l.trim()).filter(l => l !== '' && l !== url);
        rawInput.value = lines.join('\n');
    }
    const item = btn.closest('[data-gallery-item]');
    if (item) {
        item.style.transition = 'opacity 0.2s, transform 0.2s';
        item.style.opacity = '0';
        item.style.transform = 'scale(0.8)';
        setTimeout(() => item.remove(), 200);
    }
}
</script>
@endpush

@endsection
