@extends('admin.layouts.app')

@section('title', 'Inventory & Stock Management | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Inventory & Stock Control
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Real-time leather stock tracking, inventory threshold alerts, and instant workshop replenishment.
            </p>
        </div>

        @if($lowStockCount > 0)
            <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-semibold self-start sm:self-center">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 animate-bounce"></i>
                <span>{{ $lowStockCount }} items require workshop crafting replenishment</span>
            </div>
        @endif
    </div>

    <!-- 4 KPI Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">TOTAL UNITS IN STOCK</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">{{ number_format($totalInventory) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Across {{ $totalSkus }} SKUs</div>
        </div>

        <a href="{{ route('admin.inventory.index', ['status' => 'low']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-amber-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">LOW STOCK ALERTS (≤5)</div>
            <div class="font-cinzel text-2xl font-bold text-amber-600 mt-1">{{ $lowStockCount }}</div>
            <div class="text-[10px] text-amber-700/80 mt-1">Action advised</div>
        </a>

        <a href="{{ route('admin.inventory.index', ['status' => 'out']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-rose-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">DEPLETED / OUT OF STOCK</div>
            <div class="font-cinzel text-2xl font-bold text-rose-600 mt-1">{{ $outOfStockCount }}</div>
            <div class="text-[10px] text-rose-700/80 mt-1">Waitlist active</div>
        </a>

        <a href="{{ route('admin.inventory.index', ['status' => 'adequate']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-emerald-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">HEALTHY STOCK BUFFER</div>
            <div class="font-cinzel text-2xl font-bold text-emerald-600 mt-1">{{ $totalSkus - $lowStockCount - $outOfStockCount }}</div>
            <div class="text-[10px] text-emerald-700/80 mt-1">Ample inventory</div>
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
                    placeholder="Search by SKU, product name, collection..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
            </div>

            <div class="w-full sm:w-48">
                <select 
                    name="status" 
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Filter: All Inventory</option>
                    <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Low Stock Alerts (≤5)</option>
                    <option value="out" {{ request('status') === 'out' ? 'selected' : '' }}>Depleted (0)</option>
                    <option value="adequate" {{ request('status') === 'adequate' ? 'selected' : '' }}>Adequate (>5)</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shrink-0 transition-colors border border-gold-400/20">
                Filter
            </button>
        </form>
    </div>

    <!-- Inventory Table with Fast Stock Replenishment -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">PRODUCT / SKU</th>
                        <th class="py-3 px-3">COLLECTION</th>
                        <th class="py-3 px-3">CURRENT STOCK</th>
                        <th class="py-3 px-3">STOCK LEVEL HEALTH</th>
                        <th class="py-3 px-4 text-right">INSTANT REPLENISH</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($products as $product)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            
                            <!-- Product Info -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $product->image ?: '/images/products/prod-reversible-belt.jpg' }}" 
                                        alt="{{ $product->name }}"
                                        class="w-10 h-10 rounded-xl object-cover border border-[#ECE6DE] shrink-0"
                                    >
                                    <div>
                                        <div class="font-bold text-espresso-950 dark:text-white">
                                            {{ $product->name }}
                                        </div>
                                        <div class="font-mono text-[10px] text-[#8F8379]">
                                            SKU: {{ $product->sku }}
                                        </div>
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
                            </td>

                            <!-- Stock Health Progress Bar -->
                            <td class="py-3.5 px-3 w-48">
                                @php
                                    $pct = min(100, round(($product->stock_quantity / 30) * 100));
                                    $barColor = $product->stock_quantity == 0 ? 'bg-rose-500' : ($product->stock_quantity <= 5 ? 'bg-amber-500' : 'bg-emerald-500');
                                @endphp
                                <div class="space-y-1">
                                    <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                        <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <div class="text-[10px] text-gray-400 flex items-center justify-between">
                                        <span>{{ $product->stock_quantity <= 5 ? ($product->stock_quantity == 0 ? 'Depleted' : 'Low Buffer') : 'Optimal' }}</span>
                                        <span>Target: 30</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Instant Stock Update Form -->
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('admin.inventory.update', $product) }}" method="POST" class="inline-flex items-center gap-1.5 justify-end">
                                    @csrf
                                    <input 
                                        type="number" 
                                        name="stock_quantity" 
                                        value="{{ $product->stock_quantity }}" 
                                        min="0"
                                        class="w-16 px-2 py-1 text-xs rounded-lg border border-[#DFD6CB] dark:border-[#382D27] bg-[#FAF8F5] dark:bg-[#241D1A] text-center font-mono font-bold text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                                    >
                                    <button 
                                        type="submit" 
                                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-espresso-900 hover:bg-tan-600 text-white shadow-2xs transition-colors"
                                        title="Save Stock Level"
                                    >
                                        Update
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
