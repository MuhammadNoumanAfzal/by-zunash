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

    // Determine initial step based on validation errors
    $initialStep = 1;
    if ($errors->hasAny(['price', 'cost_price', 'original_price', 'stock_quantity'])) {
        $initialStep = 2;
    } elseif ($errors->hasAny(['allowed_payment_methods', 'custom_shipping_charge', 'weight_kg'])) {
        $initialStep = 3;
    } elseif ($errors->hasAny(['image', 'image_file', 'gallery_files'])) {
        $initialStep = 4;
    } elseif ($errors->hasAny(['short_description', 'description', 'spec_material'])) {
        $initialStep = 5;
    }
@endphp

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    step: {{ $initialStep }},
    totalSteps: 5,
    availability: '{{ old('availability', $product->availability ?? 'in_stock') }}',
    leadTime: '{{ old('lead_time', $product->lead_time ?? '') }}',
    paymentMethodRule: '{{ old('allowed_payment_methods', $product->allowed_payment_methods ?? 'all') }}',
    isFreeShipping: {{ old('is_free_shipping', $product->is_free_shipping) ? 'true' : 'false' }},
    primaryPreview: null,
    
    // Color Palette Manager
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

    // Step Navigation
    nextStep() {
        if (this.step < this.totalSteps) {
            this.step++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
    prevStep() {
        if (this.step > 1) {
            this.step--;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
    goToStep(s) {
        this.step = s;
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
                <span class="text-espresso-950 dark:text-white font-medium">Edit Creation</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Edit: {{ $product->name }}
            </h1>
        </div>

        <div class="flex items-center gap-2.5">
            <a 
                href="{{ route('product.details', $product->slug) }}" 
                target="_blank"
                class="px-3.5 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#201A18] transition-colors flex items-center gap-1.5"
            >
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                <span class="hidden sm:inline">Storefront</span>
            </a>
            <a 
                href="{{ route('admin.products.index') }}" 
                class="px-4 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#201A18] transition-colors"
            >
                Back
            </a>
            <button 
                type="submit" 
                form="editProductForm"
                class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 cursor-pointer"
            >
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Save Changes</span>
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
                    <template x-if="step > 1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </template>
                    <template x-if="step <= 1">
                        <span>1</span>
                    </template>
                </span>
                <div class="min-w-0">
                    <div class="truncate text-[11px] uppercase tracking-wider font-semibold opacity-75">Step 1</div>
                    <div class="truncate text-xs font-bold">Identity & Category</div>
                </div>
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
                    <template x-if="step > 2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </template>
                    <template x-if="step <= 2">
                        <span>2</span>
                    </template>
                </span>
                <div class="min-w-0">
                    <div class="truncate text-[11px] uppercase tracking-wider font-semibold opacity-75">Step 2</div>
                    <div class="truncate text-xs font-bold">Price & Inventory</div>
                </div>
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
                    <template x-if="step > 3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </template>
                    <template x-if="step <= 3">
                        <span>3</span>
                    </template>
                </span>
                <div class="min-w-0">
                    <div class="truncate text-[11px] uppercase tracking-wider font-semibold opacity-75">Step 3</div>
                    <div class="truncate text-xs font-bold">Shipping & Rules</div>
                </div>
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
                    <template x-if="step > 4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </template>
                    <template x-if="step <= 4">
                        <span>4</span>
                    </template>
                </span>
                <div class="min-w-0">
                    <div class="truncate text-[11px] uppercase tracking-wider font-semibold opacity-75">Step 4</div>
                    <div class="truncate text-xs font-bold">Visuals & Swatches</div>
                </div>
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
                <div class="min-w-0">
                    <div class="truncate text-[11px] uppercase tracking-wider font-semibold opacity-75">Step 5</div>
                    <div class="truncate text-xs font-bold">Story & SEO</div>
                </div>
            </button>

        </div>

        <!-- Progress Bar Line -->
        <div class="w-full bg-gray-100 dark:bg-[#241D1A] h-1.5 rounded-full mt-3 overflow-hidden">
            <div 
                class="bg-tan-600 h-full transition-all duration-300 ease-out"
                :style="'width: ' + ((step / totalSteps) * 100) + '%'"
            ></div>
        </div>
    </div>

    <!-- Edit Form Card -->
    <form id="editProductForm" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Hidden input for dynamic colors JSON -->
        <input type="hidden" name="colors_json" :value="activeColorsJson">

        <!-- ======================================================== -->
        <!-- STEP 1: IDENTITY & COLLECTION                           -->
        <!-- ======================================================== -->
        <div x-show="step === 1" x-cloak class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">1</span>
                    <div>
                        <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">Product Identity & Collection</h2>
                        <p class="text-xs text-[#8F8379]">Core catalog reference, SKU, and taxonomy classification</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-tan-600 dark:text-gold-400 font-bold">Step 1 of 5</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
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
                        placeholder="e.g. The Sovereign Reversible Calfskin Belt"
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 focus:ring-1 focus:ring-tan-500 font-medium"
                    >
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category & Subcategory Reactive Picker -->
                <div 
                    class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5"
                    x-data="{
                        categoryId: '{{ old('category_id', $product->category_id ?? '') }}',
                        subcategoryId: '{{ old('subcategory_id', $product->subcategory_id ?? '') }}',
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
                            class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-medium"
                        >
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
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
                            class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-medium"
                        >
                            <option value="">No Subcategory / General Piece</option>
                            <template x-for="sub in filteredSubs" :key="sub.id">
                                <option :value="sub.id" x-text="sub.name" :selected="sub.id == subcategoryId"></option>
                            </template>
                        </select>
                    </div>
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
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono uppercase"
                    >
                    @error('sku')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
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
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <!-- Flags -->
                <div class="sm:col-span-2 flex flex-wrap items-center gap-6 pt-2">
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

            <!-- Wizard Step 1 Footer -->
            <div class="pt-5 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between">
                <span class="text-xs text-[#8F8379]">Proceed to pricing & stock limits</span>
                <button 
                    type="button" 
                    @click="nextStep()" 
                    class="px-5 py-2.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs"
                >
                    <span>Next: Valuation & Profit</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- STEP 2: VALUATION, COST & INVENTORY                     -->
        <!-- ======================================================== -->
        <div x-show="step === 2" x-cloak class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">2</span>
                    <div>
                        <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">Valuation, Cost & Inventory</h2>
                        <p class="text-xs text-[#8F8379]">Set selling price, purchase cost for net margins, and availability</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-tan-600 dark:text-gold-400 font-bold">Step 2 of 5</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-2">
                <!-- Retail Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Retail / Selling Price (PKR) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        id="prod_retail_price"
                        name="price" 
                        value="{{ old('price', $product->price) }}" 
                        required
                        oninput="calculateProfitMargin()"
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono font-bold"
                    >
                    @error('price')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase / Cost Price (COGS) -->
                <div>
                    <label class="block text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1.5 flex items-center justify-between">
                        <span>Purchase / Cost (PKR)</span>
                        <span class="text-[10px] font-normal text-gray-500">For Real Profit</span>
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        id="prod_cost_price"
                        name="cost_price" 
                        value="{{ old('cost_price', $product->cost_price ?? 0) }}" 
                        placeholder="e.g. 2100"
                        oninput="calculateProfitMargin()"
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 text-emerald-900 dark:text-emerald-300 placeholder:text-gray-400 focus:outline-hidden focus:border-emerald-500 font-mono font-bold"
                    >
                </div>

                <!-- Compare Price -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Original Compare Price (PKR)
                    </label>
                    <input 
                        type="number" 
                        step="1" 
                        name="original_price" 
                        value="{{ old('original_price', $product->original_price) }}" 
                        placeholder="Optional discount anchor"
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
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
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >
                </div>

                <!-- Availability Type -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Availability Status <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="availability" 
                        x-model="availability"
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-medium"
                    >
                        <option value="in_stock">In Stock — Ready to Dispatch</option>
                        <option value="on_demand">On Demand — Made to Order</option>
                        <option value="out_of_stock">Out of Stock — Sold Out / Concierge Notice</option>
                    </select>
                </div>

                <!-- Lead Time -->
                <div class="sm:col-span-1">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Production Lead Time</span>
                        <span class="text-[10px] text-tan-600 dark:text-gold-400" x-show="availability === 'on_demand'">Required for On Demand</span>
                    </label>
                    <input 
                        type="text" 
                        name="lead_time" 
                        x-model="leadTime"
                        placeholder="e.g. 7–10 Working Days"
                        class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                        :class="availability === 'on_demand' ? 'border-amber-400 dark:border-amber-500/50 bg-amber-50/20' : ''"
                    >
                </div>

                <!-- Real-Time Profit Margin Preview Badge -->
                <div id="profit_margin_preview" class="sm:col-span-3 px-4 py-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-dashed border-[#E0D7CB] dark:border-[#3A2F29] flex items-center justify-between text-xs">
                    <span class="text-gray-600 dark:text-gray-400 flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Calculated Unit Profit (Selling Price - Purchase Cost):
                    </span>
                    <span id="profit_calc_result" class="font-mono font-bold text-emerald-700 dark:text-emerald-400">
                        Calculating profit...
                    </span>
                </div>
            </div>

            <!-- Wizard Step 2 Footer -->
            <div class="pt-5 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between">
                <button 
                    type="button" 
                    @click="prevStep()" 
                    class="px-5 py-2.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-gray-700 dark:text-gray-300 text-xs font-semibold hover:bg-gray-50 dark:hover:bg-[#241D1A] transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    <span>Back: Identity</span>
                </button>
                <button 
                    type="button" 
                    @click="nextStep()" 
                    class="px-5 py-2.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs"
                >
                    <span>Next: Shipping & Payment Rules</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- STEP 3: SHIPPING & PAYMENT RULES (NEW CLIENT FEATURES)   -->
        <!-- ======================================================== -->
        <div x-show="step === 3" x-cloak class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">3</span>
                    <div>
                        <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">Payment & Delivery Policy Control</h2>
                        <p class="text-xs text-[#8F8379]">Restrict payment channels (COD / Prepaid) & set item shipping weight and charges</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-tan-600 dark:text-gold-400 font-bold">Step 3 of 5</span>
            </div>

            <!-- Payment Method Rule Radios -->
            <div class="space-y-3 pt-2">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Allowed Payment Methods For This Creation <span class="text-rose-500">*</span>
                </label>
                <p class="text-[11px] text-[#8F8379]">
                    Control how patrons can pay for this piece. Perfect for requiring advance bank transfer on luxury or customized items.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    <!-- Option 1: All Payment Methods -->
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between"
                        :class="paymentMethodRule === 'all' 
                            ? 'border-tan-600 bg-tan-500/5 dark:bg-tan-600/10 ring-1 ring-tan-500/30' 
                            : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18] hover:border-gray-300'"
                    >
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                                <span>All Methods</span>
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="all" x-model="paymentMethodRule" class="text-tan-600 focus:ring-tan-500">
                        </div>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            COD, Bank Transfer (IBFT), JazzCash & EasyPaisa all accepted at checkout.
                        </p>
                    </label>

                    <!-- Option 2: Prepaid Only (No COD) -->
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between"
                        :class="paymentMethodRule === 'prepaid_only' 
                            ? 'border-amber-600 bg-amber-500/5 dark:bg-amber-600/10 ring-1 ring-amber-500/30' 
                            : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18] hover:border-gray-300'"
                    >
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-xs text-amber-800 dark:text-amber-400 flex items-center gap-1.5">
                                <i data-lucide="shield-check" class="w-4 h-4 text-amber-600"></i>
                                <span>Prepaid Only (No COD)</span>
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="prepaid_only" x-model="paymentMethodRule" class="text-amber-600 focus:ring-amber-500">
                        </div>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Advance Payment only (Bank / JazzCash). COD is automatically disabled at checkout.
                        </p>
                    </label>

                    <!-- Option 3: COD Only -->
                    <label 
                        class="p-4 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between"
                        :class="paymentMethodRule === 'cod_only' 
                            ? 'border-blue-600 bg-blue-500/5 dark:bg-blue-600/10 ring-1 ring-blue-500/30' 
                            : 'border-[#E0D7CB] dark:border-[#3A2F29] bg-white dark:bg-[#201A18] hover:border-gray-300'"
                    >
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-xs text-blue-800 dark:text-blue-400 flex items-center gap-1.5">
                                <i data-lucide="banknote" class="w-4 h-4 text-blue-600"></i>
                                <span>COD Only</span>
                            </span>
                            <input type="radio" name="allowed_payment_methods" value="cod_only" x-model="paymentMethodRule" class="text-blue-600 focus:ring-blue-500">
                        </div>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Cash on Delivery only. Electronic bank transfers are suppressed.
                        </p>
                    </label>

                </div>
            </div>

            <!-- Shipping Charges & Parcel Weight -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                
                <!-- Weight in KG -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Parcel Weight (Kilograms - KG)</span>
                        <span class="text-[10px] text-[#8F8379]">Courier Rate Sheet</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            step="0.05" 
                            min="0"
                            name="weight_kg" 
                            value="{{ old('weight_kg', $product->weight_kg ?? 0.50) }}" 
                            placeholder="0.50"
                            class="w-full pl-4 pr-12 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                        >
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">KG</span>
                    </div>
                    <p class="text-[10px] text-[#8F8379] mt-1">
                        E.g. 0.35 kg for cardholders/wallets; 0.65 kg for belts; 1.50 kg for leather holdall bags.
                    </p>
                </div>

                <!-- Custom Delivery Charge (Override global flat shipping) -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5 flex items-center justify-between">
                        <span>Custom Delivery Charge (PKR)</span>
                        <span class="text-[10px] text-tan-600 font-semibold">Override Default</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            step="1" 
                            min="0"
                            name="custom_shipping_charge" 
                            value="{{ old('custom_shipping_charge', $product->custom_shipping_charge) }}" 
                            placeholder="Leave blank for global store rate"
                            class="w-full pl-4 pr-12 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                        >
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">PKR</span>
                    </div>
                    <p class="text-[10px] text-[#8F8379] mt-1">
                        If set, replaces default shipping (e.g. Rs. 450 for heavy bulky items). Leave empty to use store default.
                    </p>
                </div>

                <!-- Free Shipping Toggle -->
                <div class="sm:col-span-2 pt-2">
                    <label class="flex items-center gap-3 p-4 rounded-2xl border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#201A18] cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_free_shipping" 
                            value="1" 
                            x-model="isFreeShipping"
                            class="w-4 h-4 rounded border-[#DFD6CB] text-emerald-600 focus:ring-emerald-500"
                        >
                        <div class="flex-1">
                            <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="gift" class="w-4 h-4 text-emerald-600"></i>
                                <span>Guaranteed Free Shipping For This Product</span>
                            </span>
                            <p class="text-[11px] text-gray-500 leading-relaxed mt-0.5">
                                Patrons buying this product will receive 100% free nationwide delivery regardless of total cart threshold.
                            </p>
                        </div>
                    </label>
                </div>

            </div>

            <!-- Wizard Step 3 Footer -->
            <div class="pt-5 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between">
                <button 
                    type="button" 
                    @click="prevStep()" 
                    class="px-5 py-2.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-gray-700 dark:text-gray-300 text-xs font-semibold hover:bg-gray-50 dark:hover:bg-[#241D1A] transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    <span>Back: Pricing</span>
                </button>
                <button 
                    type="button" 
                    @click="nextStep()" 
                    class="px-5 py-2.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs"
                >
                    <span>Next: Visuals & Swatches</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- STEP 4: VISUALS, GALLERY & COLOR SWATCHES               -->
        <!-- ======================================================== -->
        <div x-show="step === 4" x-cloak class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">4</span>
                    <div>
                        <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">Visuals, Atelier Gallery & Swatches</h2>
                        <p class="text-xs text-[#8F8379]">Primary photograph, multi-angle gallery, and clickable leather tone swatches</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-tan-600 dark:text-gold-400 font-bold">Step 4 of 5</span>
            </div>

            <!-- Primary Image -->
            <div class="space-y-3 pt-2">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white">
                    Primary Creation Image <span class="text-rose-500">*</span>
                </label>

                <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-dashed border-[#DFD6CB] dark:border-[#382D27] flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-espresso-950/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#382D27] shrink-0 flex items-center justify-center shadow-xs">
                        <img 
                            id="prod_preview" 
                            :src="primaryPreview || '{{ old('image', $product->image ?: '/images/products/prod-reversible-belt.jpg') }}'" 
                            alt="Preview" 
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <div class="flex-1 min-w-0 text-center sm:text-left">
                        <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs cursor-pointer transition-colors shadow-2xs">
                            <i data-lucide="upload-cloud" class="w-4 h-4 text-gold-400"></i>
                            <span>Upload Replacement Photo</span>
                            <input 
                                type="file" 
                                name="image_file" 
                                accept="image/*" 
                                class="hidden" 
                                @change="handlePrimaryUpload($event)"
                                onchange="previewProductImage(this)"
                            >
                        </label>
                        <p class="text-[10px] text-[#8F8379] mt-1.5" id="prod_file_name">
                            Recommended: Square 800x800 or 1200x1200 WebP/JPG (Auto-optimized on upload)
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Or Existing Asset Path / Image URL</label>
                    <input 
                        type="text" 
                        id="prod_image_url"
                        name="image" 
                        value="{{ old('image', $product->image) }}" 
                        oninput="previewProductUrl(this.value)"
                        class="w-full px-4 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >
                </div>
            </div>

            <!-- Additional Multi-Image Gallery -->
            <div class="space-y-3 pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white flex items-center justify-between">
                    <span>Additional Multi-Angle Gallery</span>
                    <span class="text-[10px] text-[#8F8379]">Select multiple photos</span>
                </label>

                <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-dashed border-[#DFD6CB] dark:border-[#382D27]">
                    <div class="flex flex-wrap items-center gap-3">
                        <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs cursor-pointer transition-colors shadow-2xs">
                            <i data-lucide="images" class="w-4 h-4 text-gold-400"></i>
                            <span>Upload Additional Angles</span>
                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="hidden" onchange="previewGalleryFiles(this)">
                        </label>
                        <span class="text-[11px] text-[#8F8379]" id="gallery_upload_status">
                            Select one or multiple photos to add to gallery
                        </span>
                    </div>

                    <!-- Live Selected Files Preview Grid -->
                    <div id="gallery_preview_grid" class="hidden mt-3 pt-3 border-t border-[#EAE3D9] dark:border-[#2E2420] grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5"></div>
                </div>

                <!-- Existing Additional Gallery Thumbnails -->
                @php
                    $existingAdditional = array_values(array_filter($galleryList, fn($img) => $img !== $product->image));
                @endphp
                @if(count($existingAdditional) > 0)
                    <div class="p-3.5 rounded-xl bg-[#FAF8F5] dark:bg-[#221B18] border border-[#E0D7CB] dark:border-[#382D27]">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] font-semibold text-espresso-900 dark:text-white flex items-center gap-1.5">
                                <i data-lucide="images" class="w-3.5 h-3.5 text-gold-500"></i>
                                <span>Current Gallery Photos ({{ count($existingAdditional) }})</span>
                            </span>
                            <span class="text-[10px] text-[#8F8379]">Click &times; to remove photo</span>
                        </div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5" id="existing_gallery_container">
                            @foreach($existingAdditional as $idx => $imgUrl)
                                <div class="relative group rounded-xl overflow-hidden bg-black/10 dark:bg-black/40 border border-[#E0D7CB] dark:border-[#3A2F29] aspect-square" data-gallery-item="{{ $imgUrl }}">
                                    <img src="{{ $imgUrl }}" alt="Gallery image {{ $idx + 1 }}" class="w-full h-full object-cover">
                                    <button 
                                        type="button" 
                                        onclick="removeExistingGalleryImage('{{ addslashes($imgUrl) }}', this)" 
                                        class="absolute top-1 right-1 w-5 h-5 rounded-full bg-rose-600/90 hover:bg-rose-600 text-white flex items-center justify-center text-xs shadow-md transition-transform hover:scale-110 cursor-pointer"
                                        title="Remove photo"
                                    >&times;</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Or edit Image URLs / Existing Paths (One per line)</label>
                    <textarea 
                        id="gallery_raw_input"
                        name="gallery_raw" 
                        rows="2" 
                        placeholder="/images/hero/slide-belt.jpg
/images/brand/stitch-detail.jpg"
                        class="w-full px-4 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                    >{{ old('gallery_raw', $galleryRaw) }}</textarea>
                </div>
            </div>

            <!-- Leather Swatches Manager -->
            <div class="space-y-4 pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-espresso-900 dark:text-white">Leather Tone Swatch Variations</h3>
                        <p class="text-[11px] text-[#8F8379]">Select which leather shades are offered for this specific creation</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[11px] font-semibold text-tan-600 dark:text-gold-400" x-text="colors.filter(c => c.active).length + ' selected'"></span>
                        <button type="button" @click="toggleAll(true)" class="text-[11px] text-gray-500 hover:text-tan-600 underline">Select All</button>
                        <button type="button" @click="toggleAll(false)" class="text-[11px] text-gray-500 hover:text-tan-600 underline">Clear</button>
                    </div>
                </div>

                <!-- Active Swatch Grid -->
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
                                class="text-gray-400 hover:text-rose-500 p-1 rounded-md shrink-0 transition-colors cursor-pointer"
                                title="Remove Swatch"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Custom Tone Adder -->
                <div class="p-3.5 rounded-2xl bg-[#FAF8F5] dark:bg-[#201A18] border border-[#E0D7CB] dark:border-[#342823] space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="flex items-center gap-2 flex-1 min-w-[220px]">
                            <label class="relative cursor-pointer shrink-0" title="Click to pick color">
                                <input type="color" x-model="customColorHex" class="w-9 h-9 rounded-xl cursor-pointer border border-gray-300 dark:border-gray-700 p-0.5 bg-transparent shrink-0">
                            </label>
                            <input 
                                type="text" 
                                x-model="customColorName" 
                                placeholder="Enter custom leather tone name (e.g. Vintage Bourbon)" 
                                class="px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-[#2A201C] border border-[#DFD6CB] dark:border-[#42322C] text-espresso-900 dark:text-white placeholder:text-gray-400 focus:outline-hidden focus:border-tan-500 w-full"
                                @keydown.enter.prevent="addCustomColor()"
                            >
                        </div>

                        <button 
                            type="button" 
                            @click="addCustomColor()" 
                            class="px-4 py-2 text-xs font-semibold rounded-xl bg-tan-600 hover:bg-tan-700 text-white transition-all flex items-center gap-1.5 shadow-2xs shrink-0 cursor-pointer"
                        >
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Add Custom Shade</span>
                        </button>
                    </div>

                    <div x-show="swatchFeedback" x-transition class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-medium pt-1">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        <span x-text="swatchFeedback"></span>
                    </div>
                </div>
            </div>

            <!-- Wizard Step 4 Footer -->
            <div class="pt-5 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between">
                <button 
                    type="button" 
                    @click="prevStep()" 
                    class="px-5 py-2.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-gray-700 dark:text-gray-300 text-xs font-semibold hover:bg-gray-50 dark:hover:bg-[#241D1A] transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    <span>Back: Shipping Rules</span>
                </button>
                <button 
                    type="button" 
                    @click="nextStep()" 
                    class="px-5 py-2.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs"
                >
                    <span>Next: Story, Specs & SEO</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- STEP 5: STORY, SPECIFICATIONS & SEO METADATA            -->
        <!-- ======================================================== -->
        <div x-show="step === 5" x-cloak class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-tan-100 dark:bg-[#2A1E18] text-tan-700 dark:text-gold-400 font-bold text-xs flex items-center justify-center">5</span>
                    <div>
                        <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">Story, Specifications & SEO</h2>
                        <p class="text-xs text-[#8F8379]">Editorial craft description, technical dimensions, and Google search optimization</p>
                    </div>
                </div>
                <span class="text-xs font-mono text-tan-600 dark:text-gold-400 font-bold">Step 5 of 5</span>
            </div>

            <!-- Short Summary -->
            <div class="space-y-1.5 pt-2">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white flex items-center justify-between">
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
                        data-placeholder="e.g. Handcrafted in supple vegetable-tanned full-grain leather..."
                        style="min-height: 90px;"
                    >{!! old('short_description', $product->short_description) !!}</div>
                </div>
            </div>

            <!-- Artisanal Highlights / Features -->
            <div class="space-y-1.5 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white flex items-center justify-between">
                    <span>Artisanal Highlights (Bullet Points)</span>
                    <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                        <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                    </span>
                </label>
                <textarea 
                    name="features_raw" 
                    id="prod_edit_features_raw"
                    class="hidden"
                >{{ old('features_raw', $featuresHtml) }}</textarea>
                <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#3A2F29] bg-[#FAF8F5] dark:bg-[#241D1A]">
                    <div 
                        data-rich-editor="highlights" 
                        data-target="#prod_edit_features_raw" 
                        data-placeholder="Type bullet points (e.g. 100% full-grain calfskin, solid brass hardware...)"
                        style="min-height: 110px;"
                    >{!! old('features_raw', $featuresHtml) !!}</div>
                </div>
            </div>

            <!-- Full Craft Story -->
            <div class="space-y-1.5 pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <label class="block text-xs font-semibold text-espresso-900 dark:text-white flex items-center justify-between">
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
                        data-placeholder="Detailed narrative describing hide selection, vegetable tanning, artisan edge burnishing..."
                        style="min-height: 130px;"
                    >{!! old('description', $product->description) !!}</div>
                </div>
            </div>

            <!-- Specifications Grid -->
            <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                <h3 class="text-xs font-semibold text-espresso-900 dark:text-white mb-3">Technical Specifications & Sizing</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Material Grade</label>
                        <input type="text" name="spec_material" value="{{ old('spec_material', $specMaterial) }}" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Buckle / Hardware</label>
                        <input type="text" name="spec_hardware" value="{{ old('spec_hardware', $specHardware) }}" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Width & Dimensions</label>
                        <input type="text" name="spec_dimensions" value="{{ old('spec_dimensions', $specDimensions) }}" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Available Sizes (Belts / Tailored)</label>
                        <input type="text" name="spec_sizes" value="{{ old('spec_sizes', $specSizes) }}" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Leather Care & Preservation</label>
                        <input type="text" name="spec_care" value="{{ old('spec_care', $specCare) }}" placeholder="e.g. Wipe with soft cotton cloth; treat with neutral balm" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Craft Origin</label>
                        <input type="text" name="spec_origin" value="{{ old('spec_origin', $specOrigin) }}" placeholder="e.g. Handcrafted in Pakistan" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Packaging & Presentation</label>
                        <input type="text" name="spec_packaging" value="{{ old('spec_packaging', $specPackaging) }}" placeholder="e.g. By Zunash Magnetic Hard Box" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    </div>
                </div>
            </div>

            <!-- SEO Search Optimization -->
            <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-3">
                <h3 class="text-xs font-semibold text-espresso-900 dark:text-white flex items-center gap-1.5">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span>Search Engine Optimization (SEO Metadata)</span>
                </h3>
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">SEO Title (Browser & Google Header)</label>
                    <input 
                        type="text" 
                        name="meta_title" 
                        value="{{ old('meta_title', $product->meta_title) }}" 
                        placeholder="Leave blank to use default (Product Name | By Zunash)"
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1">Meta Description (Snippet under Google result)</label>
                    <textarea 
                        name="meta_description" 
                        rows="2"
                        placeholder="Crafted from full-grain leather. Shop authentic Pakistani luxury leather with express courier delivery..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
            </div>

            <!-- Wizard Step 5 Footer (Final Submit) -->
            <div class="pt-5 border-t border-[#F0EAE1] dark:border-[#2C2420] flex items-center justify-between">
                <button 
                    type="button" 
                    @click="prevStep()" 
                    class="px-5 py-2.5 rounded-xl border border-[#DFD6CB] dark:border-[#3A2F29] text-gray-700 dark:text-gray-300 text-xs font-semibold hover:bg-gray-50 dark:hover:bg-[#241D1A] transition-all flex items-center gap-1.5 cursor-pointer"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    <span>Back: Visuals</span>
                </button>
                <button 
                    type="submit" 
                    class="px-7 py-3 rounded-xl bg-tan-600 hover:bg-tan-700 text-white font-bold text-xs shadow-lg transition-all active:scale-95 flex items-center gap-2 cursor-pointer"
                >
                    <i data-lucide="check" class="w-4 h-4 text-gold-300"></i>
                    <span>Save Changes & Sync Storefront</span>
                </button>
            </div>
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
        if (status) status.innerText = 'Select one or multiple photos to add to gallery';
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
function calculateProfitMargin() {
    const retailInput = document.getElementById('prod_retail_price');
    const costInput = document.getElementById('prod_cost_price');
    const resultSpan = document.getElementById('profit_calc_result');
    if (!retailInput || !costInput || !resultSpan) return;

    const retail = parseFloat(retailInput.value) || 0;
    const cost = parseFloat(costInput.value) || 0;

    if (retail <= 0) {
        resultSpan.innerHTML = '<span class="text-gray-400">Enter Selling & Cost Price</span>';
        return;
    }

    const profit = retail - cost;
    const margin = Math.round((profit / retail) * 100);

    if (profit < 0) {
        resultSpan.innerHTML = `<span class="text-rose-500 font-bold">LOSS: PKR ${Math.abs(profit).toLocaleString()} (${margin}%)</span>`;
    } else {
        resultSpan.innerHTML = `<span class="text-emerald-600 dark:text-emerald-400 font-bold">Profit: PKR ${profit.toLocaleString()} (${margin}% Gross Margin)</span>`;
    }
}
document.addEventListener('DOMContentLoaded', calculateProfitMargin);
</script>
@endpush

@endsection
