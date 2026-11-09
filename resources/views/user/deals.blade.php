@extends('user.layouts.app')

@section('title', 'Curated Leather Sets & Deals | Luxury Bundles Pakistan | By Zunash')
@section('meta_description', 'Discover handcrafted luxury leather deals by Atelier By Zunash Pakistan. Pair complementary reversible belts, wallets, and bags at exclusive bundle rates.')
@section('meta_keywords', 'leather deals Pakistan, buy leather belt and wallet combo, luxury leather sets Pakistan, By Zunash bundle, cash on delivery leather sets')
@section('canonical', route('deals'))
@section('og_type', 'website')
@section('og_image', asset('images/brand/artisan-craft.jpg'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ route('deals') }}/#deals",
            "name": "Curated Leather Sets & Exclusive Atelier Deals",
            "description": "Discover curated sets and exclusive handcrafted leather deals by Atelier By Zunash. Pair complementary belts, wallets, and bags at exceptional bespoke rates.",
            "url": "{{ route('deals') }}",
            "mainEntity": {
                "@type": "ItemList",
                "itemListElement": [
                    @foreach($deals as $idx => $d)
                    {
                        "@type": "ListItem",
                        "position": {{ $loop->iteration }},
                        "url": "{{ route('deal.details', $d->slug) }}",
                        "name": "{{ addslashes($d->title) }}"
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('deals') }}/#breadcrumb",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ route('home') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Curated Sets & Deals",
                    "item": "{{ route('deals') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')

<!-- ========================================================
     ATELIER HEADER: CURATED SETS & COMBINATIONS
     ======================================================== -->
<section class="pt-10 pb-6 text-center bg-[#FAF8F5] dark:bg-[#14100E] border-b border-[#ECE6DE] dark:border-white/10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <span class="text-[10px] uppercase tracking-[0.25em] font-semibold text-gold-700 dark:text-gold-400 block mb-1">
            Exclusive Pairings & Bundles
        </span>
        <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-espresso-950 dark:text-white tracking-tight">
            Curated Leather Deals
        </h1>
        <p class="text-xs sm:text-sm text-espresso-800/80 dark:text-ivory-300 font-light max-w-lg mx-auto mt-2 leading-relaxed">
            Complementary creations sculpted from matching full-grain hides, paired together at special bundle rates with complimentary luxury gift packaging.
        </p>
    </div>
</section>

<!-- ========================================================
     MAIN CONTENT: SIDEBAR FILTERS + DEALS GRID
     ======================================================== -->
<section class="py-8 sm:py-12 bg-white dark:bg-[#0F0C0A]" x-data="{ mobileFilterOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Mobile Filter Toggle Bar -->
        <div class="lg:hidden flex items-center justify-between gap-3 mb-6 p-3 rounded-xl bg-[#FAF8F5] dark:bg-[#181310] border border-ivory-300 dark:border-white/10">
            <button 
                type="button" 
                @click="mobileFilterOpen = !mobileFilterOpen"
                class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-espresso-950 dark:text-white"
            >
                <i data-lucide="sliders-horizontal" class="w-4 h-4 text-gold-600"></i>
                <span>Filter Deals ({{ $activeCategory !== 'all' || $activePriceRange !== 'all' ? 'Active' : 'All' }})</span>
            </button>
            <span class="text-xs text-[#8F8379] dark:text-[#A09387]">
                {{ $deals->count() }} Sets Found
            </span>
        </div>

        <!-- Robust Flex Layout (Sidebar + Main Content) -->
        <div class="flex flex-col lg:flex-row gap-8 items-start">

            <!-- ========================================================
                 LEFT SIDEBAR FILTER (Desktop & Mobile Toggle)
                 ======================================================== -->
            <aside 
                :class="mobileFilterOpen ? 'block' : 'hidden lg:block'"
                class="w-full lg:w-72 flex-shrink-0 space-y-6 bg-[#FAF8F5] dark:bg-[#14100E] p-5 sm:p-6 rounded-2xl border border-ivory-300 dark:border-white/10"
            >
                <div class="flex items-center justify-between border-b border-ivory-200 dark:border-white/10 pb-3">
                    <div class="flex items-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4 text-gold-600"></i>
                        <h2 class="font-serif text-sm font-bold text-espresso-950 dark:text-white uppercase tracking-wider">
                            Filter Deals
                        </h2>
                    </div>
                    @if($activeCategory !== 'all' || $activePriceRange !== 'all' || $activeSort !== 'featured')
                        <a 
                            href="{{ route('deals') }}" 
                            class="text-[11px] text-rose-600 hover:underline flex items-center gap-0.5"
                        >
                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>

                <form action="{{ route('deals') }}" method="GET" id="dealsFilterForm" class="space-y-6">

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold tracking-wider text-espresso-900 dark:text-white mb-2.5">
                            Deal Category
                        </label>
                        <div class="space-y-1.5 text-xs">
                            @php
                                $categoriesList = [
                                    'all' => ['name' => 'All Curated Sets', 'count' => $categoryCounts['all'] ?? 0],
                                    'belts' => ['name' => 'Leather Belts Deals', 'count' => $categoryCounts['belts'] ?? 0],
                                    'wallets' => ['name' => 'Wallets & Cardholders Deals', 'count' => $categoryCounts['wallets'] ?? 0],
                                    'handbags' => ['name' => 'Handbags & Satchels Deals', 'count' => $categoryCounts['handbags'] ?? 0],
                                    'accessories' => ['name' => 'Everyday Accessories Deals', 'count' => $categoryCounts['accessories'] ?? 0],
                                ];
                            @endphp

                            @foreach($categoriesList as $slug => $cat)
                                <label class="flex items-center justify-between p-2 rounded-lg cursor-pointer transition-colors {{ $activeCategory === $slug ? 'bg-espresso-950 text-white font-semibold' : 'hover:bg-white dark:hover:bg-[#201A16] text-espresso-800 dark:text-ivory-300' }}">
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="radio" 
                                            name="category" 
                                            value="{{ $slug }}" 
                                            {{ $activeCategory === $slug ? 'checked' : '' }}
                                            onchange="document.getElementById('dealsFilterForm').submit()"
                                            class="w-3.5 h-3.5 text-gold-600 focus:ring-0 cursor-pointer"
                                        >
                                        <span>{{ $cat['name'] }}</span>
                                    </div>
                                    <span class="text-[10px] {{ $activeCategory === $slug ? 'text-gold-300' : 'text-[#8F8379]' }}">
                                        ({{ $cat['count'] }})
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Tier Filter -->
                    <div class="border-t border-ivory-200 dark:border-white/10 pt-4">
                        <label class="block text-[11px] uppercase font-bold tracking-wider text-espresso-900 dark:text-white mb-2.5">
                            Price Range
                        </label>
                        <div class="space-y-1.5 text-xs">
                            @php
                                $priceTiers = [
                                    'all' => 'All Price Points',
                                    'under-8k' => 'Under PKR 8,000',
                                    '8k-15k' => 'PKR 8,000 – PKR 15,000',
                                    'above-15k' => 'Above PKR 15,000',
                                ];
                            @endphp
                            @foreach($priceTiers as $pKey => $pLabel)
                                <label class="flex items-center gap-2 p-2 rounded-lg cursor-pointer transition-colors {{ $activePriceRange === $pKey ? 'bg-gold-400/20 text-gold-900 dark:text-gold-300 font-semibold' : 'hover:bg-white dark:hover:bg-[#201A16] text-espresso-800 dark:text-ivory-300' }}">
                                    <input 
                                        type="radio" 
                                        name="price_range" 
                                        value="{{ $pKey }}" 
                                        {{ $activePriceRange === $pKey ? 'checked' : '' }}
                                        onchange="document.getElementById('dealsFilterForm').submit()"
                                        class="w-3.5 h-3.5 text-gold-600 focus:ring-0 cursor-pointer"
                                    >
                                    <span>{{ $pLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sort Filter -->
                    <div class="border-t border-ivory-200 dark:border-white/10 pt-4">
                        <label class="block text-[11px] uppercase font-bold tracking-wider text-espresso-900 dark:text-white mb-2" for="sortSelect">
                            Sort Deals
                        </label>
                        <select 
                            id="sortSelect" 
                            name="sort" 
                            onchange="document.getElementById('dealsFilterForm').submit()"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#1A1513] border border-ivory-300 dark:border-white/10 text-espresso-900 dark:text-ivory focus:outline-hidden"
                        >
                            <option value="featured" {{ $activeSort === 'featured' ? 'selected' : '' }}>Featured Curations</option>
                            <option value="discount" {{ $activeSort === 'discount' ? 'selected' : '' }}>Biggest Savings (%)</option>
                            <option value="price_asc" {{ $activeSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ $activeSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                </form>

                <!-- Value Guarantee Box -->
                <div class="p-3.5 rounded-xl bg-white dark:bg-[#1A1513] border border-ivory-200 dark:border-white/10 space-y-2 text-xs text-espresso-800 dark:text-ivory-300">
                    <div class="flex items-center gap-1.5 font-bold text-espresso-950 dark:text-white">
                        <i data-lucide="shield-check" class="w-4 h-4 text-gold-600"></i>
                        <span>The Atelier Promise</span>
                    </div>
                    <p class="text-[11px] leading-relaxed text-[#8F8379] dark:text-[#A09387]">
                        Every deal pairs genuine, matching vegetable-tanned full-grain pieces. Includes custom presentation packaging and nationwide delivery.
                    </p>
                </div>
            </aside>

            <!-- ========================================================
                 RIGHT DEALS SHOWCASE GRID (Flex-1)
                 ======================================================== -->
            <main class="flex-1 w-full min-w-0 space-y-6">

                <!-- Results Count & Active Category Badge -->
                <div class="flex items-center justify-between pb-3 border-b border-ivory-200 dark:border-white/10">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-espresso-950 dark:text-white">
                            Showing {{ $deals->count() }} Curated Sets
                        </span>
                        @if($activeCategory !== 'all')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-gold-400/20 text-gold-800 dark:text-gold-300">
                                {{ ucfirst($activeCategory) }}
                            </span>
                        @endif
                    </div>
                    <span class="text-[11px] text-[#8F8379] font-mono">
                        Handcrafted in Atelier
                    </span>
                </div>

                @if($deals->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($deals as $deal)
                            <div 
                                id="{{ $deal->slug }}" 
                                class="group bg-white dark:bg-[#181310] rounded-2xl border border-ivory-300 dark:border-white/10 shadow-xs hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col scroll-mt-24"
                            >
                                <!-- Top: Single High-Class Combination Image -->
                                <div class="relative w-full h-44 sm:h-48 bg-[#F7F5F0] dark:bg-[#14100E] overflow-hidden border-b border-ivory-200 dark:border-white/10">
                                    <a href="{{ route('deal.details', $deal->slug) }}" class="block w-full h-full">
                                        <img 
                                            src="{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}" 
                                            alt="{{ $deal->title }}" 
                                            class="w-full h-full object-cover object-center group-hover:scale-104 transition-transform duration-700 ease-out"
                                        >
                                    </a>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-50 group-hover:opacity-30 transition-opacity pointer-events-none"></div>

                                    <!-- Top-Left Badge (Discount / Tag) -->
                                    <div class="absolute top-2.5 left-2.5 z-10">
                                        <span class="px-2.5 py-1 rounded-full bg-espresso-950/90 text-gold-300 text-[10px] font-bold uppercase tracking-wider backdrop-blur-xs border border-gold/40 shadow-xs">
                                            {{ $deal->badge ?: 'Curated Set' }}
                                        </span>
                                    </div>

                                    <!-- Top-Right Savings Pill -->
                                    @if($deal->savings_amount > 0)
                                        <div class="absolute top-2.5 right-2.5 z-10">
                                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-700/90 text-white text-[10px] font-bold backdrop-blur-xs shadow-xs">
                                                SAVE {{ $deal->savings_percentage }}%
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Bottom Gift Box Overlay -->
                                    <div class="absolute bottom-2 left-2.5 z-10 pointer-events-none">
                                        <span class="px-2 py-0.5 rounded bg-black/60 backdrop-blur-xs text-white text-[9px] font-medium flex items-center gap-1">
                                            <i data-lucide="gift" class="w-3 h-3 text-gold"></i>
                                            <span>Rigid Gift Box Included</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 sm:p-5 flex flex-col flex-1 justify-between">
                                    <div>
                                        <!-- Tagline -->
                                        @if($deal->tagline)
                                            <span class="text-[10px] font-semibold uppercase tracking-wider text-gold-700 dark:text-gold-400 block mb-0.5">
                                                {{ $deal->tagline }}
                                            </span>
                                        @endif

                                        <!-- Deal Title -->
                                        <h3 class="font-serif text-base font-bold text-espresso-950 dark:text-white truncate mb-1 group-hover:text-gold-600 transition-colors">
                                            <a href="{{ route('deal.details', $deal->slug) }}">
                                                {{ $deal->title }}
                                            </a>
                                        </h3>

                                        <!-- Products Included with Pics Mini-List -->
                                        <div class="p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#201A16] border border-ivory-200 dark:border-white/10 my-3">
                                            <div class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] dark:text-[#A09387] mb-1.5 flex items-center justify-between">
                                                <span>Included Pieces:</span>
                                                <span class="text-gold-700 dark:text-gold-400 font-semibold">{{ $deal->products->count() }} Creations</span>
                                            </div>

                                            <div class="space-y-1.5">
                                                @foreach($deal->products as $item)
                                                    <div class="flex items-center justify-between gap-2 text-xs">
                                                        <div class="flex items-center gap-2 min-w-0">
                                                            <div class="w-7 h-7 rounded-lg overflow-hidden bg-white shrink-0 border border-ivory-200">
                                                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                                            </div>
                                                            <a href="{{ route('product.details', $item->slug) }}" class="text-[11px] font-medium text-espresso-900 dark:text-ivory-200 truncate hover:text-gold-600 transition-colors">
                                                                {{ $item->name }}
                                                            </a>
                                                        </div>
                                                        <span class="text-[10px] text-[#8F8379] font-mono shrink-0">
                                                            PKR {{ number_format($item->price) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Overall Regular Price vs Deal Price (Value Framing) -->
                                        <div class="flex items-center justify-between pt-1 mb-3">
                                            <div>
                                                <span class="text-[9px] uppercase tracking-wider text-[#8F8379] dark:text-[#A09387] font-semibold block leading-none mb-0.5">
                                                    Special Set Price
                                                </span>
                                                <div class="flex items-baseline gap-2">
                                                    <span class="font-serif text-lg font-bold text-espresso-950 dark:text-white">
                                                        <span class="text-[11px] font-bold text-gold-600 mr-0.5">PKR</span>{{ number_format($deal->deal_price) }}
                                                    </span>
                                                    @if($deal->effective_original_price > $deal->deal_price)
                                                        <span class="text-xs text-[#8F8379] line-through font-sans">
                                                            PKR {{ number_format($deal->effective_original_price) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($deal->savings_amount > 0)
                                                <div class="text-right">
                                                    <span class="text-[9px] text-[#8F8379] block">Your Savings</span>
                                                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400">
                                                        -PKR {{ number_format($deal->savings_amount) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- 2 Action Buttons: View Details + Add Set to Bag -->
                                    <div class="grid grid-cols-2 gap-2 pt-3 border-t border-ivory-200 dark:border-white/10 mt-auto">
                                        <!-- Button 1: View Details -->
                                        <a 
                                            href="{{ route('deal.details', $deal->slug) }}" 
                                            class="py-2 px-2.5 rounded-xl border border-espresso-950/20 dark:border-white/20 text-espresso-950 dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-white/5 text-[11px] font-bold uppercase tracking-wider transition-colors flex items-center justify-center gap-1"
                                        >
                                            <span>Details</span>
                                            <i data-lucide="arrow-right" class="w-3 h-3 text-[#8F8379]"></i>
                                        </a>

                                        <!-- Button 2: Add Set to Bag -->
                                        <button 
                                            type="button" 
                                            @click="addDealToCart(@js($deal))" 
                                            class="py-2 px-2.5 rounded-xl bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 text-[11px] font-bold uppercase tracking-wider transition-all shadow-xs flex items-center justify-center gap-1 active:scale-95"
                                        >
                                            <i data-lucide="shopping-bag" class="w-3 h-3 text-gold"></i>
                                            <span>Add Set</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="py-16 text-center max-w-sm mx-auto bg-[#FAF8F5] dark:bg-[#14100E] p-8 rounded-2xl border border-ivory-300 dark:border-white/10">
                        <div class="w-12 h-12 rounded-xl bg-gold/15 border border-gold/40 flex items-center justify-center text-gold-700 mx-auto mb-3">
                            <i data-lucide="package-search" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-espresso-950 dark:text-white mb-1">
                            No Matching Deals Found
                        </h3>
                        <p class="text-xs text-[#8F8379] font-light mb-4 leading-relaxed">
                            We couldn't find any curated sets matching your current filter criteria.
                        </p>
                        <a 
                            href="{{ route('deals') }}" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-espresso-950 text-white rounded-xl text-xs uppercase tracking-wider font-semibold hover:bg-gold hover:text-espresso-950 transition-colors"
                        >
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>View All Active Deals</span>
                        </a>
                    </div>
                @endif

            </main>

        </div>

    </div>
</section>

<!-- ========================================================
     SCRIPT: ADD DEAL BUNDLE TO ALPINE SHOPPING BAG
     ======================================================== -->
<script>
function addDealToCart(deal) {
    if (!window.Alpine || !Alpine.store('cart')) {
        alert('Shopping bag is initializing. Please try again.');
        return;
    }

    const cart = Alpine.store('cart');
    const dealKey = `deal-${deal.id}`;
    const existing = cart.items.find(item => item.key === dealKey);

    const dealItem = {
        key: dealKey,
        id: `deal-${deal.id}`,
        name: deal.title + ' (Curated Set)',
        price: Number(deal.deal_price),
        originalPrice: Number(deal.original_price || deal.deal_price),
        image: deal.image || (deal.products && deal.products[0] ? deal.products[0].image : '/images/brand/artisan-craft.jpg'),
        category: 'Atelier Set',
        variant: `${deal.products ? deal.products.length : 2} Items Paired Set`,
        quantity: 1
    };

    if (existing) {
        existing.quantity += 1;
    } else {
        cart.items.push(dealItem);
    }

    cart.save();
    if (window.lucide) {
        window.lucide.createIcons();
    }

    if (window.ZunashAlert) {
        window.ZunashAlert.toast(`"${deal.title}" added to shopping bag!`, 'success');
    }
    cart.isOpen = true;
}
</script>

@endsection