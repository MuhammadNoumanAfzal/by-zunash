<header 
    x-data="{ 
        mobileMenuOpen: false, 
        searchOpen: false, 
        searchQuery: '',
        isScrolled: false 
    }" 
    @scroll.window="isScrolled = (window.pageYOffset > 20)"
    class="sticky top-0 z-40 w-full transition-all duration-300"
    :class="isScrolled ? 'bg-white/95 backdrop-blur-md shadow-xs border-b border-ivory-300' : 'bg-white border-b border-ivory-200'"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a 
                    href="{{ route('home') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Home
                </a>
                <a 
                    href="{{ route('shop') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('shop') && !request()->has('sort') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Shop
                </a>
                <a 
                    href="{{ route('category', 'belts') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->is('category/belts') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Belts
                </a>
                <a 
                    href="{{ route('category', 'wallets') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->is('category/wallets') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Wallets
                </a>
                <a 
                    href="{{ route('category', 'handbags') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->is('category/handbags') || request()->is('category/shoulder-bags') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    Bags
                </a>
                <a 
                    href="{{ route('shop', ['sort' => 'latest']) }}" 
                    class="text-xs uppercase tracking-widest font-medium text-espresso-800 hover:text-gold-600 transition-colors duration-200 flex items-center gap-1"
                >
                    <span>New Arrivals</span>
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-gold"></span>
                </a>
                <a 
                    href="{{ route('about') }}" 
                    class="text-xs uppercase tracking-widest font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-gold-600 font-semibold' : 'text-espresso-800 hover:text-gold-600' }}"
                >
                    About Us
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

    <!-- Mobile Navigation Drawer -->
    <div 
        x-show="mobileMenuOpen" 
        x-cloak
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

                <!-- Navigation Links List -->
                <nav class="mt-6 space-y-4">
                    <a 
                        href="{{ route('home') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase {{ request()->routeIs('home') ? 'text-gold-600 font-semibold' : 'text-espresso-900 hover:text-gold-600' }}"
                    >
                        Home
                    </a>
                    <a 
                        href="{{ route('shop') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase {{ request()->routeIs('shop') ? 'text-gold-600 font-semibold' : 'text-espresso-900 hover:text-gold-600' }}"
                    >
                        All Leather Goods
                    </a>
                    <a 
                        href="{{ route('category', 'belts') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
                    >
                        Leather Belts
                    </a>
                    <a 
                        href="{{ route('category', 'wallets') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
                    >
                        Wallets & Cardholders
                    </a>
                    <a 
                        href="{{ route('category', 'handbags') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
                    >
                        Handbags
                    </a>
                    <a 
                        href="{{ route('category', 'shoulder-bags') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
                    >
                        Shoulder Bags
                    </a>
                    <a 
                        href="{{ route('category', 'accessories') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
                    >
                        Everyday Accessories
                    </a>
                    <a 
                        href="{{ route('shop', ['sort' => 'latest']) }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-gold-600 font-semibold"
                    >
                        New Arrivals
                    </a>
                    <a 
                        href="{{ route('about') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
                    >
                        About By Zunash
                    </a>
                    <a 
                        href="{{ route('contact') }}" 
                        @click="mobileMenuOpen = false"
                        class="block text-sm font-medium tracking-wide uppercase text-espresso-900 hover:text-gold-600"
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
