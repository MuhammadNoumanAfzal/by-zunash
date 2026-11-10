@extends('admin.layouts.app')

@section('title', (!empty($query) ? 'Search: "' . $query . '"' : 'Unified Search') . ' | By Zunash Control')

@section('content')

<div class="space-y-4 max-w-7xl mx-auto" x-data="{ activeTab: 'all' }">

    <!-- Search Header & Stats -->
    <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-tan-600"></span>
                <span class="text-xs uppercase tracking-wider font-bold text-tan-600 dark:text-gold-400">Executive Omnisearch</span>
            </div>
            <h1 class="font-cinzel text-lg sm:text-xl font-bold text-espresso-950 dark:text-white mt-1">
                @if(!empty($query))
                    Results for <span class="text-tan-700 dark:text-gold italic">"{{ $query }}"</span>
                @else
                    Search Atelier Catalog, Orders & Patrons
                @endif
            </h1>
            <p class="text-xs text-muted mt-0.5">
                Found <strong class="text-espresso-900 dark:text-white">{{ $totalMatches }}</strong> matching records across creations, client orders, categories, and patron dossiers.
            </p>
        </div>

        <!-- In-page Search Bar -->
        <form action="{{ route('admin.search') }}" method="GET" class="relative max-w-md w-full">
            <i data-lucide="search" class="w-4 h-4 text-muted absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input 
                type="text" 
                name="q" 
                value="{{ $query }}" 
                placeholder="Search by name, SKU, order #, phone, email, city..."
                class="w-full pl-9 pr-20 py-2 text-xs rounded-xl bg-[#FAF9F6] dark:bg-[#201815] border border-[#E8E1D7] dark:border-[#332620] text-espresso-900 dark:text-white placeholder-[#A89C91] focus:outline-hidden focus:border-gold focus:bg-white"
                autofocus
            >
            <button 
                type="submit" 
                class="absolute right-1.5 top-1/2 -translate-y-1/2 px-3 py-1 rounded-lg bg-espresso-900 hover:bg-tan-600 text-white text-[11px] font-semibold transition-colors shadow-2xs"
            >
                Search
            </button>
        </form>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto scrollbar-none pb-1">
        <button 
            type="button" 
            @click="activeTab = 'all'"
            :class="activeTab === 'all' ? 'bg-espresso-900 text-white shadow-2xs' : 'bg-white dark:bg-[#1E1714] text-muted hover:text-espresso-900 border border-[#ECE6DE] dark:border-[#261E1A]'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5"
        >
            <i data-lucide="layers" class="w-3.5 h-3.5"></i>
            <span>All Records ({{ $totalMatches }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'products'"
            :class="activeTab === 'products' ? 'bg-espresso-900 text-white shadow-2xs' : 'bg-white dark:bg-[#1E1714] text-muted hover:text-espresso-900 border border-[#ECE6DE] dark:border-[#261E1A]'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5"
        >
            <i data-lucide="gem" class="w-3.5 h-3.5"></i>
            <span>Creations ({{ $products->count() }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'orders'"
            :class="activeTab === 'orders' ? 'bg-espresso-900 text-white shadow-2xs' : 'bg-white dark:bg-[#1E1714] text-muted hover:text-espresso-900 border border-[#ECE6DE] dark:border-[#261E1A]'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5"
        >
            <i data-lucide="package" class="w-3.5 h-3.5"></i>
            <span>Orders ({{ $orders->count() }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'categories'"
            :class="activeTab === 'categories' ? 'bg-espresso-900 text-white shadow-2xs' : 'bg-white dark:bg-[#1E1714] text-muted hover:text-espresso-900 border border-[#ECE6DE] dark:border-[#261E1A]'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5"
        >
            <i data-lucide="folder" class="w-3.5 h-3.5"></i>
            <span>Categories ({{ $categories->count() }})</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'customers'"
            :class="activeTab === 'customers' ? 'bg-espresso-900 text-white shadow-2xs' : 'bg-white dark:bg-[#1E1714] text-muted hover:text-espresso-900 border border-[#ECE6DE] dark:border-[#261E1A]'"
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5"
        >
            <i data-lucide="users" class="w-3.5 h-3.5"></i>
            <span>Patrons ({{ $customers->count() }})</span>
        </button>
    </div>

    <!-- Empty State -->
    @if($totalMatches === 0)
        <div class="py-16 text-center bg-white dark:bg-[#161210] rounded-2xl border border-[#ECE6DE] dark:border-[#261E1A] p-8">
            <div class="w-14 h-14 rounded-full bg-tan-50 dark:bg-[#201815] text-tan-700 dark:text-gold mx-auto flex items-center justify-center mb-3 border border-tan-200 dark:border-[#38261E]">
                <i data-lucide="search-x" class="w-7 h-7"></i>
            </div>
            <h3 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white mb-1">No Matching Records Found</h3>
            <p class="text-xs text-muted max-w-md mx-auto mb-5 leading-relaxed">
                @if(!empty($query))
                    No creations, client orders, or categories matched "{{ $query }}". Check your spelling or try searching with a broader keyword.
                @else
                    Type a keyword, SKU, order reference, or phone number above to search across the entire atelier suite.
                @endif
            </p>
            <div class="flex flex-wrap items-center justify-center gap-2">
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white text-xs font-semibold transition-colors shadow-2xs inline-flex items-center gap-1.5">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Add New Creation</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-white dark:bg-[#1E1714] text-espresso-900 dark:text-white border border-[#ECE6DE] dark:border-[#261E1A] hover:bg-gray-50 text-xs font-semibold transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>
    @else

        <!-- Section 1: Creations / Products -->
        <div x-show="activeTab === 'all' || activeTab === 'products'" class="space-y-2">
            @if($products->isNotEmpty())
                <div class="flex items-center justify-between pt-2">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="gem" class="w-4 h-4 text-tan-600"></i>
                        <span>Matching Atelier Creations ({{ $products->count() }})</span>
                    </h2>
                    <a href="{{ route('admin.products.index', ['q' => $query]) }}" class="text-[11px] text-tan-700 dark:text-gold hover:underline font-medium">
                        View in Catalog &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($products as $prod)
                        <div class="p-3.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] flex items-center justify-between gap-3 shadow-2xs hover:border-gold/50 transition-colors group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-[#201815] overflow-hidden shrink-0 border border-gray-200 dark:border-[#261E1A]">
                                    <img src="{{ $prod->image ?: asset('images/products/prod-reversible-belt.jpg') }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-serif font-bold text-xs text-espresso-950 dark:text-white truncate group-hover:text-tan-700 transition-colors">
                                        {{ $prod->name }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-[10px] text-muted mt-0.5">
                                        <span>SKU: <strong class="font-mono text-espresso-900 dark:text-white">{{ $prod->sku }}</strong></span>
                                        <span>•</span>
                                        <span>{{ $prod->category_name }}</span>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-tan-700 dark:text-gold block mt-0.5">
                                        Rs. {{ number_format($prod->price) }}
                                    </span>
                                </div>
                            </div>
                            <div class="shrink-0 flex items-center gap-1.5">
                                <a href="{{ route('admin.products.edit', $prod->id) }}" class="p-2 rounded-lg bg-gray-50 dark:bg-[#201815] hover:bg-tan-50 text-espresso-900 dark:text-white hover:text-tan-700 border border-[#ECE6DE] dark:border-[#261E1A] transition-colors" title="Edit Creation">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Section 2: Orders -->
        <div x-show="activeTab === 'all' || activeTab === 'orders'" class="space-y-2 pt-2">
            @if($orders->isNotEmpty())
                <div class="flex items-center justify-between">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="package" class="w-4 h-4 text-tan-600"></i>
                        <span>Matching Store Orders ({{ $orders->count() }})</span>
                    </h2>
                    <a href="{{ route('admin.orders.index', ['q' => $query]) }}" class="text-[11px] text-tan-700 dark:text-gold hover:underline font-medium">
                        View in Orders &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($orders as $ord)
                        <div class="p-3.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] flex items-center justify-between gap-3 shadow-2xs hover:border-gold/50 transition-colors">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-xs text-tan-700 dark:text-gold">{{ $ord->order_number }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-tan-50 dark:bg-[#201815] text-tan-800 dark:text-gold border border-tan-200 dark:border-[#38261E]">
                                        {{ $ord->order_status }}
                                    </span>
                                </div>
                                <h4 class="font-semibold text-xs text-espresso-950 dark:text-white mt-1">{{ $ord->customer_name }}</h4>
                                <div class="flex items-center gap-2 text-[10px] text-muted mt-0.5">
                                    <span>{{ $ord->city }}</span>
                                    <span>•</span>
                                    <span class="font-mono">{{ $ord->customer_phone }}</span>
                                </div>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="font-mono font-bold text-xs text-espresso-950 dark:text-white block">
                                    Rs. {{ number_format($ord->total) }}
                                </span>
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="inline-flex items-center gap-1 text-[11px] font-semibold text-tan-700 dark:text-gold hover:underline mt-1">
                                    <span>Inspect</span>
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Section 3: Categories -->
        <div x-show="activeTab === 'all' || activeTab === 'categories'" class="space-y-2 pt-2">
            @if($categories->isNotEmpty())
                <div class="flex items-center justify-between">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="folder" class="w-4 h-4 text-tan-600"></i>
                        <span>Matching Collections ({{ $categories->count() }})</span>
                    </h2>
                    <a href="{{ route('admin.categories.index', ['q' => $query]) }}" class="text-[11px] text-tan-700 dark:text-gold hover:underline font-medium">
                        View in Collections &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($categories as $cat)
                        <div class="p-3 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] flex items-center justify-between gap-2 shadow-2xs">
                            <div>
                                <h3 class="font-bold text-xs text-espresso-950 dark:text-white">{{ $cat->name }}</h3>
                                <span class="font-mono text-[10px] text-muted">{{ $cat->slug }}</span>
                            </div>
                            <a href="{{ route('admin.categories.index', ['q' => $cat->name]) }}" class="p-1.5 rounded-lg text-muted hover:text-tan-700 text-xs font-semibold" title="Manage Category">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Section 4: Patrons / Customers -->
        <div x-show="activeTab === 'all' || activeTab === 'customers'" class="space-y-2 pt-2">
            @if($customers->isNotEmpty())
                <div class="flex items-center justify-between">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-tan-600"></i>
                        <span>Matching Patrons ({{ $customers->count() }})</span>
                    </h2>
                    <a href="{{ route('admin.customers.index', ['q' => $query]) }}" class="text-[11px] text-tan-700 dark:text-gold hover:underline font-medium">
                        View in Patrons &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($customers as $cust)
                        <div class="p-3 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] flex items-center justify-between gap-2 shadow-2xs">
                            <div class="min-w-0">
                                <h3 class="font-bold text-xs text-espresso-950 dark:text-white truncate">{{ $cust->name }}</h3>
                                <p class="text-[10px] text-muted truncate">{{ $cust->email }}</p>
                                @if($cust->phone)
                                    <span class="font-mono text-[10px] text-tan-700 dark:text-gold">{{ $cust->phone }}</span>
                                @endif
                            </div>
                            <a href="{{ route('admin.customers.index', ['q' => $cust->email ?: $cust->name]) }}" class="p-1.5 rounded-lg text-muted hover:text-tan-700 text-xs font-semibold shrink-0" title="View Patron Profile">
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @endif

</div>

@endsection
