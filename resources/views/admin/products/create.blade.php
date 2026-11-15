@extends('admin.layouts.app')

@section('title', 'Add New Luxury Creation | By Zunash Atelier')

@section('content')

@php
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
    viewMode: 'tabs', // 'tabs' or 'all'
    productTitle: '{{ old('name', '') }}',
    availability: '{{ old('availability', 'in_stock') }}',
    leadTime: '{{ old('lead_time', 'Dispatched in 24 Hours') }}',
    paymentMethodRule: '{{ old('allowed_payment_methods', 'all') }}',
    isFreeShipping: {{ old('is_free_shipping') ? 'true' : 'false' }},
    hasEngraving: {{ old('has_engraving') ? 'true' : 'false' }},
    hasAddons: {{ old('has_addons') ? 'true' : 'false' }},
    hasGiftSet: {{ old('has_gift_set') ? 'true' : 'false' }},
    primaryPreview: null,
    galleryPreviews: [],
    badgeText: '{{ old('badge', '') }}',
    
    // Preset Badges
    setBadge(text) {
        this.badgeText = text;
    },

    // Color Palette Manager
    colors: [
        { name: 'Espresso & Obsidian Black', hex: '#24160F', stock: true, active: true },
        { name: 'Cognac Tan & Coffee', hex: '#A87548', stock: true, active: true },
        { name: 'Midnight Espresso', hex: '#120E0C', stock: true, active: false },
        { name: 'Oxblood Burgundy', hex: '#581825', stock: true, active: false },
        { name: 'Saddle Brown', hex: '#5D3A1A', stock: true, active: false },
        { name: 'Antique Gold', hex: '#C5A16B', stock: true, active: false },
        { name: 'Classic Black', hex: '#0D0A09', stock: true, active: false }
    ],
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

    // Navigation
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

    // Image preview helper
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
                    <span class="text-espresso-950 dark:text-white font-medium">Add New</span>
                </div>
                <h1 class="font-cinzel text-lg sm:text-xl font-bold text-espresso-950 dark:text-white truncate">
                    <span x-text="productTitle ? productTitle : 'Create New Creation'"></span>
                </h1>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <!-- View Mode Toggle (Tabs vs Single Page) -->
                <button 
                    type="button" 
                    @click="viewMode = (viewMode === 'tabs' ? 'all' : 'tabs')"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-espresso-900 dark:text-ivory bg-white dark:bg-[#1E1714] hover:bg-gray-50 transition-colors shadow-2xs"
                    :title="viewMode === 'tabs' ? 'Switch to All-in-One single page view' : 'Switch to Tabbed view'"
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
                    form="productForm"
                    class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 cursor-pointer active:scale-95"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Save & Publish</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Error Alert Banner (If Any) -->
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

    <!-- Tabbed Navigation Bar (Directly Clickable Anytime) -->
    <div x-show="viewMode === 'tabs'" class="bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] p-2 shadow-xs overflow-x-auto">
        <div class="flex items-center gap-1 sm:grid sm:grid-cols-5 min-w-[620px] text-xs">
            
            <!-- Tab 1 -->
            <button 
                type="button" 
                @click="switchTab(1)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full"
                :class="tab === 1 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'"
            >
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0"
                      :class="tab === 1 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">1</span>
                <span class="truncate">Basic & Pricing</span>
            </button>

            <!-- Tab 2 -->
            <button 
                type="button" 
                @click="switchTab(2)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full"
                :class="tab === 2 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'"
            >
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0"
                      :class="tab === 2 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">2</span>
                <span class="truncate">Media & Swatches</span>
            </button>

            <!-- Tab 3 -->
            <button 
                type="button" 
                @click="switchTab(3)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full"
                :class="tab === 3 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'"
            >
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0"
                      :class="tab === 3 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">3</span>
                <span class="truncate">Story & Specs</span>
            </button>

            <!-- Tab 4 -->
            <button 
                type="button" 
                @click="switchTab(4)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full"
                :class="tab === 4 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'"
            >
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0"
                      :class="tab === 4 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">4</span>
                <span class="truncate">Upsells & Engraving</span>
            </button>

            <!-- Tab 5 -->
            <button 
                type="button" 
                @click="switchTab(5)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2 cursor-pointer w-full"
                :class="tab === 5 ? 'bg-tan-600 text-white font-bold shadow-xs' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#241D1A]'"
            >
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0"
                      :class="tab === 5 ? 'bg-white text-tan-700' : 'bg-gray-200 dark:bg-white/10 text-gray-700 dark:text-gray-300'">5</span>
                <span class="truncate">Shipping & SEO</span>
            </button>

        </div>
    </div>

    <!-- MAIN PRODUCT FORM -->
    <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Dynamic Colors JSON Input -->
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

            <!-- Product Title -->
            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                    Product Title <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    x-model="productTitle"
                    value="{{ old('name') }}" 
                    required 
                    placeholder="e.g. The Royal Reversible Calfskin Belt"
                    class="w-full px-4 py-3 text-sm rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-medium focus:outline-hidden focus:border-tan-500 focus:ring-2 focus:ring-tan-500/20 shadow-2xs"
                >
                @error('name')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category & Subcategory -->
            <div 
                class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                x-data="{
                    categoryId: '{{ old('category_id', $categories->first()?->id ?? '') }}',
                    subcategoryId: '{{ old('subcategory_id', '') }}',
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
                <!-- Category -->
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
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcategory -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                            Subcategory (Optional)
                        </label>
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
                <!-- Retail / Selling Price -->
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
                            value="{{ old('price') }}" 
                            placeholder="4950"
                            required
                            oninput="calculateProfitMargin()"
                            class="w-full pl-12 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono font-bold"
                        >
                    </div>
                    @error('price')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original / Compare-At Price -->
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
                            value="{{ old('original_price') }}" 
                            placeholder="6500"
                            class="w-full pl-12 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono"
                        >
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Shows discount badge automatically</span>
                </div>

                <!-- Production Cost Price -->
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
                            value="{{ old('cost_price') }}" 
                            placeholder="2100"
                            oninput="calculateProfitMargin()"
                            class="w-full pl-12 pr-3.5 py-2.5 text-xs rounded-xl bg-emerald-50/40 dark:bg-emerald-950/20 border border-emerald-300 dark:border-emerald-800/40 text-emerald-900 dark:text-emerald-300 placeholder:text-gray-400 focus:outline-hidden focus:border-emerald-500 font-mono font-bold"
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
                <!-- Stock Quantity -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Stock Quantity (Units)
                    </label>
                    <input 
                        type="number" 
                        name="stock_quantity" 
                        value="{{ old('stock_quantity', 15) }}" 
                        placeholder="15"
                        min="0"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-semibold"
                    >
                </div>

                <!-- Availability Status -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Production / Stock Status
                    </label>
                    <select 
                        name="availability" 
                        x-model="availability"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-medium"
                    >
                        <option value="in_stock">In Stock — Dispatched in 24h</option>
                        <option value="on_demand">On Demand — Bespoke Craft</option>
                        <option value="out_of_stock">Out of Stock / Restock</option>
                    </select>
                </div>

                <!-- Custom Lead Time -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Lead Time Display
                    </label>
                    <input 
                        type="text" 
                        name="lead_time" 
                        x-model="leadTime"
                        value="{{ old('lead_time', 'Dispatched in 24 Hours') }}" 
                        placeholder="e.g. 24 Hours or 7-10 Days"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white"
                    >
                </div>
            </div>

            <!-- SKU, Badge & Social Proof -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <!-- SKU -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>SKU Code</span>
                        <span class="text-[10px] text-gray-400">Auto if blank</span>
                    </label>
                    <input 
                        type="text" 
                        name="sku" 
                        value="{{ old('sku') }}" 
                        placeholder="e.g. BZ-BELT-001"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono uppercase"
                    >
                </div>

                <!-- Visual Badge with Quick Chips -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Badge Tag
                    </label>
                    <input 
                        type="text" 
                        name="badge" 
                        x-model="badgeText"
                        value="{{ old('badge') }}" 
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

                <!-- Social Proof: Rating & Review Count -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                            Rating (Stars)
                        </label>
                        <input 
                            type="number" 
                            step="0.1" 
                            min="1.0" 
                            max="5.0" 
                            name="rating" 
                            value="{{ old('rating', '5.0') }}" 
                            class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                            Reviews Count
                        </label>
                        <input 
                            type="number" 
                            min="0" 
                            name="reviews_count" 
                            value="{{ old('reviews_count', 18) }}" 
                            class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                </div>
            </div>

            <!-- Bestseller & New Arrival Flags -->
            <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center gap-6">
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white select-none">
                    <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }} class="w-4 h-4 rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                    <span>⭐ Highlight as Flagship / Bestseller</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white select-none">
                    <input type="checkbox" name="is_new" value="1" {{ old('is_new', '1') ? 'checked' : '' }} class="w-4 h-4 rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
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

            <!-- Primary Silhouette Image -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 items-start">
                <div class="sm:col-span-2 space-y-3">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                        Primary Silhouette Photo <span class="text-rose-500">*</span>
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
                                Click to upload primary photo (or drag & drop)
                            </span>
                            <span class="text-[10px] text-gray-500">
                                JPG, PNG, WEBP up to 5MB. Auto-optimized to high speed WebP.
                            </span>
                        </label>
                    </div>

                    <!-- Direct Relative Path Fallback -->
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">
                            Or Existing Image Path
                        </label>
                        <input 
                            type="text" 
                            name="image" 
                            value="{{ old('image') }}" 
                            placeholder="/images/products/prod-dress-belt.webp"
                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                        >
                    </div>
                </div>

                <!-- Primary Live Preview -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-2">
                        Image Preview
                    </label>
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#3A2F29] flex items-center justify-center relative shadow-xs">
                        <template x-if="primaryPreview">
                            <img :src="primaryPreview" alt="Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!primaryPreview">
                            <div class="text-center p-4 text-gray-400">
                                <i data-lucide="image" class="w-8 h-8 mx-auto mb-1 text-gray-300"></i>
                                <span class="text-[11px]">No image selected</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Additional Gallery Angles -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Additional Gallery Angle Images (Multi-File Select)
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
                            Select multiple photos (Hardware closeup, open wallet, gift box)
                        </span>
                        <span class="text-[10px] text-gray-500">Hold Ctrl or Shift to pick multiple images at once</span>
                    </label>
                </div>

                <!-- Live Gallery Thumbnails Preview -->
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
                        Or Existing Gallery Image Paths (One per line)
                    </label>
                    <textarea 
                        name="gallery_raw" 
                        rows="2" 
                        placeholder="/images/products/prod-dress-belt.webp&#10;/images/products/prod-reversible-belt-thumb.webp"
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                    >{{ old('gallery_raw') }}</textarea>
                </div>
            </div>

            <!-- Leather Tone Swatches -->
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

                <!-- Add Custom Swatch -->
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

            <!-- Short Description -->
            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                    Short Tagline Description
                </label>
                <textarea 
                    name="short_description" 
                    rows="3" 
                    placeholder="e.g. Handcrafted full-grain calfskin leather belt with an antique brass 360° swivel buckle."
                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white leading-relaxed focus:outline-hidden focus:border-tan-500"
                >{{ old('short_description') }}</textarea>
                <span class="text-[10px] text-gray-400">Displayed at the top of the product page right under the price.</span>
            </div>

            <!-- Artisanal Bullet Points / Highlights -->
            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                    Artisanal Highlights (One per line)
                </label>
                <textarea 
                    name="features_raw" 
                    rows="4" 
                    placeholder="100% Full-grain drum-dyed calfskin hide&#10;Solid antique brass swivel buckle with 360° mechanism&#10;Hand-beveled and beeswax-burnished edges&#10;Rigid gold-embossed presentation gift box included"
                    class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono leading-relaxed focus:outline-hidden focus:border-tan-500"
                >{{ old('features_raw') }}</textarea>
                <span class="text-[10px] text-gray-400">Rendered as stylish bullet points in the product details overview.</span>
            </div>

            <!-- Full Atelier Story & Description -->
            <div>
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                    Full Atelier Story & Craft Description
                </label>
                <textarea 
                    name="description" 
                    rows="6" 
                    placeholder="Detailed narrative about the hide selection, drum-dyeing, hand-waxed saddle stitching, and heirloom longevity..."
                    class="w-full px-4 py-3 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white leading-relaxed focus:outline-hidden focus:border-tan-500"
                >{{ old('description') }}</textarea>
            </div>

            <!-- Technical Specifications Grid (Clean & Complete) -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-espresso-950 dark:text-white">Technical Specifications Grid</h3>
                    <span class="text-[10px] text-gray-400">Fill what applies to this piece</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Leather / Material</label>
                        <input type="text" name="spec_material" value="{{ old('spec_material') }}" placeholder="100% Full-Grain Calfskin" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Hardware / Buckle</label>
                        <input type="text" name="spec_hardware" value="{{ old('spec_hardware') }}" placeholder="Solid Antique Brass Hardware" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Dimensions & Width</label>
                        <input type="text" name="spec_dimensions" value="{{ old('spec_dimensions') }}" placeholder="35mm (1.38 in) Universal Width" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Available Belt Sizes</label>
                        <input type="text" name="spec_sizes" value="{{ old('spec_sizes', '30″, 32″, 34″, 36″, 38″, 40″, 42″') }}" placeholder="30, 32, 34, 36, 38, 40, 42" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Lining & Seams</label>
                        <input type="text" name="spec_lining" value="{{ old('spec_lining') }}" placeholder="Hand-waxed bonded nylon thread" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Atelier Origin</label>
                        <input type="text" name="spec_origin" value="{{ old('spec_origin', 'Handcrafted in Lahore, Pakistan') }}" placeholder="Handcrafted in Lahore, Pakistan" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Packaging Box</label>
                        <input type="text" name="spec_packaging" value="{{ old('spec_packaging', 'Rigid Foil-Embossed Presentation Box') }}" placeholder="Rigid Foil-Embossed Presentation Box" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Care & Conditioning</label>
                        <input type="text" name="spec_care" value="{{ old('spec_care', 'Condition annually with natural beeswax balm') }}" placeholder="Condition annually with natural beeswax balm" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
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

            <!-- 1. Custom Name Engraving & Debossing -->
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
                            value="{{ old('engraving_price', 0) }}" 
                            placeholder="0 (Free) or 350" 
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold"
                        >
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">
                            Customer Notice Note
                        </label>
                        <input 
                            type="text" 
                            name="engraving_note" 
                            value="{{ old('engraving_note', 'Advance payment only. Personalised, so not returnable for change of mind.') }}" 
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white"
                        >
                    </div>
                </div>
            </div>

            <!-- 2. Cross-Sell Add-ons ("ADD THESE & GET EXTRA 15% OFF") -->
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
                            <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">
                                Addon Discount %
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="addon_discount_percent" 
                                    value="{{ old('addon_discount_percent', 15) }}" 
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
                        @foreach($allProducts ?? [] as $cand)
                            <label class="flex items-center gap-2.5 p-1.5 hover:bg-gray-50 dark:hover:bg-white/5 rounded-lg cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="addon_product_ids[]" 
                                    value="{{ $cand->id }}"
                                    {{ in_array($cand->id, old('addon_product_ids', [])) ? 'checked' : '' }}
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
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">
                            Link to Existing Deal / Curated Set (Recommended)
                        </label>
                        <select name="gift_deal_id" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                            <option value="">-- Or enter custom gift set details below --</option>
                            @foreach($deals ?? [] as $d)
                                <option value="{{ $d->id }}" {{ old('gift_deal_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->title }} — PKR {{ number_format($d->deal_price) }} (Save PKR {{ number_format($d->original_price - $d->deal_price) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Custom Gift Set Title</label>
                        <input type="text" name="gift_set_title" value="{{ old('gift_set_title') }}" placeholder="e.g. Get the Gentleman's Set instead" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Gift Set Subtitle</label>
                        <input type="text" name="gift_set_subtitle" value="{{ old('gift_set_subtitle') }}" placeholder="e.g. Belt + Wallet paired in presentation box" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Together Gift-Boxed Price (PKR)</label>
                        <input type="number" name="gift_set_price" value="{{ old('gift_set_price') }}" placeholder="e.g. 5999" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Separate Total Price (PKR)</label>
                        <input type="number" name="gift_set_original_price" value="{{ old('gift_set_original_price') }}" placeholder="e.g. 6999" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">Gift Box Image Upload</label>
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
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Allowed Checkout Payment Methods
                </label>
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
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            Shopper can choose between COD, Bank Transfer, JazzCash & EasyPaisa.
                        </p>
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
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            Disables COD at checkout. Advance payment via IBFT/Raast required.
                        </p>
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
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            Restricts checkout specifically to doorstep COD payment.
                        </p>
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
                            value="{{ old('weight_kg', '0.50') }}" 
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
                            value="{{ old('custom_shipping_charge') }}" 
                            placeholder="Leave blank for store default (Rs. 250)"
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
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                        Always offer Free Delivery on this piece, regardless of cart subtotal.
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_free_shipping" value="1" x-model="isFreeShipping" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- Google Search Engine SEO Preview -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <h3 class="text-xs font-bold text-espresso-950 dark:text-white">Google Search Engine Preview (SEO)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="By Zunash | Handcrafted Pure Leather..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Meta Description</label>
                        <input type="text" name="meta_description" value="{{ old('meta_description') }}" placeholder="Experience heirloom Pakistani leathercraft..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             BOTTOM FLOATING ACTION BAR (Always visible & accessible)
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
                        <span>Publish Product to Store</span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<!-- Real-time profit calculation helper -->
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
