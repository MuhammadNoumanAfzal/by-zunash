@extends('admin.layouts.app')

@section('title', 'Edit Atelier Deal | By Zunash Control Center')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="dealForm()">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.deals.index') }}" class="text-xs text-[#8F8379] hover:text-tan-600 transition-colors flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Deals</span>
                </a>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white mt-1">
                Edit Deal: {{ $deal->title }}
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387]">
                Update bundle components, adjust pricing, or manage validity window.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('deals') }}#{{ $deal->slug }}" 
                target="_blank" 
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#ECE6DE] text-xs font-semibold text-[#8F8379] hover:text-espresso-950 dark:hover:text-white transition-colors"
            >
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                <span>View Live</span>
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <div class="font-bold mb-1">Please correct the following errors:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.deals.update', $deal) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Left Form Details (7 Cols) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Basic Information Card -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs space-y-4">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-tan-600"></i>
                        <span>Deal Details</span>
                    </h2>

                    <!-- Deal Title -->
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="title">
                            Deal Title <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $deal->title) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                        >
                    </div>

                    <!-- Tagline, Category & Badge -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="tagline">
                                Subtitle / Tagline
                            </label>
                            <input 
                                type="text" 
                                id="tagline" 
                                name="tagline" 
                                value="{{ old('tagline', $deal->tagline) }}" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="category_slug">
                                Deal Category
                            </label>
                            <select 
                                id="category_slug" 
                                name="category_slug" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                            >
                                <option value="">Auto-Detect from Products</option>
                                <option value="belts" {{ old('category_slug', $deal->category_slug) == 'belts' ? 'selected' : '' }}>Leather Belts Deals</option>
                                <option value="wallets" {{ old('category_slug', $deal->category_slug) == 'wallets' ? 'selected' : '' }}>Wallets & Cardholders Deals</option>
                                <option value="handbags" {{ old('category_slug', $deal->category_slug) == 'handbags' ? 'selected' : '' }}>Handbags Deals</option>
                                <option value="shoulder-bags" {{ old('category_slug', $deal->category_slug) == 'shoulder-bags' ? 'selected' : '' }}>Shoulder Bags Deals</option>
                                <option value="accessories" {{ old('category_slug', $deal->category_slug) == 'accessories' ? 'selected' : '' }}>Everyday Accessories Deals</option>
                                <option value="gift-sets" {{ old('category_slug', $deal->category_slug) == 'gift-sets' ? 'selected' : '' }}>Curated Gift Sets</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="badge">
                                Promotional Badge
                            </label>
                            <input 
                                type="text" 
                                id="badge" 
                                name="badge" 
                                value="{{ old('badge', $deal->badge) }}" 
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                            >
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1 flex items-center justify-between" for="description">
                            <span>Atelier Story & Description</span>
                            <span class="text-[10px] text-tan-600 dark:text-gold-400 font-semibold flex items-center gap-1">
                                <i data-lucide="sparkles" class="w-3 h-3"></i> Rich Editor
                            </span>
                        </label>
                        <textarea 
                            id="deal_edit_description" 
                            name="description" 
                            class="hidden"
                        >{{ old('description', $deal->description) }}</textarea>
                        <div class="quill-wrapper rounded-2xl overflow-hidden border border-[#E0D7CB] dark:border-[#2C2420] bg-[#FAF8F5] dark:bg-[#120E0C]">
                            <div 
                                data-rich-editor="full" 
                                data-target="#deal_edit_description" 
                                data-placeholder="Describe why these pieces complement each other, their matching leather tones, and the exceptional value of this curated combination..."
                                style="min-height: 120px;"
                            >{!! old('description', $deal->description) !!}</div>
                        </div>
                    </div>

                    <!-- Deal Highlights / Perks -->
                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="highlights">
                            Deal Highlights & Included Perks <span class="text-[10px] text-[#8F8379] font-normal">(One line per bullet point)</span>
                        </label>
                        <textarea 
                            id="highlights" 
                            name="highlights" 
                            rows="3" 
                            placeholder="100% Full-grain vegetable-tanned calfskin&#10;Hand-beveled and beeswax-burnished edges&#10;Complimentary rigid matte gift presentation box"
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                        >{{ old('highlights', $deal->highlights) }}</textarea>
                    </div>
                            rows="3" 
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                        >{{ old('description', $deal->description) }}</textarea>
                    </div>
                </div>

                <!-- Pricing & Savings Card -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs space-y-4">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="tag" class="w-4 h-4 text-tan-600"></i>
                        <span>Bundle Pricing & Valuation</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Special Deal Price -->
                        <div>
                            <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="deal_price">
                                Promotional Deal Price (PKR) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gold-600">PKR</span>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    id="deal_price" 
                                    name="deal_price" 
                                    x-model="dealPrice"
                                    required 
                                    class="w-full pl-14 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500 font-bold"
                                >
                            </div>
                        </div>

                        <!-- Original Price -->
                        <div>
                            <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1" for="original_price">
                                Combined Regular Price (PKR)
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#8F8379]">PKR</span>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    id="original_price" 
                                    name="original_price" 
                                    x-model="originalPrice"
                                    class="w-full pl-14 pr-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                                >
                            </div>
                            <p class="text-[10px] text-muted mt-1">
                                Auto-computed from selected products: <span class="font-bold text-espresso-950 dark:text-white" x-text="'PKR ' + computedOriginal.toLocaleString()"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Live Calculation Badge -->
                    <div class="p-3.5 rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                        <div>
                            <div class="text-[10px] uppercase font-bold text-[#8F8379]">Patron Advantage</div>
                            <div class="text-xs font-bold text-emerald-600 flex items-center gap-1 mt-0.5">
                                <i data-lucide="tag" class="w-3.5 h-3.5 text-gold-500"></i>
                                <span>Save PKR <span x-text="computedSavings.toLocaleString()"></span> (<span x-text="computedPercent"></span>% OFF)</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 self-start sm:self-auto flex-wrap">
                            <button 
                                type="button" 
                                @click="applySuggestedDiscount(15)" 
                                class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-gold/15 text-gold-800 dark:text-gold-300 hover:bg-gold/25 transition-colors"
                            >
                                15% Off
                            </button>
                            <button 
                                type="button" 
                                @click="applySuggestedDiscount(20)" 
                                class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-gold/15 text-gold-800 dark:text-gold-300 hover:bg-gold/25 transition-colors"
                            >
                                20% Off
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Deal Image Card -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs space-y-4">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="image" class="w-4 h-4 text-tan-600"></i>
                        <span>Featured Deal Imagery</span>
                    </h2>

                    @if($deal->image)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420]">
                            <img src="{{ asset($deal->image) }}" alt="{{ $deal->title }}" class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <span class="text-xs font-semibold text-espresso-950 dark:text-white block">Current Deal Banner</span>
                                <span class="text-[10px] text-muted font-mono truncate block max-w-xs">{{ $deal->image }}</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1">
                            Replace Banner Photo
                        </label>
                        <input 
                            type="file" 
                            name="image_file" 
                            accept="image/*"
                            class="w-full text-xs text-[#8F8379] file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-tan-600 file:text-white hover:file:bg-tan-700"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-espresso-900 dark:text-ivory-200 mb-1">
                            Or Image Path / URL
                        </label>
                        <input 
                            type="text" 
                            name="image" 
                            value="{{ old('image', $deal->image) }}" 
                            class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                        >
                    </div>
                </div>

            </div>

            <!-- Right Column: Product Picker (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Products Selector Card -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                            <i data-lucide="layers" class="w-4 h-4 text-tan-600"></i>
                            <span>Select Products</span>
                        </h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-tan-50 dark:bg-tan-950 text-tan-700 dark:text-tan-300">
                            <span x-text="selectedCount"></span> Selected
                        </span>
                    </div>

                    <!-- Product Search -->
                    <div class="relative">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            placeholder="Filter products..." 
                            class="w-full pl-9 pr-3 py-1.5 text-xs rounded-lg bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                        >
                    </div>

                    <!-- Scrollable Product List -->
                    <div class="space-y-2 max-h-[380px] overflow-y-auto pr-1">
                        @foreach($products as $p)
                            <div 
                                x-show="matchesSearch('{{ strtolower(addslashes($p->name)) }}', '{{ strtolower(addslashes($p->category_name)) }}')"
                                class="p-2.5 rounded-xl border transition-all flex items-center justify-between gap-2.5"
                                :class="isSelected({{ $p->id }}) ? 'border-tan-600 bg-tan-50/40 dark:bg-tan-950/20' : 'border-[#ECE6DE] dark:border-[#2C2420] bg-white dark:bg-[#120E0C] hover:border-tan-400'"
                            >
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <input 
                                        type="checkbox" 
                                        id="prod-{{ $p->id }}" 
                                        value="{{ $p->id }}" 
                                        @change="toggleProduct({{ $p->id }}, {{ $p->price }})"
                                        :checked="isSelected({{ $p->id }})"
                                        class="rounded border-[#E0D7CB] text-tan-600 focus:ring-tan-500 w-4 h-4 cursor-pointer"
                                    >
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-ivory-100 shrink-0 border border-ivory-200">
                                        <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <label for="prod-{{ $p->id }}" class="text-xs font-semibold text-espresso-950 dark:text-white truncate block cursor-pointer">
                                            {{ $p->name }}
                                        </label>
                                        <div class="text-[10px] text-muted truncate">
                                            {{ $p->category_name }} • PKR {{ number_format($p->price) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity input when selected -->
                                <template x-if="isSelected({{ $p->id }})">
                                    <div class="flex items-center gap-1 shrink-0">
                                        <span class="text-[10px] text-muted">Qty:</span>
                                        <input 
                                            type="number" 
                                            min="1" 
                                            max="10" 
                                            :name="'products[' + getIndex({{ $p->id }}) + '][quantity]'"
                                            x-model.number="getProd({{ $p->id }}).qty"
                                            @input="recalculate()"
                                            class="w-12 py-1 px-1.5 text-xs text-center font-bold rounded-lg bg-white dark:bg-[#1A1513] border border-tan-400 focus:outline-hidden"
                                        >
                                        <input type="hidden" :name="'products[' + getIndex({{ $p->id }}) + '][id]'" value="{{ $p->id }}">
                                    </div>
                                </template>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Settings & Scheduling Card -->
                <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs space-y-4">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-tan-600"></i>
                        <span>Publishing & Validity</span>
                    </h2>

                    <!-- Toggles -->
                    <div class="space-y-3 pt-1">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div>
                                <span class="text-xs font-semibold text-espresso-900 dark:text-ivory-200 block">Active Status</span>
                                <span class="text-[10px] text-muted">Visible to patrons on storefront</span>
                            </div>
                            <input type="checkbox" name="is_active" value="1" {{ $deal->is_active ? 'checked' : '' }} class="rounded border-[#E0D7CB] text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                        </label>

                        <label class="flex items-center justify-between cursor-pointer">
                            <div>
                                <span class="text-xs font-semibold text-espresso-900 dark:text-ivory-200 block">Featured Deal</span>
                                <span class="text-[10px] text-muted">Highlighted at the top of Deals page</span>
                            </div>
                            <input type="checkbox" name="is_featured" value="1" {{ $deal->is_featured ? 'checked' : '' }} class="rounded border-[#E0D7CB] text-gold focus:ring-gold w-4 h-4">
                        </label>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-2 gap-2.5 pt-2 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                        <div>
                            <label class="block text-[10px] font-semibold text-[#8F8379] mb-1">Start Date</label>
                            <input type="date" name="start_date" value="{{ $deal->start_date ? $deal->start_date->format('Y-m-d') : '' }}" class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] text-espresso-900 dark:text-ivory">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-[#8F8379] mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ $deal->end_date ? $deal->end_date->format('Y-m-d') : '' }}" class="w-full px-2.5 py-1.5 text-xs rounded-lg bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] text-espresso-900 dark:text-ivory">
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-[10px] font-semibold text-[#8F8379] mb-1">Display Priority Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $deal->sort_order) }}" min="0" class="w-full px-3 py-1.5 text-xs rounded-lg bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] text-espresso-900 dark:text-ivory">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3.5 px-6 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs tracking-wider uppercase shadow-lg hover:shadow-xl active:scale-98 transition-all flex items-center justify-center gap-2 border border-gold-400/30"
                    >
                        <i data-lucide="check" class="w-4 h-4 text-gold-400"></i>
                        <span>Update Atelier Deal</span>
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

<script>
function dealForm() {
    return {
        selectedProducts: @json($deal->products->map(fn($p) => ['id' => $p->id, 'price' => (float)$p->price, 'qty' => (int)($p->pivot->quantity ?? 1)])),
        dealPrice: {{ (float)$deal->deal_price }},
        originalPrice: {{ (float)($deal->original_price ?? 0) }},
        searchQuery: '',

        isSelected(id) {
            return this.selectedProducts.some(p => p.id === id);
        },

        getProd(id) {
            return this.selectedProducts.find(p => p.id === id) || { qty: 1 };
        },

        getIndex(id) {
            return this.selectedProducts.findIndex(p => p.id === id);
        },

        toggleProduct(id, price) {
            const index = this.selectedProducts.findIndex(p => p.id === id);
            if (index > -1) {
                this.selectedProducts.splice(index, 1);
            } else {
                this.selectedProducts.push({ id, price: Number(price), qty: 1 });
            }
        },

        recalculate() {
            // Live
        },

        get selectedCount() {
            return this.selectedProducts.length;
        },

        get computedOriginal() {
            return this.selectedProducts.reduce((sum, p) => sum + (p.price * (p.qty || 1)), 0);
        },

        get effectiveOriginal() {
            return Number(this.originalPrice) > 0 ? Number(this.originalPrice) : this.computedOriginal;
        },

        get computedSavings() {
            const orig = this.effectiveOriginal;
            const deal = Number(this.dealPrice) || 0;
            return Math.max(0, orig - deal);
        },

        get computedPercent() {
            const orig = this.effectiveOriginal;
            const savings = this.computedSavings;
            if (orig > 0 && savings > 0) {
                return Math.round((savings / orig) * 100);
            }
            return 0;
        },

        applySuggestedDiscount(percent) {
            const orig = this.computedOriginal;
            if (orig > 0) {
                const discounted = Math.round(orig * (1 - (percent / 100)));
                this.dealPrice = discounted;
                this.originalPrice = orig;
            }
        },

        matchesSearch(name, cat) {
            if (!this.searchQuery) return true;
            const q = this.searchQuery.toLowerCase();
            return name.includes(q) || cat.includes(q);
        }
    };
}
</script>
@endsection

