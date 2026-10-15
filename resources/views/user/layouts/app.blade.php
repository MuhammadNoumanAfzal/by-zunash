<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary SEO Meta Tags -->
    <title>@yield('title', 'By Zunash | Luxury Pakistani Leather Goods — Belts, Wallets & Bags')</title>
    <meta name="title" content="@yield('title', 'By Zunash | Luxury Pakistani Leather Goods — Belts, Wallets & Bags')">
    <meta name="description" content="@yield('meta_description', 'Discover handcrafted full-grain leather belts, luxury bifold wallets, sculpted handbags, shoulder bags, and accessories in Pakistan by By Zunash. Nationwide Cash on Delivery.')">
    <meta name="keywords" content="@yield('meta_keywords', 'pure leather belts Pakistan, full grain leather wallets Pakistan, luxury leather handbags Lahore, handmade leather bags Karachi, Pakistani leather goods, By Zunash')">
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <meta name="author" content="By Zunash Atelier">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Regional & Local Pakistani E-Commerce SEO -->
    <meta name="geo.region" content="PK">
    <meta name="geo.placename" content="Lahore, Karachi, Islamabad, Pakistan">
    <meta name="geo.position" content="31.5204;74.3587">
    <meta name="ICBM" content="31.5204, 74.3587">
    <meta name="language" content="English">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="By Zunash">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', View::getSection('title', 'By Zunash | Luxury Pakistani Leather Goods'))">
    <meta property="og:description" content="@yield('og_description', View::getSection('meta_description', 'Handcrafted full-grain leather silhouettes, reversible belts, and accessories in Pakistan.'))">
    <meta property="og:image" content="@yield('og_image', asset('images/hero/slide-bag.jpg'))">
    <meta property="og:image:alt" content="By Zunash Luxury Pakistani Leathercraft">
    <meta property="og:locale" content="en_PK">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', View::getSection('title', 'By Zunash | Luxury Pakistani Leather Goods'))">
    <meta name="twitter:description" content="@yield('og_description', View::getSection('meta_description', 'Handcrafted full-grain leather silhouettes, reversible belts, and accessories in Pakistan.'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/hero/slide-bag.jpg'))">

    <!-- Google Global Structured Data (Organization & WebSite) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "@id": "{{ url('/') }}/#organization",
                "name": "By Zunash",
                "url": "{{ url('/') }}",
                "logo": {
                    "@type": "ImageObject",
                    "@id": "{{ url('/') }}/#logo",
                    "url": "{{ asset('images/logo.png') }}",
                    "caption": "By Zunash Luxury Leather"
                },
                "description": "Artisanal full-grain leather goods handcrafted in Pakistan. Heirloom reversible belts, RFID wallets, handbags, and bespoke accessories.",
                "address": {
                    "@type": "PostalAddress",
                    "addressCountry": "PK",
                    "addressLocality": "Lahore",
                    "addressRegion": "Punjab"
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+92-300-1234567",
                    "contactType": "customer service",
                    "areaServed": "PK",
                    "availableLanguage": ["English", "Urdu"]
                },
                "sameAs": [
                    "https://www.instagram.com",
                    "https://www.facebook.com"
                ]
            },
            {
                "@type": "WebSite",
                "@id": "{{ url('/') }}/#website",
                "url": "{{ url('/') }}",
                "name": "By Zunash",
                "publisher": {
                    "@id": "{{ url('/') }}/#organization"
                },
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": "{{ route('search') }}?q={search_term_string}",
                    "query-input": "required name=search_term_string"
                }
            }
        ]
    }
    </script>

    @stack('schema')

    <!-- Preconnect & Luxury Google Fonts (Cormorant Garamond, Cinzel, Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Critical Alpine Cloak Protection (Prevents sidepane and drawer flash on navigation) -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Stylesheet & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="antialiased bg-[#FAF8F5] text-espresso-900 selection:bg-gold selection:text-white flex flex-col min-h-screen">
    
    <!-- Announcement Bar -->
    <div class="bg-espresso-950 text-gold-200 text-[11px] py-2 px-4 text-center font-medium tracking-widest border-b border-gold/20 flex items-center justify-center gap-2">
        <span class="inline-block w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></span>
        <span>TIMELESS LEATHER. EVERYDAY LUXURY. | Nationwide Delivery Across Pakistan</span>
        <span class="inline-block w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></span>
    </div>

    <!-- Main Navigation Bar -->
    <x-user.components.navbar />

    <!-- Main Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <x-user.components.footer />

    <!-- Slide-over Shopping Bag Drawer (Zero-FOUC Glitch Protected) -->
    <div 
        x-data 
        x-show="$store.cart.isOpen" 
        x-cloak 
        style="display: none;"
        class="fixed inset-0 z-50 overflow-hidden" 
        role="dialog" 
        aria-modal="true"
        aria-labelledby="cart-drawer-title"
    >
        <!-- Background Backdrop -->
        <div 
            x-show="$store.cart.isOpen" 
            x-cloak
            x-transition:enter="ease-in-out duration-400"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="$store.cart.isOpen = false" 
            class="fixed inset-0 bg-espresso-950/70 backdrop-blur-xs transition-opacity"
        ></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10" x-show="$store.cart.isOpen" x-cloak style="display: none;">
            <div 
                x-show="$store.cart.isOpen" 
                x-cloak
                x-transition:enter="transform transition ease-in-out duration-400 sm:duration-500"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-400 sm:duration-500"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md bg-white shadow-2xl flex flex-col"
            >
                <!-- Drawer Header -->
                <div class="p-6 bg-ivory-50 border-b border-ivory-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-gold-600"></i>
                        <h2 id="cart-drawer-title" class="font-serif text-lg font-bold text-espresso-900 uppercase tracking-wider">
                            Shopping Bag (<span x-text="$store.cart.count"></span>)
                        </h2>
                    </div>
                    <button 
                        type="button" 
                        @click="$store.cart.isOpen = false" 
                        class="p-2 text-muted hover:text-espresso-900 rounded-full focus:outline-none"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Free Shipping Progress -->
                <div class="px-6 py-3 bg-ivory-100/60 border-b border-ivory-200 text-xs text-espresso-800">
                    <template x-if="$store.cart.subtotal >= 6000">
                        <div class="flex items-center gap-1.5 text-chocolate-700 font-medium">
                            <i data-lucide="truck" class="w-4 h-4 text-gold"></i>
                            <span>Complimentary Nationwide Delivery unlocked!</span>
                        </div>
                    </template>
                    <template x-if="$store.cart.subtotal > 0 && $store.cart.subtotal < 6000">
                        <div>
                            Add <span class="font-bold text-chocolate-700">PKR <span x-text="(6000 - $store.cart.subtotal).toLocaleString()"></span></span> more for free delivery.
                        </div>
                    </template>
                    <template x-if="$store.cart.subtotal === 0">
                        <span>Free Nationwide Delivery on orders over PKR 6,000.</span>
                    </template>
                </div>

                <!-- Cart Items List (Scrollable) -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <!-- Empty State -->
                    <template x-if="$store.cart.items.length === 0">
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-ivory-200 flex items-center justify-center text-muted">
                                <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                            </div>
                            <h3 class="font-serif text-base font-semibold text-espresso-900 mb-1">Your bag is empty</h3>
                            <p class="text-xs text-muted max-w-xs mx-auto mb-6">
                                Explore our heirloom collection of pure leather belts, wallets, and bags.
                            </p>
                            <a 
                                href="{{ route('shop') }}" 
                                @click="$store.cart.isOpen = false" 
                                class="inline-flex items-center justify-center px-6 py-2.5 bg-espresso text-ivory text-xs uppercase tracking-widest font-medium rounded hover:bg-chocolate-700 transition-colors shadow-sm"
                            >
                                Discover Catalog
                            </a>
                        </div>
                    </template>

                    <!-- Items -->
                    <template x-for="item in $store.cart.items" :key="item.key">
                        <div class="flex items-start gap-4 py-3 border-b border-ivory-200">
                            <!-- Thumbnail -->
                            <img 
                                :src="item.image" 
                                :alt="item.name" 
                                class="w-20 h-24 object-cover rounded bg-ivory-100 flex-shrink-0 border border-ivory-300"
                            >

                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <h4 class="font-serif text-sm font-semibold text-espresso-900 truncate" x-text="item.name"></h4>
                                    <button 
                                        type="button" 
                                        @click="$store.cart.removeItem(item.key)" 
                                        class="text-muted hover:text-red-500 transition-colors ml-2 p-1"
                                        title="Remove item"
                                    >
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>

                                <p class="text-xs text-muted mt-0.5" x-show="item.variant" x-text="'Tone: ' + item.variant"></p>

                                <div class="mt-2 text-sm font-bold text-espresso-900">
                                    PKR <span x-text="(item.price * item.quantity).toLocaleString()"></span>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="mt-2.5 flex items-center gap-2">
                                    <div class="flex items-center border border-ivory-300 rounded overflow-hidden">
                                        <button 
                                            type="button" 
                                            @click="$store.cart.updateQuantity(item.key, item.quantity - 1)" 
                                            class="w-7 h-7 flex items-center justify-center bg-ivory-50 hover:bg-ivory-200 text-espresso-800 transition-colors"
                                            :disabled="item.quantity <= 1"
                                        >
                                            <i data-lucide="minus" class="w-3 h-3"></i>
                                        </button>
                                        <span class="w-8 text-center text-xs font-semibold text-espresso-900" x-text="item.quantity"></span>
                                        <button 
                                            type="button" 
                                            @click="$store.cart.updateQuantity(item.key, item.quantity + 1)" 
                                            class="w-7 h-7 flex items-center justify-center bg-ivory-50 hover:bg-ivory-200 text-espresso-800 transition-colors"
                                        >
                                            <i data-lucide="plus" class="w-3 h-3"></i>
                                        </button>
                                    </div>
                                    <span class="text-[11px] text-muted">@ PKR <span x-text="item.price.toLocaleString()"></span></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Drawer Footer (Subtotals & Checkout) -->
                <div x-show="$store.cart.items.length > 0" class="p-6 bg-ivory-50 border-t border-ivory-200 space-y-4">
                    <div class="space-y-1.5 text-xs text-espresso-800">
                        <div class="flex justify-between">
                            <span>Bag Subtotal</span>
                            <span class="font-semibold">PKR <span x-text="$store.cart.subtotal.toLocaleString()"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimated Shipping (Pakistan)</span>
                            <span class="font-semibold" x-text="$store.cart.shipping === 0 ? 'FREE' : 'PKR ' + $store.cart.shipping"></span>
                        </div>
                        <div class="pt-2 border-t border-ivory-300 flex justify-between text-sm font-bold text-espresso-950 font-serif">
                            <span>Estimated Total</span>
                            <span>PKR <span x-text="$store.cart.total.toLocaleString()"></span></span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <a 
                            href="{{ route('checkout') }}" 
                            @click="$store.cart.isOpen = false"
                            class="w-full py-3.5 px-4 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded text-center block transition-all shadow-md border border-gold/30"
                        >
                            Proceed to Checkout
                        </a>
                        <a 
                            href="{{ route('cart') }}" 
                            @click="$store.cart.isOpen = false"
                            class="w-full py-2.5 px-4 bg-white hover:bg-ivory-100 text-espresso-800 text-xs uppercase tracking-widest font-medium rounded text-center block transition-colors border border-ivory-300"
                        >
                            View Full Bag
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Toast Alert -->
    <div 
        x-data 
        x-show="$store.toast.visible" 
        x-cloak
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-3"
        class="fixed top-6 right-6 z-50 max-w-sm w-full bg-espresso-950 text-ivory px-4 py-3 rounded-lg shadow-2xl border border-gold/40 flex items-center justify-between gap-3"
        role="alert"
    >
        <div class="flex items-center gap-3">
            <template x-if="$store.toast.type === 'success'">
                <div class="w-7 h-7 rounded-full bg-gold/20 flex items-center justify-center text-gold flex-shrink-0">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
            </template>
            <template x-if="$store.toast.type === 'info'">
                <div class="w-7 h-7 rounded-full bg-white/10 flex items-center justify-center text-ivory flex-shrink-0">
                    <i data-lucide="check" class="w-4 h-4 text-gold"></i>
                </div>
            </template>
            <p class="text-xs font-medium text-ivory-200" x-text="$store.toast.message"></p>
        </div>
        <button 
            type="button" 
            @click="$store.toast.hide()" 
            class="text-ivory-400 hover:text-white"
        >
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    @stack('scripts')
</body>
</html>
