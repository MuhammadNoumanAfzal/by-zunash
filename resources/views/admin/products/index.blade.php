@extends('admin.layouts.app')

@section('title', 'Product Catalogue Management | By Zunash Atelier Admin')

@section('content')

<!-- Header & Quick Stats -->
<div class="space-y-4">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Product Catalogue
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Manage, filter, curate, and price handcrafted luxury creations across all By Zunash collections.
            </p>
        </div>

        <a 
            href="{{ route('admin.products.create') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
            <span>Add New Product</span>
        </a>
    </div>

    <!-- 4 Filter Metric Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('admin.products.index') }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-tan-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Total Products</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $totalCount }}</div>
        </a>
        <a href="{{ route('admin.products.index', ['stock' => 'in_stock']) }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-emerald-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Active in Store</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $activeCount }}</div>
        </a>
        <a href="{{ route('admin.products.index', ['stock' => 'low_stock']) }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-amber-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Low Stock Alert</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $lowStockCount }}</div>
        </a>
        <a href="{{ route('admin.products.index', ['stock' => 'out_of_stock']) }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-rose-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Out of Stock</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $outOfStockCount }}</div>
        </a>
    </div>

</div>

<!-- Filter Bar Card -->
<div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
    <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
        
        <!-- Search with Instant Live Suggestions Dropdown -->
        <div 
            class="lg:col-span-3 relative"
            x-data="{
                query: '{{ request('q') }}',
                open: false,
                loading: false,
                suggestions: { products: [], categories: [], total: 0 },
                timer: null,
                fetchSuggestions() {
                    if (this.query.trim().length < 1) {
                        this.suggestions = { products: [], categories: [], total: 0 };
                        this.open = false;
                        return;
                    }
                    this.loading = true;
                    clearTimeout(this.timer);
                    this.timer = setTimeout(() => {
                        fetch('{{ route('admin.search.live') }}?q=' + encodeURIComponent(this.query))
                            .then(res => res.json())
                            .then(data => {
                                this.suggestions = data;
                                this.open = (data.products && data.products.length > 0) || (data.categories && data.categories.length > 0);
                                this.loading = false;
                                this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
                            })
                            .catch(() => { this.loading = false; });
                    }, 180);
                },
                selectProduct(name) {
                    this.query = name;
                    this.open = false;
                    this.$el.closest('form').submit();
                },
                selectCategory(slug) {
                    const select = this.$el.closest('form').querySelector('select[name=category]');
                    if (select) {
                        select.value = slug;
                    }
                    this.open = false;
                    this.$el.closest('form').submit();
                }
            }"
            @click.outside="open = false"
            @keydown.escape="open = false"
        >
            <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input 
                type="text" 
                name="q" 
                x-model="query"
                @input="fetchSuggestions()"
                @focus="if (query.trim().length >= 1 && suggestions.total > 0) open = true"
                placeholder="Search by name, SKU, category..." 
                autocomplete="off"
                class="w-full pl-9 pr-8 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-sans"
            >
            <!-- Loading indicator / Clear button -->
            <div class="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center">
                <template x-if="loading">
                    <svg class="animate-spin h-3.5 w-3.5 text-tan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </template>
                <template x-if="!loading && query.length > 0">
                    <button type="button" @click="query = ''; suggestions = { products: [], categories: [], total: 0 }; open = false;" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                </template>
            </div>

            <!-- Instant Table Suggestions Dropdown -->
            <div 
                x-show="open && query.trim().length >= 1"
                x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="absolute left-0 right-0 top-full mt-1.5 bg-white dark:bg-[#1A1412] rounded-2xl shadow-xl border border-[#ECE6DE] dark:border-[#2D231E] overflow-hidden z-50 max-h-72 overflow-y-auto scrollbar-thin divide-y divide-gray-100 dark:divide-white/5"
            >
                <!-- Suggested Products -->
                <template x-if="suggestions.products && suggestions.products.length > 0">
                    <div class="p-2">
                        <div class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-tan-700 dark:text-gold flex items-center justify-between">
                            <span>Matching Creations</span>
                            <span class="text-[#8F8379]" x-text="suggestions.products.length + ' found'"></span>
                        </div>
                        <template x-for="item in suggestions.products" :key="'sp-' + item.id">
                            <div 
                                @click="selectProduct(item.name)"
                                class="flex items-center justify-between gap-2.5 p-2 rounded-xl hover:bg-tan-50 dark:hover:bg-[#251C18] cursor-pointer transition-colors group"
                            >
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <img :src="item.image" :alt="item.name" class="w-8 h-8 rounded-lg object-cover shrink-0 border border-black/10">
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold text-espresso-950 dark:text-white truncate group-hover:text-tan-700" x-text="item.name"></div>
                                        <div class="text-[10px] text-[#8F8379] font-mono flex items-center gap-1.5">
                                            <span x-text="item.sku"></span>
                                            <span>•</span>
                                            <span x-text="item.category"></span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs font-bold font-mono text-tan-700 dark:text-gold shrink-0" x-text="item.price"></span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Suggested Categories -->
                <template x-if="suggestions.categories && suggestions.categories.length > 0">
                    <div class="p-2 bg-[#FAF8F5] dark:bg-[#16100E]">
                        <div class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider text-tan-700 dark:text-gold">
                            Filter by Category
                        </div>
                        <template x-for="cat in suggestions.categories" :key="'sc-' + cat.id">
                            <div 
                                @click="selectCategory(cat.slug)"
                                class="flex items-center justify-between p-1.5 px-2 rounded-lg hover:bg-tan-100 dark:hover:bg-[#2A201C] cursor-pointer text-xs font-semibold text-espresso-900 dark:text-white"
                            >
                                <span class="flex items-center gap-1.5">
                                    <i data-lucide="folder" class="w-3.5 h-3.5 text-tan-600"></i>
                                    <span x-text="cat.name"></span>
                                </span>
                                <span class="text-[10px] text-[#8F8379] font-mono">Apply filter &rarr;</span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Filter button footer -->
                <div class="p-2 bg-gray-50 dark:bg-[#140F0D] text-center">
                    <button 
                        type="submit" 
                        class="w-full py-1 text-[11px] font-bold text-tan-700 dark:text-gold hover:underline flex items-center justify-center gap-1"
                    >
                        <span>Filter table for "<span x-text="query"></span>"</span>
                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="lg:col-span-3">
            <select 
                name="category" 
                onchange="this.form.submit()"
                class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
            >
                <option value="all">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Stock Status Filter -->
        <div class="lg:col-span-2">
            <select 
                name="stock" 
                onchange="this.form.submit()"
                class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
            >
                <option value="">Stock Status: All</option>
                <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>In Stock (>5)</option>
                <option value="low_stock" {{ request('stock') === 'low_stock' ? 'selected' : '' }}>Low Stock (≤5)</option>
                <option value="out_of_stock" {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                <option value="on_demand" {{ request('stock') === 'on_demand' ? 'selected' : '' }}>On Demand / Bespoke</option>
            </select>
        </div>

        <!-- Sort -->
        <div class="lg:col-span-2">
            <select 
                name="sort" 
                onchange="this.form.submit()"
                class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
            >
                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Sort: Latest</option>
                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="stock_low" {{ request('sort') === 'stock_low' ? 'selected' : '' }}>Stock: Low to High</option>
                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
            </select>
        </div>

        <!-- Submit & Reset Buttons -->
        <div class="sm:col-span-2 lg:col-span-2 flex items-center gap-1.5">
            <button 
                type="submit" 
                class="flex-1 min-w-0 py-2 px-3 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-1.5 shadow-2xs"
                title="Apply Filter"
            >
                <i data-lucide="filter" class="w-3.5 h-3.5 shrink-0"></i>
                <span class="truncate">Filter</span>
            </button>
            <a 
                href="{{ route('admin.products.index') }}" 
                class="w-9 h-9 shrink-0 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center justify-center shadow-2xs"
                title="Reset All Filters"
            >
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 shrink-0"></i>
            </a>
        </div>

    </form>
</div>

<!-- Products Table Card & Mobile Cards -->
<div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
    
    <!-- Mobile Clean Product Cards (< 640px) -->
    <div class="block sm:hidden divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
        @forelse($products as $product)
            <div class="p-3.5 hover:bg-[#FAF8F5]/80 dark:hover:bg-[#221B18] transition-colors space-y-2.5">
                <div class="flex items-start gap-3">
                    <img 
                        src="{{ $product->image ?: '/images/products/prod-reversible-belt.jpg' }}" 
                        alt="{{ $product->name }}"
                        class="w-14 h-14 rounded-xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs shrink-0"
                    >
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-1.5">
                            <h3 class="font-bold text-xs text-espresso-950 dark:text-white truncate">
                                {{ $product->name }}
                            </h3>
                            <div class="font-cinzel font-bold text-xs text-espresso-950 dark:text-white shrink-0">
                                Rs. {{ number_format($product->price) }}
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[#F5F1EA] dark:bg-[#2A221E] text-espresso-800 dark:text-[#E8D0BE]">
                                {{ $product->category_name ?: ucfirst($product->category_slug) }}
                            </span>
                            @if($product->badge)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#FAF3F0] text-tan-700 border border-[#F3E3DC]">
                                    {{ $product->badge }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1 border-t border-[#F0EAE1] dark:border-[#28201C]">
                    <div>
                        @if($product->availability === 'on_demand')
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/15 text-amber-800 dark:text-amber-400 border border-amber-500/30">
                                On Demand
                            </span>
                        @elseif($product->stock_quantity <= 0)
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                Out of Stock
                            </span>
                        @elseif($product->stock_quantity <= 5)
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                Low: {{ $product->stock_quantity }}
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                In Stock ({{ $product->stock_quantity }})
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-1.5">
                        <a 
                            href="{{ route('product.details', $product->slug) }}" 
                            target="_blank"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-tan-600 border border-[#DFD6CB] dark:border-[#382D27]"
                            title="View Live Product"
                        >
                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        </a>

                        <a 
                            href="{{ route('admin.products.edit', $product) }}" 
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-espresso-900 hover:bg-tan-600 text-white transition-colors"
                        >
                            Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="p-1.5 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg border border-rose-200"
                                title="Delete Product"
                            >
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-xs text-gray-400">
                <i data-lucide="package-search" class="w-8 h-8 text-[#A89C91] mx-auto mb-2"></i>
                <div class="font-bold text-espresso-950 dark:text-white">No creations match the selected filters.</div>
                <a href="{{ route('admin.products.index') }}" class="inline-block mt-2 text-tan-600 dark:text-gold hover:underline font-bold">Reset All Filters &rarr;</a>
            </div>
        @endforelse
    </div>

    <!-- Desktop / Tablet Table View (>= 640px) -->
    <div class="hidden sm:block overflow-x-auto w-full max-w-full">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                    <th class="py-3 px-4">PRODUCT</th>
                    <th class="py-3 px-3">CATEGORY</th>
                    <th class="py-3 px-3">PRICE</th>
                    <th class="py-3 px-3">STOCK & STATUS</th>
                    <th class="py-3 px-3">RATING</th>
                    <th class="py-3 px-4 text-right">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                @forelse($products as $product)
                    <tr class="hover:bg-[#FAF8F5]/80 dark:hover:bg-[#221B18] transition-colors">
                        
                        <!-- Thumbnail & Info (Product Name Only) -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img 
                                    src="{{ $product->image ?: '/images/products/prod-reversible-belt.jpg' }}" 
                                    alt="{{ $product->name }}"
                                    class="w-12 h-12 rounded-xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs shrink-0"
                                >
                                <div class="min-w-0">
                                    <div class="font-bold text-espresso-950 dark:text-white truncate max-w-xs hover:text-tan-600 transition-colors">
                                        {{ $product->name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Category (Category Only) -->
                        <td class="py-3.5 px-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#F5F1EA] dark:bg-[#2A221E] text-espresso-800 dark:text-[#E8D0BE]">
                                {{ $product->category_name ?: ucfirst($product->category_slug) }}
                            </span>
                        </td>

                        <!-- Price (Current Price Only) -->
                        <td class="py-3.5 px-3">
                            <div class="font-cinzel font-bold text-sm text-espresso-950 dark:text-white">
                                Rs. {{ number_format($product->price) }}
                            </div>
                        </td>

                        <!-- Stock & Status -->
                        <td class="py-3.5 px-3">
                            @if($product->availability === 'on_demand')
                                <div class="space-y-0.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 dark:text-amber-400 border border-amber-500/30 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        On Demand
                                    </span>
                                    <div class="text-[9px] text-[#8F8379] font-mono">
                                        {{ $product->lead_time ?: '7–10 Days' }}
                                    </div>
                                </div>
                            @elseif($product->stock_quantity <= 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    Out of Stock (0)
                                </span>
                            @elseif($product->stock_quantity <= 5)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Low: {{ $product->stock_quantity }} left
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    In Stock ({{ $product->stock_quantity }})
                                </span>
                            @endif
                        </td>


                        <!-- Rating -->
                        <td class="py-3.5 px-3">
                            <div class="flex items-center gap-1 font-semibold text-espresso-900 dark:text-white text-xs">
                                <span class="text-amber-500">★</span>
                                <span>{{ number_format($product->rating, 1) }}</span>
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <a 
                                    href="{{ route('product.details', $product->slug) }}" 
                                    target="_blank"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] transition-colors"
                                    title="View Live Product Page"
                                >
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>

                                <a 
                                    href="{{ route('admin.products.edit', $product) }}" 
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] transition-colors"
                                    title="Edit Product"
                                >
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product from the catalogue?')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors"
                                        title="Delete Product"
                                    >
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-14 text-center">
                            <i data-lucide="package-search" class="w-9 h-9 text-[#A89C91] mx-auto mb-2.5"></i>
                            <div class="text-xs font-bold text-espresso-950 dark:text-white">No creations match your current filters.</div>
                            <p class="text-[11px] text-gray-400 mt-0.5">Try selecting another collection or clearing active filters.</p>
                            <a href="{{ route('admin.products.index') }}" class="inline-block mt-3 px-3 py-1.5 rounded-xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#DFD6CB] dark:border-[#382D27] text-xs font-bold text-espresso-900 dark:text-gold hover:bg-tan-50 transition-colors">
                                Reset All Filters
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Clean Pagination Footer -->
    <div class="px-6 py-4 bg-[#FAF8F5]/60 dark:bg-[#201A18] border-t border-[#ECE6DE] dark:border-[#2C2420]">
        {{ $products->links() }}
    </div>

</div>

@endsection
