@extends('user.layouts.app')

@section('title', 'Luxury Leather Catalog | Belts, Wallets & Handbags | By Zunash Pakistan')
@section('meta_description', 'Explore handcrafted full-grain leather belts, bifold wallets, cardholders, luxury handbags, and accessories. Nationwide Cash on Delivery across Pakistan.')
@section('meta_keywords', 'buy leather products Pakistan, handcrafted leather shop Pakistan, leather bags Karachi, pure leather belts Lahore, luxury wallets Islamabad, By Zunash')
@section('canonical', route('shop'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ route('shop') }}/#catalog",
            "name": "Luxury Leather Goods Collection",
            "description": "Hand-cut, drum-dyed, and wax-finished full-grain leather goods crafted for everyday utility and enduring distinction.",
            "url": "{{ route('shop') }}",
            "mainEntity": {
                "@type": "ItemList",
                "itemListElement": [
                    @foreach($products as $idx => $item)
                    {
                        "@type": "ListItem",
                        "position": {{ $loop->iteration }},
                        "url": "{{ route('product.details', $item['slug']) }}",
                        "name": "{{ addslashes($item['name']) }}"
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('shop') }}/#breadcrumb",
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
                    "name": "Catalog",
                    "item": "{{ route('shop') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div 
    x-data="{ mobileFiltersOpen: false }"
    class="bg-[#FAF9F5] min-h-screen text-espresso-900"
>
    @php
        $headerBgImage = asset('images/hero/slide-bag.jpg');
        if ($activeCategory === 'belts') {
            $headerBgImage = asset('images/hero/slide-belt.jpg');
        } elseif ($activeCategory === 'wallets') {
            $headerBgImage = asset('images/hero/slide-wallet.jpg');
        } elseif ($activeCategory === 'handbags') {
            $headerBgImage = asset('images/hero/slide-bag.jpg');
        }
    @endphp

    <!-- Expanded & Rich Atelier Dark Header with Visible Leather Product Background -->
    <section class="relative bg-espresso-950 text-ivory border-b border-gold/40 py-12 sm:py-16 lg:py-20 min-h-[220px] sm:min-h-[260px] flex items-center overflow-hidden">
        <!-- Leather product photo clearly visible with directional dark luxury gradient -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ $headerBgImage }}" 
                alt="By Zunash Leather Atelier Catalog" 
                class="w-full h-full object-cover object-right sm:object-center transform scale-100"
            >
            <!-- Smooth horizontal gradient: dark on left for text readability, clear & transparent on right so the leather products are vivid and bright -->
            <div class="absolute inset-0 bg-gradient-to-r from-espresso-950/95 via-espresso-950/75 to-espresso-950/20 sm:to-transparent"></div>
            <!-- Subtle top and bottom vignette -->
            <div class="absolute inset-0 bg-gradient-to-b from-espresso-950/40 via-transparent to-espresso-950/60"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div class="max-w-2xl">
                    <!-- Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-xs font-sans uppercase tracking-widest text-gold-300/90 mb-2.5 drop-shadow-sm">
                        <a href="{{ route('home') }}" class="hover:text-gold-200 transition-colors">Home</a>
                        <span class="text-gold-500/60">/</span>
                        <a href="{{ route('shop') }}" class="hover:text-gold-200 transition-colors">Atelier Catalog</a>
                        @if($activeCategory !== 'all' && isset($categories[$activeCategory]))
                            <span class="text-gold-500/60">/</span>
                            <span class="text-ivory font-bold">{{ $categories[$activeCategory]['name'] }}</span>
                        @endif
                    </nav>

                    <div class="flex items-center gap-3.5 flex-wrap">
                        <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-ivory tracking-tight drop-shadow-md">
                            @if($activeCategory !== 'all' && isset($categories[$activeCategory]))
                                {{ $categories[$activeCategory]['name'] }}
                            @else
                                All Leather Creations
                            @endif
                        </h1>
                        <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-sans font-bold bg-gold/30 text-gold-200 border border-gold/50 shadow-md backdrop-blur-md">
                            {{ $products->total() }} Designs
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-ivory-100/95 mt-2 max-w-xl font-sans leading-relaxed drop-shadow-sm">
                        @if($activeCategory !== 'all' && isset($categories[$activeCategory]))
                            {{ $categories[$activeCategory]['tagline'] }}
                        @else
                            Hand-cut, drum-dyed, and wax-finished full-grain leather goods crafted for everyday utility and enduring distinction.
                        @endif
                    </p>
                </div>

                <!-- Right Side Atelier Quality Mark -->
                <div class="hidden md:flex items-center gap-2.5 text-gold-300 text-xs font-serif italic border border-gold/40 bg-espresso-950/80 backdrop-blur-md px-5 py-3 rounded-xl self-start sm:self-center shadow-xl">
                    <i data-lucide="shield-check" class="w-4 h-4 text-gold-400"></i>
                    <span>100% Pure Full-Grain Hide Guarantee</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        
        <!-- Top Controls & Active Filter Bar -->
        <div class="space-y-4 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-ivory-300">
                <div class="flex items-center gap-3">
                    <!-- Mobile Filter Trigger -->
                    <button 
                        type="button" 
                        @click="mobileFiltersOpen = true"
                        class="lg:hidden inline-flex items-center gap-2 px-4 py-2 bg-white border border-ivory-300 rounded-lg text-xs uppercase tracking-wider font-semibold text-espresso-950 shadow-2xs hover:border-gold-500 transition-colors"
                    >
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-gold-600"></i>
                        <span>Filters</span>
                        @if($activeCategory !== 'all' || request('min_price') || request('max_price') || request('tag'))
                            <span class="w-2 h-2 rounded-full bg-gold-600"></span>
                        @endif
                    </button>

                    <p class="text-xs text-muted-dark font-sans">
                        Showing <span class="font-bold text-espresso-950">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span> of <span class="font-bold text-espresso-950">{{ $products->total() }}</span> authentic creations
                    </p>
                </div>

                <!-- Sort By Dropdown (Direct URL Navigation) -->
                <div class="flex items-center gap-2.5">
                    <label for="sort-select" class="text-xs uppercase tracking-wider text-muted-dark font-semibold font-sans">Sort By:</label>
                    <div class="relative">
                        <select 
                            id="sort-select" 
                            onchange="window.location.href = this.value" 
                            class="appearance-none pl-3.5 pr-8 py-2 bg-white border border-ivory-300 rounded-lg text-xs font-semibold text-espresso-950 focus:outline-none focus:ring-1 focus:ring-gold-500 focus:border-gold-500 shadow-2xs cursor-pointer hover:border-ivory-400 transition-colors"
                        >
                            <option value="{{ route('shop', array_filter(array_merge(request()->query(), ['sort' => 'featured', 'page' => 1]))) }}" {{ request('sort', 'featured') === 'featured' ? 'selected' : '' }}>Featured & Curated</option>
                            <option value="{{ route('shop', array_filter(array_merge(request()->query(), ['sort' => 'price_low', 'page' => 1]))) }}" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('shop', array_filter(array_merge(request()->query(), ['sort' => 'price_high', 'page' => 1]))) }}" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ route('shop', array_filter(array_merge(request()->query(), ['sort' => 'latest', 'page' => 1]))) }}" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="{{ route('shop', array_filter(array_merge(request()->query(), ['sort' => 'popularity', 'page' => 1]))) }}" {{ request('sort') === 'popularity' ? 'selected' : '' }}>Most Appreciated</option>
                        </select>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-muted pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2"></i>
                    </div>
                </div>
            </div>

            <!-- Active Filter Badges Bar (Visible when any filter is active) -->
            @php
                $hasActiveFilters = ($activeCategory !== 'all') || request('min_price') || request('max_price') || request('tag') || request('q');
            @endphp
            @if($hasActiveFilters)
                <div class="flex items-center gap-2 flex-wrap pt-1 text-xs font-sans">
                    <span class="text-muted-dark font-semibold text-[11px] uppercase tracking-wider">Active:</span>

                    @if($activeCategory !== 'all' && isset($categories[$activeCategory]))
                        <a 
                            href="{{ route('shop', array_filter(array_merge(request()->query(), ['category' => null, 'page' => 1]))) }}" 
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-espresso-950 text-ivory text-xs font-medium shadow-2xs hover:bg-gold-600 hover:text-espresso-950 transition-colors"
                        >
                            <span>Collection: {{ $categories[$activeCategory]['name'] }}</span>
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </a>
                    @endif

                    @if(request('min_price') || request('max_price'))
                        <a 
                            href="{{ route('shop', array_filter(array_merge(request()->query(), ['min_price' => null, 'max_price' => null, 'page' => 1]))) }}" 
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-espresso-950 text-ivory text-xs font-medium shadow-2xs hover:bg-gold-600 hover:text-espresso-950 transition-colors"
                        >
                            <span>
                                Price: 
                                @if(request('min_price') && request('max_price'))
                                    PKR {{ number_format(request('min_price')) }} – {{ number_format(request('max_price')) }}
                                @elseif(request('min_price'))
                                    > PKR {{ number_format(request('min_price')) }}
                                @else
                                    < PKR {{ number_format(request('max_price')) }}
                                @endif
                            </span>
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </a>
                    @endif

                    @if(request('tag'))
                        <a 
                            href="{{ route('shop', array_filter(array_merge(request()->query(), ['tag' => null, 'page' => 1]))) }}" 
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gold-600 text-espresso-950 text-xs font-semibold shadow-2xs hover:bg-espresso-950 hover:text-ivory transition-colors"
                        >
                            <span>Badge: {{ ucfirst(request('tag')) }}</span>
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </a>
                    @endif

                    @if(request('q'))
                        <a 
                            href="{{ route('shop', array_filter(array_merge(request()->query(), ['q' => null, 'page' => 1]))) }}" 
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-ivory-200 text-espresso-900 text-xs font-medium border border-ivory-300 hover:bg-red-100 hover:text-red-700 transition-colors"
                        >
                            <span>Keyword: "{{ request('q') }}"</span>
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </a>
                    @endif

                    <a 
                        href="{{ route('shop') }}" 
                        class="text-xs text-muted-dark hover:text-red-600 font-semibold underline underline-offset-2 ml-2 transition-colors"
                    >
                        Clear All
                    </a>
                </div>
            @endif
        </div>

        <!-- 2-Column Layout: Sticky Sidebar Filter + Product Catalog Grid -->
        <div class="flex flex-col lg:flex-row gap-8 xl:gap-10 items-start">
            
            <!-- STICKY Desktop Sidebar Filter Column (Elevated Distinct Card) -->
            <aside class="hidden lg:block w-72 xl:w-80 flex-shrink-0 sticky top-24 self-start max-h-[calc(100vh-6.5rem)] overflow-y-auto hide-scrollbar pb-10">
                
                <div class="bg-white rounded-2xl border border-ivory-300 shadow-sm overflow-hidden divide-y divide-ivory-200">
                    
                    <!-- Sidebar Header Panel -->
                    <div class="p-4 bg-ivory-100/90 flex items-center justify-between border-b border-ivory-300">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-lg bg-espresso-950 text-gold-400 flex items-center justify-center shadow-2xs">
                                <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                            </span>
                            <div>
                                <h2 class="font-serif text-sm font-bold text-espresso-950 tracking-wider uppercase leading-none">
                                    Filter Catalog
                                </h2>
                                <span class="text-[10px] text-muted-dark font-sans leading-tight">Refine your selection</span>
                            </div>
                        </div>
                        @if($hasActiveFilters)
                            <a 
                                href="{{ route('shop') }}" 
                                class="inline-flex items-center gap-1 text-[11px] font-sans uppercase tracking-wider text-red-600 hover:text-red-700 font-bold transition-colors bg-red-50 hover:bg-red-100 px-2 py-1 rounded"
                            >
                                <i data-lucide="rotate-ccw" class="w-3 h-3"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>

                    <!-- Collections / Categories Filter -->
                    <div class="p-5 space-y-3">
                        <h3 class="text-xs uppercase tracking-wider font-sans font-bold text-espresso-950 flex items-center justify-between">
                            <span>Collections</span>
                            <span class="text-[10px] text-muted font-normal">({{ $totalAllCount ?? 20 }} items)</span>
                        </h3>

                        <div class="space-y-1 font-sans">
                            <!-- All Collections Option -->
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['category' => null, 'page' => 1]))) }}"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all text-left border {{ $activeCategory === 'all' ? 'bg-espresso-950 text-ivory font-bold border-espresso-950 shadow-xs' : 'text-espresso-800 border-transparent hover:bg-ivory-100 hover:text-espresso-950' }}"
                            >
                                <span class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full {{ $activeCategory === 'all' ? 'bg-gold-400' : 'bg-ivory-400' }}"></span>
                                    <span>All Creations</span>
                                </span>
                                <span class="text-[11px] px-2 py-0.5 rounded-full {{ $activeCategory === 'all' ? 'bg-white/20 text-ivory font-semibold' : 'bg-ivory-100 text-espresso-900' }}">
                                    {{ $totalAllCount ?? 20 }}
                                </span>
                            </a>

                            <!-- Individual Categories -->
                            @foreach($categories as $slug => $cat)
                                @php
                                    $cCount = $categoryCounts[$slug] ?? $cat['count'] ?? 4;
                                    $isCatActive = ($activeCategory === $slug);
                                @endphp
                                <a 
                                    href="{{ route('shop', array_filter(array_merge(request()->query(), ['category' => $slug, 'page' => 1]))) }}"
                                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium transition-all text-left border {{ $isCatActive ? 'bg-espresso-950 text-ivory font-bold border-espresso-950 shadow-xs' : 'text-espresso-800 border-transparent hover:bg-ivory-100 hover:text-espresso-950' }}"
                                >
                                    <span class="flex items-center gap-2.5">
                                        <span class="w-2 h-2 rounded-full {{ $isCatActive ? 'bg-gold-400' : 'bg-ivory-400' }}"></span>
                                        <span>{{ $cat['name'] }}</span>
                                    </span>
                                    <span class="text-[11px] px-2 py-0.5 rounded-full {{ $isCatActive ? 'bg-white/20 text-ivory font-semibold' : 'bg-ivory-100 text-espresso-900' }}">
                                        {{ $cCount }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range Filter with Quick Presets -->
                    <div class="p-5 space-y-3.5">
                        <h3 class="text-xs uppercase tracking-wider font-sans font-bold text-espresso-950">
                            Price Range (PKR)
                        </h3>

                        <!-- Quick Price Preset Pills -->
                        <div class="grid grid-cols-2 gap-1.5 font-sans">
                            @php
                                $isUnder5k = (request('max_price') == '5000' && !request('min_price'));
                                $is5to10k = (request('min_price') == '5000' && request('max_price') == '10000');
                                $isAbove10k = (request('min_price') == '10000' && !request('max_price'));
                            @endphp
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['min_price' => null, 'max_price' => ($isUnder5k ? null : 5000), 'page' => 1]))) }}"
                                class="px-2.5 py-2 rounded-lg text-[11px] border text-center transition-all {{ $isUnder5k ? 'bg-espresso-950 text-ivory border-espresso-950 font-bold shadow-xs' : 'border-ivory-300 bg-ivory-50 hover:bg-ivory-100 hover:border-gold-500 text-espresso-900 font-medium' }}"
                            >
                                Under 5,000
                            </a>
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['min_price' => ($is5to10k ? null : 5000), 'max_price' => ($is5to10k ? null : 10000), 'page' => 1]))) }}"
                                class="px-2.5 py-2 rounded-lg text-[11px] border text-center transition-all {{ $is5to10k ? 'bg-espresso-950 text-ivory border-espresso-950 font-bold shadow-xs' : 'border-ivory-300 bg-ivory-50 hover:bg-ivory-100 hover:border-gold-500 text-espresso-900 font-medium' }}"
                            >
                                5,000 – 10,000
                            </a>
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['min_price' => ($isAbove10k ? null : 10000), 'max_price' => null, 'page' => 1]))) }}"
                                class="col-span-2 px-2.5 py-2 rounded-lg text-[11px] border text-center transition-all {{ $isAbove10k ? 'bg-espresso-950 text-ivory border-espresso-950 font-bold shadow-xs' : 'border-ivory-300 bg-ivory-50 hover:bg-ivory-100 hover:border-gold-500 text-espresso-900 font-medium' }}"
                            >
                                Above 10,000 (Luxury)
                            </a>
                        </div>

                        <!-- Custom Price Range Inputs Form -->
                        <form method="GET" action="{{ route('shop') }}" class="space-y-2.5 pt-1">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            @if(request('tag'))
                                <input type="hidden" name="tag" value="{{ request('tag') }}">
                            @endif
                            @if(request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-[10px] uppercase text-muted block mb-1 font-sans">Min (PKR)</label>
                                    <input 
                                        type="number" 
                                        name="min_price"
                                        value="{{ request('min_price') }}" 
                                        placeholder="1,500" 
                                        class="w-full px-2.5 py-1.5 bg-ivory-50 border border-ivory-300 rounded-lg text-xs text-espresso-950 focus:outline-none focus:ring-1 focus:ring-gold-500 focus:bg-white"
                                    >
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase text-muted block mb-1 font-sans">Max (PKR)</label>
                                    <input 
                                        type="number" 
                                        name="max_price"
                                        value="{{ request('max_price') }}" 
                                        placeholder="25,000" 
                                        class="w-full px-2.5 py-1.5 bg-ivory-50 border border-ivory-300 rounded-lg text-xs text-espresso-950 focus:outline-none focus:ring-1 focus:ring-gold-500 focus:bg-white"
                                    >
                                </div>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full py-2 bg-espresso-950 hover:bg-gold-500 hover:text-espresso-950 text-ivory text-xs uppercase tracking-wider font-semibold rounded-lg transition-all duration-200 shadow-2xs"
                            >
                                Apply Price
                            </button>
                        </form>
                    </div>

                    <!-- Curated Highlights / Tag Filter -->
                    <div class="p-5 space-y-3">
                        <h3 class="text-xs uppercase tracking-wider font-sans font-bold text-espresso-950">
                            Curated Highlights
                        </h3>
                        <div class="flex flex-col gap-1.5 font-sans">
                            @php
                                $isBestseller = (request('tag') === 'bestseller');
                                $isNew = (request('tag') === 'new');
                            @endphp
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['tag' => ($isBestseller ? null : 'bestseller'), 'page' => 1]))) }}"
                                class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium border transition-all text-left {{ $isBestseller ? 'border-gold-600 bg-gold/15 font-bold text-espresso-950 shadow-2xs' : 'border-ivory-300 bg-ivory-50 text-espresso-800 hover:bg-ivory-100' }}"
                            >
                                <span class="flex items-center gap-2">
                                    <i data-lucide="award" class="w-3.5 h-3.5 text-gold-600"></i>
                                    <span>Bestsellers Only</span>
                                </span>
                                @if($isBestseller)
                                    <span class="text-gold-700 font-bold">✓</span>
                                @endif
                            </a>

                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['tag' => ($isNew ? null : 'new'), 'page' => 1]))) }}"
                                class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium border transition-all text-left {{ $isNew ? 'border-gold-600 bg-gold/15 font-bold text-espresso-950 shadow-2xs' : 'border-ivory-300 bg-ivory-50 text-espresso-800 hover:bg-ivory-100' }}"
                            >
                                <span class="flex items-center gap-2">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-gold-600"></i>
                                    <span>New Releases</span>
                                </span>
                                @if($isNew)
                                    <span class="text-gold-700 font-bold">✓</span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- Handcrafted Leather Guarantee Callout -->
                    <div class="p-4 bg-ivory-100/70 space-y-2">
                        <div class="flex items-center gap-2 text-gold-700 font-serif font-bold text-xs uppercase tracking-wider">
                            <i data-lucide="shield-check" class="w-4 h-4 text-gold-600"></i>
                            <span>Pure Hide Guarantee</span>
                        </div>
                        <p class="text-[11px] text-muted-dark leading-relaxed font-sans">
                            Every creation is hand-crafted with 100% genuine top-grade Pakistani hides.
                        </p>
                        <div class="pt-2 border-t border-ivory-300/80 flex items-center justify-between text-[10px] text-muted-dark font-sans font-medium">
                            <span class="flex items-center gap-1">
                                <i data-lucide="truck" class="w-3 h-3 text-gold-600"></i> Cash on Delivery
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="refresh-cw" class="w-3 h-3 text-gold-600"></i> 7-Day Returns
                            </span>
                        </div>
                    </div>

                </div>

            </aside>

            <!-- Product Grid Column & Pagination -->
            <div class="flex-1 w-full min-w-0">
                @if(count($products) > 0)
                    <!-- Product Grid (Responsive: 1 col on mobile, 2 cols on tablet, 3 cols on desktop) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-user.components.product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Luxury Pagination Bar (12 Products Per Page) -->
                    @if($products->hasPages())
                        <div class="mt-12 pt-8 border-t border-ivory-300 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Showing Info -->
                            <p class="text-xs text-muted-dark font-sans">
                                Showing <span class="font-bold text-espresso-950">{{ $products->firstItem() }}</span> to <span class="font-bold text-espresso-950">{{ $products->lastItem() }}</span> of <span class="font-bold text-espresso-950">{{ $products->total() }}</span> handcrafted creations
                            </p>

                            <!-- Page Navigation Controls -->
                            <nav class="flex items-center gap-1.5 font-sans" aria-label="Catalog Pagination">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <span class="px-3.5 py-2 rounded-lg border border-ivory-200 text-xs text-muted cursor-not-allowed bg-ivory-100 flex items-center gap-1 select-none">
                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                        <span class="hidden sm:inline font-medium">Prev</span>
                                    </span>
                                @else
                                    <a 
                                        href="{{ $products->previousPageUrl() }}" 
                                        class="px-3.5 py-2 rounded-lg border border-ivory-300 bg-white text-xs font-semibold text-espresso-950 hover:bg-gold-500 hover:text-espresso-950 hover:border-gold-500 transition-all duration-200 flex items-center gap-1 shadow-2xs"
                                    >
                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                        <span class="hidden sm:inline font-medium">Prev</span>
                                    </a>
                                @endif

                                {{-- Numbered Pages --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span class="w-9 h-9 rounded-lg bg-espresso-950 text-ivory text-xs font-bold flex items-center justify-center shadow-xs border border-espresso-950">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a 
                                            href="{{ $url }}" 
                                            class="w-9 h-9 rounded-lg border border-ivory-300 bg-white text-espresso-900 hover:bg-ivory-100 hover:text-gold-700 hover:border-gold-500 text-xs font-semibold flex items-center justify-center transition-colors shadow-2xs"
                                        >
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <a 
                                        href="{{ $products->nextPageUrl() }}" 
                                        class="px-3.5 py-2 rounded-lg border border-ivory-300 bg-white text-xs font-semibold text-espresso-950 hover:bg-gold-500 hover:text-espresso-950 hover:border-gold-500 transition-all duration-200 flex items-center gap-1 shadow-2xs"
                                    >
                                        <span class="hidden sm:inline font-medium">Next</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </a>
                                @else
                                    <span class="px-3.5 py-2 rounded-lg border border-ivory-200 text-xs text-muted cursor-not-allowed bg-ivory-100 flex items-center gap-1 select-none">
                                        <span class="hidden sm:inline font-medium">Next</span>
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    @endif

                @else
                    <!-- Refined Empty State -->
                    <div class="py-20 text-center bg-white rounded-2xl border border-ivory-300 p-8 shadow-xs">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-ivory-100 border border-ivory-300 flex items-center justify-center text-gold-600">
                            <i data-lucide="search-x" class="w-8 h-8"></i>
                        </div>
                        <h3 class="font-serif text-2xl font-bold text-espresso-950 mb-2">
                            No Matching Creations Found
                        </h3>
                        <p class="text-xs sm:text-sm text-muted-dark max-w-md mx-auto mb-6 leading-relaxed font-sans">
                            We could not find any products matching your active filters. Try broadening your price range or exploring all collections.
                        </p>
                        <a 
                            href="{{ route('shop') }}" 
                            class="inline-block px-6 py-2.5 bg-espresso-950 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg hover:bg-gold-500 hover:text-espresso-950 transition-colors shadow-xs"
                        >
                            Reset All Filters
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- Mobile Filter Slide-over Drawer -->
    <div 
        x-show="mobileFiltersOpen" 
        x-cloak 
        style="display: none;"
        class="fixed inset-0 z-50 overflow-hidden lg:hidden"
    >
        <div 
            @click="mobileFiltersOpen = false" 
            class="fixed inset-0 bg-espresso-950/60 backdrop-blur-xs transition-opacity"
        ></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-xs bg-white shadow-2xl flex flex-col justify-between p-6 overflow-y-auto">
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-ivory-200">
                        <div class="flex items-center gap-2">
                            <i data-lucide="sliders" class="w-4 h-4 text-gold-600"></i>
                            <h3 class="font-serif text-lg font-bold text-espresso-950 uppercase">Filter Catalog</h3>
                        </div>
                        <button type="button" @click="mobileFiltersOpen = false" class="p-1.5 text-muted hover:text-espresso-950 rounded-lg hover:bg-ivory-100">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Collections -->
                    <div>
                        <h4 class="font-sans text-xs uppercase tracking-wider font-bold text-espresso-950 mb-3">Collections</h4>
                        <div class="space-y-1.5 font-sans">
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['category' => null, 'page' => 1]))) }}"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs {{ $activeCategory === 'all' ? 'bg-espresso-950 text-ivory font-bold' : 'text-espresso-800 bg-ivory-100/70' }}"
                            >
                                <span>All Collections</span>
                                <span>{{ $totalAllCount ?? 20 }}</span>
                            </a>
                            @foreach($categories as $slug => $cat)
                                <a 
                                    href="{{ route('shop', array_filter(array_merge(request()->query(), ['category' => $slug, 'page' => 1]))) }}"
                                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs {{ $activeCategory === $slug ? 'bg-espresso-950 text-ivory font-bold' : 'text-espresso-800 bg-ivory-100/70' }}"
                                >
                                    <span>{{ $cat['name'] }}</span>
                                    <span>{{ $categoryCounts[$slug] ?? 4 }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <h4 class="font-sans text-xs uppercase tracking-wider font-bold text-espresso-950 mb-3">Price Range (PKR)</h4>
                        <form method="GET" action="{{ route('shop') }}" class="space-y-3 font-sans">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-[10px] text-muted block mb-1">Min (PKR)</label>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="1,500" class="w-full px-2.5 py-1.5 border border-ivory-300 rounded text-xs">
                                </div>
                                <div>
                                    <label class="text-[10px] text-muted block mb-1">Max (PKR)</label>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="25,000" class="w-full px-2.5 py-1.5 border border-ivory-300 rounded text-xs">
                                </div>
                            </div>
                            <button 
                                type="submit" 
                                class="w-full py-2.5 bg-espresso-950 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-sm hover:bg-gold-500 hover:text-espresso-950 transition-colors"
                            >
                                Apply Price
                            </button>
                        </form>
                    </div>

                    <!-- Tags -->
                    <div>
                        <h4 class="font-sans text-xs uppercase tracking-wider font-bold text-espresso-950 mb-3">Curated Badges</h4>
                        <div class="space-y-2 font-sans">
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['tag' => (request('tag') === 'bestseller' ? null : 'bestseller'), 'page' => 1]))) }}"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs border {{ request('tag') === 'bestseller' ? 'border-gold-600 bg-gold/15 font-bold' : 'border-ivory-300' }}"
                            >
                                <span>Bestsellers Only</span>
                                @if(request('tag') === 'bestseller')
                                    <span>✓</span>
                                @endif
                            </a>
                            <a 
                                href="{{ route('shop', array_filter(array_merge(request()->query(), ['tag' => (request('tag') === 'new' ? null : 'new'), 'page' => 1]))) }}"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs border {{ request('tag') === 'new' ? 'border-gold-600 bg-gold/15 font-bold' : 'border-ivory-300' }}"
                            >
                                <span>New Arrivals</span>
                                @if(request('tag') === 'new')
                                    <span>✓</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-6 border-t border-ivory-200">
                    <a 
                        href="{{ route('shop') }}" 
                        class="block text-center w-full py-2.5 bg-ivory-100 text-espresso-800 text-xs uppercase tracking-widest font-medium rounded-lg hover:bg-ivory-200 transition-colors"
                    >
                        Reset All Filters
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

