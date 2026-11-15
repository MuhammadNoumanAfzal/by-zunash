@extends('admin.layouts.app')

@section('title', 'Add New Luxury Creation | By Zunash Atelier')

@section('content')

@php
    // Determine initial step based on validation errors
    $initialStep = 1;
    if (isset($errors) && $errors->hasAny(['price', 'cost_price', 'original_price', 'stock_quantity'])) {
        $initialStep = 2;
    } elseif (isset($errors) && $errors->hasAny(['allowed_payment_methods', 'custom_shipping_charge', 'weight_kg'])) {
        $initialStep = 3;
    } elseif (isset($errors) && $errors->hasAny(['image', 'image_file', 'gallery_files'])) {
        $initialStep = 4;
    } elseif (isset($errors) && $errors->hasAny(['short_description', 'description', 'spec_material'])) {
        $initialStep = 5;
    }
@endphp

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    step: {{ $initialStep }},
    totalSteps: 5,
    availability: '{{ old('availability', 'in_stock') }}',
    leadTime: '{{ old('lead_time', '') }}',
    paymentMethodRule: '{{ old('allowed_payment_methods', 'all') }}',
    isFreeShipping: {{ old('is_free_shipping') ? 'true' : 'false' }},
    primaryPreview: null,
    
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

    // Step Navigation
    nextStep() {
        if (this.step < this.totalSteps) {
            this.step++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => { if (typeof initRichEditors === 'function') initRichEditors(); }, 80);
        }
    },
    prevStep() {
        if (this.step > 1) {
            this.step--;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => { if (typeof initRichEditors === 'function') initRichEditors(); }, 80);
        }
    },
    goToStep(s) {
        this.step = s;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        setTimeout(() => { if (typeof initRichEditors === 'function') initRichEditors(); }, 80);
    },
    init() {
        setTimeout(() => { if (typeof initRichEditors === 'function') initRichEditors(); }, 150);
    },

    // Image preview helper
    handlePrimaryUpload(e) {
        const file = e.target.files[0];
        if (file) {
            this.primaryPreview = URL.createObjectURL(file);
        }
    }
}">

    <!-- Top Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
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

        <div class="flex items-center gap-2.5">
            <a 
                href="{{ route('admin.products.index') }}" 
                class="px-4 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#201A18] transition-colors"
            >
                Cancel
            </a>
            <button 
                type="submit" 
                form="createProductForm"
                class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 cursor-pointer"
            >
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                <span>Publish Now</span>
            </button>
        </div>
    </div>

    <!-- Stepper Navigation Bar (Tabs) -->
    <div class="bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] p-3 sm:p-4 shadow-xs">
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-xs">
            
            <!-- Step 1 Tab -->
            <button 
                type="button" 
                @click="goToStep(1)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2.5 cursor-pointer"
                :class="step === 1 ? 'bg-tan-500/10 dark:bg-tan-600/20 text-tan-700 dark:text-gold-300 font-bold border border-tan-500/30' : (step > 1 ? 'text-emerald-700 dark:text-emerald-400 hover:bg-gray-50 dark:hover:bg-[#241D1A]' : 'text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-[#241D1A]')"
            >
                <span 
                    class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 transition-colors"
                    :class="step === 1 ? 'bg-tan-600 text-white' : (step > 1 ? 'bg-emerald-600 text-white' : 'bg-gray-200 dark:bg-[#2E2520] text-gray-600 dark:text-gray-400')"
                >
                    <span x-show="step <= 1">1</span>
                    <i data-lucide="check" class="w-3.5 h-3.5" x-show="step > 1"></i>
                </span>
                <span class="truncate">1. Identity</span>
            </button>

            <!-- Step 2 Tab -->
            <button 
                type="button" 
                @click="goToStep(2)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2.5 cursor-pointer"
                :class="step === 2 ? 'bg-tan-500/10 dark:bg-tan-600/20 text-tan-700 dark:text-gold-300 font-bold border border-tan-500/30' : (step > 2 ? 'text-emerald-700 dark:text-emerald-400 hover:bg-gray-50 dark:hover:bg-[#241D1A]' : 'text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-[#241D1A]')"
            >
                <span 
                    class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 transition-colors"
                    :class="step === 2 ? 'bg-tan-600 text-white' : (step > 2 ? 'bg-emerald-600 text-white' : 'bg-gray-200 dark:bg-[#2E2520] text-gray-600 dark:text-gray-400')"
                >
                    <span x-show="step <= 2">2</span>
                    <i data-lucide="check" class="w-3.5 h-3.5" x-show="step > 2"></i>
                </span>
                <span class="truncate">2. Pricing & Profit</span>
            </button>

            <!-- Step 3 Tab -->
            <button 
                type="button" 
                @click="goToStep(3)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2.5 cursor-pointer"
                :class="step === 3 ? 'bg-tan-500/10 dark:bg-tan-600/20 text-tan-700 dark:text-gold-300 font-bold border border-tan-500/30' : (step > 3 ? 'text-emerald-700 dark:text-emerald-400 hover:bg-gray-50 dark:hover:bg-[#241D1A]' : 'text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-[#241D1A]')"
            >
                <span 
                    class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 transition-colors"
                    :class="step === 3 ? 'bg-tan-600 text-white' : (step > 3 ? 'bg-emerald-600 text-white' : 'bg-gray-200 dark:bg-[#2E2520] text-gray-600 dark:text-gray-400')"
                >
                    <span x-show="step <= 3">3</span>
                    <i data-lucide="check" class="w-3.5 h-3.5" x-show="step > 3"></i>
                </span>
                <span class="truncate">3. Shipping & Rules</span>
            </button>

            <!-- Step 4 Tab -->
            <button 
                type="button" 
                @click="goToStep(4)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2.5 cursor-pointer"
                :class="step === 4 ? 'bg-tan-500/10 dark:bg-tan-600/20 text-tan-700 dark:text-gold-300 font-bold border border-tan-500/30' : (step > 4 ? 'text-emerald-700 dark:text-emerald-400 hover:bg-gray-50 dark:hover:bg-[#241D1A]' : 'text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-[#241D1A]')"
            >
                <span 
                    class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 transition-colors"
                    :class="step === 4 ? 'bg-tan-600 text-white' : (step > 4 ? 'bg-emerald-600 text-white' : 'bg-gray-200 dark:bg-[#2E2520] text-gray-600 dark:text-gray-400')"
                >
                    <span x-show="step <= 4">4</span>
                    <i data-lucide="check" class="w-3.5 h-3.5" x-show="step > 4"></i>
                </span>
                <span class="truncate">4. Visuals & Swatches</span>
            </button>

            <!-- Step 5 Tab -->
            <button 
                type="button" 
                @click="goToStep(5)"
                class="p-2.5 rounded-xl text-left transition-all flex items-center gap-2.5 cursor-pointer col-span-2 sm:col-span-1"
                :class="step === 5 ? 'bg-tan-500/10 dark:bg-tan-600/20 text-tan-700 dark:text-gold-300 font-bold border border-tan-500/30' : 'text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-[#241D1A]'"
            >
                <span 
                    class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold shrink-0 transition-colors"
                    :class="step === 5 ? 'bg-tan-600 text-white' : 'bg-gray-200 dark:bg-[#2E2520] text-gray-600 dark:text-gray-400'"
                >
                    5
                </span>
                <span class="truncate">5. Story & SEO</span>
            </button>

        </div>

        <!-- Step Progress Bar -->
        <div class="w-full bg-gray-100 dark:bg-[#251D1A] h-1.5 rounded-full mt-3 overflow-hidden">
            <div 
                class="bg-gradient-to-r from-tan-600 to-gold-400 h-full transition-all duration-300 rounded-full"
                :style="'width: ' + (step * 20) + '%'"
            ></div>
        </div>
    </div>

    <!-- Creation Form Card -->
    <form id="createProductForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card">
        @csrf

        <!-- Hidden input for dynamic colors JSON -->
        <input type="hidden" name="colors_json" :value="activeColorsJson">

        <!-- ==============================================================
             STEP 1: IDENTITY, CATEGORIZATION & AVAILABILITY
             ============================================================== -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" class="space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">1</span>
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Product Identity & Collection
                    </h2>
                    <p class="text-[11px] text-[#8F8379]">Core identification, collection grouping, and production status.</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Product Name -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Product Title <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="e.g. The Royal Reversible Calfskin Belt"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500 font-medium"
                    >
                    @error('name')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category & Subcategory (Reactive Dependent Dropdown) -->
                <div 
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                    x-data="{
                        categoryId: '{{ old('category_id', '') }}',
                        subcategoryId: '{{ old('subcategory_id', '') }}',
                        allSubs: [
                            @foreach($subcategories as $s)
                                { id: {{ $s->id }}, name: '{{ addslashes($s->name) }}', category_id: {{ $s->category_id }} },
                            @endforeach
                        ],
                        get filteredSubs() {
                            if (!this.categoryId) return [];
                            return this.allSubs.filter(s => s.category_id == this.categoryId);
                        },
                        onCategoryChange() {
                            const valid = this.filteredSubs.some(s => s.id == this.subcategoryId);
                            if (!valid) {
                                this.subcategoryId = '';
                            }
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
                            @change="onCategoryChange()"
                            required
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-medium"
                        >
                            <option value="">Select Primary Collection</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subcategory -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                                Subcategory (Optional)
                            </label>
                            <a href="{{ route('admin.subcategories.index') }}#add-subcat" target="_blank" class="text-[10px] text-tan-600 hover:text-tan-700 font-semibold flex items-center gap-0.5">
                                <span>+ New Subcategory</span>
                            </a>
                        </div>
                        <select 
                            name="subcategory_id" 
                            x-model="subcategoryId"
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                        >
                            <option value="">No Subcategory / General Piece</option>
                            <template x-for="sub in filteredSubs" :key="sub.id">
                                <option :value="sub.id" x-text="sub.name" :selected="sub.id == subcategoryId"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <!-- SKU & Highlight Badge -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                            <span>SKU Reference</span>
                            <span class="text-[10px] text-[#8F8379]">Leave blank to auto-generate</span>
                        </label>
                        <input 
                            type="text" 
                            name="sku" 
                            value="{{ old('sku') }}" 
                            placeholder="e.g. BZ-BELT-001"
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500 font-mono uppercase"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                            Atelier Highlight Badge
                        </label>
                        <input 
                            type="text" 
                            name="badge" 
                            value="{{ old('badge') }}" 
                            placeholder="e.g. Bespoke Edition, 2-in-1 Swivel"
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500"
                        >
                    </div>
                </div>

                <!-- Availability & Lead Time -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                            <option value="on_demand">On Demand — Handcrafted to Order</option>
                            <option value="out_of_stock">Out of Stock — Sold Out / Concierge Notice</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                            <span>Production & Dispatch Lead Time</span>
                            <span class="text-[10px] text-tan-600 dark:text-gold-400" x-show="availability === 'on_demand'">Recommended for On Demand</span>
                        </label>
                        <input 
                            type="text" 
                            name="lead_time" 
                            x-model="leadTime"
                            placeholder="e.g. 7–10 Working Days"
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-[#6E645E] focus:outline-hidden focus:border-tan-500"
                            :class="availability === 'on_demand' ? 'border-amber-400 dark:border-amber-500/50 bg-amber-50/20' : ''"
                        >
                    </div>
                </div>

                <!-- Bestseller & New Arrival Toggles -->
                <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420] flex flex-wrap items-center gap-6">
                    <label class="inline-flex items-center gap-2.5 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white select-none">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>⭐ Mark as Bestseller / Flagship</span>
                    </label>

                    <label class="inline-flex items-center gap-2.5 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white select-none">
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new', '1') ? 'checked' : '' }} class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>✨ Mark as New Arrival</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- ==============================================================
             STEP 2: VALUATION, COST & INVENTORY
             ============================================================== -->
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" class="space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">2</span>
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Pricing, Cost & Profit Engine
                    </h2>
                    <p class="text-[11px] text-[#8F8379]">Selling price, production cost price for profit metrics, and inventory quantities.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Retail / Selling Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Selling Price (PKR) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        id="prod_retail_price"
                        name="price" 
                        value="{{ old('price') }}" 
                        placeholder="e.g. 4950"
                        required
                        oninput="calculateProfitMargin()"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono font-bold"
                    >
                    @error('price')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase / Cost Price -->
                <div>
                    <label class="block text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1.5 flex items-center justify-between">
                        <span>Cost Price (PKR)</span>
                        <span class="text-[10px] font-normal text-gray-500">For Real Profit</span>
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        id="prod_cost_price"
                        name="cost_price" 
                        value="{{ old('cost_price') }}" 
                        placeholder="e.g. 2100"
                        oninput="calculateProfitMargin()"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-300 dark:border-emerald-800/40 text-emerald-900 dark:text-emerald-300 placeholder:text-gray-400 focus:outline-hidden focus:border-emerald-500 font-mono font-bold"
                    >
                </div>

                <!-- Original / Compare-At Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Original / Strikethrough (PKR)
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        name="original_price" 
                        value="{{ old('original_price') }}" 
                        placeholder="e.g. 6500"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono"
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
                        value="{{ old('stock_quantity') }}" 
                        placeholder="e.g. 15"
                        required
                        min="0"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono font-semibold"
                    >
                    @error('stock_quantity')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Real-Time Profit Calculation Card -->
            <div id="profit_margin_preview" class="p-4 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5 text-emerald-900 dark:text-emerald-300">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="font-bold">Estimated Atelier Profit Per Sale</div>
                        <div class="text-[11px] text-emerald-700 dark:text-emerald-400">Calculated as: Selling Price − Cost Price (COGS)</div>
                    </div>
                </div>
                <div id="profit_calc_result" class="font-mono font-bold text-sm text-emerald-800 dark:text-emerald-300 sm:text-right">
                    Enter Selling & Cost Price
                </div>
            </div>
        </div>

        <!-- ==============================================================
             STEP 3: SHIPPING, WEIGHT & PAYMENT RULES (NEW FEATURE!)
             ============================================================== -->
        <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" class="space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">3</span>
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Shipping, Courier Weight & Payment Controls
                    </h2>
                    <p class="text-[11px] text-[#8F8379]">Restrict payment methods per product (e.g. No COD on luxury pieces) and custom delivery charges.</p>
                </div>
            </div>

            <!-- 1. Allowed Payment Methods Rule -->
            <div class="space-y-3">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Allowed Checkout Payment Methods <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    <!-- Option 1: All Methods -->
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between gap-3 relative overflow-hidden"
                        :class="paymentMethodRule === 'all' ? 'border-tan-600 bg-[#FAF7F2] dark:bg-[#2A1F1A] ring-2 ring-tan-500/20' : 'border-[#E0D7CB] dark:border-[#3A2F29] hover:border-gray-400 bg-white dark:bg-[#201A18]'"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="check-check" class="w-4 h-4 text-emerald-600"></i>
                                All Payment Methods
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="all" x-model="paymentMethodRule" class="text-tan-600 focus:ring-tan-500">
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                            Shopper can choose between <strong>Cash on Delivery (COD)</strong>, Bank Transfer, JazzCash & EasyPaisa.
                        </p>
                        <span class="text-[10px] font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-950/40 px-2 py-0.5 rounded-md w-fit">
                            Standard Recommended
                        </span>
                    </label>

                    <!-- Option 2: Prepaid Only (Bank / Mobile Account) -->
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between gap-3 relative overflow-hidden"
                        :class="paymentMethodRule === 'prepaid_only' ? 'border-amber-600 bg-amber-50/50 dark:bg-[#2A1F1A] ring-2 ring-amber-500/20' : 'border-[#E0D7CB] dark:border-[#3A2F29] hover:border-gray-400 bg-white dark:bg-[#201A18]'"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="shield-alert" class="w-4 h-4 text-amber-600"></i>
                                Bank Transfer Only (No COD)
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="prepaid_only" x-model="paymentMethodRule" class="text-amber-600 focus:ring-amber-500">
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                            COD is disabled at checkout. Shopper <strong>must pay in advance</strong> via IBFT or JazzCash/EasyPaisa.
                        </p>
                        <span class="text-[10px] font-semibold text-amber-700 dark:text-amber-400 bg-amber-100 dark:bg-amber-950/40 px-2 py-0.5 rounded-md w-fit">
                            For High-Value / Bespoke Items
                        </span>
                    </label>

                    <!-- Option 3: COD Only -->
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between gap-3 relative overflow-hidden"
                        :class="paymentMethodRule === 'cod_only' ? 'border-tan-600 bg-[#FAF7F2] dark:bg-[#2A1F1A] ring-2 ring-tan-500/20' : 'border-[#E0D7CB] dark:border-[#3A2F29] hover:border-gray-400 bg-white dark:bg-[#201A18]'"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="banknote" class="w-4 h-4 text-tan-600"></i>
                                Cash on Delivery (COD) Only
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="cod_only" x-model="paymentMethodRule" class="text-tan-600 focus:ring-tan-500">
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                            Restricts payment specifically to COD at doorstep upon nationwide receipt.
                        </p>
                        <span class="text-[10px] font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-[#2A221E] px-2 py-0.5 rounded-md w-fit">
                            COD Exclusive
                        </span>
                    </label>

                </div>
            </div>

            <!-- 2. Weight & Delivery Charges -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <!-- Product Weight (KG) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Approx. Weight (Kilograms)</span>
                        <span class="text-[10px] text-gray-500">For Courier Rates</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            step="0.05" 
                            name="weight_kg" 
                            value="{{ old('weight_kg') }}" 
                            placeholder="e.g. 0.50"
                            class="w-full pl-3.5 pr-12 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono font-semibold"
                        >
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">KG</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1">Helps calculate heavy-parcel shipping manifests.</p>
                </div>

                <!-- Custom Delivery Charge -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Custom Delivery Charge (PKR)</span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400">Optional Override</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            step="1" 
                            name="custom_shipping_charge" 
                            value="{{ old('custom_shipping_charge') }}" 
                            placeholder="Leave empty for store default (Rs. 250)"
                            class="w-full pl-10 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 font-mono"
                        >
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">Rs.</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1">If blank, store standard shipping policy applies automatically.</p>
                </div>
            </div>

            <!-- 3. Guaranteed Free Shipping Toggle -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-espresso-950 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="gift" class="w-4 h-4 text-tan-600"></i>
                        <span>Complimentary Free Shipping Guarantee</span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                        Always offer Free Delivery on this creation, regardless of shopping bag total.
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_free_shipping" value="1" x-model="isFreeShipping" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>
        </div>

        <!-- ==============================================================
             STEP 4: VISUALS, GALLERY & LEATHER TONES
             ============================================================== -->
        <div x-show="step === 4" x-transition:enter="transition ease-out duration-200" class="space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">4</span>
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Atelier Imagery & Leather Tones
                    </h2>
                    <p class="text-[11px] text-[#8F8379]">Primary silhouette photo (auto-converted to WebP), gallery angles, and color swatches.</p>
                </div>
            </div>

            <!-- Primary Image Upload -->
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
                            <div class="w-12 h-12 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-600 dark:text-gold-400 flex items-center justify-center">
                                <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                            </div>
                            <span class="text-xs font-semibold text-espresso-900 dark:text-white">
                                Click to select from device or drag & drop
                            </span>
                            <span class="text-[10px] text-gray-500">
                                JPG, PNG, WEBP, AVIF up to 5MB. Automatically compressed to high-speed WebP!
                            </span>
                        </label>
                    </div>

                    <!-- Fallback Path / URL input -->
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1">
                            Or Existing Relative Path
                        </label>
                        <input 
                            type="text" 
                            name="image" 
                            value="{{ old('image') }}" 
                            placeholder="/images/products/prod-reversible-belt.webp"
                            class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white font-mono"
                        >
                    </div>
                </div>

                <!-- Live Preview Card -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-2">
                        Live Image Preview
                    </label>
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#3A2F29] flex items-center justify-center relative shadow-xs">
                        <template x-if="primaryPreview">
                            <img :src="primaryPreview" alt="Preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!primaryPreview">
                            <div class="text-center p-4 text-gray-400">
                                <i data-lucide="image" class="w-8 h-8 mx-auto mb-1 text-gray-300"></i>
                                <span class="text-[11px]">Upload to preview</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Additional Gallery Angles -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Additional Gallery Angle Images (Multi-upload)
                </label>
                <div class="border-2 border-dashed border-[#DFD6CB] dark:border-[#3A2F29] rounded-2xl p-5 text-center hover:border-tan-500 transition-colors bg-[#FAF8F5] dark:bg-[#241D1A]">
                    <input 
                        type="file" 
                        name="gallery_files[]" 
                        id="galleryImagesInput" 
                        accept="image/*" 
                        multiple
                        class="hidden"
                    >
                    <label for="galleryImagesInput" class="cursor-pointer flex flex-col items-center justify-center gap-1.5">
                        <i data-lucide="images" class="w-6 h-6 text-tan-600 dark:text-gold-400"></i>
                        <span class="text-xs font-semibold text-espresso-900 dark:text-white">
                            Select multiple gallery photos (Buckle closeups, interior, packing)
                        </span>
                        <span class="text-[10px] text-gray-500">Hold Ctrl or Shift to select multiple photos</span>
                    </label>
                </div>
            </div>

            <!-- Handcrafted Leather Colorway Swatches -->
            <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-espresso-950 dark:text-white">
                            Available Leather Tone Swatches
                        </h3>
                        <p class="text-[11px] text-[#8F8379]">Select the color tones available for this handcrafted creation.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="toggleAll(true)" class="text-[10px] text-tan-600 hover:underline font-semibold cursor-pointer">Select All</button>
                        <span class="text-gray-300">|</span>
                        <button type="button" @click="toggleAll(false)" class="text-[10px] text-gray-500 hover:underline font-semibold cursor-pointer">Clear All</button>
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
                        placeholder="Custom Tone Name (e.g. Vintage Bourbon)" 
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

        <!-- ==============================================================
             STEP 5: STORY, SPECIFICATIONS & SEO
             ============================================================== -->
        <div x-show="step === 5" x-transition:enter="transition ease-out duration-200" class="space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">5</span>
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Editorial Story, Specifications & SEO
                    </h2>
                    <p class="text-[11px] text-[#8F8379]">Punchy tagline, full story, material specs, and Google search snippet.</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Short Description (Rich Editor) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Short Tagline Description <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                            <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                        </span>
                    </label>
                    <textarea 
                        name="short_description" 
                        id="prod_short_desc"
                        class="hidden"
                    >{{ old('short_description') }}</textarea>
                    <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                        <div 
                            data-rich-editor="compact" 
                            data-target="#prod_short_desc" 
                            data-placeholder="e.g. Handcrafted full-grain calfskin leather belt with an antique brass 360° swivel buckle."
                            style="min-height: 90px;"
                        >{!! old('short_description') !!}</div>
                    </div>
                    @error('short_description')
                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Artisanal Highlights / Features (Rich Editor) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Artisanal Highlights (Bullet Points)</span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                            <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                        </span>
                    </label>
                    <textarea 
                        name="features_raw" 
                        id="prod_features_raw"
                        class="hidden"
                    >{{ old('features_raw') }}</textarea>
                    <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                        <div 
                            data-rich-editor="highlights" 
                            data-target="#prod_features_raw" 
                            data-placeholder="Type bullet points (e.g. 100% full-grain calfskin, solid brass hardware, 5-year guarantee...)"
                            style="min-height: 100px;"
                        >{!! old('features_raw') !!}</div>
                    </div>
                </div>

                <!-- Full Editorial Story (Rich Editor) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Full Atelier Story & Craft Description</span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                            <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                        </span>
                    </label>
                    <textarea 
                        name="description" 
                        id="prod_desc"
                        class="hidden"
                    >{{ old('description') }}</textarea>
                    <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                        <div 
                            data-rich-editor="full" 
                            data-target="#prod_desc" 
                            data-placeholder="Detailed narrative about the hide selection, drum-dyeing, hand-waxed saddle stitching, and heirloom longevity..."
                            style="min-height: 140px;"
                        >{!! old('description') !!}</div>
                    </div>
                </div>

                <!-- Specifications Grid (Clean Empty Placeholders - Zero Pre-Filled Text) -->
                <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold text-espresso-950 dark:text-white">
                            Technical Specifications
                        </h3>
                        <span class="text-[10px] text-gray-400">All fields are optional</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Leather / Material</label>
                            <input type="text" name="spec_material" value="{{ old('spec_material') }}" placeholder="e.g. 100% Full-Grain Vegetable-Tanned Calfskin" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Hardware / Buckle</label>
                            <input type="text" name="spec_hardware" value="{{ old('spec_hardware') }}" placeholder="e.g. Solid Antique Brass Hardware" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Dimensions & Width</label>
                            <input type="text" name="spec_dimensions" value="{{ old('spec_dimensions') }}" placeholder="e.g. 35mm (1.38 in) width" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Lining & Seams</label>
                            <input type="text" name="spec_care" value="{{ old('spec_care') }}" placeholder="e.g. Hand-waxed bonded nylon thread" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Atelier Origin</label>
                            <input type="text" name="spec_origin" value="{{ old('spec_origin') }}" placeholder="e.g. Handcrafted in Pakistan" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Packaging Box</label>
                            <input type="text" name="spec_packaging" value="{{ old('spec_packaging') }}" placeholder="e.g. Rigid Foil-Embossed Presentation Box" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        </div>
                    </div>
                </div>

                <!-- Google SEO Snippet -->
                <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                    <h3 class="text-xs font-bold text-espresso-950 dark:text-white mb-2">
                        Google Search Engine Preview (SEO)
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="By Zunash | Handcrafted Leather..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Meta Description</label>
                            <input type="text" name="meta_description" value="{{ old('meta_description') }}" placeholder="Experience heirloom Pakistani leathercraft..." class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================================================
             BOTTOM STEPPER CONTROLS & SUBMIT BUTTONS
             ============================================================== -->
        <div class="pt-6 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between gap-4 mt-8">
            <!-- Previous Button -->
            <button 
                type="button" 
                @click="prevStep()" 
                x-show="step > 1"
                class="px-4 py-2.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-bold text-espresso-900 dark:text-white hover:bg-gray-50 dark:hover:bg-[#201A18] transition-all flex items-center gap-1.5 cursor-pointer"
            >
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Previous Step</span>
            </button>
            <div x-show="step === 1"></div>

            <div class="flex items-center gap-3">
                <!-- Next Button -->
                <button 
                    type="button" 
                    @click="nextStep()" 
                    x-show="step < totalSteps"
                    class="px-5 py-2.5 rounded-xl bg-espresso-900 dark:bg-white text-white dark:text-espresso-950 text-xs font-bold hover:bg-black dark:hover:bg-gray-100 transition-all flex items-center gap-1.5 cursor-pointer shadow-md"
                >
                    <span>Next: Continue</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>

                <!-- Final Save & Publish Button -->
                <button 
                    type="submit" 
                    x-show="step === totalSteps"
                    class="px-6 py-2.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 cursor-pointer"
                >
                    <i data-lucide="sparkles" class="w-4 h-4 text-gold-300"></i>
                    <span>Save & Publish to Store</span>
                </button>
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
        resultEl.innerHTML = `PKR ${profit.toLocaleString()} profit <span class="ml-1 text-[11px] bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded font-bold">${margin}% margin</span>`;
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
    if (typeof initRichEditors === 'function') {
        initRichEditors();
    }
});
</script>

@endsection
