@extends('admin.layouts.app')

@section('title', 'Product Catalogue Management | By Zunash Atelier Admin')

@section('content')

<!-- Header & Quick Stats -->
<div class="space-y-4">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Product Catalogue
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Manage, filter, curate, and price handcrafted luxury creations across all By Zunash collections.
            </p>
        </div>

        <a 
            href="{{ route('admin.products.create') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
            <span>Add New Product</span>
        </a>
    </div>

    <!-- 4 Filter Metric Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('admin.products.index') }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-tan-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Total Products</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $totalCount }}</div>
        </a>
        <a href="{{ route('admin.products.index', ['stock' => 'in_stock']) }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-emerald-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Active in Store</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $activeCount }}</div>
        </a>
        <a href="{{ route('admin.products.index', ['stock' => 'low_stock']) }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-amber-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Low Stock Alert</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $lowStockCount }}</div>
        </a>
        <a href="{{ route('admin.products.index', ['stock' => 'out_of_stock']) }}" class="p-3.5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-rose-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Out of Stock</div>
            <div class="font-cinzel text-xl font-bold text-espresso-950 dark:text-white mt-0.5">{{ $outOfStockCount }}</div>
        </a>
    </div>

</div>

<!-- Filter Bar Card -->
<div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
    <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
        
        <!-- Search -->
        <div class="lg:col-span-4 relative">
            <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}"
                placeholder="Search by name, SKU, category..." 
                class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
            >
        </div>

        <!-- Category Filter -->
        <div class="lg:col-span-3">
            <select 
                name="category" 
                class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
            >
                <option value="all">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Stock Status Filter -->
        <div class="lg:col-span-2">
            <select 
                name="stock" 
                class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
            >
                <option value="">Stock Status: All</option>
                <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>In Stock (>5)</option>
                <option value="low_stock" {{ request('stock') === 'low_stock' ? 'selected' : '' }}>Low Stock (≤5)</option>
                <option value="out_of_stock" {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                <option value="on_demand" {{ request('stock') === 'on_demand' ? 'selected' : '' }}>On Demand / Bespoke</option>
            </select>
        </div>

        <!-- Sort -->
        <div class="lg:col-span-2">
            <select 
                name="sort" 
                class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
            >
                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Sort: Latest</option>
                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="stock_low" {{ request('sort') === 'stock_low' ? 'selected' : '' }}>Stock: Low to High</option>
                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
            </select>
        </div>

        <!-- Submit & Reset Buttons -->
        <div class="lg:col-span-1 flex items-center gap-1.5">
            <button 
                type="submit" 
                class="w-full py-2 px-3 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs transition-colors flex items-center justify-center"
                title="Apply Filter"
            >
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
            </button>
            <a 
                href="{{ route('admin.products.index') }}" 
                class="py-2 px-2.5 rounded-xl border border-[#DFD6CB] text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center justify-center"
                title="Reset Filters"
            >
                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
            </a>
        </div>

    </form>
</div>

<!-- Products Table Card -->
<div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                    <th class="py-3 px-4">PRODUCT</th>
                    <th class="py-3 px-3">CATEGORY</th>
                    <th class="py-3 px-3">PRICE</th>
                    <th class="py-3 px-3">STOCK & STATUS</th>
                    <th class="py-3 px-3">CURATION</th>
                    <th class="py-3 px-3">RATING</th>
                    <th class="py-3 px-4 text-right">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                @forelse($products as $product)
                    <tr class="hover:bg-[#FAF8F5]/80 dark:hover:bg-[#221B18] transition-colors">
                        
                        <!-- Thumbnail & Info -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img 
                                    src="{{ $product->image ?: '/images/products/prod-reversible-belt.jpg' }}" 
                                    alt="{{ $product->name }}"
                                    class="w-12 h-12 rounded-xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs shrink-0"
                                >
                                <div class="min-w-0">
                                    <div class="font-bold text-espresso-950 dark:text-white truncate max-w-xs hover:text-tan-600 transition-colors">
                                        {{ $product->name }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="font-mono text-[10px] font-semibold text-[#8F8379]">
                                            {{ $product->sku }}
                                        </span>
                                        @if($product->badge)
                                            <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-[#FAF3F0] text-tan-700 border border-[#F3E3DC]">
                                                {{ $product->badge }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Variation Leather Swatches Preview -->
                                    @if(is_array($product->colors) && count($product->colors) > 0)
                                        <div class="flex items-center gap-1 mt-1.5" title="Available Leather Tones">
                                            @foreach(array_slice($product->colors, 0, 5) as $col)
                                                <span 
                                                    class="w-3 h-3 rounded-full border border-black/20 shadow-2xs inline-block" 
                                                    style="background-color: {{ $col['hex'] ?? '#8B4513' }};"
                                                    title="{{ $col['name'] ?? '' }}"
                                                ></span>
                                            @endforeach
                                            @if(count($product->colors) > 5)
                                                <span class="text-[9px] text-[#8F8379] font-semibold font-mono">+{{ count($product->colors) - 5 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="py-3.5 px-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#F5F1EA] dark:bg-[#2A221E] text-espresso-800 dark:text-[#E8D0BE]">
                                {{ $product->category_name ?: ucfirst($product->category_slug) }}
                            </span>
                            @if($product->subcategory)
                                <div class="text-[10px] text-gray-500 dark:text-gray-400 font-medium mt-1">
                                    {{ $product->subcategory->name }}
                                </div>
                            @endif
                        </td>

                        <!-- Price -->
                        <td class="py-3.5 px-3">
                            <div class="font-cinzel font-bold text-sm text-espresso-950 dark:text-white">
                                Rs. {{ number_format($product->price) }}
                            </div>
                            @if($product->original_price)
                                <div class="text-[10px] text-gray-400 line-through font-mono">
                                    Rs. {{ number_format($product->original_price) }}
                                </div>
                            @endif
                        </td>

                        <!-- Stock & Status -->
                        <td class="py-3.5 px-3">
                            @if($product->availability === 'on_demand')
                                <div class="space-y-0.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 dark:text-amber-400 border border-amber-500/30 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        On Demand
                                    </span>
                                    <div class="text-[9px] text-[#8F8379] font-mono">
                                        {{ $product->lead_time ?: '7–10 Days' }}
                                    </div>
                                </div>
                            @elseif($product->stock_quantity <= 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    Out of Stock (0)
                                </span>
                            @elseif($product->stock_quantity <= 5)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Low: {{ $product->stock_quantity }} left
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    In Stock ({{ $product->stock_quantity }})
                                </span>
                            @endif
                        </td>

                        <!-- Bestseller / New Pills -->
                        <td class="py-3.5 px-3">
                            <div class="flex items-center gap-1">
                                @if($product->is_bestseller)
                                    <span class="w-5 h-5 rounded-full bg-gold-400/20 text-tan-700 dark:text-gold-300 flex items-center justify-center font-bold text-[10px]" title="Bestseller Flagship">
                                        ★
                                    </span>
                                @endif
                                @if($product->is_new)
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        NEW
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- Rating -->
                        <td class="py-3.5 px-3">
                            <div class="flex items-center gap-1 font-semibold text-espresso-900 dark:text-white">
                                <span class="text-amber-500">★</span>
                                <span>{{ number_format($product->rating, 1) }}</span>
                                <span class="text-[10px] text-gray-400">({{ $product->reviews_count }})</span>
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <a 
                                    href="{{ route('product.details', $product->slug) }}" 
                                    target="_blank"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] transition-colors"
                                    title="View Live Product Page"
                                >
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>

                                <a 
                                    href="{{ route('admin.products.edit', $product) }}" 
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] transition-colors"
                                    title="Edit Product"
                                >
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this product from the catalogue?')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors"
                                        title="Delete Product"
                                    >
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            No products match your current filters. Try resetting search filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Clean Pagination Footer -->
    <div class="px-6 py-4 bg-[#FAF8F5]/60 dark:bg-[#201A18] border-t border-[#ECE6DE] dark:border-[#2C2420]">
        {{ $products->links() }}
    </div>

</div>

@endsection
