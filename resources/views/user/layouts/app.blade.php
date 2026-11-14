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
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#231B15">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

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
                    "telephone": "+92-321-4700545",
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

    @if(request()->routeIs('home'))
    <!-- Preload Critical Hero LCP Image for Instant Mobile Performance -->
    <link rel="preload" as="image" href="{{ asset('images/hero/slide-bag.webp') }}" type="image/webp" fetchpriority="high">
    @endif

    <!-- Preconnect & Asynchronous High-Performance Luxury Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">
    </noscript>

    <!-- Critical Alpine Cloak Protection & Print Styling -->
    <style>
        [x-cloak] {
            display: none !important;
        }
        @media print {
            .no-print, [no-print], .print\:hidden, a[href*="wa.me"], a[href*="whatsapp"] {
                display: none !important;
                visibility: hidden !important;
            }
        }
    </style>

    <!-- Immediate Theme & Dynamic Store Settings Initialization -->
    @php
        $freeShippingThreshold = (int) \App\Models\StoreSetting::get('free_shipping_threshold', 5000);
        $currencySymbol = \App\Models\StoreSetting::get('currency_symbol', 'Rs.');
    @endphp
    <script>
        window.BYZUNASH_FREE_SHIPPING_THRESHOLD = {{ $freeShippingThreshold }};
        window.BYZUNASH_CURRENCY_SYMBOL = "{{ $currencySymbol }}";
        (function() {
            const saved = localStorage.getItem('byzunash_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Stylesheet & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="antialiased bg-[#FAF8F5] dark:bg-[#161210] text-espresso-900 dark:text-[#F7F4EE] selection:bg-gold selection:text-white flex flex-col min-h-screen transition-colors duration-300">
    
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
        x-effect="if ($store.cart.isOpen) { setTimeout(() => window.refreshLucideIcons && window.refreshLucideIcons(), 50); }"
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

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-6 sm:pl-10" x-show="$store.cart.isOpen" x-cloak style="display: none;">
            <div 
                x-show="$store.cart.isOpen" 
                x-cloak
                x-transition:enter="transform transition ease-out duration-300 sm:duration-400"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-250 sm:duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md bg-white dark:bg-[#161210] shadow-2xl flex flex-col h-full border-l border-ivory-300 dark:border-white/10"
            >
                <!-- Drawer Header -->
                <div class="px-5 py-4 sm:px-6 sm:py-5 bg-[#FAF7F2] dark:bg-[#191411] border-b border-ivory-300 dark:border-white/10 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-gold/15 text-gold-700 dark:text-gold-400 flex items-center justify-center border border-gold/30 shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </div>
                        <div>
                            <h2 id="cart-drawer-title" class="font-serif text-sm sm:text-base font-bold text-espresso-950 dark:text-ivory uppercase tracking-wider">
                                Atelier Shopping Bag
                            </h2>
                            <span class="text-[11px] text-muted dark:text-ivory-400 font-light block -mt-0.5">
                                <span x-text="$store.cart.count" class="font-bold text-espresso-950 dark:text-ivory"></span> item(s) selected
                            </span>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        @click="$store.cart.isOpen = false" 
                        class="w-8 h-8 rounded-full bg-white dark:bg-[#241C18] hover:bg-ivory-200 dark:hover:bg-[#2F241F] border border-ivory-300 dark:border-white/15 text-espresso-800 dark:text-ivory-200 flex items-center justify-center transition-all hover:rotate-90 focus:outline-none shadow-xs cursor-pointer"
                        aria-label="Close cart"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>

                <!-- Animated Free Shipping Progress Bar (Dynamically Calculated from Backend Settings) -->
                @php
                    $freeShippingThreshold = (int) \App\Models\StoreSetting::get('free_shipping_threshold', 5000);
                @endphp
                <div class="px-5 py-3 bg-ivory-50 dark:bg-[#1A1411] border-b border-ivory-200/90 dark:border-white/10 text-xs flex-shrink-0" x-data="{ threshold: {{ $freeShippingThreshold }} }">
                    <template x-if="threshold <= 0 || $store.cart.subtotal >= threshold">
                        <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 font-semibold bg-emerald-50/90 dark:bg-emerald-950/40 px-3 py-1.5 rounded-lg border border-emerald-200/70 dark:border-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span class="text-[11px]">Free Nationwide Delivery Unlocked!</span>
                        </div>
                    </template>
                    <template x-if="threshold > 0 && $store.cart.subtotal > 0 && $store.cart.subtotal < threshold">
                        <div>
                            <div class="flex items-center justify-between text-[11px] text-espresso-800 dark:text-ivory-200 mb-1.5">
                                <span>Add <strong class="text-espresso-950 dark:text-white font-bold">PKR <span x-text="(threshold - $store.cart.subtotal).toLocaleString()"></span></strong> for Free Delivery</span>
                                <span class="font-mono text-gold-700 dark:text-gold-400 font-semibold" x-text="Math.min(100, Math.round(($store.cart.subtotal / threshold) * 100)) + '%'"></span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-ivory-200 dark:bg-white/10 overflow-hidden">
                                <div 
                                    class="h-full bg-gold rounded-full transition-all duration-500" 
                                    :style="'width: ' + Math.min(100, Math.round(($store.cart.subtotal / threshold) * 100)) + '%'"
                                ></div>
                            </div>
                        </div>
                    </template>
                    <template x-if="threshold > 0 && $store.cart.subtotal === 0">
                        <div class="text-[11px] text-muted flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>Free Delivery on orders over PKR {{ number_format($freeShippingThreshold) }}.</span>
                        </div>
                    </template>
                </div>

                <!-- Cart Items List (Scrollable, Clean Modern Cards) -->
                <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-3.5 scrollbar-thin">
                    
                    <!-- Empty State -->
                    <template x-if="$store.cart.items.length === 0">
                        <div class="py-14 text-center px-4">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-ivory-100 border border-ivory-200 flex items-center justify-center text-gold-700 shadow-xs">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            </div>
                            <h3 class="font-serif text-base font-bold text-espresso-950 mb-1.5">Your Shopping Bag is Empty</h3>
                            <p class="text-xs text-muted max-w-xs mx-auto mb-6 leading-relaxed font-light">
                                Discover our collection of pure full-grain leather belts, wallets, and sculpted bags.
                            </p>
                            <a 
                                href="{{ route('shop') }}" 
                                @click="$store.cart.isOpen = false" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-espresso text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl hover:bg-chocolate-800 transition-all shadow-md border border-gold/30"
                            >
                                Explore Atelier Catalog
                            </a>
                        </div>
                    </template>

                    <!-- Item Cards -->
                    <template x-for="item in $store.cart.items" :key="item.key">
                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] dark:bg-[#1E1815] hover:bg-ivory-100/70 dark:hover:bg-[#251E1A] border border-ivory-200/90 dark:border-white/10 transition-all flex items-start gap-3.5 group shadow-2xs">
                            
                            <!-- Thumbnail -->
                            <img 
                                :src="item.image" 
                                :alt="item.name" 
                                class="w-20 h-22 object-cover rounded-xl bg-white dark:bg-[#161210] border border-ivory-300 dark:border-white/10 shadow-xs flex-shrink-0 group-hover:scale-102 transition-transform"
                            >

                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                
                                <div class="flex items-start justify-between gap-1">
                                    <h4 class="font-serif text-xs sm:text-sm font-bold text-espresso-950 dark:text-ivory truncate leading-snug" x-text="item.name"></h4>
                                    <!-- Remove Button -->
                                    <button 
                                        type="button" 
                                        @click="$store.cart.removeItem(item.key)" 
                                        class="w-6 h-6 rounded-full bg-white dark:bg-[#251E1A] hover:bg-red-50 dark:hover:bg-red-950/40 text-muted dark:text-ivory-400 hover:text-red-500 border border-ivory-200 dark:border-white/10 flex items-center justify-center transition-colors flex-shrink-0 shadow-2xs cursor-pointer"
                                        title="Remove item"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </div>

                                <!-- Variant Pill -->
                                <div class="mt-1" x-show="item.variant">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold text-espresso-800 dark:text-ivory-200 bg-white dark:bg-[#161210] border border-ivory-200 dark:border-white/10 shadow-2xs" x-text="item.variant"></span>
                                </div>

                                <!-- Price -->
                                <div class="mt-1.5 flex items-baseline gap-2">
                                    <span class="font-serif text-sm font-bold text-espresso-950 dark:text-ivory" x-text="'PKR ' + (item.price * item.quantity).toLocaleString()"></span>
                                    <span class="text-[10px] text-muted dark:text-ivory-400 font-light" x-show="item.quantity > 1" x-text="'(@ PKR ' + item.price.toLocaleString() + ')'"></span>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="mt-2.5 flex items-center justify-between">
                                    <div class="h-7 rounded-lg bg-white dark:bg-[#161210] border border-ivory-300 dark:border-white/15 shadow-xs flex items-center overflow-hidden">
                                        <button 
                                            type="button" 
                                            @click="$store.cart.updateQuantity(item.key, item.quantity - 1)" 
                                            class="w-7 h-full flex items-center justify-center hover:bg-ivory-100 dark:hover:bg-white/5 text-espresso-800 dark:text-ivory-200 transition-colors focus:outline-none cursor-pointer"
                                            :disabled="item.quantity <= 1"
                                            aria-label="Decrease quantity"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </button>
                                        <span class="w-7 text-center text-xs font-bold text-espresso-950 dark:text-ivory" x-text="item.quantity"></span>
                                        <button 
                                            type="button" 
                                            @click="$store.cart.updateQuantity(item.key, item.quantity + 1)" 
                                            class="w-7 h-full flex items-center justify-center hover:bg-ivory-100 dark:hover:bg-white/5 text-espresso-800 dark:text-ivory-200 transition-colors focus:outline-none cursor-pointer"
                                            aria-label="Increase quantity"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </button>
                                    </div>
                                    <span class="text-[10px] text-muted dark:text-ivory-400">Doorstep COD</span>
                                </div>

                            </div>

                        </div>
                    </template>

                </div>

                <!-- Drawer Footer (Subtotals & Checkout, with Generous Breathing Room) -->
                <div x-show="$store.cart.items.length > 0" class="p-5 sm:p-6 pb-6 sm:pb-8 bg-white dark:bg-[#161210] border-t border-ivory-200 dark:border-white/10 space-y-3.5 shadow-2xl flex-shrink-0">
                    
                    <div class="space-y-1.5 text-xs text-espresso-800 dark:text-ivory-200">
                        <div class="flex justify-between">
                            <span class="text-muted dark:text-ivory-400">Bag Subtotal</span>
                            <span class="font-semibold text-espresso-950 dark:text-ivory">PKR <span x-text="$store.cart.subtotal.toLocaleString()"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted dark:text-ivory-400">Estimated Shipping (Pakistan)</span>
                            <span class="font-semibold" :class="$store.cart.shipping === 0 ? 'text-emerald-700 dark:text-emerald-400 font-bold' : 'text-espresso-950 dark:text-ivory'" x-text="$store.cart.shipping === 0 ? 'FREE' : 'PKR ' + $store.cart.shipping"></span>
                        </div>
                        <div class="pt-2 border-t border-ivory-200 dark:border-white/10 flex justify-between text-base font-bold text-espresso-950 dark:text-ivory font-serif">
                            <span>Estimated Total</span>
                            <span>PKR <span x-text="$store.cart.total.toLocaleString()"></span></span>
                        </div>
                    </div>

                    <!-- Action Buttons with Adequate Bottom Margins -->
                    <div class="space-y-2 pt-1">
                        <a 
                            href="{{ route('checkout') }}" 
                            @click="$store.cart.isOpen = false" 
                            class="w-full py-3.5 px-4 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-bold rounded-xl text-center block transition-all shadow-md hover:shadow-gold-glow border border-gold/40 flex items-center justify-center gap-2 active:scale-[0.98]"
                        >
                            <span>Proceed to Checkout</span>
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>

                        <a 
                            href="{{ route('cart') }}" 
                            @click="$store.cart.isOpen = false" 
                            class="w-full py-2.5 px-4 bg-ivory-100 dark:bg-[#251E1A] hover:bg-ivory-200 dark:hover:bg-[#2F2520] text-espresso-900 dark:text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl text-center block transition-colors border border-ivory-300 dark:border-white/10"
                        >
                            View & Edit Full Bag
                        </a>
                    </div>

                    <!-- Reassurance Footer Note -->
                    <div class="pt-1 text-center text-[10px] text-muted dark:text-ivory-400 flex items-center justify-center gap-3">
                        <span>• Doorstep COD</span>
                        <span>• 7-Day Size Exchange</span>
                        <span>• 100% Full-Grain</span>
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

    <!-- ================= FLOATING WHATSAPP CONCIERGE BUTTON ================= -->
    <a 
        href="https://wa.me/923214700545?text={{ urlencode('Assalam-o-Alaikum By Zunash Concierge! I would like assistance with an inquiry or order.') }}" 
        target="_blank" 
        rel="noopener noreferrer" 
        class="fixed bottom-6 right-6 z-40 group flex items-center gap-2.5 p-3.5 sm:px-4 sm:py-3 bg-[#25D366] hover:bg-[#20ba59] text-white rounded-full shadow-2xl hover:shadow-[#25D366]/40 hover:scale-105 transition-all duration-300 no-print print:hidden"
        aria-label="Chat with By Zunash Concierge on WhatsApp"
        title="Chat on WhatsApp (+92 321 4700545)"
    >
        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        <span class="hidden sm:inline-block text-xs font-bold uppercase tracking-wider">WhatsApp</span>
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-white rounded-full flex items-center justify-center shadow-xs">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
        </span>
    </a>

    @stack('scripts')
</body>
</html>
