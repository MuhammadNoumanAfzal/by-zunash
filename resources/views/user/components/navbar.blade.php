<header 
    x-data="{ 
        mobileMenuOpen: false, 
        searchOpen: false, 
        searchQuery: '',
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
    class="sticky top-0 z-40 w-full transition-all duration-300"
    :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-xs border-b border-ivory-300' : 'bg-white border-b border-ivory-200'"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative" @click.outside="collectionsOpen = false">
        <div class="flex items-center justify-between h-20">
            
            <!-- Mobile Menu Toggle Button (Left on Mobile) -->
            <div class="flex items-center lg:hidden">
                <button 
                    type="button" 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="p-2 -ml-2 rounded-md text-espresso-900 hover:text-gold-600 focus:outline-none"
                    aria-label="Toggle navigation menu"
                >
                    <i data-lucide="menu" x-show="!mobileMenuOpen" class="w-6 h-6"></i>
                    <i data-lucide="x" x-show="mobileMenuOpen" x-cloak class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Brand Logo (Center on Mobile, Left on Desktop) -->
            <div class="flex-shrink-0 flex items-center">
                <x-user.components.logo height="h-10" />
            </div>

            <!-- Desktop Navigation Links (Scalable Curated Top-Level) -->
            <nav class="hidden lg:flex items-center space-x-7">
                <a 
                    href="{{ route('home') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
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
                        class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 flex items-center gap-1.5 py-7 focus:outline-none"
                        :class="collectionsOpen || {{ request()->is('category*') ? 'true' : 'false' }} ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600'"
                        aria-expanded="collectionsOpen"
                    >
                        <span>Collections</span>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="collectionsOpen ? 'rotate-180 text-gold-600' : ''"></i>
                    </button>

                    <!-- Full-Width Luxury Mega-Menu Dropdown (Centered & Contained within max-w-7xl, Zero Overflow) -->
                    <div 
                        x-show="collectionsOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1 pointer-events-none"
                        x-transition:enter-end="opacity-100 translate-y-0 pointer-events-auto"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute top-full left-0 right-0 w-full bg-white border border-ivory-300 rounded-2xl shadow-2xl z-50 pt-7 pb-0 px-8 overflow-hidden before:absolute before:-top-6 before:left-0 before:right-0 before:h-6 before:content-['']"
                        style="background-color: #ffffff !important;"
                        @mouseenter="openCollections()"
                        @mouseleave="closeCollections()"
                    >
                        <div class="grid grid-cols-12 gap-8 pb-7">
                            
                            <!-- Column 1: Leather Belts -->
                            <div class="col-span-3 space-y-3">
                                <a href="{{ route('category', 'belts') }}" class="group flex items-center justify-between pb-2.5 border-b border-ivory-200">
                                    <h4 class="font-serif text-xs font-bold uppercase tracking-wider text-black group-hover:text-gold-600 transition-colors">
                                        Leather Belts
                                    </h4>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gold-600 transition-transform group-hover:translate-x-1"></i>
                                </a>
                                <ul class="space-y-1 text-xs">
                                    <li>
                                        <a href="{{ route('product.details', 'the-royal-reversible-calfskin-belt') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Reversible 360° Calfskin Belts
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'hand-burnished-classic-dress-belt') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Hand-Burnished Classic Dress Belts
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'saddle-stitched-artisan-casual-belt') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Saddle-Stitched Casual Belts
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'braided-heritage-leather-belt') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Braided Heritage Leather Belts
                                        </a>
                                    </li>
                                    <li class="pt-1.5">
                                        <a href="{{ route('category', 'belts') }}" class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wider flex items-center gap-1.5 px-2">
                                            <span>All Belts (4 Pieces)</span>
                                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Column 2: Wallets & Cardholders -->
                            <div class="col-span-3 space-y-3">
                                <a href="{{ route('category', 'wallets') }}" class="group flex items-center justify-between pb-2.5 border-b border-ivory-200">
                                    <h4 class="font-serif text-xs font-bold uppercase tracking-wider text-black group-hover:text-gold-600 transition-colors">
                                        Wallets & Cardholders
                                    </h4>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gold-600 transition-transform group-hover:translate-x-1"></i>
                                </a>
                                <ul class="space-y-1 text-xs">
                                    <li>
                                        <a href="{{ route('product.details', 'the-heritage-bifold-leather-wallet') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            The Heritage Bifold Wallet
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'minimalist-slim-cardholder') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Minimalist Slim Cardholders
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'the-continental-zippered-long-wallet') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Continental Zippered Long Wallets
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'the-executive-travel-passport-case') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Executive Travel Passport Cases
                                        </a>
                                    </li>
                                    <li class="pt-1.5">
                                        <a href="{{ route('category', 'wallets') }}" class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wider flex items-center gap-1.5 px-2">
                                            <span>All Wallets (4 Pieces)</span>
                                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Column 3: Handbags & Shoulder Bags -->
                            <div class="col-span-3 space-y-3">
                                <a href="{{ route('category', 'handbags') }}" class="group flex items-center justify-between pb-2.5 border-b border-ivory-200">
                                    <h4 class="font-serif text-xs font-bold uppercase tracking-wider text-black group-hover:text-gold-600 transition-colors">
                                        Handbags & Bags
                                    </h4>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gold-600 transition-transform group-hover:translate-x-1"></i>
                                </a>
                                <ul class="space-y-1 text-xs">
                                    <li>
                                        <a href="{{ route('product.details', 'the-sovereign-leather-tote') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            The Sovereign Leather Tote
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.details', 'the-zunash-signature-satchel') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            The Zunash Signature Satchel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('category', 'shoulder-bags') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Shoulder Bags & Crossbodies
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('category', 'accessories') }}" class="text-espresso-800 hover:text-gold-600 hover:bg-ivory-50 px-2 py-1.5 rounded font-medium transition-all block">
                                            Everyday Leather Accessories
                                        </a>
                                    </li>
                                    <li class="pt-1.5">
                                        <a href="{{ route('shop') }}" class="text-xs font-bold text-gold-600 hover:text-gold-700 uppercase tracking-wider flex items-center gap-1.5 px-2">
                                            <span>All Bags (8 Pieces)</span>
                                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Column 4: Atelier Spotlight Card -->
                            <div class="col-span-3 bg-ivory-50 rounded-xl p-4 border border-ivory-200 flex flex-col justify-between shadow-xs">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[10px] uppercase tracking-widest text-gold-600 font-serif font-bold">
                                            Atelier Spotlight
                                        </span>
                                        <span class="text-[10px] uppercase tracking-wider text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded font-medium border border-emerald-200">
                                            Bestseller
                                        </span>
                                    </div>
                                    <h5 class="font-serif text-sm font-bold text-espresso-950 mb-1">
                                        The Royal Reversible Belt
                                    </h5>
                                    <p class="text-[11px] text-muted-dark leading-relaxed line-clamp-2 mb-3 font-light">
                                        Two refined looks in one. Italian calfskin with 360° swivel brass buckle.
                                    </p>
                                    <div class="aspect-[16/10] rounded-lg overflow-hidden bg-ivory-100 mb-3 border border-ivory-300">
                                        <img 
                                            src="https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=600&q=80" 
                                            alt="The Royal Reversible Belt" 
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                </div>
                                <a 
                                    href="{{ route('product.details', 'the-royal-reversible-calfskin-belt') }}" 
                                    class="w-full py-2 bg-espresso-950 hover:bg-gold-600 text-white hover:text-white text-xs uppercase tracking-wider font-bold rounded-lg text-center block transition-all shadow-xs"
                                >
                                    Inspect • PKR 4,950
                                </a>
                            </div>

                        </div>

                        <!-- Mega Menu Bottom Reassurance Bar (Solid Ivory with high-contrast text) -->
                        <div class="-mx-8 py-3.5 px-8 bg-ivory-100 border-t border-ivory-200 flex items-center justify-between text-xs text-espresso-900">
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
                                <span>Explore Full Catalog (20 Pieces)</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <a 
                    href="{{ route('shop') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('shop') && !request()->has('sort') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Shop All
                </a>

                <a 
                    href="{{ route('shop', ['sort' => 'latest']) }}" 
                    class="text-xs uppercase tracking-widest font-medium text-espresso-800 hover:text-gold-600 transition-colors duration-200 flex items-center gap-1.5"
                >
                    <span>New Arrivals</span>
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-gold"></span>
                </a>

                <a 
                    href="{{ route('about') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Our Story
                </a>

                <a 
                    href="{{ route('contact') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Contact
                </a>
            </nav>

            <!-- Right Action Icons (Search, Account, Wishlist, Cart) -->
            <div class="flex items-center space-x-3 sm:space-x-5">
                
                <!-- Search Button -->
                <button 
                    type="button" 
                    @click="searchOpen = !searchOpen" 
                    class="p-2 text-espresso-900 hover:text-gold-600 transition-colors focus:outline-none"
                    aria-label="Search catalog"
                >
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>

                <!-- Customer Account Link -->
                <a 
                    href="{{ route('contact') }}" 
                    class="p-2 text-espresso-900 hover:text-gold-600 transition-colors focus:outline-none hidden sm:inline-flex"
                    aria-label="Client Services & Contact"
                    title="Client Services"
                >
                    <i data-lucide="user" class="w-5 h-5"></i>
                </a>

                <!-- Wishlist Icon with Dynamic Badge -->
                <a 
                    href="{{ route('wishlist') }}" 
                    class="relative p-2 text-espresso-900 hover:text-gold-600 transition-colors focus:outline-none"
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

                <!-- Shopping Bag Button with Dynamic Badge -->
                <button 
                    type="button" 
                    @click="$store.cart.isOpen = true" 
                    class="relative p-2 text-espresso-900 hover:text-gold-600 transition-colors focus:outline-none"
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

            </div>
        </div>
    </div>

    <!-- Search Overlay Bar (Slide Down) -->
    <div 
        x-show="searchOpen" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="bg-ivory-50 border-t border-b border-ivory-300 py-4 px-4 sm:px-6 shadow-md"
    >
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('search') }}" method="GET" class="relative flex items-center">
                <i data-lucide="search" class="absolute left-4 w-5 h-5 text-muted pointer-events-none"></i>
                <input 
                    type="search" 
                    name="q" 
                    x-model="searchQuery" 
                    placeholder="Search fine leather belts, wallets, handbags, and accessories..." 
                    class="w-full pl-12 pr-24 py-3 bg-white border border-ivory-300 rounded-lg text-sm text-espresso-900 placeholder-muted focus:outline-none focus:ring-2 focus:ring-gold/60 focus:border-gold"
                    autofocus
                >
                <div class="absolute right-2 flex items-center space-x-1">
                    <button 
                        type="submit" 
                        class="px-4 py-1.5 bg-espresso text-ivory text-xs uppercase tracking-wider font-medium rounded hover:bg-chocolate-700 transition-colors"
                    >
                        Search
                    </button>
                    <button 
                        type="button" 
                        @click="searchOpen = false" 
                        class="p-2 text-muted hover:text-espresso-900"
                        aria-label="Close search"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
            <div class="mt-2.5 flex items-center gap-2 text-xs text-muted">
                <span class="font-medium text-espresso-800">Popular:</span>
                <a href="{{ route('category', 'belts') }}" class="hover:text-gold-600 underline underline-offset-2">Reversible Belts</a>
                <span>•</span>
                <a href="{{ route('category', 'wallets') }}" class="hover:text-gold-600 underline underline-offset-2">RFID Wallets</a>
                <span>•</span>
                <a href="{{ route('category', 'handbags') }}" class="hover:text-gold-600 underline underline-offset-2">Signature Satchels</a>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer with Accordion Subcategories -->
    <div 
        x-show="mobileMenuOpen" 
        x-cloak
        style="display: none;"
        class="lg:hidden fixed inset-0 z-50 flex"
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
            class="fixed inset-0 bg-espresso-950/60 backdrop-blur-xs"
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
            class="relative max-w-xs w-full bg-white h-full shadow-2xl flex flex-col justify-between py-6 px-6 z-10 overflow-y-auto"
        >
            <div>
                <!-- Drawer Header -->
                <div class="flex items-center justify-between pb-6 border-b border-ivory-200">
                    <x-user.components.logo height="h-8" />
                    <button 
                        type="button" 
                        @click="mobileMenuOpen = false" 
                        class="p-2 -mr-2 text-espresso-800 hover:text-gold-600"
                        aria-label="Close menu"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Navigation Links List with Accordion -->
                <nav class="mt-6 space-y-3">
                    <a 
                        href="{{ route('home') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-espresso-900 hover:text-gold-600' }}"
                    >
                        Home
                    </a>

                    <!-- Mobile Collections Accordion -->
                    <div class="py-1 border-t border-b border-ivory-200">
                        <button 
                            type="button" 
                            @click="mobileCollectionsOpen = !mobileCollectionsOpen"
                            class="w-full flex items-center justify-between py-2 text-sm font-bold tracking-wide uppercase text-espresso-950 focus:outline-none"
                        >
                            <span>All Collections</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="mobileCollectionsOpen ? 'rotate-180 text-gold-600' : ''"></i>
                        </button>

                        <div x-show="mobileCollectionsOpen" class="pl-3 pr-1 py-2 space-y-4">
                            <!-- Belts Subgroup -->
                            <div>
                                <div class="flex items-center justify-between text-xs font-bold text-espresso-900 uppercase font-serif pb-1">
                                    <a href="{{ route('category', 'belts') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600">Leather Belts</a>
                                </div>
                                <ul class="pl-2 space-y-1.5 text-xs text-muted">
                                    <li><a href="{{ route('category', 'belts') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Reversible Belts</a></li>
                                    <li><a href="{{ route('category', 'belts') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Formal Dress Belts</a></li>
                                </ul>
                            </div>

                            <!-- Wallets Subgroup -->
                            <div>
                                <div class="flex items-center justify-between text-xs font-bold text-espresso-900 uppercase font-serif pb-1">
                                    <a href="{{ route('category', 'wallets') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600">Wallets & Smallgoods</a>
                                </div>
                                <ul class="pl-2 space-y-1.5 text-xs text-muted">
                                    <li><a href="{{ route('category', 'wallets') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Slim Bifold Wallets</a></li>
                                    <li><a href="{{ route('category', 'wallets') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">RFID Shielded Wallets</a></li>
                                </ul>
                            </div>

                            <!-- Bags Subgroup -->
                            <div>
                                <div class="flex items-center justify-between text-xs font-bold text-espresso-900 uppercase font-serif pb-1">
                                    <a href="{{ route('category', 'handbags') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600">Handbags & Purses</a>
                                </div>
                                <ul class="pl-2 space-y-1.5 text-xs text-muted">
                                    <li><a href="{{ route('category', 'handbags') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Signature Satchels</a></li>
                                    <li><a href="{{ route('category', 'shoulder-bags') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Crossbody & Shoulder</a></li>
                                </ul>
                            </div>

                            <!-- Accessories Subgroup -->
                            <div>
                                <div class="flex items-center justify-between text-xs font-bold text-espresso-900 uppercase font-serif pb-1">
                                    <a href="{{ route('category', 'accessories') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600">Accessories & Care</a>
                                </div>
                                <ul class="pl-2 space-y-1.5 text-xs text-muted">
                                    <li><a href="{{ route('category', 'accessories') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Passport Folios & Sleeves</a></li>
                                    <li><a href="{{ route('category', 'accessories') }}" @click="mobileMenuOpen = false" class="hover:text-gold-600 block py-0.5">Bespoke Gift Sets</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <a 
                        href="{{ route('shop') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 {{ request()->routeIs('shop') ? 'text-gold-600 font-semibold' : 'text-espresso-900 hover:text-gold-600' }}"
                    >
                        Shop All Creations
                    </a>
                    <a 
                        href="{{ route('shop', ['sort' => 'latest']) }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase py-1 text-gold-600 font-semibold"
                    >
                        New Arrivals
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
    </div>
</header>
