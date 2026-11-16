<header 
    x-data="{ 
        mobileMenuOpen: false, 
        searchOpen: false, 
        searchQuery: '',
        searchLoading: false,
        searchResults: { products: [], categories: [], total: 0 },
        searchTimer: null,
        onSearchInput() {
            if (this.searchQuery.trim().length < 1) {
                this.searchResults = { products: [], categories: [], total: 0 };
                return;
            }
            this.searchLoading = true;
            clearTimeout(this.searchTimer);
            this.searchTimer = setTimeout(() => {
                fetch('{{ route('search.live') }}?q=' + encodeURIComponent(this.searchQuery))
                    .then(res => res.json())
                    .then(data => {
                        this.searchResults = data;
                        this.searchLoading = false;
                        this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
                    })
                    .catch(() => { this.searchLoading = false; });
            }, 200);
        },
        applyPopular(term) {
            this.searchQuery = term;
            this.onSearchInput();
        },
        collectionsOpen: false,
        mobileCollectionsOpen: true,
        hoverTimer: null,
        openCollections() {
            if (this.hoverTimer) clearTimeout(this.hoverTimer);
            this.collectionsOpen = true;
        },
        closeCollections() {
            if (this.hoverTimer) clearTimeout(this.hoverTimer);
            this.hoverTimer = setTimeout(() => {
                this.collectionsOpen = false;
            }, 300);
        },
        toggleCollections() {
            if (this.hoverTimer) clearTimeout(this.hoverTimer);
            this.collectionsOpen = !this.collectionsOpen;
        },
        isScrolled: false 
    }" 
    @scroll.window="isScrolled = (window.pageYOffset > 20)"
    class="sticky top-0 z-40 w-full transition-all duration-300 bg-white dark:bg-[#161210] text-espresso-900 dark:text-[#F7F4EE]"
    :class="isScrolled ? 'bg-white/95 dark:bg-[#161210]/95 backdrop-blur-md shadow-xs border-b border-ivory-300 dark:border-white/10' : 'bg-white dark:bg-[#161210] border-b border-ivory-200 dark:border-white/10'"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative" @click.outside="collectionsOpen = false">
        <div class="flex items-center justify-between h-16">
            
            <!-- Mobile Left Controls: Back Button on inner pages + Menu Toggle -->
            <div class="flex items-center gap-0.5 lg:hidden">
                @if(!request()->routeIs('home'))
                    <button 
                        type="button" 
                        onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ route('home') }}'"
                        class="p-2 -ml-2 rounded-full text-espresso-900 dark:text-ivory-200 hover:text-gold-600 hover:bg-ivory-100 dark:hover:bg-white/5 transition-colors focus:outline-none flex items-center justify-center"
                        aria-label="Go back to previous page"
                        title="Back"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                @endif
                <button 
                    type="button" 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="p-2 {{ request()->routeIs('home') ? '-ml-2' : '' }} rounded-md text-espresso-900 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold focus:outline-none"
                    aria-label="Toggle navigation menu"
                >
                    <i data-lucide="menu" x-show="!mobileMenuOpen" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    <i data-lucide="x" x-show="mobileMenuOpen" x-cloak class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </button>
            </div>

            <!-- Brand Logo (Center on Mobile, Left on Desktop) -->
            <div class="flex-shrink-0 flex items-center">
                <x-user.components.logo height="h-10 sm:h-12" />
            </div>

            <!-- Desktop Navigation Links (Scalable Curated Top-Level) -->
            <nav class="hidden lg:flex items-center space-x-7">
                <a 
                    href="{{ route('home') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-[#593E15] dark:text-gold-400 font-bold' : 'text-espresso-800 dark:text-ivory-200 hover:text-[#593E15] dark:hover:text-gold' }}"
                >
                    Home
                </a>

                <!-- Scalable Mega-Menu with Zero-Glitch Hover & Click Support -->
                <div 
                    class=""
                    @mouseenter="openCollections()"
                    @mouseleave="closeCollections()"
                >
                    <button 
                        type="button" 
                        @click="toggleCollections()"
                        class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 flex items-center gap-1.5 py-5 focus:outline-none"
                        :class="collectionsOpen || {{ request()->is('category*') ? 'true' : 'false' }} ? 'text-[#593E15] dark:text-gold-400 font-semibold' : 'text-espresso-800 dark:text-ivory-200 hover:text-[#593E15] dark:hover:text-gold'"
                        aria-label="Toggle collections menu"
                        aria-expanded="false"
                        :aria-expanded="collectionsOpen ? 'true' : 'false'"
                    >
                        <span>Collections</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="collectionsOpen ? 'rotate-180 text-[#593E15] dark:text-gold-400' : ''"></i>
                    </button>

                    <!-- Full-Width Luxury Mega-Menu Dropdown (Dynamic from Atelier Database) -->
                    @php
                        $megaCategories = \App\Models\Category::with(['subcategories'])->withCount('products')->orderBy('sort_order')->take(4)->get();
                        $totalCreationsCount = \App\Models\Product::count();
                        $spotlightProduct = \App\Models\Product::where('is_bestseller', true)->orWhere('is_new', true)->first() ?: \App\Models\Product::first();
                    @endphp
                    <div 
                        x-show="collectionsOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1 pointer-events-none"
                        x-transition:enter-end="opacity-100 translate-y-0 pointer-events-auto"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute top-full left-0 right-0 w-full bg-white dark:bg-[#1A1411] border border-ivory-300 dark:border-white/10 rounded-2xl shadow-2xl z-50 pt-7 pb-0 px-8 overflow-hidden before:absolute before:-top-6 before:left-0 before:right-0 before:h-6 before:content-['']"
                        @mouseenter="openCollections()"
                        @mouseleave="closeCollections()"
                    >
                        <div class="grid grid-cols-12 gap-8 pb-7">
                            @if($megaCategories->isNotEmpty())
                                @php
                                    $catCount = $megaCategories->count();
                                    // Allocate column width nicely depending on how many categories exist
                                    $catColSpan = match($catCount) {
                                        1 => ($spotlightProduct ? 'col-span-8' : 'col-span-12'),
                                        2 => ($spotlightProduct ? 'col-span-4' : 'col-span-6'),
                                        default => ($spotlightProduct ? 'col-span-3' : 'col-span-4'),
                                    };
                                @endphp

                                @foreach($megaCategories as $cat)
                                    <div class="{{ $catColSpan }} space-y-3">
                                        <a href="{{ route('category', $cat->slug) }}" class="group flex items-center justify-between pb-2.5 border-b border-ivory-200 dark:border-white/10">
                                            <h4 class="font-serif text-xs font-bold uppercase tracking-wider text-espresso-950 dark:text-ivory group-hover:text-gold-600 transition-colors">
                                                {{ $cat->name }}
                                            </h4>
                                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gold-600 transition-transform group-hover:translate-x-1"></i>
                                        </a>

                                        @if($cat->subcategories->isNotEmpty())
                                            <ul class="space-y-1 text-xs">
                                                @foreach($cat->subcategories->take(4) as $sub)
                                                    <li>
                                                        <a href="{{ route('shop', ['category' => $cat->slug, 'subcategory' => $sub->slug]) }}" class="text-espresso-800 dark:text-ivory-200 hover:text-gold-600 hover:bg-ivory-50 dark:hover:bg-white/5 px-2 py-1.5 rounded font-medium transition-all block">
                                                            {{ $sub->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                                <li class="pt-1.5">
                                                    <a href="{{ route('category', $cat->slug) }}" class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wider flex items-center gap-1.5 px-2">
                                                        <span>All {{ $cat->name }} ({{ $cat->products_count }} {{ Str::plural('Piece', $cat->products_count) }})</span>
                                                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        @elseif($cat->tagline)
                                            <p class="text-xs text-muted dark:text-ivory-300 font-light italic leading-relaxed px-1">
                                                {{ $cat->tagline }}
                                            </p>
                                            <div class="pt-2">
                                                <a href="{{ route('category', $cat->slug) }}" class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wider flex items-center gap-1.5 px-1">
                                                    <span>Explore Collection ({{ $cat->products_count }} {{ Str::plural('Piece', $cat->products_count) }})</span>
                                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                                </a>
                                            </div>
                                        @else
                                            <div class="pt-1">
                                                <a href="{{ route('category', $cat->slug) }}" class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wider flex items-center gap-1.5 px-1">
                                                    <span>View Collection ({{ $cat->products_count }} {{ Str::plural('Piece', $cat->products_count) }})</span>
                                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                @if($spotlightProduct)
                                    <!-- Dynamic Atelier Spotlight Card -->
                                    <div class="col-span-4 bg-ivory-50 dark:bg-[#241C18] rounded-2xl p-4 border border-ivory-200 dark:border-white/10 flex flex-col justify-between shadow-xs">
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-[10px] uppercase tracking-widest text-gold-600 font-serif font-bold">
                                                    Atelier Spotlight
                                                </span>
                                                @if($spotlightProduct->badge)
                                                    <span class="text-[10px] uppercase tracking-wider text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-300 px-1.5 py-0.5 rounded font-medium border border-emerald-200 dark:border-emerald-800">
                                                        {{ $spotlightProduct->badge }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h5 class="font-serif text-sm font-bold text-espresso-950 dark:text-ivory mb-1 truncate">
                                                {{ $spotlightProduct->name }}
                                            </h5>
                                            <p class="text-[11px] text-muted-dark dark:text-ivory-300 leading-relaxed line-clamp-2 mb-3 font-light">
                                                {{ $spotlightProduct->short_description ?: $spotlightProduct->tagline ?: 'Handcrafted luxury full-grain piece.' }}
                                            </p>
                                            @if($spotlightProduct->image)
                                                <div class="aspect-[16/10] rounded-xl overflow-hidden bg-ivory-100 dark:bg-[#161210] mb-3 border border-ivory-300 dark:border-white/10">
                                                    <img 
                                                        src="{{ $spotlightProduct->image }}" 
                                                        alt="{{ $spotlightProduct->name }}" 
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>
                                            @endif
                                        </div>
                                        <a 
                                            href="{{ route('product.details', $spotlightProduct->slug) }}" 
                                            class="w-full py-2 bg-espresso-950 hover:bg-gold-600 text-white hover:text-white text-xs uppercase tracking-wider font-bold rounded-xl text-center block transition-all shadow-xs"
                                        >
                                            Inspect • PKR {{ number_format($spotlightProduct->price) }}
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="col-span-12 py-8 text-center space-y-2">
                                    <p class="font-serif text-sm text-espresso-900 dark:text-ivory">
                                        Atelier collections are currently being curated.
                                    </p>
                                    <a href="{{ route('shop') }}" class="inline-flex items-center gap-1.5 text-xs uppercase tracking-widest font-bold text-gold-600 hover:underline">
                                        <span>Explore Full Catalog</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Mega Menu Bottom Reassurance Bar -->
                        <div class="-mx-8 py-3.5 px-8 bg-ivory-100 dark:bg-[#140F0D] border-t border-ivory-200 dark:border-white/10 flex items-center justify-between text-xs text-espresso-900 dark:text-ivory-200">
                            <div class="flex items-center gap-6">
                                <span class="flex items-center gap-2 font-medium">
                                    <i data-lucide="shield-check" class="w-4 h-4 text-gold-600"></i>
                                    100% Full-Grain Vegetable Tanned Hides
                                </span>
                                <span class="flex items-center gap-2 font-medium">
                                    <i data-lucide="truck" class="w-4 h-4 text-gold-600"></i>
                                    Nationwide Cash on Delivery Across Pakistan
                                </span>
                            </div>
                            <a href="{{ route('shop') }}" class="font-bold text-gold-600 hover:text-gold-700 uppercase tracking-widest text-xs flex items-center gap-1.5 group">
                                <span>Explore Full Catalog ({{ $totalCreationsCount }} {{ Str::plural('Piece', $totalCreationsCount) }})</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <a 
                    href="{{ route('shop') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('shop') && !request()->has('sort') ? 'text-gold-600 font-semibold' : 'text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold' }}"
                >
                    Shop All
                </a>

                <a 
                    href="{{ route('deals') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('deals*') ? 'text-gold-600 font-semibold' : 'text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold' }}"
                >
                    Deals
                </a>

                <a 
                    href="{{ route('about') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-gold-600 font-semibold' : 'text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold' }}"
                >
                    Our Story
                </a>

                <a 
                    href="{{ route('contact') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-gold-600 font-semibold' : 'text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold' }}"
                >
                    Contact
                </a>

                <a 
                    href="{{ route('track-order') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('track-order') ? 'text-gold-600 font-semibold' : 'text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold' }}"
                >
                    Track Order
                </a>
            </nav>

            <!-- Right Action Icons (De-cluttered on mobile: Search + Bag; Wishlist/Theme in drawer) -->
            <div class="flex items-center gap-1 sm:gap-3">
                
                <!-- Search Button -->
                <button 
                    type="button" 
                    @click="searchOpen = !searchOpen" 
                    class="p-2 text-espresso-900 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold transition-colors focus:outline-none"
                    aria-label="Search catalog"
                >
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>


                <!-- Wishlist Icon with Dynamic Badge (Desktop & Tablet only; in mobile drawer) -->
                <a 
                    href="{{ route('wishlist') }}" 
                    class="relative p-2 text-espresso-900 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold transition-colors focus:outline-none hidden md:inline-flex"
                    aria-label="Wishlist"
                >
                    <i data-lucide="heart" class="w-5 h-5"></i>
                    <span 
                        x-show="$store.wishlist.count > 0" 
                        x-text="$store.wishlist.count" 
                        x-cloak
                        class="absolute top-1 right-1 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-chocolate-700 rounded-full border border-white"
                    ></span>
                </a>

                <!-- Shopping Bag Button with Dynamic Badge (Mobile & Desktop Core Conversion) -->
                <button 
                    type="button" 
                    @click="$store.cart.isOpen = true" 
                    class="relative p-2 text-espresso-900 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold transition-colors focus:outline-none"
                    aria-label="Shopping Bag"
                >
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span 
                        x-show="$store.cart.count > 0" 
                        x-text="$store.cart.count" 
                        x-cloak
                        class="absolute top-1 right-1 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-espresso-950 bg-gold rounded-full border border-white"
                    ></span>
                </button>

                <!-- Theme Switcher Button (Desktop & Tablet only; mobile has it inside drawer header) -->
                <button 
                    type="button" 
                    @click="$store.theme.toggle()" 
                    class="p-2 text-espresso-900 dark:text-ivory-200 hover:text-gold dark:hover:text-gold transition-colors focus:outline-none rounded-full hidden md:inline-flex"
                    aria-label="Toggle light or dark theme"
                    :aria-label="$store.theme.current === 'dark' ? 'Switch to Light Theme' : 'Switch to Dark Atelier Theme'"
                    :title="$store.theme.current === 'dark' ? 'Switch to Light Theme' : 'Switch to Dark Atelier Theme'"
                >
                    <span x-show="$store.theme.current === 'dark'" x-cloak>
                        <i data-lucide="sun" class="w-5 h-5 text-gold"></i>
                    </span>
                    <span x-show="$store.theme.current === 'light'" x-cloak>
                        <i data-lucide="moon" class="w-5 h-5 text-espresso-900"></i>
                    </span>
                </button>

            </div>
        </div>
    </div>

    <!-- Search Overlay Bar with Live Instant Autocomplete Dropdown -->
    <div 
        x-show="searchOpen" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="bg-ivory-50 dark:bg-[#1E1815] border-t border-b border-ivory-300 dark:border-white/10 py-4 px-4 sm:px-6 shadow-md relative z-50"
    >
        <div class="max-w-3xl mx-auto relative">
            <form action="{{ route('search') }}" method="GET" class="relative flex items-center">
                <i data-lucide="search" class="absolute left-4 w-5 h-5 text-muted pointer-events-none"></i>
                <input 
                    type="search" 
                    name="q" 
                    x-model="searchQuery" 
                    @input="onSearchInput()"
                    aria-label="Search fine leather catalog"
                    placeholder="Search fine leather belts, wallets, handbags, and accessories..." 
                    class="w-full pl-12 pr-28 py-3.5 bg-white dark:bg-[#161210] border border-ivory-300 dark:border-white/10 rounded-xl text-sm text-espresso-900 dark:text-ivory-100 placeholder-muted focus:outline-none focus:ring-2 focus:ring-gold/60 focus:border-gold shadow-xs"
                    autofocus
                    autocomplete="off"
                >
                <div class="absolute right-2 flex items-center space-x-1.5">
                    <!-- Loading Indicator -->
                    <div x-show="searchLoading" class="mr-1 text-gold-600" x-cloak>
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </div>

                    <button 
                        type="submit" 
                        class="px-4 py-1.5 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-wider font-semibold rounded-lg shadow-sm transition-all"
                    >
                        Search
                    </button>
                    <button 
                        type="button" 
                        @click="searchOpen = false" 
                        class="p-2 text-muted hover:text-espresso-900 dark:hover:text-white transition-colors"
                        aria-label="Close search"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>

            <!-- Popular Suggestions Pills -->
            <div class="mt-2.5 flex items-center gap-2 text-xs text-muted flex-wrap">
                <span class="font-medium text-espresso-800 dark:text-ivory-200">Popular:</span>
                <button type="button" @click="applyPopular('Leather Belts')" class="hover:text-gold-600 dark:hover:text-gold underline underline-offset-2">Leather Belts</button>
                <span>•</span>
                <button type="button" @click="applyPopular('Reversible Belt')" class="hover:text-gold-600 dark:hover:text-gold underline underline-offset-2">Reversible Belts</button>
                <span>•</span>
                <button type="button" @click="applyPopular('Wallets')" class="hover:text-gold-600 dark:hover:text-gold underline underline-offset-2">Wallets</button>
                <span>•</span>
                <button type="button" @click="applyPopular('Handbags')" class="hover:text-gold-600 dark:hover:text-gold underline underline-offset-2">Handbags</button>
            </div>

            <!-- Instant Live Results Floating Card -->
            <div 
                x-show="searchQuery.trim().length >= 1" 
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="absolute left-0 right-0 top-full mt-2 bg-white dark:bg-[#1A1412] rounded-2xl shadow-2xl border border-ivory-300 dark:border-white/10 overflow-hidden z-50 max-h-[70vh] overflow-y-auto scrollbar-thin divide-y divide-ivory-200 dark:divide-white/5"
            >
                <!-- If No Matches -->
                <div x-show="!searchLoading && searchResults.total === 0" class="p-8 text-center">
                    <div class="w-12 h-12 rounded-full bg-ivory-100 dark:bg-[#251D18] text-muted mx-auto flex items-center justify-center mb-2.5">
                        <i data-lucide="search-x" class="w-6 h-6"></i>
                    </div>
                    <h4 class="font-serif font-bold text-sm text-espresso-950 dark:text-white">No creations found matching "<span x-text="searchQuery"></span>"</h4>
                    <p class="text-xs text-muted mt-1">Try searching by leather type, collection name, or SKU.</p>
                </div>

                <!-- Matched Products -->
                <div x-show="searchResults.products && searchResults.products.length > 0" class="p-3">
                    <div class="px-2 py-1 text-[10px] uppercase tracking-wider font-bold text-gold-700 dark:text-gold flex items-center justify-between">
                        <span>Handcrafted Creations</span>
                        <span class="text-muted font-normal" x-text="searchResults.products.length + ' matches'"></span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-1.5">
                        <template x-for="item in searchResults.products" :key="'sp-' + item.id">
                            <a 
                                :href="item.url" 
                                class="flex items-center gap-3 p-2 rounded-xl hover:bg-ivory-100 dark:hover:bg-[#251D18] transition-all group border border-transparent hover:border-ivory-300 dark:hover:border-white/10"
                            >
                                <div class="w-12 h-12 rounded-lg bg-ivory-50 dark:bg-black/30 overflow-hidden shrink-0 border border-ivory-200 dark:border-white/10 shadow-xs">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="text-[10px] text-gold-700 font-medium uppercase tracking-wider block" x-text="item.category"></span>
                                    <h5 class="text-xs font-serif font-bold text-espresso-950 dark:text-white truncate group-hover:text-gold-700 transition-colors" x-text="item.name"></h5>
                                    <span class="text-xs font-mono font-bold text-espresso-900 dark:text-ivory-100" x-text="item.price"></span>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Matched Categories -->
                <div x-show="searchResults.categories && searchResults.categories.length > 0" class="p-3 bg-ivory-50/50 dark:bg-[#161210]/50">
                    <div class="px-2 py-0.5 text-[10px] uppercase tracking-wider font-bold text-gold-700 dark:text-gold">
                        Collections
                    </div>
                    <div class="flex items-center gap-2 flex-wrap mt-1.5">
                        <template x-for="cat in searchResults.categories" :key="'sc-' + cat.id">
                            <a 
                                :href="cat.url" 
                                class="px-3 py-1 rounded-full text-xs font-semibold bg-white dark:bg-[#251D18] border border-ivory-300 dark:border-white/10 text-espresso-900 dark:text-white hover:border-gold hover:text-gold-700 transition-colors inline-flex items-center gap-1.5"
                            >
                                <i data-lucide="folder" class="w-3 h-3 text-gold-600"></i>
                                <span x-text="cat.name"></span>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Full Search Page Link Footer -->
                <div class="p-2.5 bg-ivory-100/60 dark:bg-[#120E0C] text-center">
                    <a 
                        :href="'{{ route('search') }}?q=' + encodeURIComponent(searchQuery)" 
                        class="text-xs font-bold text-espresso-950 dark:text-gold hover:underline inline-flex items-center gap-1.5"
                    >
                        <span>View all matching creations in catalog</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- Mobile Navigation Drawer with Accordion Subcategories (Teleported to body to prevent sticky header clipping on scroll) -->
    <template x-teleport="body">
        <div 
            x-show="mobileMenuOpen" 
            x-cloak
            style="display: none;"
            class="lg:hidden fixed inset-0 z-[9999] flex"
        >
            <!-- Backdrop -->
            <div 
                x-show="mobileMenuOpen" 
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileMenuOpen = false" 
                class="fixed inset-0 bg-espresso-950/70 backdrop-blur-xs"
            ></div>

            <!-- Drawer Content -->
            <div 
                x-show="mobileMenuOpen" 
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative max-w-xs w-full bg-white dark:bg-[#161210] h-full shadow-2xl flex flex-col justify-between py-6 px-6 z-10 overflow-y-auto"
            >
            <div>
                <!-- Drawer Header -->
                <div class="flex items-center justify-between pb-6 border-b border-ivory-200 dark:border-white/10">
                    <x-user.components.logo height="h-10" />
                    <div class="flex items-center gap-1">
                        <!-- Mobile Theme Toggle -->
                        <button 
                            type="button" 
                            @click="$store.theme.toggle()" 
                            class="p-2 text-espresso-800 dark:text-ivory-200 hover:text-gold rounded-full focus:outline-none"
                            aria-label="Toggle Theme"
                        >
                            <span x-show="$store.theme.current === 'dark'" x-cloak>
                                <i data-lucide="sun" class="w-5 h-5 text-gold"></i>
                            </span>
                            <span x-show="$store.theme.current === 'light'" x-cloak>
                                <i data-lucide="moon" class="w-5 h-5 text-espresso-800"></i>
                            </span>
                        </button>
                        <button 
                            type="button" 
                            @click="mobileMenuOpen = false" 
                            class="p-2 -mr-2 text-espresso-800 dark:text-ivory-200 hover:text-gold-600 focus:outline-none"
                            aria-label="Close menu"
                        >
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Navigation Links List with Accordion -->
                <nav class="mt-6 space-y-3">
                    <a 
                        href="{{ route('home') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-espresso-900 dark:text-ivory-100 hover:text-gold-600' }}"
                    >
                        Home
                    </a>

                    <!-- Mobile Collections Accordion -->
                    <div class="py-1 border-t border-b border-ivory-200 dark:border-white/10">
                        <button 
                            type="button" 
                            @click="mobileCollectionsOpen = !mobileCollectionsOpen"
                            class="w-full flex items-center justify-between py-2 text-sm font-bold tracking-wide uppercase text-espresso-950 dark:text-ivory-100 focus:outline-none"
                        >
                            <span>All Collections</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="mobileCollectionsOpen ? 'rotate-180 text-gold-600' : ''"></i>
                        </button>

                        <div x-show="mobileCollectionsOpen" class="pl-3 pr-1 py-2 space-y-4">
                            @forelse($megaCategories as $cat)
                                <div>
                                    <div class="flex items-center justify-between text-xs font-bold text-espresso-900 dark:text-ivory uppercase font-serif pb-1">
                                        <a href="{{ route('category', $cat->slug) }}" @click="mobileMenuOpen = false" class="hover:text-gold-600">{{ $cat->name }}</a>
                                    </div>
                                    @if($cat->subcategories->isNotEmpty())
                                        <ul class="pl-2 space-y-1.5 text-xs text-muted dark:text-ivory-300">
                                            @foreach($cat->subcategories as $sub)
                                                <li>
                                                    <a href="{{ route('shop', ['category' => $cat->slug, 'subcategory' => $sub->slug]) }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">
                                                        {{ $sub->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @empty
                                <div class="text-xs text-muted py-2">
                                    <a href="{{ route('shop') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600">Explore All Creations</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <a 
                        href="{{ route('wishlist') }}" 
                        @click="mobileMenuOpen = false"
                        class="flex items-center justify-between text-sm font-medium tracking-wide uppercase py-1 text-espresso-900 dark:text-ivory-100 hover:text-gold-600"
                    >
                        <span class="flex items-center gap-2">
                            <i data-lucide="heart" class="w-4 h-4 text-gold"></i>
                            <span>Saved Pieces (Wishlist)</span>
                        </span>
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count" class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gold/20 text-gold-700"></span>
                    </a>

                    <a 
                        href="{{ route('shop') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 {{ request()->routeIs('shop') ? 'text-gold-600 font-semibold' : 'text-espresso-900 hover:text-gold-600' }}"
                    >
                        Shop All Creations
                    </a>
                    <a 
                        href="{{ route('deals') }}" 
                        @click="mobileMenuOpen = false"
                        class="flex items-center justify-between text-sm font-medium tracking-wide uppercase py-1 {{ request()->routeIs('deals*') ? 'text-gold-600 font-semibold' : 'text-espresso-900 hover:text-gold-600' }}"
                    >
                        <span>Curated Deals & Sets</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gold/20 text-gold-700">Offers</span>
                    </a>
                    <a 
                        href="{{ route('about') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 text-espresso-900 hover:text-gold-600"
                    >
                        About By Zunash
                    </a>
                    <a 
                        href="{{ route('contact') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 text-espresso-900 hover:text-gold-600"
                    >
                        Client Care & Concierge
                    </a>
                    <a 
                        href="{{ route('track-order') }}" 
                        @click="mobileMenuOpen = false"
                        class="flex items-center gap-2 text-sm font-medium tracking-wide uppercase py-1 {{ request()->routeIs('track-order') ? 'text-gold-600 font-semibold' : 'text-espresso-900 dark:text-ivory-100 hover:text-gold-600' }}"
                    >
                        <i data-lucide="compass" class="w-4 h-4 text-tan-600"></i>
                        <span>Track Consignment</span>
                    </a>
                </nav>
            </div>

            <!-- Drawer Footer -->
            <div class="pt-6 border-t border-ivory-200">
                <div class="text-xs text-muted mb-2">
                    Nationwide Cash on Delivery Across Pakistan
                </div>
                <div class="text-[11px] text-muted-dark">
                    Crafted with pride & enduring elegance.
                </div>
            </div>
        </div>
    </template>
</header>
