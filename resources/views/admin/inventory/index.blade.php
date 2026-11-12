@extends('admin.layouts.app')

@section('title', 'Artisan Inventory & Stock Health | By Zunash Atelier')

@section('content')

<div class="space-y-6" x-data="{ currentTab: 'catalogue', bespokeProduct: null, bespokeModalOpen: false }">

    <!-- Header & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Artisan Inventory & Stock Management
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Real-time stock tracking, availability modes (In Stock, On Demand, Out of Stock), lead times & audit trail.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <!-- Tabs Toggle -->
            <div class="inline-flex p-1 rounded-2xl bg-espresso-950/5 dark:bg-black/30 border border-[#ECE6DE] dark:border-[#2C2420]">
                <button 
                    type="button" 
                    @click="currentTab = 'catalogue'" 
                    :class="currentTab === 'catalogue' ? 'bg-white dark:bg-[#201815] text-espresso-950 dark:text-gold-400 font-bold shadow-2xs' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5"
                >
                    <i data-lucide="package" class="w-3.5 h-3.5"></i>
                    <span>Stock Catalogue</span>
                </button>
                <button 
                    type="button" 
                    @click="currentTab = 'audit'" 
                    :class="currentTab === 'audit' ? 'bg-white dark:bg-[#201815] text-espresso-950 dark:text-gold-400 font-bold shadow-2xs' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                    class="px-3.5 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 relative"
                >
                    <i data-lucide="history" class="w-3.5 h-3.5"></i>
                    <span>Audit Trail Log</span>
                    <span class="w-2 h-2 rounded-full bg-tan-500"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- 5 KPI Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <a href="{{ route('admin.inventory.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-tan-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">TOTAL READY UNITS</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">{{ number_format($totalInventory) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Across {{ $totalSkus }} Articles</div>
        </a>

        <a href="{{ route('admin.inventory.index', ['status' => 'adequate']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-emerald-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">IN STOCK BUFFER</div>
            <div class="font-cinzel text-2xl font-bold text-emerald-600 mt-1">{{ $totalSkus - $lowStockCount - $outOfStockCount }}</div>
            <div class="text-[10px] text-emerald-700/80 mt-1">Immediate dispatch</div>
        </a>

        <a href="{{ route('admin.inventory.index', ['status' => 'on_demand']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-amber-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">ON DEMAND EDITIONS</div>
            <div class="font-cinzel text-2xl font-bold text-amber-600 mt-1">{{ $onDemandCount ?? 0 }}</div>
            <div class="text-[10px] text-amber-700/80 mt-1">Bespoke lead times</div>
        </a>

        <a href="{{ route('admin.inventory.index', ['status' => 'low']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-amber-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">LOW STOCK (≤5)</div>
            <div class="font-cinzel text-2xl font-bold text-amber-600 mt-1">{{ $lowStockCount }}</div>
            <div class="text-[10px] text-amber-700/80 mt-1">Action advised</div>
        </a>

        <a href="{{ route('admin.inventory.index', ['status' => 'out']) }}" class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-rose-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">SOLD OUT / ARCHIVAL</div>
            <div class="font-cinzel text-2xl font-bold text-rose-600 mt-1">{{ $outOfStockCount }}</div>
            <div class="text-[10px] text-rose-700/80 mt-1">Concierge alerts</div>
        </a>
    </div>

    <!-- Workshop Low-Stock Run-out Predictions Banner -->
    @if(isset($predictions) && $predictions->count() > 0)
        <div class="p-4 rounded-2xl bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-500/30">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="trending-down" class="w-4 h-4 text-amber-600 dark:text-amber-400"></i>
                    <h3 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white">
                        Workshop Replenishment & Stock Run-out Predictions
                    </h3>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-800 dark:text-amber-300">
                    Velocity Forecast
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($predictions as $pred)
                    <div class="p-3 rounded-xl bg-white/80 dark:bg-[#1E1714] border border-amber-200/60 dark:border-amber-800/40 flex items-center justify-between gap-3 shadow-2xs">
                        <div class="min-w-0">
                            <div class="font-bold text-xs text-espresso-950 dark:text-white truncate">
                                {{ $pred['name'] }}
                            </div>
                            <div class="text-[10px] text-gray-400 font-mono">
                                SKU: {{ $pred['sku'] }} • <span class="font-bold {{ $pred['stock'] <= 2 ? 'text-rose-600' : 'text-amber-600' }}">{{ $pred['stock'] }} left</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block px-2 py-0.5 rounded-md text-[9px] font-bold {{ $pred['urgency'] === 'CRITICAL' ? 'bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-300' : 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300' }}">
                                Run-out ~{{ $pred['runout_days'] }} {{ Str::plural('day', $pred['runout_days']) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- TAB 1: Stock Catalogue -->
    <div x-show="currentTab === 'catalogue'" class="space-y-6">
        <!-- Filter & Search Bar -->
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <form action="{{ route('admin.inventory.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-1 w-full">
                    <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}"
                        placeholder="Search inventory by product name, SKU, or collection..." 
                        class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <div class="w-full sm:w-48">
                    <select 
                        name="category" 
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
                    >
                        <option value="all">All Collections</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full sm:w-48">
                    <select 
                        name="status" 
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer"
                    >
                        <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="adequate" {{ request('status') === 'adequate' ? 'selected' : '' }}>In Stock (>5 units)</option>
                        <option value="on_demand" {{ request('status') === 'on_demand' ? 'selected' : '' }}>On Demand / Bespoke</option>
                        <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Low Stock (≤5 units)</option>
                        <option value="out" {{ request('status') === 'out' ? 'selected' : '' }}>Depleted (0 units)</option>
                    </select>
                </div>

                <div class="flex items-center gap-1.5 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-initial px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shrink-0 transition-colors border border-gold-400/20 text-center">
                        Filter
                    </button>
                    <a href="{{ route('admin.inventory.index') }}" class="w-9 h-9 shrink-0 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-500 hover:bg-gray-100 dark:hover:bg-[#201A18] flex items-center justify-center transition-colors" title="Reset All Filters">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Inventory Table with Fast Stock & Availability Replenishment -->
        <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
            
            <!-- Mobile Inventory Cards (< 640px) -->
            <div class="block sm:hidden divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                @forelse($products as $product)
                    <div class="p-4 hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors space-y-3">
                        <div class="flex items-start gap-3">
                            <img 
                                src="{{ $product->image ?: '/images/products/prod-reversible-belt.jpg' }}" 
                                alt="{{ $product->name }}"
                                class="w-12 h-12 rounded-xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] shrink-0"
                            >
                            <div class="min-w-0 flex-1">
                                <h3 class="font-bold text-xs text-espresso-950 dark:text-white truncate">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-center gap-2 mt-0.5 text-[10px] text-gray-400 font-mono">
                                    <span>{{ $product->sku }}</span>
                                    <span>•</span>
                                    <span>{{ $product->category_name ?: ucfirst($product->category_slug) }}</span>
                                </div>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="font-bold text-xs {{ $product->stock_quantity <= 5 ? ($product->stock_quantity == 0 ? 'text-rose-600' : 'text-amber-600') : 'text-emerald-700 dark:text-emerald-400' }}">
                                        {{ $product->stock_quantity }} in stock
                                    </span>
                                    <span class="text-gray-300">•</span>
                                    <span class="text-[10px] text-gray-400 font-mono">PKR {{ number_format($product->price) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Fast Quick-Replenish Form for Mobile -->
                        <form action="{{ route('admin.inventory.update', $product) }}" method="POST" class="p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E8E1D7] dark:border-[#332620] flex items-center gap-2">
                            @csrf
                            <div class="flex items-center gap-1 min-w-0 flex-1">
                                <input 
                                    type="number" 
                                    name="stock_quantity" 
                                    value="{{ $product->stock_quantity }}" 
                                    min="0"
                                    title="Units"
                                    class="w-16 px-2 py-1.5 text-xs rounded-lg border border-[#DFD6CB] dark:border-[#382D27] bg-white dark:bg-[#2A201C] text-center font-mono font-bold text-espresso-900 dark:text-white"
                                >
                                <select 
                                    name="availability" 
                                    class="flex-1 min-w-0 px-2 py-1.5 text-xs rounded-lg border border-[#DFD6CB] dark:border-[#382D27] bg-white dark:bg-[#2A201C] text-espresso-900 dark:text-white"
                                >
                                    <option value="in_stock" {{ $product->availability === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="on_demand" {{ $product->availability === 'on_demand' ? 'selected' : '' }}>On Demand</option>
                                    <option value="out_of_stock" {{ $product->availability === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>

                            <button 
                                type="submit" 
                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-espresso-900 hover:bg-tan-600 text-white shrink-0 shadow-xs transition-colors"
                            >
                                Save
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-gray-400">
                        No inventory records match current filter.
                    </div>
                @endforelse
            </div>

            <!-- Desktop / Tablet Table (>= 640px) -->
            <div class="hidden sm:block overflow-x-auto w-full max-w-full">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                            <th class="py-3 px-4">PRODUCT / VARIATIONS</th>
                            <th class="py-3 px-3">COLLECTION</th>
                            <th class="py-3 px-3">CURRENT STOCK</th>
                            <th class="py-3 px-3">STOREFRONT STATUS</th>
                            <th class="py-3 px-4 text-right">QUICK REPLENISH & BESPOKE MODE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                        @forelse($products as $product)
                            <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                                
                                <!-- Product Info & Leather Swatches -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <img 
                                            src="{{ $product->image ?: '/images/products/prod-reversible-belt.jpg' }}" 
                                            alt="{{ $product->name }}"
                                            class="w-11 h-11 rounded-xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] shrink-0"
                                        >
                                        <div>
                                            <div class="font-bold text-espresso-950 dark:text-white">
                                                {{ $product->name }}
                                            </div>
                                            <div class="font-mono text-[10px] text-[#8F8379]">
                                                SKU: {{ $product->sku }}
                                            </div>

                                            @if(is_array($product->colors) && count($product->colors) > 0)
                                                <div class="flex items-center gap-1 mt-1">
                                                    @foreach(array_slice($product->colors, 0, 4) as $col)
                                                        <span 
                                                            class="w-2.5 h-2.5 rounded-full border border-black/20" 
                                                            style="background-color: {{ $col['hex'] ?? '#8B4513' }};"
                                                            title="{{ $col['name'] ?? '' }}"
                                                        ></span>
                                                    @endforeach
                                                    @if(count($product->colors) > 4)
                                                        <span class="text-[8px] text-[#8F8379] font-mono">+{{ count($product->colors) - 4 }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="py-3.5 px-3">
                                    <span class="text-xs text-gray-600 dark:text-gray-300">
                                        {{ $product->category_name ?: ucfirst($product->category_slug) }}
                                    </span>
                                </td>

                                <!-- Current Stock -->
                                <td class="py-3.5 px-3">
                                    <div class="font-mono font-bold text-sm {{ $product->stock_quantity <= 5 ? ($product->stock_quantity == 0 ? 'text-rose-600' : 'text-amber-600') : 'text-emerald-700 dark:text-emerald-400' }}">
                                        {{ $product->stock_quantity }} units
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-mono">
                                        PKR {{ number_format($product->price) }}
                                    </div>
                                </td>

                                <!-- Storefront Status / Availability Mode -->
                                <td class="py-3.5 px-3">
                                    @if($product->availability === 'on_demand')
                                        <div class="space-y-0.5">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30 inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Made-to-Order
                                            </span>
                                            <div class="text-[9px] text-[#8F8379] font-mono">
                                                {{ $product->lead_time ?: '7–10 Working Days' }}
                                            </div>
                                        </div>
                                    @elseif($product->stock_quantity <= 0 || $product->availability === 'out_of_stock')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                            Sold Out / Waitlist
                                        </span>
                                    @elseif($product->stock_quantity <= 5)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 flex items-center gap-1 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Low: {{ $product->stock_quantity }} left
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                            In Stock Ready
                                        </span>
                                    @endif
                                </td>

                                <!-- Fast Stock & Mode Update Form + Bespoke Switcher -->
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.inventory.update', $product) }}" method="POST" class="inline-flex flex-wrap items-center gap-1.5 justify-end">
                                            @csrf
                                            
                                            <!-- Stock units input -->
                                            <input 
                                                type="number" 
                                                name="stock_quantity" 
                                                value="{{ $product->stock_quantity }}" 
                                                min="0"
                                                title="Units count"
                                                class="w-14 px-1.5 py-1 text-xs rounded-lg border border-[#DFD6CB] dark:border-[#382D27] bg-[#FAF8F5] dark:bg-[#241D1A] text-center font-mono font-bold text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                                            >

                                            <!-- Availability Mode dropdown -->
                                            <select 
                                                name="availability" 
                                                class="px-2 py-1 text-[11px] rounded-lg border border-[#DFD6CB] dark:border-[#382D27] bg-[#FAF8F5] dark:bg-[#241D1A] text-espresso-900 dark:text-white focus:outline-hidden"
                                            >
                                                <option value="in_stock" {{ $product->availability === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                                <option value="on_demand" {{ $product->availability === 'on_demand' ? 'selected' : '' }}>On Demand</option>
                                                <option value="out_of_stock" {{ $product->availability === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                            </select>

                                            <button 
                                                type="submit" 
                                                class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-espresso-900 hover:bg-tan-600 text-white shadow-2xs transition-colors shrink-0"
                                                title="Save Stock & Availability"
                                            >
                                                Save
                                            </button>
                                        </form>

                                        <!-- 1-Click Switch to Bespoke / Made-to-Order Modal Trigger -->
                                        <button 
                                            type="button"
                                            @click="bespokeProduct = {{ json_encode(['id' => $product->id, 'name' => $product->name, 'sku' => $product->sku, 'lead_time' => $product->lead_time ?: '7–10 Working Days']) }}; document.getElementById('bespokeModal').showModal();"
                                            class="p-1.5 text-tan-600 dark:text-gold-400 hover:bg-tan-50 dark:hover:bg-[#2A201C] rounded-lg transition-colors border border-tan-300/40"
                                            title="Set Bespoke / Made-to-Order Lead Time"
                                        >
                                            <i data-lucide="clock" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">
                                    No inventory records match current filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- TAB 2: Stock History & Audit Trail Log -->
    <div x-show="currentTab === 'audit'" class="space-y-4" style="display: none;">
        <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
            <div class="p-5 border-b border-[#ECE6DE] dark:border-[#2C2420] flex items-center justify-between">
                <div>
                    <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">
                        Inventory Audit Trail Log
                    </h2>
                    <p class="text-xs text-[#8F8379] mt-0.5">
                        Immutable record of stock level modifications, customer purchases, workshop replenishments, and bespoke status changes.
                    </p>
                </div>
                <span class="text-xs font-mono text-[#8F8379]">Latest {{ $auditLogs->count() }} events</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                            <th class="py-3 px-4">TIMESTAMP</th>
                            <th class="py-3 px-4">PRODUCT / SKU</th>
                            <th class="py-3 px-3">EVENT TYPE</th>
                            <th class="py-3 px-3 text-center">CHANGE</th>
                            <th class="py-3 px-3 text-center">PREV → NEW</th>
                            <th class="py-3 px-4">ACTOR / REASON</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                        @forelse($auditLogs as $log)
                            <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                                <td class="py-3.5 px-4 font-mono text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ $log->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-espresso-950 dark:text-white">
                                        {{ $log->product_name }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-mono">
                                        {{ $log->sku }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    @if($log->change_type === 'order_placed')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 border border-blue-200">
                                            Online Order
                                        </span>
                                    @elseif($log->change_type === 'restock')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200">
                                            Replenishment
                                        </span>
                                    @elseif($log->change_type === 'bespoke_switch')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200">
                                            Bespoke Lead
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 border border-purple-200">
                                            Manual Adjust
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3 text-center font-mono font-bold text-xs whitespace-nowrap">
                                    @if($log->quantity_change > 0)
                                        <span class="text-emerald-600">+{{ $log->quantity_change }}</span>
                                    @elseif($log->quantity_change < 0)
                                        <span class="text-rose-600">{{ $log->quantity_change }}</span>
                                    @else
                                        <span class="text-gray-400">0</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-3 text-center font-mono text-[11px] text-gray-500 whitespace-nowrap">
                                    {{ $log->previous_stock }} → <span class="font-bold text-espresso-950 dark:text-white">{{ $log->new_stock }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="text-xs text-espresso-950 dark:text-white font-medium">
                                        {{ $log->reason }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">
                                        By: <span class="font-semibold">{{ $log->admin_name ?: 'System' }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400">
                                    <i data-lucide="history" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                    No audit history entries recorded yet. Modifications and orders will appear here automatically.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bespoke / Made-to-Order Lead Time Card Dialog -->
    <dialog id="bespokeModal" class="rounded-3xl p-0 shadow-2xl">
        <div class="p-6 sm:p-7">
            <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-tan-600 dark:text-gold-400"></i>
                    <h3 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400">Switch to Made-to-Order</h3>
                </div>
                <button type="button" onclick="document.getElementById('bespokeModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form 
                :action="bespokeProduct ? '{{ url('admin/inventory') }}/' + bespokeProduct.id + '/bespoke' : '#'" 
                method="POST" 
                class="space-y-4"
            >
                @csrf
                
                <div>
                    <div class="text-xs font-bold text-espresso-950 dark:text-white" x-text="bespokeProduct ? bespokeProduct.name : ''"></div>
                    <div class="text-[10px] text-gray-400 font-mono" x-text="bespokeProduct ? 'SKU: ' + bespokeProduct.sku : ''"></div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Production Lead Time Preset</label>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <button 
                            type="button" 
                            @click="$refs.leadTimeInput.value = '3–5 Working Days'" 
                            class="px-2.5 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-left text-[11px] hover:border-tan-500 hover:bg-[#FAF8F5] dark:hover:bg-[#201815] transition-colors"
                        >
                            3–5 Working Days
                        </button>
                        <button 
                            type="button" 
                            @click="$refs.leadTimeInput.value = '7–10 Working Days'" 
                            class="px-2.5 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-left text-[11px] hover:border-tan-500 hover:bg-[#FAF8F5] dark:hover:bg-[#201815] transition-colors"
                        >
                            7–10 Working Days (Standard)
                        </button>
                        <button 
                            type="button" 
                            @click="$refs.leadTimeInput.value = '2–3 Weeks Artisan Craft'" 
                            class="px-2.5 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-left text-[11px] hover:border-tan-500 hover:bg-[#FAF8F5] dark:hover:bg-[#201815] transition-colors"
                        >
                            2–3 Weeks Artisan Craft
                        </button>
                        <button 
                            type="button" 
                            @click="$refs.leadTimeInput.value = '3–4 Weeks Haute Leather'" 
                            class="px-2.5 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-left text-[11px] hover:border-tan-500 hover:bg-[#FAF8F5] dark:hover:bg-[#201815] transition-colors"
                        >
                            3–4 Weeks Haute Bespoke
                        </button>
                    </div>

                    <input 
                        type="text" 
                        name="lead_time" 
                        x-ref="leadTimeInput"
                        x-bind:value="bespokeProduct ? bespokeProduct.lead_time : '7–10 Working Days'" 
                        required 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                        placeholder="e.g., 7–10 Working Days"
                    >
                    <p class="text-[10px] text-gray-400 mt-1">
                        When enabled, shoppers can still order this item online with a "Made-to-Order" badge and the stated timeline.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                    <button type="button" onclick="document.getElementById('bespokeModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-espresso-900 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                        Confirm Bespoke Mode
                    </button>
                </div>
            </form>
        </div>
    </dialog>

</div>

@endsection
