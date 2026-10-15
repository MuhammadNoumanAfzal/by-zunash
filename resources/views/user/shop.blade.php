@extends('user.layouts.app')

@section('title', 'Shop Full Leather Collection | By Zunash')
@section('meta_description', 'Explore our handcrafted collection of pure leather belts, bifold wallets, cardholders, luxury handbags, and shoulder bags in Pakistan.')

@section('content')
<div 
    x-data="{ 
        mobileFiltersOpen: false,
        activeCategory: '{{ $activeCategory }}',
        sort: '{{ request('sort', 'featured') }}',
        minPrice: '{{ request('min_price', '') }}',
        maxPrice: '{{ request('max_price', '') }}',
        searchQuery: '{{ request('q', '') }}',
        applyFilter() {
            let url = new URL(window.location.origin + '{{ route('shop') }}');
            if (this.activeCategory && this.activeCategory !== 'all') url.searchParams.set('category', this.activeCategory);
            if (this.sort) url.searchParams.set('sort', this.sort);
            if (this.minPrice) url.searchParams.set('min_price', this.minPrice);
            if (this.maxPrice) url.searchParams.set('max_price', this.maxPrice);
            if (this.searchQuery) url.searchParams.set('q', this.searchQuery);
            window.location.href = url.toString();
        },
        resetFilters() {
            window.location.href = '{{ route('shop') }}';
        }
    }"
    class="bg-white min-h-screen"
>
    <!-- Shop Hero / Banner -->
    <div class="bg-ivory-100 border-b border-ivory-200 py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-semibold">The Atelier Catalog</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-espresso-900 mt-2 mb-4">
                All Leather Creations
            </h1>
            <p class="text-sm text-muted max-w-xl mx-auto leading-relaxed">
                Hand-cut, drum-dyed, and wax-finished full-grain leather goods crafted for everyday utility and enduring distinction.
            </p>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Top Controls Bar (Mobile Filter Toggle, Result Count, Sort Dropdown) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-ivory-200 mb-8">
            <div class="flex items-center gap-3">
                <!-- Mobile Filter Button -->
                <button 
                    type="button" 
                    @click="mobileFiltersOpen = true"
                    class="lg:hidden inline-flex items-center gap-2 px-4 py-2 border border-ivory-300 rounded text-xs uppercase tracking-wider font-medium text-espresso-900 bg-ivory-50 hover:bg-ivory-100"
                >
                    <i data-lucide="sliders-horizontal" class="w-4 h-4 text-gold-600"></i>
                    <span>Filters</span>
                </button>

                <p class="text-xs text-muted">
                    Showing <span class="font-bold text-espresso-900">{{ count($products) }}</span> authentic designs
                </p>
            </div>

            <!-- Sort By Select -->
            <div class="flex items-center gap-2">
                <label for="sort-select" class="text-xs uppercase tracking-wider text-muted font-medium">Sort By:</label>
                <select 
                    id="sort-select" 
                    x-model="sort" 
                    @change="applyFilter()" 
                    class="px-3 py-2 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 font-medium focus:outline-none focus:ring-1 focus:ring-gold"
                >
                    <option value="featured">Featured & Curated</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="latest">Newest Releases</option>
                    <option value="popularity">Most Appreciated</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Desktop Sidebar Filter Column -->
            <aside class="hidden lg:block space-y-8 pr-4 border-r border-ivory-200">
                <!-- Category Filter -->
                <div>
                    <h3 class="font-serif text-sm uppercase tracking-widest text-espresso-900 font-bold mb-4 pb-2 border-b border-ivory-200">
                        Categories
                    </h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2.5 text-xs text-espresso-800 cursor-pointer hover:text-gold-600">
                            <input 
                                type="radio" 
                                name="category_desktop" 
                                value="all" 
                                x-model="activeCategory" 
                                @change="applyFilter()" 
                                class="text-gold focus:ring-gold"
                            >
                            <span :class="activeCategory === 'all' ? 'font-bold text-gold-600' : ''">All Collections</span>
                        </label>
                        @foreach($categories as $slug => $cat)
                            <label class="flex items-center gap-2.5 text-xs text-espresso-800 cursor-pointer hover:text-gold-600">
                                <input 
                                    type="radio" 
                                    name="category_desktop" 
                                    value="{{ $slug }}" 
                                    x-model="activeCategory" 
                                    @change="applyFilter()" 
                                    class="text-gold focus:ring-gold"
                                >
                                <span :class="activeCategory === '{{ $slug }}' ? 'font-bold text-gold-600' : ''">
                                    {{ $cat['name'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div>
                    <h3 class="font-serif text-sm uppercase tracking-widest text-espresso-900 font-bold mb-4 pb-2 border-b border-ivory-200">
                        Price Range (PKR)
                    </h3>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] uppercase text-muted block mb-1">Min (PKR)</label>
                                <input 
                                    type="number" 
                                    x-model="minPrice" 
                                    placeholder="1,500" 
                                    class="w-full px-2.5 py-1.5 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                >
                            </div>
                            <div>
                                <label class="text-[10px] uppercase text-muted block mb-1">Max (PKR)</label>
                                <input 
                                    type="number" 
                                    x-model="maxPrice" 
                                    placeholder="20,000" 
                                    class="w-full px-2.5 py-1.5 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                >
                            </div>
                        </div>
                        <button 
                            type="button" 
                            @click="applyFilter()" 
                            class="w-full py-2 bg-espresso text-ivory text-xs uppercase tracking-wider font-medium rounded hover:bg-chocolate-700 transition-colors"
                        >
                            Apply Price Filter
                        </button>
                    </div>
                </div>

                <!-- Filter Reset -->
                <div>
                    <button 
                        type="button" 
                        @click="resetFilters()" 
                        class="text-xs text-muted hover:text-red-500 underline underline-offset-2 flex items-center gap-1.5"
                    >
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset All Filters</span>
                    </button>
                </div>

                <!-- Handcrafted Guarantee Callout -->
                <div class="p-4 bg-ivory-50 rounded-lg border border-ivory-300 text-xs text-espresso-800">
                    <div class="flex items-center gap-2 text-gold-600 font-serif font-bold uppercase mb-1">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Pure Hide Guarantee</span>
                    </div>
                    <p class="text-[11px] text-muted leading-relaxed">
                        Every piece is guaranteed 100% genuine full-grain or top-grain leather. Zero synthetic leatherette.
                    </p>
                </div>
            </aside>

            <!-- Product Grid Column -->
            <div class="lg:col-span-3">
                @if(count($products) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-user.components.product-card :product="$product" />
                        @endforeach
                    </div>
                @else
                    <!-- Empty State Design -->
                    <div class="py-20 text-center bg-ivory-50 rounded-xl border border-ivory-200 p-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-ivory-200 flex items-center justify-center text-muted">
                            <i data-lucide="filter" class="w-8 h-8"></i>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-espresso-900 mb-2">
                            No matching creations found
                        </h3>
                        <p class="text-xs text-muted max-w-md mx-auto mb-6 leading-relaxed">
                            We could not find any products matching your active criteria. Try broadening your price range or exploring another category.
                        </p>
                        <button 
                            type="button" 
                            @click="resetFilters()" 
                            class="px-6 py-2.5 bg-espresso text-ivory text-xs uppercase tracking-widest font-semibold rounded hover:bg-chocolate-700 transition-colors shadow-xs"
                        >
                            Reset Filters
                        </button>
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- Mobile Filter Slide-over Drawer -->
    <div 
        x-show="mobileFiltersOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-hidden lg:hidden"
    >
        <div 
            @click="mobileFiltersOpen = false" 
            class="fixed inset-0 bg-espresso-950/60 backdrop-blur-xs transition-opacity"
        ></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-xs bg-white shadow-xl flex flex-col justify-between p-6 overflow-y-auto">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-ivory-200 mb-6">
                        <h3 class="font-serif text-lg font-bold text-espresso-900 uppercase">Filters</h3>
                        <button type="button" @click="mobileFiltersOpen = false" class="p-1 text-muted">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-serif text-xs uppercase tracking-wider font-bold text-espresso-900 mb-3">Categories</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-xs">
                                <input type="radio" value="all" x-model="activeCategory" class="text-gold">
                                <span>All Collections</span>
                            </label>
                            @foreach($categories as $slug => $cat)
                                <label class="flex items-center gap-2 text-xs">
                                    <input type="radio" value="{{ $slug }}" x-model="activeCategory" class="text-gold">
                                    <span>{{ $cat['name'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-6">
                        <h4 class="font-serif text-xs uppercase tracking-wider font-bold text-espresso-900 mb-3">Price (PKR)</h4>
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <input type="number" x-model="minPrice" placeholder="Min PKR" class="px-2 py-1.5 border border-ivory-300 rounded text-xs">
                            <input type="number" x-model="maxPrice" placeholder="Max PKR" class="px-2 py-1.5 border border-ivory-300 rounded text-xs">
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-4 border-t border-ivory-200">
                    <button 
                        type="button" 
                        @click="applyFilter(); mobileFiltersOpen = false;" 
                        class="w-full py-3 bg-espresso text-ivory text-xs uppercase tracking-widest font-semibold rounded"
                    >
                        Apply Filters
                    </button>
                    <button 
                        type="button" 
                        @click="resetFilters(); mobileFiltersOpen = false;" 
                        class="w-full py-2 bg-ivory-100 text-espresso-800 text-xs uppercase tracking-widest font-medium rounded"
                    >
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
