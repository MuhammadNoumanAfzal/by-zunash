<!DOCTYPE html>
<html lang="en" class="scroll-smooth bg-[#FAF9F6] dark:bg-[#0D0A09]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'By Zunash Atelier Control Center | Luxury Leather Goods')</title>

    <!-- Theme Initialization: Set 'dark' class on html before first render to prevent white flash -->
    <script>
        (function() {
            try {
                const storedTheme = localStorage.getItem('zunash_admin_theme');
                if (storedTheme === 'dark' || (!storedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Google Fonts: Plus Jakarta Sans & Inter for clean, ultra-readable modern e-commerce dashboard -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Play CDN for Admin UI) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        espresso: {
                            50: '#F5F5F5',
                            100: '#E8E6E3',
                            200: '#D2CEC8',
                            300: '#A9A39A',
                            400: '#736B61',
                            700: '#2A201A',
                            800: '#1C1512',
                            900: '#120E0C', // Signature By Zunash Deep Espresso
                            950: '#0A0807',
                            DEFAULT: '#120E0C',
                        },
                        tan: {
                            50: '#FDF9F5',
                            100: '#F8EFE6',
                            200: '#EED9C5',
                            300: '#DFC0A1',
                            400: '#C99E74',
                            500: '#B07D4E', // Warm Cognac Tan
                            600: '#976239', // Burnished Saddle
                            700: '#7A4B27',
                            800: '#5E361A',
                            DEFAULT: '#976239',
                        },
                        gold: {
                            50: '#FBF9F2',
                            100: '#F5F0DF',
                            200: '#E9DDBC',
                            300: '#DAC694',
                            400: '#C5A16B', // Signature By Zunash Antique Gold
                            500: '#B38D4F',
                            600: '#947137',
                            700: '#735425',
                            DEFAULT: '#C5A16B',
                        },
                        ivory: {
                            50: '#FFFFFF',
                            DEFAULT: '#FAF9F6',
                            100: '#FAF9F6',
                            200: '#F4EFEA',
                            300: '#ECE6DE',
                            400: '#DFD6CB',
                        }
                    },
                    fontFamily: {
                        cinzel: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        serif: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'zunash': '0 10px 30px -5px rgba(18, 14, 12, 0.08), 0 4px 12px -2px rgba(151, 98, 57, 0.06)',
                        'gold-glow': '0 0 25px -4px rgba(197, 161, 107, 0.35)',
                        'card': '0 2px 8px -1px rgba(18, 14, 12, 0.04), 0 8px 20px -3px rgba(151, 98, 57, 0.05)',
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons & Alpine.js -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Quill Rich Text Editor -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body, button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .font-cinzel {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            letter-spacing: -0.015em;
        }
        .font-serif {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        /* Completely hide scrollbars across all browsers while keeping smooth scrollable functionality */
        html, body, aside, nav, div, * {
            -ms-overflow-style: none !important; /* IE and Edge */
            scrollbar-width: none !important; /* Firefox */
        }
        *::-webkit-scrollbar {
            display: none !important;
            width: 0px !important;
            height: 0px !important;
        }

        /* Universal Dead-Center Dialog Styling for All Admin Modals: Compact Luxury Card Shape */
        dialog {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            width: min(480px, calc(100vw - 2rem)) !important;
            max-width: 480px !important;
            max-height: 88vh !important;
            box-sizing: border-box !important;
            overflow-y: auto !important;
            border-radius: 1.5rem !important;
            border: 1px solid #ECE6DE !important;
            background: #ffffff !important;
            color: #120E0C !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(197, 161, 107, 0.25) !important;
            outline: none !important;
            z-index: 9999 !important;
        }

        html.dark dialog {
            background: #1A1513 !important;
            color: #FAF5F0 !important;
            border-color: #2C2420 !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(197, 161, 107, 0.2) !important;
        }

        /* Wider card only for Staff Modal with 12 module checkboxes */
        dialog#addStaffModal,
        dialog#editStaffModal,
        dialog.modal-wide,
        dialog.max-w-2xl {
            width: min(580px, calc(100vw - 2rem)) !important;
            max-width: 580px !important;
        }

        dialog:not([open]) {
            display: none !important;
        }

        dialog[open] {
            display: block !important;
            animation: modalCenterScale 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes modalCenterScale {
            0% {
                opacity: 0;
                transform: translate(-50%, -46%) scale(0.96);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        dialog::backdrop {
            background: rgba(10, 8, 7, 0.75) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            z-index: 9998 !important;
            animation: backdropFade 0.2s ease-out forwards;
        }

        @keyframes backdropFade {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ===== By Zunash Luxury Quill Editor Styling ===== */
        .quill-wrapper {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .quill-wrapper:focus-within {
            border-color: #A87548 !important;
            box-shadow: 0 0 0 1px rgba(168, 117, 72, 0.25) !important;
        }
        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid #ECE6DE !important;
            background-color: #F7F3EE;
            padding: 8px 12px !important;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
            align-items: center;
        }
        .dark .ql-toolbar.ql-snow {
            border-bottom: 1px solid #2C2420 !important;
            background-color: #1A1513;
        }
        .ql-container.ql-snow {
            border: none !important;
            font-family: inherit !important;
            font-size: 0.8125rem !important; /* 13px */
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }
        .ql-editor {
            color: #1A120B;
            min-height: 95px;
            padding: 12px 14px !important;
            line-height: 1.6;
        }
        .dark .ql-editor {
            color: #FAF8F5;
        }
        .ql-editor.ql-blank::before {
            color: #A89C91 !important;
            font-style: italic;
            left: 14px !important;
            right: 14px !important;
        }
        .dark .ql-editor.ql-blank::before {
            color: #6E645E !important;
        }
        /* Toolbar icons color in dark mode */
        .dark .ql-snow .ql-stroke {
            stroke: #C9BDB3 !important;
        }
        .dark .ql-snow .ql-fill {
            fill: #C9BDB3 !important;
        }
        .dark .ql-snow .ql-picker {
            color: #C9BDB3 !important;
        }
        .dark .ql-snow .ql-picker-options {
            background-color: #241D1A !important;
            border-color: #3A2F29 !important;
        }
        /* Active / Hover icons in Tan & Gold */
        .ql-snow.ql-toolbar button:hover,
        .ql-snow .ql-toolbar button:hover,
        .ql-snow.ql-toolbar button:focus,
        .ql-snow .ql-toolbar button:focus,
        .ql-snow.ql-toolbar button.ql-active,
        .ql-snow .ql-toolbar button.ql-active {
            color: #A87548 !important;
        }
        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow .ql-toolbar button:hover .ql-stroke,
        .ql-snow.ql-toolbar button.ql-active .ql-stroke,
        .ql-snow .ql-toolbar button.ql-active .ql-stroke {
            stroke: #A87548 !important;
        }
        .dark .ql-snow.ql-toolbar button:hover .ql-stroke,
        .dark .ql-snow .ql-toolbar button:hover .ql-stroke,
        .dark .ql-snow.ql-toolbar button.ql-active .ql-stroke,
        .dark .ql-snow .ql-toolbar button.ql-active .ql-stroke {
            stroke: #C5A16B !important;
        }
        .ql-snow.ql-toolbar button:hover .ql-fill,
        .ql-snow .ql-toolbar button:hover .ql-fill,
        .ql-snow.ql-toolbar button.ql-active .ql-fill,
        .ql-snow .ql-toolbar button.ql-active .ql-fill {
            fill: #A87548 !important;
        }
        .dark .ql-snow.ql-toolbar button:hover .ql-fill,
        .dark .ql-snow .ql-toolbar button:hover .ql-fill,
        .dark .ql-snow.ql-toolbar button.ql-active .ql-fill,
        .dark .ql-snow .ql-toolbar button.ql-active .ql-fill {
            fill: #C5A16B !important;
        }
        .ql-snow .ql-picker-label {
            padding-left: 6px !important;
            padding-right: 18px !important;
        }
    </style>

    @stack('styles')
</head>
<body 
    x-data="{ 
        sidebarOpen: false,
        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
        categoriesOpen: false,
        subcategoriesOpen: false,
        productsOpen: false,
        dealsOpen: false,
        bulkOrdersOpen: false,
        toggleTheme() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            localStorage.setItem('zunash_admin_theme', this.theme);
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            window.dispatchEvent(new CustomEvent('themechanged', { detail: this.theme }));
        }
    }"
    class="bg-[#FAF9F6] dark:bg-[#0D0A09] text-espresso-900 dark:text-[#F7F4EE] antialiased selection:bg-gold selection:text-espresso-950 min-h-screen flex flex-col transition-colors duration-200 w-full max-w-full overflow-x-hidden"
>

    <div class="min-h-screen flex flex-1 w-full min-w-0 max-w-full overflow-x-hidden">

        <!-- ======================= LEFT SIDEBAR ======================= -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-[#161210] border-r border-[#ECE6DE] dark:border-[#261E1A] transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-xs"
        >
            <!-- Top Logo & Brand Identity -->
            <div class="px-6 py-5 border-b border-[#ECE6DE] dark:border-[#261E1A] flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-espresso-900 via-espresso-800 to-tan-700 text-gold flex items-center justify-center shadow-md border border-gold/40 group-hover:scale-105 transition-transform duration-300">
                        <span class="font-cinzel text-base font-bold tracking-wider text-gold">Z</span>
                    </div>
                    <div>
                        <div class="font-cinzel text-base font-bold tracking-widest text-espresso-900 dark:text-[#E8D0BE] uppercase leading-none">
                            BY ZUNASH
                        </div>
                        <div class="text-[9px] font-bold tracking-widest uppercase text-gold-600 dark:text-gold-light mt-1">
                            ATELIER CONTROL
                        </div>
                    </div>
                </a>

                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">
                
                @if(auth('admin')->user()->hasPermission('dashboard'))
                <!-- Dashboard Overview -->
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 dark:text-gold font-bold border-l-4 border-tan-600 dark:border-gold shadow-2xs' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613] hover:text-tan-700' }}"
                >
                    <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('admin.dashboard*') ? 'text-tan-600 dark:text-gold' : 'text-[#9C8F85]' }}"></i>
                    <span>Dashboard Overview</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('categories'))
                <!-- Categories -->
                <div>
                    <button 
                        @click="categoriesOpen = !categoriesOpen" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613] hover:text-tan-700 transition-colors"
                    >
                        <div class="flex items-center gap-3">
                            <i data-lucide="layers" class="w-4 h-4 text-[#9C8F85]"></i>
                            <span>Categories</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': categoriesOpen }"></i>
                    </button>
                    <div x-show="categoriesOpen || {{ request()->routeIs('admin.categories*') ? 'true' : 'false' }}" x-cloak class="pl-9 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.categories.index') }}" class="block py-1.5 text-xs text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600 transition-colors">
                            • View Categories
                        </a>
                        <a href="{{ route('admin.categories.index') }}#add-category" class="block py-1.5 text-xs text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600 transition-colors">
                            • Add Category
                        </a>
                    </div>
                </div>
                @endif

                @if(auth('admin')->user()->hasPermission('subcategories'))
                <!-- Subcategories -->
                <div>
                    <button 
                        @click="subcategoriesOpen = !subcategoriesOpen" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613] hover:text-tan-700 transition-colors"
                    >
                        <div class="flex items-center gap-3">
                            <i data-lucide="git-branch" class="w-4 h-4 text-[#9C8F85]"></i>
                            <span>Subcategories</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': subcategoriesOpen }"></i>
                    </button>
                    <div x-show="subcategoriesOpen || {{ request()->routeIs('admin.subcategories*') ? 'true' : 'false' }}" x-cloak class="pl-9 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.subcategories.index') }}" class="block py-1.5 text-xs text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600 transition-colors">
                            • View Subcategories
                        </a>
                        <a href="{{ route('admin.subcategories.index') }}#add-subcat" class="block py-1.5 text-xs text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600 transition-colors">
                            • Add Subcategory
                        </a>
                    </div>
                </div>
                @endif

                @if(auth('admin')->user()->hasPermission('products'))
                <!-- Product Catalog -->
                <div>
                    <button 
                        @click="productsOpen = !productsOpen" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.products*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 dark:text-gold font-bold' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i data-lucide="shopping-bag" class="w-4 h-4 {{ request()->routeIs('admin.products*') ? 'text-tan-600 dark:text-gold' : 'text-[#9C8F85]' }}"></i>
                            <span>Product Catalog</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': productsOpen }"></i>
                    </button>
                    <div x-show="productsOpen || {{ request()->routeIs('admin.products*') ? 'true' : 'false' }}" x-cloak class="pl-9 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.products.index') }}" class="block py-1.5 text-xs {{ request()->routeIs('admin.products.index') ? 'text-tan-700 font-bold' : 'text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600' }}">
                            • View Products
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="block py-1.5 text-xs {{ request()->routeIs('admin.products.create') ? 'text-tan-700 font-bold' : 'text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600' }}">
                            • Add Product
                        </a>
                    </div>
                </div>
                @endif

                @if(auth('admin')->user()->hasPermission('deals'))
                <!-- Deals & Bundles Module -->
                <div>
                    <button 
                        @click="dealsOpen = !dealsOpen" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.deals*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 dark:text-gold font-bold' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i data-lucide="tag" class="w-4 h-4 {{ request()->routeIs('admin.deals*') ? 'text-tan-600 dark:text-gold' : 'text-[#9C8F85]' }}"></i>
                            <span>Deals & Bundles</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': dealsOpen }"></i>
                    </button>
                    <div x-show="dealsOpen || {{ request()->routeIs('admin.deals*') ? 'true' : 'false' }}" x-cloak class="pl-9 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.deals.index') }}" class="block py-1.5 text-xs {{ request()->routeIs('admin.deals.index') ? 'text-tan-700 font-bold' : 'text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600' }}">
                            • View All Deals
                        </a>
                        <a href="{{ route('admin.deals.create') }}" class="block py-1.5 text-xs {{ request()->routeIs('admin.deals.create') ? 'text-tan-700 font-bold' : 'text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600' }}">
                            • Create New Deal
                        </a>
                    </div>
                </div>
                @endif

                @if(auth('admin')->user()->hasPermission('inventory'))
                <!-- Inventory & Stock (With Low Badge) -->
                @php
                    $navLowStock = \App\Models\Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count();
                @endphp
                <a 
                    href="{{ route('admin.inventory.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.inventory*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 dark:text-gold font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <div class="flex items-center gap-3">
                        <i data-lucide="boxes" class="w-4 h-4 text-[#9C8F85]"></i>
                        <span>Inventory & Stock</span>
                    </div>
                    @if($navLowStock > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FBF1E6] text-tan-700 border border-[#F3D7BD]">
                            {{ $navLowStock }} Low
                        </span>
                    @endif
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('orders'))
                <!-- Store Orders -->
                <div>
                    <button 
                        @click="bulkOrdersOpen = !bulkOrdersOpen" 
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 dark:text-gold font-bold' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                    >
                        <div class="flex items-center gap-3">
                            <i data-lucide="clipboard-list" class="w-4 h-4 text-[#9C8F85]"></i>
                            <span>Store Orders</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': bulkOrdersOpen }"></i>
                    </button>
                    <div x-show="bulkOrdersOpen || {{ request()->routeIs('admin.orders*') ? 'true' : 'false' }}" x-cloak class="pl-9 pr-2 py-1 space-y-1">
                        <a href="{{ route('admin.orders.index') }}" class="block py-1.5 text-xs {{ request()->routeIs('admin.orders.index') ? 'text-tan-700 font-bold' : 'text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600' }}">
                            • View Orders
                        </a>
                        <a href="{{ route('admin.orders.index') }}?payment=BANK_TRANSFER" class="block py-1.5 text-xs text-[#7F746A] dark:text-[#9E9084] hover:text-tan-600">
                            • Bank Transfers & Invoices
                        </a>
                    </div>
                </div>
                @endif

                @if(auth('admin')->user()->hasPermission('abandoned_carts'))
                <!-- Abandoned Carts & Drop-off Recovery -->
                @php
                    $navPendingAbandoned = \App\Models\AbandonedCart::where('status', 'abandoned')->count();
                @endphp
                <a 
                    href="{{ route('admin.abandoned-carts.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.abandoned-carts*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <div class="flex items-center gap-3">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-[#9C8F85]"></i>
                        <span>Abandoned Carts</span>
                    </div>
                    @if($navPendingAbandoned > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200">
                            {{ $navPendingAbandoned }} Drop-offs
                        </span>
                    @endif
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('coupons'))
                <!-- Coupons & Promo Codes -->
                @php
                    $navActiveCoupons = \App\Models\Coupon::where('is_active', true)->where(function ($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()); })->count();
                @endphp
                <a 
                    href="{{ route('admin.coupons.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.coupons*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <div class="flex items-center gap-3">
                        <i data-lucide="ticket" class="w-4 h-4 text-[#9C8F85]"></i>
                        <span>Coupons & Promos</span>
                    </div>
                    @if($navActiveCoupons > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF4ED] text-tan-700 border border-tan-300">
                            {{ $navActiveCoupons }} Active
                        </span>
                    @endif
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('analytics'))
                <!-- Financial Analytics & Reports -->
                <a 
                    href="{{ route('admin.analytics.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.analytics*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <div class="flex items-center gap-3">
                        <i data-lucide="line-chart" class="w-4 h-4 text-[#9C8F85]"></i>
                        <span>Analytics & Finance</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200">
                        ROI
                    </span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('customers'))
                <!-- Customers & Patrons -->
                <a 
                    href="{{ route('admin.customers.index') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.customers*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <i data-lucide="users" class="w-4 h-4 text-[#9C8F85]"></i>
                    <span>Customers & Patrons</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('messages'))
                <!-- Customer Messages (Concierge) -->
                @php
                    $navUnreadMsgs = \App\Models\Inquiry::where('status', 'unread')->count();
                @endphp
                <a 
                    href="{{ route('admin.messages.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.messages*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <div class="flex items-center gap-3">
                        <i data-lucide="message-square" class="w-4 h-4 text-[#9C8F85]"></i>
                        <span>Customer Messages</span>
                    </div>
                    @if($navUnreadMsgs > 0)
                        <span class="w-5 h-5 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center">
                            {{ $navUnreadMsgs }}
                        </span>
                    @endif
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('reviews'))
                <!-- Customer Reviews -->
                <a 
                    href="{{ route('admin.reviews.index') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.reviews*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <i data-lucide="star" class="w-4 h-4 text-[#9C8F85]"></i>
                    <span>Customer Reviews</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('staff'))
                <!-- Staff & Roles (RBAC) -->
                <a 
                    href="{{ route('admin.staff.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.staff*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield-check" class="w-4 h-4 text-[#9C8F85]"></i>
                        <span>Staff & Roles</span>
                    </div>
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#FAF0E6] text-tan-800 border border-[#EDD5C0]">
                        RBAC
                    </span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('settings'))
                <!-- Store Settings -->
                <a 
                    href="{{ route('admin.settings.index') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-medium transition-colors {{ request()->routeIs('admin.settings*') ? 'bg-[#FAF4ED] dark:bg-[#251A14] text-tan-700 font-bold border-l-4 border-tan-600' : 'text-[#6C635B] dark:text-[#B3A69C] hover:bg-[#FAF9F6] dark:hover:bg-[#1C1613]' }}"
                >
                    <i data-lucide="sliders" class="w-4 h-4 text-[#9C8F85]"></i>
                    <span>Store Settings</span>
                </a>
                @endif

            </nav>

            <!-- Bottom Super Admin Profile & Logout Bar -->
            <div class="p-3.5 border-t border-[#ECE6DE] dark:border-[#261E1A] bg-[#FAF9F6]/60 dark:bg-[#120E0C]">
                <div class="flex items-center justify-between gap-3 p-2 rounded-xl bg-white dark:bg-[#1C1613] border border-[#EAE3DA] dark:border-[#2C221D] shadow-2xs">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-espresso-900 to-tan-700 text-gold font-cinzel font-bold text-xs flex items-center justify-center shrink-0 shadow-xs border border-gold/40">
                            ZA
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-espresso-900 dark:text-[#F3EDE6] truncate leading-tight">
                                {{ auth('admin')->user()->name ?? 'Zunash Super Admin' }}
                            </div>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="px-1 py-0.2 rounded text-[8px] font-black uppercase tracking-wider bg-gold/15 text-gold-700 dark:text-gold border border-gold/30">
                                    {{ auth('admin')->user()->role ?? 'SUPER ADMIN' }}
                                </span>
                            </div>
                            <div class="text-[10px] text-[#8F8379] truncate mt-0.5">
                                {{ auth('admin')->user()->email ?? 'admin@byzunash.com' }}
                            </div>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            title="Sign out of By Zunash Control Center" 
                            class="p-1.5 rounded-lg text-gray-400 hover:text-tan-700 hover:bg-[#FAF4ED] dark:hover:bg-[#251A14] transition-colors"
                        >
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Overlay backdrop for mobile -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-cloak 
            class="fixed inset-0 z-40 bg-black/40 backdrop-blur-xs lg:hidden"
        ></div>

        <!-- ======================= MAIN CONTENT WRAPPER ======================= -->
        <div class="flex-1 lg:pl-64 flex flex-col min-h-screen w-full min-w-0 max-w-full overflow-x-hidden bg-[#FAF9F6] dark:bg-[#0D0A09] transition-colors duration-200">

            <!-- Top Header Bar (Compact Sleek h-14) -->
            <header class="sticky top-0 z-30 h-14 bg-white/95 dark:bg-[#161210]/95 backdrop-blur-md border-b border-[#ECE6DE] dark:border-[#261E1A] px-3 sm:px-6 flex items-center justify-between gap-2 sm:gap-4 w-full min-w-0">
                
                <!-- Left: Hamburger (mobile) + Global Search -->
                <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0 max-w-xl">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-600 dark:text-gray-300 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 shrink-0">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>

                    <!-- Global Search Input with Instant Live Autocomplete Dropdown -->
                    <div 
                        class="relative w-full min-w-0" 
                        x-data="{
                            searchQuery: '{{ request('q') }}',
                            open: false,
                            loading: false,
                            results: { products: [], orders: [], categories: [], customers: [], total: 0 },
                            timer: null,
                            search() {
                                if (this.searchQuery.trim().length < 1) {
                                    this.results = { products: [], orders: [], categories: [], customers: [], total: 0 };
                                    this.open = false;
                                    return;
                                }
                                this.loading = true;
                                clearTimeout(this.timer);
                                this.timer = setTimeout(() => {
                                    fetch('{{ route('admin.search.live') }}?q=' + encodeURIComponent(this.searchQuery))
                                        .then(res => res.json())
                                        .then(data => {
                                            this.results = data;
                                            this.open = true;
                                            this.loading = false;
                                            this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
                                        })
                                        .catch(() => { this.loading = false; });
                                }, 220);
                                }, 150);
                            }
                        }"
                        @click.outside="open = false"
                        @keydown.escape="open = false"
                    >
                        <form action="{{ route('admin.search') }}" method="GET" class="relative w-full">
                            <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            <input 
                                type="text" 
                                name="q" 
                                placeholder="Search creations, orders, patrons..." 
                                x-model="searchQuery"
                                @input="search()"
                                @focus="if (searchQuery.trim().length >= 1) open = true"
                                autocomplete="off"
                                class="w-full pl-9 pr-8 py-1.5 text-xs rounded-full bg-[#FAF9F6] dark:bg-[#201815] border border-[#E8E1D7] dark:border-[#332620] text-espresso-900 dark:text-white placeholder-[#A89C91] focus:outline-hidden focus:border-gold focus:bg-white transition-all shadow-2xs"
                            >
                            <!-- Mini Loading Spinner -->
                            <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" x-cloak>
                                <svg class="animate-spin h-3.5 w-3.5 text-tan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                            </div>
                        </form>

                        <!-- Live Dropdown Results Popup -->
                        <div 
                            x-show="open && searchQuery.trim().length >= 1" 
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute left-0 right-0 top-full mt-2 bg-white dark:bg-[#1A1412] rounded-2xl shadow-2xl border border-[#ECE6DE] dark:border-[#2D231E] overflow-hidden z-50 max-h-[75vh] overflow-y-auto scrollbar-thin text-espresso-900 dark:text-white divide-y divide-gray-100 dark:divide-white/5"
                        >
                            <!-- If no results -->
                            <div x-show="!loading && results.total === 0" class="p-6 text-center text-xs text-muted">
                                <i data-lucide="search-x" class="w-6 h-6 mx-auto mb-1.5 text-tan-600"></i>
                                <p>No creations, orders, or patrons matching "<span class="font-bold text-espresso-900 dark:text-white" x-text="searchQuery"></span>"</p>
                            </div>

                            <!-- Products / Creations -->
                            <div x-show="results.products && results.products.length > 0" class="p-2.5">
                                <div class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-tan-700 dark:text-gold flex items-center justify-between">
                                    <span>Creations</span>
                                    <span class="text-muted" x-text="results.products.length + ' found'"></span>
                                </div>
                                <div class="space-y-1 mt-1">
                                    <template x-for="item in results.products" :key="'p-' + item.id">
                                        <a 
                                            :href="item.url" 
                                            class="flex items-center justify-between gap-3 p-2 rounded-xl hover:bg-tan-50 dark:hover:bg-[#251C18] transition-colors group"
                                        >
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-black/30 overflow-hidden shrink-0 border border-gray-200 dark:border-white/10">
                                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                                </div>
                                                <div class="min-w-0">
                                                    <h4 class="text-xs font-semibold text-espresso-950 dark:text-white truncate group-hover:text-tan-700 transition-colors" x-text="item.name"></h4>
                                                    <div class="flex items-center gap-1.5 text-[10px] text-muted">
                                                        <span x-text="'SKU: ' + item.sku"></span>
                                                        <span>•</span>
                                                        <span x-text="item.category"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold font-mono text-tan-700 dark:text-gold shrink-0" x-text="item.price"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- Orders -->
                            <div x-show="results.orders && results.orders.length > 0" class="p-2.5">
                                <div class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-tan-700 dark:text-gold flex items-center justify-between">
                                    <span>Orders</span>
                                    <span class="text-muted" x-text="results.orders.length + ' found'"></span>
                                </div>
                                <div class="space-y-1 mt-1">
                                    <template x-for="ord in results.orders" :key="'o-' + ord.id">
                                        <a 
                                            :href="ord.url" 
                                            class="flex items-center justify-between gap-2 p-2 rounded-xl hover:bg-tan-50 dark:hover:bg-[#251C18] transition-colors"
                                        >
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-mono font-bold text-xs text-espresso-950 dark:text-white" x-text="ord.order_number"></span>
                                                    <span class="text-[9px] px-1.5 py-0.2 rounded bg-tan-100 text-tan-800 font-bold" x-text="ord.status"></span>
                                                </div>
                                                <p class="text-[11px] text-muted truncate mt-0.5" x-text="ord.customer + ' (' + ord.city + ')'"></p>
                                            </div>
                                            <span class="text-xs font-bold font-mono text-espresso-900 dark:text-white" x-text="ord.total"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- Subcategories -->
                            <div x-show="results.subcategories && results.subcategories.length > 0" class="p-2.5">
                                <div class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-tan-700 dark:text-gold flex items-center justify-between">
                                    <span>Subcategories</span>
                                    <span class="text-muted" x-text="results.subcategories.length + ' found'"></span>
                                </div>
                                <div class="space-y-1 mt-1">
                                    <template x-for="sub in results.subcategories" :key="'sub-' + sub.id">
                                        <a 
                                            :href="sub.url" 
                                            class="flex items-center justify-between gap-2 p-2 rounded-xl hover:bg-tan-50 dark:hover:bg-[#251C18] transition-colors"
                                        >
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="git-branch" class="w-3.5 h-3.5 text-tan-600"></i>
                                                <span class="text-xs font-semibold text-espresso-950 dark:text-white" x-text="sub.name"></span>
                                            </div>
                                            <span class="text-[10px] text-muted font-medium" x-text="sub.category"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- View All Footer Link -->
                            <div class="p-2 bg-gray-50 dark:bg-[#150F0D] text-center">
                                <a 
                                    :href="'{{ route('admin.search') }}?q=' + encodeURIComponent(searchQuery)"
                                    class="text-xs font-bold text-tan-700 dark:text-gold hover:underline inline-flex items-center gap-1.5"
                                >
                                    <span>View full results in Omnisearch</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                    
                    <!-- + Add Creation Button (Rich Cognac Leather & Gold) -->
                    <a 
                        href="{{ route('admin.products.create') }}" 
                        class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-tan-700 to-tan-600 hover:from-tan-800 hover:to-tan-700 text-white shadow-xs transition-transform active:scale-95 border border-tan-600"
                        title="Add New Creation"
                    >
                        <i data-lucide="plus" class="w-3.5 h-3.5 text-gold-light"></i>
                        <span class="hidden sm:inline">Add Creation</span>
                    </a>

                    <!-- View Live Store Link Button (Desktop/Tablet) -->
                    <a 
                        href="{{ route('home') }}" 
                        target="_blank" 
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium text-espresso-800 dark:text-[#E8D0BE] border border-[#E0D7CB] dark:border-[#3A2F29] hover:bg-[#FAF9F6] dark:hover:bg-[#201815] transition-colors"
                        title="Open customer storefront in new tab"
                    >
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-gold-600"></i>
                        <span>Live Store</span>
                    </a>

                    <!-- Dark / Light Theme Toggle -->
                    <button 
                        @click="toggleTheme()" 
                        class="w-8 h-8 rounded-full border border-[#E0D7CB] dark:border-[#3A2F29] flex items-center justify-center text-gray-500 hover:text-gold-600 transition-colors"
                        title="Toggle Dark/Light Mode"
                    >
                        <template x-if="theme === 'light'">
                            <i data-lucide="moon" class="w-3.5 h-3.5"></i>
                        </template>
                        <template x-if="theme === 'dark'">
                            <i data-lucide="sun" class="w-3.5 h-3.5 text-amber-400"></i>
                        </template>
                    </button>

                    <!-- Currency Identifier Pill (PKR / Rs.) -->
                    <div class="hidden sm:flex items-center text-[10px] font-bold rounded-full border border-gold/40 px-2.5 py-1 text-espresso-900 dark:text-gold bg-gold/10">
                        <span class="text-gold-700 dark:text-gold font-extrabold">PKR</span>
                        <span class="text-gray-300 mx-1">|</span>
                        <span>Rs.</span>
                    </div>

                    <!-- User Initials Circle -->
                    <div class="w-8 h-8 rounded-full bg-espresso-900 text-gold font-cinzel font-bold text-[11px] flex items-center justify-center border border-gold/50 shadow-xs">
                        ZA
                    </div>

                </div>

            </header>

            <!-- Main Page View Content (Compact Padding & Tighter Gaps) -->
            <main class="flex-1 p-3 sm:p-5 space-y-3.5 w-full min-w-0 max-w-full overflow-x-hidden bg-[#FAF9F6] dark:bg-[#0D0A09] transition-colors duration-200">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- Global Toast & Notification Trigger via Blade Sessions -->
    @if(session('toast_success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('toast_success')),
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    background: '#FFFFFF',
                    iconColor: '#976239',
                    customClass: { popup: 'rounded-2xl border border-[#ECE6DE] shadow-xl text-xs' }
                });
            });
        </script>
    @endif

    @if(session('toast_error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('toast_error')),
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: '#FFFFFF',
                    customClass: { popup: 'rounded-2xl border border-rose-200 shadow-xl text-xs' }
                });
            });
        </script>
    @endif

    <script>
        function initRichEditors() {
            if (typeof Quill === 'undefined') return;

            document.querySelectorAll('[data-rich-editor]:not(.ql-initialized)').forEach((editorEl) => {
                editorEl.classList.add('ql-initialized');
                const type = editorEl.getAttribute('data-rich-editor') || 'full';
                const targetSelector = editorEl.getAttribute('data-target');
                const placeholder = editorEl.getAttribute('data-placeholder') || 'Write your content here...';
                const targetTextarea = targetSelector ? document.querySelector(targetSelector) : null;

                const compactToolbar = [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'clean']
                ];

                const highlightsToolbar = [
                    [{ 'list': 'bullet' }, { 'list': 'ordered' }],
                    ['bold', 'italic', 'underline'],
                    ['clean']
                ];

                const fullToolbar = [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'link'],
                    ['clean']
                ];

                let toolbarConfig = fullToolbar;
                if (type === 'compact') {
                    toolbarConfig = compactToolbar;
                } else if (type === 'highlights') {
                    toolbarConfig = highlightsToolbar;
                }

                const quill = new Quill(editorEl, {
                    theme: 'snow',
                    placeholder: placeholder,
                    modules: {
                        toolbar: toolbarConfig
                    }
                });

                if (targetTextarea) {
                    quill.on('text-change', () => {
                        const html = quill.root.innerHTML;
                        targetTextarea.value = (html === '<p><br></p>' || quill.getText().trim() === '') ? '' : html;
                    });

                    const form = targetTextarea.closest('form');
                    if (form) {
                        form.addEventListener('submit', () => {
                            const html = quill.root.innerHTML;
                            targetTextarea.value = (html === '<p><br></p>' || quill.getText().trim() === '') ? '' : html;
                        });
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            initRichEditors();

            // Backdrop click closes dialog
            document.addEventListener('click', function(e) {
                if (e.target.tagName === 'DIALOG' && e.target.open) {
                    const rect = e.target.getBoundingClientRect();
                    const isInDialog = (
                        rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
                        rect.left <= e.clientX && e.clientX <= rect.left + rect.width
                    );
                    if (!isInDialog) {
                        e.target.close();
                    }
                }
            });
        });
    </script>

    @stack('scripts')

</body>
</html>
