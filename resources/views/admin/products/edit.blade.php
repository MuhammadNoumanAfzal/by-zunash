@extends('admin.layouts.app')

@section('title', 'Edit ' . $product->name . ' | By Zunash Atelier')

@section('content')

@php
    $existingColors = is_array($product->colors) && count($product->colors) > 0 ? $product->colors : [
        ['name' => 'Midnight Espresso', 'hex' => '#120E0C', 'stock' => true],
        ['name' => 'Cognac Tan', 'hex' => '#976239', 'stock' => true]
    ];
    $initialColors = array_map(function($c) {
        $c['active'] = true;
        return $c;
    }, $existingColors);

    $featuresList = is_array($product->features) ? $product->features : [];
    $cleanFeatures = array_map(function ($f) {
        $c = html_entity_decode($f, ENT_QUOTES, 'UTF-8');
        return trim(strip_tags($c));
    }, $featuresList);
    $cleanFeatures = array_values(array_filter($cleanFeatures, fn($f) => $f !== ''));
    $featuresRaw = implode("\n", $cleanFeatures);

    $galleryList = is_array($product->gallery) ? $product->gallery : [];
    $additionalGallery = array_filter($galleryList, fn($img) => $img !== $product->image);
    $galleryRaw = implode("\n", $additionalGallery);

    $specs = is_array($product->specifications) ? $product->specifications : [];
    $specMaterial = $specs['Material'] ?? '';
    $specHardware = $specs['Hardware'] ?? '';
    $specDimensions = $specs['Width & Dimensions'] ?? ($specs['Width'] ?? ($specs['Dimensions'] ?? ''));
    $specSizes = $specs['Available Sizes'] ?? '';
    $specLining = $specs['Lining & Seams'] ?? '';
    $specCare = $specs['Care'] ?? '';
    $specOrigin = $specs['Origin'] ?? '';
    $specPackaging = $specs['Packaging'] ?? '';

    $initialStep = 1;
    if (isset($errors) && $errors->hasAny(['price', 'cost_price', 'original_price', 'stock_quantity'])) {
        $initialStep = 1;
    } elseif (isset($errors) && $errors->hasAny(['image', 'image_file', 'gallery_files'])) {
        $initialStep = 2;
    } elseif (isset($errors) && $errors->hasAny(['short_description', 'description', 'spec_material'])) {
        $initialStep = 3;
    } elseif (isset($errors) && $errors->hasAny(['has_engraving', 'has_addons', 'has_gift_set'])) {
        $initialStep = 4;
    } elseif (isset($errors) && $errors->hasAny(['allowed_payment_methods', 'custom_shipping_charge', 'weight_kg'])) {
        $initialStep = 5;
    }
@endphp

<div class="max-w-5xl mx-auto space-y-6 pb-24" x-data="{
    tab: {{ $initialStep }},
    viewMode: 'tabs',
    productTitle: '{{ addslashes(old('name', $product->name)) }}',
    availability: '{{ old('availability', $product->availability ?? 'in_stock') }}',
    leadTime: '{{ old('lead_time', $product->lead_time ?? 'Dispatched in 24 Hours') }}',
    paymentMethodRule: '{{ old('allowed_payment_methods', $product->allowed_payment_methods ?? 'all') }}',
    isFreeShipping: {{ old('is_free_shipping', $product->is_free_shipping) ? 'true' : 'false' }},
    hasEngraving: {{ old('has_engraving', $product->has_engraving) ? 'true' : 'false' }},
    hasAddons: {{ old('has_addons', $product->has_addons) ? 'true' : 'false' }},
    hasGiftSet: {{ old('has_gift_set', $product->has_gift_set) ? 'true' : 'false' }},
    primaryPreview: '{{ $product->image }}',
    galleryPreviews: [],
    badgeText: '{{ addslashes(old('badge', $product->badge ?? '')) }}',
    
    setBadge(text) {
        this.badgeText = text;
    },

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
    },

    switchTab(t) {
        this.tab = t;
        window.scrollTo({ top: 120, behavior: 'smooth' });
    },
    nextTab() {
        if (this.tab < 5) {
            this.tab++;
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }
    },
    prevTab() {
        if (this.tab > 1) {
            this.tab--;
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }
    },

    handlePrimaryUpload(e) {
        const file = e.target.files[0];
        if (file) {
            this.primaryPreview = URL.createObjectURL(file);
        }
    },
    handleGalleryUpload(e) {
        this.galleryPreviews = [];
        const files = e.target.files;
        if (files) {
            for (let i = 0; i < files.length; i++) {
                this.galleryPreviews.push(URL.createObjectURL(files[i]));
            }
        }
    }
}">

    <!-- Top Sticky Header -->
    <div class="sticky top-0 z-30 bg-[#FAF7F2]/95 dark:bg-[#120B08]/95 backdrop-blur-md py-3 -mx-4 px-4 sm:-mx-6 sm:px-6 border-b border-[#ECE6DE] dark:border-[#2C2420] transition-all">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 text-[11px] text-[#8F8379]">
                    <a href="{{ route('admin.products.index') }}" class="hover:text-tan-600 transition-colors">Products</a>
                    <span>/</span>
                    <span class="text-espresso-950 dark:text-white font-medium">Edit Creation</span>
                    <a href="{{ route('product.details', $product->slug) }}" target="_blank" class="text-tan-600 hover:underline flex items-center gap-0.5 ml-2">
                        <span>View Live</span>
                        <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
                <h1 class="font-cinzel text-lg sm:text-xl font-bold text-espresso-950 dark:text-white truncate">
                    Editing: <span x-text="productTitle ? productTitle : '{{ addslashes($product->name) }}'"></span>
                </h1>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button 
                    type="button" 
                    @click="viewMode = (viewMode === 'tabs' ? 'all' : 'tabs')"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-espresso-900 dark:text-ivory bg-white dark:bg-[#1E1714] hover:bg-gray-50 transition-colors shadow-2xs"
                >
                    <i data-lucide="layout" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span x-text="viewMode === 'tabs' ? 'Show All in 1 Page' : 'Switch to Tabs'"></span>
                </button>

                <a 
                    href="{{ route('admin.products.index') }}" 
                    class="px-3 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </a>

                <button 
                    type="submit" 
                    form="productEditForm"
                    class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 cursor-pointer active:scale-95"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Error Alert Banner -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/30 border border-rose-300 dark:border-rose-800 text-rose-900 dark:text-rose-200 text-xs shadow-xs space-y-1">
            <div class="flex items-center gap-2 font-bold text-sm">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                <span>Please correct the highlighted fields:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 pl-2 text-[11px] text-rose-800 dark:text-rose-300">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabbed Navigation Bar -->
    <div x-show="viewMode === 'tabs'" class="bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] p-2 shadow-xs overflow-x-auto">
        <div class="flex items-center gap-1 sm:grid sm:grid-cols-5 min-w-[620px] text-xs">
            <button type="button" @click="switchTab(1)" class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full" :class="tab === 1 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0" :class="tab === 1 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">1</span>
                <span class="truncate">Basic & Pricing</span>
            </button>
            <button type="button" @click="switchTab(2)" class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full" :class="tab === 2 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0" :class="tab === 2 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">2</span>
                <span class="truncate">Media & Swatches</span>
            </button>
            <button type="button" @click="switchTab(3)" class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full" :class="tab === 3 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0" :class="tab === 3 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">3</span>
                <span class="truncate">Story & Specs</span>
            </button>
            <button type="button" @click="switchTab(4)" class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full" :class="tab === 4 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0" :class="tab === 4 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">4</span>
                <span class="truncate">Upsells & Engraving</span>
            </button>
            <button type="button" @click="switchTab(5)" class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full" :class="tab === 5 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0" :class="tab === 5 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">5</span>
                <span class="truncate">Shipping & SEO</span>
            </button>
        </div>
    </div>

    <!-- MAIN PRODUCT FORM -->
    <form id="productEditForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <input type="hidden" name="colors_json" :value="activeColorsJson">

        <!-- =========================================================================
             SECTION 1: BASIC INFORMATION, PRICING & INVENTORY
             ========================================================================= -->
        <div x-show="viewMode === 'all' || tab === 1" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">1</span>
                    <div>
                        <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">Basic Information, Pricing & Inventory</h2>
                        <p class="text-[11px] text-[#8F8379]">Core identification, collection grouping, stock quantities, and retail pricing.</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-tan-600 uppercase tracking-wider bg-tan-50 dark:bg-tan-950/40 px-2.5 py-1 rounded-full border border-tan-200 dark:border-tan-800">Step 1 of 5</span>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                    Product Title <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    x-model="productTitle"
                    value="{{ old('name', $product->name) }}" 
                    required 
                    class="w-full px-4 py-3 text-sm rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-medium focus:outline-hidden focus:border-tan-500 focus:ring-2 focus:ring-tan-500/20 shadow-2xs"
                >
            </div>

            <!-- Category & Subcategory -->
            <div 
                class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                x-data="{
                    categoryId: '{{ old('category_id', $product->category_id) }}',
                    subcategoryId: '{{ old('subcategory_id', $product->subcategory_id) }}',
                    allSubs: [
                        @foreach($subcategories as $s)
                            { id: {{ $s->id }}, name: '{{ addslashes($s->name) }}', category_id: {{ $s->category_id }} },
                        @endforeach
                    ],
                    get filteredSubs() {
                        if (!this.categoryId) return [];
                        return this.allSubs.filter(s => s.category_id == this.categoryId);
                    }
                }"
            >
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Collection Category <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="category_id" 
                        x-model="categoryId"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-medium"
                    >
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white">Subcategory (Optional)</label>
                        <a href="{{ route('admin.subcategories.index') }}" target="_blank" class="text-[10px] text-tan-600 hover:text-tan-700 font-semibold">+ Add Subcategory</a>
                    </div>
                    <select 
                        name="subcategory_id" 
                        x-model="subcategoryId"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                        <option value="">General / No Subcategory</option>
                        <template x-for="sub in filteredSubs" :key="sub.id">
                            <option :value="sub.id" x-text="sub.name" :selected="sub.id == subcategoryId"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Pricing Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Selling Price (PKR) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">PKR</span>
                        <input 
                            type="number" 
                            step="1" 
                            id="prod_retail_price"
                            name="price" 
                            value="{{ old('price', (int)$product->price) }}" 
                            required
                            oninput="calculateProfitMargin()"
                            class="w-full pl-12 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Original / Strikethrough Price
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">PKR</span>
                        <input 
                            type="number" 
                            step="1" 
                            name="original_price" 
                            value="{{ old('original_price', $product->original_price ? (int)$product->original_price : '') }}" 
                            placeholder="6500"
                            class="w-full pl-12 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1.5 flex items-center justify-between">
                        <span>Cost Price (COGS)</span>
                        <span class="text-[10px] font-normal text-gray-400">For Net Profit</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">PKR</span>
                        <input 
                            type="number" 
                            step="1" 
                            id="prod_cost_price"
                            name="cost_price" 
                            value="{{ old('cost_price', $product->cost_price ? (int)$product->cost_price : '') }}" 
                            placeholder="2100"
                            oninput="calculateProfitMargin()"
                            class="w-full pl-12 pr-3.5 py-2.5 text-xs rounded-xl bg-emerald-50/40 dark:bg-emerald-950/20 border border-emerald-300 dark:border-emerald-800/40 text-emerald-900 dark:text-emerald-300 font-mono font-bold"
                        >
                    </div>
                </div>
            </div>

            <!-- Profit Calculation Pill -->
            <div id="profit_margin_preview" class="p-3.5 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2 text-emerald-900 dark:text-emerald-300">
                    <i data-lucide="trending-up" class="w-4 h-4 text-emerald-600"></i>
                    <span>Net Margin:</span>
                </div>
                <div id="profit_calc_result" class="font-mono font-bold text-xs text-emerald-800 dark:text-emerald-300">
                    Enter Selling & Cost Price
                </div>
            </div>

            <!-- Inventory, SKU & Availability -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Stock Quantity (Units)
                    </label>
                    <input 
                        type="number" 
                        name="stock_quantity" 
                        value="{{ old('stock_quantity', $product->stock_quantity ?? 15) }}" 
                        min="0"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-semibold"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Production / Stock Status
                    </label>
                    <select 
                        name="availability" 
                        x-model="availability"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-medium"
                    >
                        <option value="in_stock" {{ old('availability', $product->availability) === 'in_stock' ? 'selected' : '' }}>In Stock — Dispatched in 24h</option>
                        <option value="on_demand" {{ old('availability', $product->availability) === 'on_demand' ? 'selected' : '' }}>On Demand — Bespoke Craft</option>
                        <option value="out_of_stock" {{ old('availability', $product->availability) === 'out_of_stock' ? 'selected' : '' }}>Out of Stock / Restock</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Lead Time Display
                    </label>
                    <input 
                        type="text" 
                        name="lead_time" 
                        x-model="leadTime"
                        value="{{ old('lead_time', $product->lead_time ?? 'Dispatched in 24 Hours') }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white"
                    >
                </div>
            </div>

            <!-- SKU, Badge & Social Proof -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">SKU Code</label>
                    <input 
                        type="text" 
                        name="sku" 
                        value="{{ old('sku', $product->sku) }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono uppercase"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Badge Tag</label>
                    <input 
                        type="text" 
                        name="badge" 
                        x-model="badgeText"
                        value="{{ old('badge', $product->badge) }}" 
                        placeholder="e.g. Bestseller"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white"
                    >
                    <div class="flex flex-wrap gap-1 mt-1.5">
                        @foreach(['Bestseller', 'New Arrival', 'Limited Edition', 'Save 18%', 'Flagship'] as $chip)
                            <button type="button" @click="setBadge('{{ $chip }}')" class="text-[9px] px-2 py-0.5 rounded-md bg-gray-100 dark:bg-white/10 hover:bg-tan-100 text-gray-700 dark:text-gray-300 font-semibold cursor-pointer">
                                {{ $chip }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Rating (Stars)</label>
                        <input 
                            type="number" 
                            step="0.1" 
                            min="1.0" 
                            max="5.0" 
                            name="rating" 
                            value="{{ old('rating', $product->rating ?? 5.0) }}" 
                            class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Reviews Count</label>
                        <input 
                            type="number" 
                            min="0" 
                            name="reviews_count" 
                            value="{{ old('reviews_count', $product->reviews_count ?? 18) }}" 
                            class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                </div>
            </div>

            <!-- Bestseller & New Arrival Flags -->
            <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center gap-6">
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white select-none">
                    <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} class="w-4 h-4 rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                    <span>⭐ Highlight as Flagship / Bestseller</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white select-none">
                    <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }} class="w-4 h-4 rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                    <span>✨ Tag as New Collection Piece</span>
                </label>
            </div>
        </div>

        <!-- =========================================================================
             SECTION 2: VISUALS, GALLERY & LEATHER SWATCHES
             ========================================================================= -->
        <div x-show="viewMode === 'all' || tab === 2" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">2</span>
                    <div>
                        <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">Product Imagery & Leather Tones</h2>
                        <p class="text-[11px] text-[#8F8379]">Main silhouette image, multi-angle gallery, and available leather colorways.</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-tan-600 uppercase tracking-wider bg-tan-50 dark:bg-tan-950/40 px-2.5 py-1 rounded-full border border-tan-200 dark:border-tan-800">Step 2 of 5</span>
            </div>

            <!-- Primary Photo -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 items-start">
                <div class="sm:col-span-2 space-y-3">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                        Primary Silhouette Photo
                    </label>
                    <div class="border-2 border-dashed border-[#DFD6CB] dark:border-[#3A2F29] rounded-2xl p-6 text-center hover:border-tan-500 transition-colors bg-[#FAF8F5] dark:bg-[#241D1A]">
                        <input 
                            type="file" 
                            name="image_file" 
                            id="primaryImageInput" 
                            accept="image/*"
                            @change="handlePrimaryUpload($event)"
                            class="hidden"
                        >
                        <label for="primaryImageInput" class="cursor-pointer flex flex-col items-center justify-center gap-2">
                            <div class="w-12 h-12 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-600 dark:text-gold-400 flex items-center justify-center shadow-2xs">
                                <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-bold text-espresso-900 dark:text-white">
                                Click to replace primary photo (or drag & drop)
                            </span>
                            <span class="text-[10px] text-gray-500">Auto-compressed to WebP</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">Or Existing Image Path</label>
                        <input 
                            type="text" 
                            name="image" 
                            value="{{ old('image', $product->image) }}" 
                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-2">Image Preview</label>
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#3A2F29] flex items-center justify-center relative shadow-xs">
                        <template x-if="primaryPreview">
                            <img :src="primaryPreview" alt="Preview" class="w-full h-full object-cover">
                        </template>
                    </div>
                </div>
            </div>

            <!-- Additional Gallery Angles -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Additional Gallery Angle Images
                </label>
                <div class="border-2 border-dashed border-[#DFD6CB] dark:border-[#3A2F29] rounded-2xl p-5 text-center hover:border-tan-500 transition-colors bg-[#FAF8F5] dark:bg-[#241D1A]">
                    <input 
                        type="file" 
                        name="gallery_files[]" 
                        id="galleryImagesInput" 
                        accept="image/*" 
                        multiple
                        @change="handleGalleryUpload($event)"
                        class="hidden"
                    >
                    <label for="galleryImagesInput" class="cursor-pointer flex flex-col items-center justify-center gap-1.5">
                        <i data-lucide="images" class="w-6 h-6 text-tan-600 dark:text-gold-400"></i>
                        <span class="text-xs font-semibold text-espresso-900 dark:text-white">
                            Select multiple photos to append to gallery
                        </span>
                        <span class="text-[10px] text-gray-500">Hold Ctrl or Shift to pick multiple images</span>
                    </label>
                </div>

                <template x-if="galleryPreviews.length > 0">
                    <div class="flex items-center gap-2 overflow-x-auto py-2">
                        <template x-for="(img, idx) in galleryPreviews" :key="idx">
                            <div class="w-16 h-16 rounded-xl overflow-hidden border border-tan-400 shrink-0 shadow-2xs">
                                <img :src="img" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>
                </template>

                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">
                        Gallery Image Paths (One per line)
                    </label>
                    <textarea 
                        name="gallery_raw" 
                        rows="3" 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                    >{{ old('gallery_raw', $galleryRaw) }}</textarea>
                </div>
            </div>

            <!-- Leather Swatches -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-espresso-950 dark:text-white">Leather Tone Swatches</h3>
                        <p class="text-[11px] text-[#8F8379]">Select which colorways are available for customer selection.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="toggleAll(true)" class="text-[10px] text-tan-600 font-bold hover:underline cursor-pointer">Select All</button>
                        <span class="text-gray-300">|</span>
                        <button type="button" @click="toggleAll(false)" class="text-[10px] text-gray-500 font-bold hover:underline cursor-pointer">Clear All</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                    <template x-for="(color, idx) in colors" :key="idx">
                        <label 
                            class="p-2.5 rounded-xl border flex items-center justify-between gap-2 cursor-pointer transition-all select-none"
                            :class="color.active ? 'border-tan-500 bg-[#FAF7F2] dark:bg-[#2A1F1A] shadow-2xs' : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18] opacity-75'"
                        >
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="w-4 h-4 rounded-full border border-black/20 shrink-0 shadow-2xs" :style="'background-color: ' + color.hex"></span>
                                <span class="text-xs font-medium text-espresso-950 dark:text-white truncate" x-text="color.name"></span>
                            </div>
                            <input type="checkbox" x-model="color.active" class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        </label>
                    </template>
                </div>

                <div class="p-3 rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] flex flex-wrap items-center gap-2.5">
                    <input type="color" x-model="customColorHex" class="w-8 h-8 rounded-lg cursor-pointer border-0 bg-transparent">
                    <input 
                        type="text" 
                        x-model="customColorName" 
                        placeholder="Custom Tone Name (e.g. Hunter Green)" 
                        class="flex-1 min-w-[200px] px-3 py-1.5 text-xs rounded-lg bg-white dark:bg-[#1E1815] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white"
                    >
                    <button 
                        type="button" 
                        @click="addCustomColor()" 
                        class="px-3.5 py-1.5 rounded-lg bg-tan-600 hover:bg-tan-700 text-white text-xs font-semibold transition-colors cursor-pointer"
                    >
                        + Add Swatch
                    </button>
                    <span class="text-emerald-600 text-xs font-medium" x-text="swatchFeedback"></span>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             SECTION 3: DESCRIPTIONS, STORY & SPECIFICATIONS
             ========================================================================= -->
        <div x-show="viewMode === 'all' || tab === 3" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">3</span>
                    <div>
                        <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">Descriptions & Specifications</h2>
                        <p class="text-[11px] text-[#8F8379]">Short tagline, artisanal bullet points, editorial story, and technical dimensions.</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-tan-600 uppercase tracking-wider bg-tan-50 dark:bg-tan-950/40 px-2.5 py-1 rounded-full border border-tan-200 dark:border-tan-800">Step 3 of 5</span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Short Tagline Description</label>
                <textarea 
                    name="short_description" 
                    rows="3" 
                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white leading-relaxed focus:outline-hidden focus:border-tan-500"
                >{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Artisanal Highlights (One per line)</label>
                <textarea 
                    name="features_raw" 
                    rows="4" 
                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono leading-relaxed focus:outline-hidden focus:border-tan-500"
                >{{ old('features_raw', $featuresRaw) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Full Atelier Story & Craft Description</label>
                <textarea 
                    name="description" 
                    rows="6" 
                    class="w-full px-4 py-3 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white leading-relaxed focus:outline-hidden focus:border-tan-500"
                >{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Technical Specifications Grid -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-espresso-950 dark:text-white">Technical Specifications Grid</h3>
                    <span class="text-[10px] text-gray-400">Fill what applies to this piece</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Leather / Material</label>
                        <input type="text" name="spec_material" value="{{ old('spec_material', $specMaterial) }}" placeholder="100% Full-Grain Calfskin" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Hardware / Buckle</label>
                        <input type="text" name="spec_hardware" value="{{ old('spec_hardware', $specHardware) }}" placeholder="Solid Antique Brass Hardware" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Dimensions & Width</label>
                        <input type="text" name="spec_dimensions" value="{{ old('spec_dimensions', $specDimensions) }}" placeholder="35mm (1.38 in) Universal Width" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Available Belt Sizes</label>
                        <input type="text" name="spec_sizes" value="{{ old('spec_sizes', $specSizes ?: '30″, 32″, 34″, 36″, 38″, 40″, 42″') }}" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Lining & Seams</label>
                        <input type="text" name="spec_lining" value="{{ old('spec_lining', $specLining) }}" placeholder="Hand-waxed bonded nylon thread" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Atelier Origin</label>
                        <input type="text" name="spec_origin" value="{{ old('spec_origin', $specOrigin ?: 'Handcrafted in Lahore, Pakistan') }}" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Packaging Box</label>
                        <input type="text" name="spec_packaging" value="{{ old('spec_packaging', $specPackaging ?: 'Rigid Foil-Embossed Presentation Box') }}" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Care & Conditioning</label>
                        <input type="text" name="spec_care" value="{{ old('spec_care', $specCare ?: 'Condition annually with natural beeswax balm') }}" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             SECTION 4: UPSELLS, ENGRAVING & GIFT SET CONVERSIONS
             ========================================================================= -->
        <div x-show="viewMode === 'all' || tab === 4" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">4</span>
                    <div>
                        <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">eCommerce Conversions, Upsells & Personalization</h2>
                        <p class="text-[11px] text-[#8F8379]">Name engraving debossing, 15% off add-on bundles, and gift set upgrade boxes.</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-tan-600 uppercase tracking-wider bg-tan-50 dark:bg-tan-950/40 px-2.5 py-1 rounded-full border border-tan-200 dark:border-tan-800">Step 4 of 5</span>
            </div>

            <!-- 1. Custom Name Engraving -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-espresso-950 dark:text-white flex items-center gap-1.5">
                            <i data-lucide="sparkles" class="w-4 h-4 text-tan-600 dark:text-gold"></i>
                            <span>Custom Name Engraving & Hot-Foil Debossing</span>
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                            Allows customers to deboss their name on leather. Automatically enforces Advance Payment.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="has_engraving" value="1" x-model="hasEngraving" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-tan-600"></div>
                    </label>
                </div>

                <div x-show="hasEngraving" x-cloak class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-[#E0D7CB] dark:border-[#3A2F29]">
                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">
                            Engraving Surcharge (PKR) — Enter 0 for Free
                        </label>
                        <input 
                            type="number" 
                            name="engraving_price" 
                            value="{{ old('engraving_price', (int)($product->engraving_price ?? 0)) }}" 
                            placeholder="0 (Free) or 350" 
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Customer Notice Note</label>
                        <input 
                            type="text" 
                            name="engraving_note" 
                            value="{{ old('engraving_note', $product->engraving_note ?? 'Advance payment only. Personalised, so not returnable for change of mind.') }}" 
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white"
                        >
                    </div>
                </div>
            </div>

            <!-- 2. Cross-Sell Add-ons -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-espresso-950 dark:text-white flex items-center gap-1.5">
                            <i data-lucide="layers" class="w-4 h-4 text-tan-600 dark:text-gold"></i>
                            <span>Cross-Sell Add-ons ("ADD THESE & GET EXTRA 15% OFF")</span>
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                            Displays checkbox accessory add-ons on the product detail page with 1-click Claim Offer.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="has_addons" value="1" x-model="hasAddons" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-tan-600"></div>
                    </label>
                </div>

                <div x-show="hasAddons" x-cloak class="space-y-3 pt-3 border-t border-[#E0D7CB] dark:border-[#3A2F29]">
                    <div class="flex items-center gap-3">
                        <div class="w-36">
                            <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Addon Discount %</label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="addon_discount_percent" 
                                    value="{{ old('addon_discount_percent', $product->addon_discount_percent ?? 15) }}" 
                                    min="0" 
                                    max="80"
                                    class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold"
                                >
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">%</span>
                            </div>
                        </div>
                        <div class="flex-1 text-[11px] text-gray-500 pt-4">
                            Select companion items below to display as discounted add-ons:
                        </div>
                    </div>

                    <div class="max-h-52 overflow-y-auto divide-y divide-gray-100 dark:divide-white/5 border border-[#DCD3C7] dark:border-[#382D27] rounded-xl bg-white dark:bg-[#16100E] p-2 space-y-1">
                        @php
                            $currentAddons = is_array($product->addon_product_ids) ? $product->addon_product_ids : [];
                        @endphp
                        @foreach($allProducts ?? [] as $cand)
                            <label class="flex items-center gap-2.5 p-1.5 hover:bg-gray-50 dark:hover:bg-white/5 rounded-lg cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="addon_product_ids[]" 
                                    value="{{ $cand->id }}"
                                    {{ in_array($cand->id, old('addon_product_ids', $currentAddons)) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded text-tan-600 focus:ring-tan-500 border-gray-300"
                                >
                                <img src="{{ $cand->image }}" class="w-8 h-8 rounded object-cover border border-gray-200">
                                <div class="flex-1 min-w-0 text-xs text-espresso-950 dark:text-white truncate">
                                    <strong>{{ $cand->name }}</strong>
                                    <span class="text-gray-400 font-mono text-[10px]"> (PKR {{ number_format($cand->price) }})</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 3. Gift Set / Bundle Upgrade Card -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-espresso-950 dark:text-white flex items-center gap-1.5">
                            <i data-lucide="gift" class="w-4 h-4 text-tan-600 dark:text-gold"></i>
                            <span>Gift Set / Bundle Upgrade Card ("Buying as a gift? Get the Set")</span>
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                            Displays a luxury boxed gift card with savings amount right on this product detail page.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="has_gift_set" value="1" x-model="hasGiftSet" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-tan-600"></div>
                    </label>
                </div>

                <div x-show="hasGiftSet" x-cloak class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-[#E0D7CB] dark:border-[#3A2F29]">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Link to Existing Deal / Curated Set</label>
                        <select name="gift_deal_id" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                            <option value="">-- Or enter custom gift set details below --</option>
                            @foreach($deals ?? [] as $d)
                                <option value="{{ $d->id }}" {{ old('gift_deal_id', $product->gift_deal_id) == $d->id ? 'selected' : '' }}>
                                    {{ $d->title }} — PKR {{ number_format($d->deal_price) }} (Save PKR {{ number_format($d->original_price - $d->deal_price) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Custom Gift Set Title</label>
                        <input type="text" name="gift_set_title" value="{{ old('gift_set_title', $product->gift_set_title) }}" placeholder="e.g. Get the Gentleman's Set instead" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Gift Set Subtitle</label>
                        <input type="text" name="gift_set_subtitle" value="{{ old('gift_set_subtitle', $product->gift_set_subtitle) }}" placeholder="e.g. Belt + Wallet paired in presentation box" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Together Gift-Boxed Price (PKR)</label>
                        <input type="number" name="gift_set_price" value="{{ old('gift_set_price', $product->gift_set_price ? (int)$product->gift_set_price : '') }}" placeholder="e.g. 5999" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Separate Total Price (PKR)</label>
                        <input type="number" name="gift_set_original_price" value="{{ old('gift_set_original_price', $product->gift_set_original_price ? (int)$product->gift_set_original_price : '') }}" placeholder="e.g. 6999" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Gift Box Image Upload</label>
                        @if($product->gift_set_image)
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ asset($product->gift_set_image) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                <span class="text-xs text-gray-500 font-mono">{{ $product->gift_set_image }}</span>
                            </div>
                        @endif
                        <input type="file" name="gift_set_image_file" accept="image/*" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-tan-100 file:text-tan-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             SECTION 5: SHIPPING, WEIGHT, RULES & GOOGLE SEO
             ========================================================================= -->
        <div x-show="viewMode === 'all' || tab === 5" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">5</span>
                    <div>
                        <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">Shipping Controls, Rules & Google SEO</h2>
                        <p class="text-[11px] text-[#8F8379]">Payment method restrictions, delivery charges, and search engine optimization.</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-tan-600 uppercase tracking-wider bg-tan-50 dark:bg-tan-950/40 px-2.5 py-1 rounded-full border border-tan-200 dark:border-tan-800">Step 5 of 5</span>
            </div>

            <!-- Payment Method Rule -->
            <div class="space-y-3">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">Allowed Checkout Payment Methods</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between gap-2.5"
                        :class="paymentMethodRule === 'all' ? 'border-tan-600 bg-tan-50/40 dark:bg-[#2A1F1A] shadow-xs' : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18]'"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="check-check" class="w-4 h-4 text-emerald-600"></i>
                                All Methods (COD + Prepaid)
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="all" x-model="paymentMethodRule" class="text-tan-600 focus:ring-tan-500">
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">COD, Bank Transfer, JazzCash & EasyPaisa all supported.</p>
                    </label>

                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between gap-2.5"
                        :class="paymentMethodRule === 'prepaid_only' ? 'border-amber-600 bg-amber-50/40 dark:bg-[#2A1F1A] shadow-xs' : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18]'"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="shield-alert" class="w-4 h-4 text-amber-600"></i>
                                Bank Transfer Only (No COD)
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="prepaid_only" x-model="paymentMethodRule" class="text-amber-600 focus:ring-amber-500">
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Advance payment via IBFT/Raast strictly required.</p>
                    </label>

                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between gap-2.5"
                        :class="paymentMethodRule === 'cod_only' ? 'border-tan-600 bg-tan-50/40 dark:bg-[#2A1F1A] shadow-xs' : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18]'"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="banknote" class="w-4 h-4 text-tan-600"></i>
                                Cash on Delivery (COD) Only
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="cod_only" x-model="paymentMethodRule" class="text-tan-600 focus:ring-tan-500">
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Restricts checkout exclusively to doorstep cash.</p>
                    </label>
                </div>
            </div>

            <!-- Weight & Custom Delivery -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Parcel Weight (Kilograms)</span>
                        <span class="text-[10px] text-gray-400">For Courier Rates</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            step="0.05" 
                            name="weight_kg" 
                            value="{{ old('weight_kg', $product->weight_kg ?? '0.50') }}" 
                            class="w-full pl-3.5 pr-12 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-semibold"
                        >
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">KG</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Custom Delivery Charge Override (PKR)</span>
                        <span class="text-[10px] text-gray-400">Optional</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Rs.</span>
                        <input 
                            type="number" 
                            step="1" 
                            name="custom_shipping_charge" 
                            value="{{ old('custom_shipping_charge', $product->custom_shipping_charge ? (int)$product->custom_shipping_charge : '') }}" 
                            placeholder="Leave blank for store default"
                            class="w-full pl-10 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                        >
                    </div>
                </div>
            </div>

            <!-- Free Shipping Guarantee Toggle -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-espresso-950 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="gift" class="w-4 h-4 text-tan-600"></i>
                        <span>Guaranteed Complimentary Free Shipping</span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Always offer Free Delivery on this piece regardless of cart total.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_free_shipping" value="1" x-model="isFreeShipping" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- SEO Preview -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <h3 class="text-xs font-bold text-espresso-950 dark:text-white">Google Search Engine Preview (SEO)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" placeholder="By Zunash | Handcrafted Leather..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Meta Description</label>
                        <input type="text" name="meta_description" value="{{ old('meta_description', $product->meta_description) }}" placeholder="Experience heirloom Pakistani leathercraft..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             BOTTOM FLOATING ACTION BAR
             ========================================================================= -->
        <div class="fixed bottom-0 inset-x-0 z-40 bg-white/95 dark:bg-[#1A1513]/95 backdrop-blur-md border-t border-[#ECE6DE] dark:border-[#2C2420] p-3 shadow-2xl">
            <div class="max-w-5xl mx-auto flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        @click="prevTab()" 
                        x-show="viewMode === 'tabs' && tab > 1"
                        class="px-3.5 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-espresso-900 dark:text-white hover:bg-gray-50 transition-colors flex items-center gap-1 cursor-pointer"
                    >
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        <span>Previous Tab</span>
                    </button>
                    <button 
                        type="button" 
                        @click="nextTab()" 
                        x-show="viewMode === 'tabs' && tab < 5"
                        class="px-3.5 py-2 rounded-xl bg-gray-100 dark:bg-white/10 text-xs font-semibold text-espresso-900 dark:text-white hover:bg-gray-200 transition-colors flex items-center gap-1 cursor-pointer"
                    >
                        <span>Next Tab</span>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.products.index') }}" class="px-3.5 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>

                    <button 
                        type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 cursor-pointer active:scale-95"
                    >
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
function calculateProfitMargin() {
    const retailInput = document.getElementById('prod_retail_price');
    const costInput = document.getElementById('prod_cost_price');
    const resultEl = document.getElementById('profit_calc_result');
    if (!retailInput || !costInput || !resultEl) return;

    const retail = parseFloat(retailInput.value) || 0;
    const cost = parseFloat(costInput.value) || 0;

    if (retail <= 0) {
        resultEl.innerHTML = 'Enter Selling Price';
        resultEl.className = 'font-mono font-bold text-xs text-gray-500';
        return;
    }

    const profit = retail - cost;
    const margin = Math.round((profit / retail) * 100);

    if (profit > 0) {
        resultEl.innerHTML = `PKR ${profit.toLocaleString()} profit <span class="ml-1 text-[11px] bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 px-1.5 py-0.5 rounded font-bold">${margin}% margin</span>`;
        resultEl.className = 'font-mono font-bold text-xs text-emerald-700 dark:text-emerald-400';
    } else if (profit === 0) {
        resultEl.innerHTML = `Break Even (PKR 0 profit)`;
        resultEl.className = 'font-mono font-bold text-xs text-amber-600';
    } else {
        resultEl.innerHTML = `Loss: PKR ${Math.abs(profit).toLocaleString()}`;
        resultEl.className = 'font-mono font-bold text-xs text-rose-600';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    calculateProfitMargin();
});
</script>

@endsection
