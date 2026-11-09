@extends('admin.layouts.app')

@section('title', 'Artisan Inventory & Stock Health | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Artisan Inventory & Stock Management
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Real-time stock tracking, availability modes (In Stock, On Demand, Out of Stock), and lead-time controls.
            </p>
        </div>

        @if($lowStockCount > 0)
            <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-900 dark:text-amber-300 text-xs font-semibold self-start sm:self-center">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 animate-bounce"></i>
                <span>{{ $lowStockCount }} items require workshop replenishment</span>
            </div>
        @endif
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

        <a href="{{ route('admin.inventory.index', ['status' => 'out']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-rose-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">SOLD OUT / ARCHIVAL</div>
            <div class="font-cinzel text-2xl font-bold text-rose-600 mt-1">{{ $outOfStockCount }}</div>
            <div class="text-[10px] text-rose-700/80 mt-1">Concierge alerts</div>
        </a>
    </div>

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
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
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
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="adequate" {{ request('status') === 'adequate' ? 'selected' : '' }}>In Stock (>5 units)</option>
                    <option value="on_demand" {{ request('status') === 'on_demand' ? 'selected' : '' }}>On Demand / Bespoke</option>
                    <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Low Stock (≤5 units)</option>
                    <option value="out" {{ request('status') === 'out' ? 'selected' : '' }}>Depleted (0 units)</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shrink-0 transition-colors border border-gold-400/20">
                Filter
            </button>
            <a href="{{ route('admin.inventory.index') }}" class="px-3 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-500 hover:bg-gray-100 dark:hover:bg-[#201A18] text-xs font-semibold">
                Reset
            </a>
        </form>
    </div>

    <!-- Inventory Table with Fast Stock & Availability Replenishment -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">PRODUCT / VARIATIONS</th>
                        <th class="py-3 px-3">COLLECTION</th>
                        <th class="py-3 px-3">CURRENT STOCK</th>
                        <th class="py-3 px-3">STOREFRONT STATUS</th>
                        <th class="py-3 px-4 text-right">QUICK REPLENISH & MODE</th>
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

                                        <!-- Leather Swatches -->
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
                                            On Demand
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

                            <!-- Fast Stock & Mode Update Form -->
                            <td class="py-3.5 px-4 text-right">
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

                                    <!-- Lead time (optional) -->
                                    <input 
                                        type="text" 
                                        name="lead_time" 
                                        value="{{ $product->lead_time }}" 
                                        placeholder="Lead time" 
                                        class="w-24 px-1.5 py-1 text-[11px] rounded-lg border border-[#DFD6CB] dark:border-[#382D27] bg-[#FAF8F5] dark:bg-[#241D1A] text-espresso-900 dark:text-white focus:outline-hidden"
                                    >

                                    <button 
                                        type="submit" 
                                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-espresso-900 hover:bg-tan-600 text-white shadow-2xs transition-colors shrink-0"
                                        title="Save Stock & Availability"
                                    >
                                        Save
                                    </button>
                                </form>
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

@endsection
