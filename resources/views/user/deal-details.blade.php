@extends('user.layouts.app')

@section('title', $deal->title . ' — Curated Leather Set | By Zunash Pakistan')
@section('meta_description', $deal->description ?: 'Exclusive luxury leather pairing handcrafted by Atelier By Zunash Pakistan. Enjoy bespoke bundle pricing and complimentary presentation gift packaging.')
@section('meta_keywords', $deal->title . ', leather deals Pakistan, luxury bundle By Zunash, leather gift sets Pakistan, cash on delivery leather bundle')
@section('canonical', route('deal.details', $deal->slug))
@section('og_type', 'product')
@section('og_image', str_starts_with($deal->image, 'http') ? $deal->image : asset($deal->image ?: 'images/brand/artisan-craft.jpg'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Product",
            "@id": "{{ route('deal.details', $deal->slug) }}/#deal",
            "name": "{{ addslashes($deal->title) }}",
            "image": [
                "{{ str_starts_with($deal->image, 'http') ? $deal->image : asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}"
                @foreach($deal->products as $dp)
                    ,"{{ str_starts_with($dp->image, 'http') ? $dp->image : asset($dp->image) }}"
                @endforeach
            ],
            "description": "{{ addslashes(strip_tags($deal->description ?: $deal->tagline)) }}",
            "sku": "BZ-DEAL-{{ str_pad($deal->id, 3, '0', STR_PAD_LEFT) }}",
            "brand": {
                "@type": "Brand",
                "name": "By Zunash"
            },
            "category": "{{ addslashes($deal->category_name) }}",
            "offers": {
                "@type": "Offer",
                "url": "{{ route('deal.details', $deal->slug) }}",
                "priceCurrency": "PKR",
                "price": "{{ $deal->deal_price }}",
                "priceValidUntil": "2027-12-31",
                "itemCondition": "https://schema.org/NewCondition",
                "availability": "https://schema.org/InStock",
                "seller": {
                    "@type": "Organization",
                    "name": "By Zunash"
                }
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.9",
                "reviewCount": "42",
                "bestRating": "5",
                "worstRating": "1"
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('deal.details', $deal->slug) }}/#breadcrumb",
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
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($deal->title) }}",
                    "item": "{{ route('deal.details', $deal->slug) }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')

<!-- ========================================================
     BREADCRUMB & ATELIER PATH
     ======================================================== -->
<nav class="bg-[#FAF8F5] dark:bg-[#14100E] border-b border-[#ECE6DE] dark:border-white/10 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center gap-2 text-xs text-[#8F8379] dark:text-[#A09387]">
            <li>
                <a href="{{ route('home') }}" class="hover:text-espresso-950 dark:hover:text-white transition-colors">Home</a>
            </li>
            <li><i data-lucide="chevron-right" class="w-3 h-3 text-[#B8ADA2]"></i></li>
            <li>
                <a href="{{ route('deals') }}" class="hover:text-espresso-950 dark:hover:text-white transition-colors">Curated Sets & Deals</a>
            </li>
            <li><i data-lucide="chevron-right" class="w-3 h-3 text-[#B8ADA2]"></i></li>
            <li class="text-espresso-950 dark:text-white font-medium truncate max-w-xs sm:max-w-md">
                {{ $deal->title }}
            </li>
        </ol>
    </div>
</nav>

<!-- ========================================================
     HERO: COMBINATION SHOWCASE & VALUE FRAMING
     ======================================================== -->
<section class="py-8 sm:py-12 bg-white dark:bg-[#0F0C0A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            <!-- Left: High-Class Single Combination Visual (7 Cols) -->
            <div class="lg:col-span-7 space-y-4" x-data="{ activeImg: '{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}' }">
                <!-- Main Combo Image -->
                <div class="relative w-full aspect-[4/3] sm:aspect-[16/10] rounded-2xl overflow-hidden bg-[#F7F5F0] dark:bg-[#181310] border border-ivory-300 dark:border-white/10 shadow-sm group">
                    <img 
                        :src="activeImg" 
                        alt="{{ $deal->title }}" 
                        class="w-full h-full object-cover object-center group-hover:scale-103 transition-transform duration-700 ease-out"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-60"></div>

                    <!-- Floating Discount Badge -->
                    <div class="absolute top-4 left-4 z-10 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-espresso-950/90 text-gold-300 text-xs font-bold uppercase tracking-wider backdrop-blur-xs border border-gold/40 shadow-sm">
                            {{ $deal->badge ?: 'Curated Set' }}
                        </span>
                        @if($deal->savings_amount > 0)
                            <span class="px-3 py-1 rounded-full bg-emerald-700/90 text-white text-xs font-bold backdrop-blur-xs shadow-sm">
                                SAVE {{ $deal->savings_percentage }}%
                            </span>
                        @endif
                    </div>

                    <!-- Gift Box Included Pill -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="px-3 py-1 rounded-full bg-black/70 backdrop-blur-xs text-white text-[11px] font-medium flex items-center gap-1.5 shadow-sm">
                            <i data-lucide="gift" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Gift Box Included</span>
                        </span>
                    </div>

                    <!-- Bottom Scarcity Tag -->
                    <div class="absolute bottom-4 left-4 right-4 z-10 flex items-center justify-between text-white text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="font-medium text-ivory-100">Atelier Curated Pairing • Handcrafted in Pakistan</span>
                        </div>
                        <span class="text-ivory-300 text-[11px] font-mono hidden sm:inline">{{ $deal->products->count() }} Pieces Included</span>
                    </div>
                </div>

                <!-- Mini Thumbnails Bar: Combo + Individual Products -->
                <div class="flex items-center gap-3 overflow-x-auto pb-1">
                    <!-- Main Combo Thumbnail -->
                    <button 
                        type="button" 
                        @click="activeImg = '{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}'"
                        :class="activeImg === '{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}' ? 'ring-2 ring-gold border-gold' : 'opacity-70 hover:opacity-100'"
                        class="w-20 h-16 rounded-xl overflow-hidden border border-ivory-300 dark:border-white/10 shrink-0 transition-all bg-[#FAF8F5] dark:bg-[#181310] relative text-left"
                    >
                        <img src="{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}" alt="Combination View" class="w-full h-full object-cover">
                        <span class="absolute bottom-0 inset-x-0 bg-black/70 text-[8px] text-white text-center py-0.5 font-bold uppercase">Combo</span>
                    </button>

                    <!-- Each Included Product Thumbnail -->
                    @foreach($deal->products as $item)
                        <button 
                            type="button" 
                            @click="activeImg = '{{ asset($item->image) }}'"
                            :class="activeImg === '{{ asset($item->image) }}' ? 'ring-2 ring-gold border-gold' : 'opacity-70 hover:opacity-100'"
                            class="w-20 h-16 rounded-xl overflow-hidden border border-ivory-300 dark:border-white/10 shrink-0 transition-all bg-[#FAF8F5] dark:bg-[#181310] relative text-left"
                        >
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            <span class="absolute bottom-0 inset-x-0 bg-black/70 text-[8px] text-white text-center py-0.5 truncate px-1">
                                {{ Str::limit($item->name, 10) }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Right: Set Details, Pricing, & Add to Cart Action (5 Cols) -->
            <div class="lg:col-span-5 flex flex-col justify-between space-y-6">

                <div>
                    <!-- Category & Subtitle -->
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-[11px] uppercase tracking-[0.2em] font-bold text-gold-700 dark:text-gold-400">
                            {{ $deal->category_name }}
                        </span>
                        <span class="text-[#B8ADA2]">•</span>
                        <span class="text-xs text-[#8F8379] dark:text-[#A09387]">
                            {{ $deal->products->count() }} Handcrafted Pieces
                        </span>
                    </div>

                    <!-- Deal Title -->
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white leading-tight mb-2">
                        {{ $deal->title }}
                    </h1>

                    @if($deal->tagline)
                        <p class="text-sm font-medium text-gold-700 dark:text-gold-400 mb-3">
                            {{ $deal->tagline }}
                        </p>
                    @endif

                    <!-- Atelier Ratings & Scarcity Note -->
                    <div class="flex items-center gap-3 py-2 border-y border-ivory-200 dark:border-white/10 mb-4 text-xs">
                        <div class="flex items-center gap-1 text-gold-600">
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                        </div>
                        <span class="font-semibold text-espresso-900 dark:text-white">4.9 / 5.0</span>
                        <span class="text-[#8F8379] dark:text-[#A09387]">(Atelier Verified Set)</span>
                    </div>

                    <!-- Deal Price Box (High-Impact Value Framing) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-[#FAF8F5] dark:bg-[#181310] border border-ivory-300 dark:border-white/10 mb-5">
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-[#8F8379] dark:text-[#A09387]">
                                Exclusive Curated Price
                            </span>
                            @if($deal->savings_amount > 0)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-[10px] font-bold">
                                    SAVE PKR {{ number_format($deal->savings_amount) }}
                                </span>
                            @endif
                        </div>

                        <div class="flex items-baseline gap-3">
                            <span class="font-serif text-3xl font-bold text-espresso-950 dark:text-white">
                                <span class="text-xs font-bold text-gold-600 mr-1">PKR</span>{{ number_format($deal->deal_price) }}
                            </span>
                            @if($deal->effective_original_price > $deal->deal_price)
                                <span class="text-sm sm:text-base text-[#8F8379] line-through font-sans">
                                    PKR {{ number_format($deal->effective_original_price) }}
                                </span>
                            @endif
                        </div>

                        <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-medium mt-1">
                            Save {{ $deal->savings_percentage }}% compared to purchasing each creation individually.
                        </p>
                    </div>

                    @if($deal->description)
                        <div class="text-xs sm:text-sm text-espresso-800/80 dark:text-ivory-300 leading-relaxed font-light mb-5">
                            {{ $deal->description }}
                        </div>
                    @endif

                    <!-- Included Pieces Quick Preview -->
                    <div class="space-y-2 mb-6">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-[#8F8379] dark:text-[#A09387] block">
                            Included in this Bundle:
                        </span>
                        <div class="grid grid-cols-1 gap-2">
                            @foreach($deal->products as $item)
                                <div class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-[#201A16] border border-ivory-200 dark:border-white/10 text-xs">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-8 h-8 rounded-lg overflow-hidden bg-[#FAF8F5] shrink-0 border border-ivory-200">
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-medium text-espresso-950 dark:text-white truncate">
                                            {{ $item->name }}
                                        </span>
                                    </div>
                                    <span class="text-[11px] font-mono text-[#8F8379] shrink-0">
                                        PKR {{ number_format($item->price) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Highlights Checklist -->
                    <div class="space-y-1.5 mb-6">
                        @foreach($deal->highlights_list as $bullet)
                            <div class="flex items-start gap-2 text-xs text-espresso-800 dark:text-ivory-200">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-gold-600 shrink-0 mt-0.5"></i>
                                <span>{{ $bullet }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-4 border-t border-ivory-200 dark:border-white/10 space-y-3">
                    <button 
                        type="button" 
                        @click="addDealToCart(@js($deal))" 
                        class="w-full py-3.5 px-6 rounded-xl bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 font-serif text-sm font-bold uppercase tracking-wider transition-all duration-200 shadow-md flex items-center justify-center gap-2 active:scale-98"
                    >
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-gold"></i>
                        <span>Add Entire Set to Bag (PKR {{ number_format($deal->deal_price) }})</span>
                    </button>

                    <!-- WhatsApp Quick Order (High Converting for Pakistani Ad Traffic) -->
                    <a 
                        href="https://wa.me/923214700545?text={{ urlencode('Hello By Zunash! I want to order the Curated Deal: ' . $deal->title . ' (PKR ' . number_format($deal->deal_price) . '). Link: ' . url()->current() . ' — My delivery city is: ') }}" 
                        target="_blank"
                        rel="noopener"
                        class="w-full h-11 px-4 bg-[#25D366] hover:bg-[#20BD5A] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 active:scale-[0.98]"
                    >
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Order via WhatsApp (Doorstep COD)</span>
                    </a>

                    <!-- Doorstep Inspection & Authenticity Guarantee -->
                    <div class="p-3.5 rounded-xl bg-ivory-100/90 dark:bg-white/5 border border-gold/40 text-xs space-y-1">
                        <div class="flex items-center gap-2 font-bold text-espresso-950 dark:text-white">
                            <i data-lucide="shield-check" class="w-4 h-4 text-gold-600"></i>
                            <span>100% Full-Grain Hide • Open Parcel Inspection</span>
                        </div>
                        <p class="text-[11px] text-[#8F8379] dark:text-[#A09387] leading-relaxed">
                            Open and inspect both leather creations at your doorstep before handing payment to the rider. Cash on Delivery supported nationwide.
                        </p>
                    </div>

                    <div class="flex items-center justify-center gap-4 text-[11px] text-[#8F8379] dark:text-[#A09387] pt-1">
                        <span class="flex items-center gap-1">
                            <i data-lucide="truck" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Free Express Delivery</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold"></i>
                            <span>30-Day Exchange</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="package" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Rigid Presentation Box</span>
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     DETAILED CREATIONS BREAKDOWN: EACH PRODUCT IN DETAIL
     ======================================================== -->
<section class="py-12 bg-[#FAF8F5] dark:bg-[#14100E] border-t border-b border-[#ECE6DE] dark:border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-[10px] uppercase tracking-[0.25em] font-semibold text-gold-700 dark:text-gold-400 block mb-1">
                Full Transparency & Craftsmanship
            </span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                What’s In This Curated Set
            </h2>
            <p class="text-xs sm:text-sm text-espresso-800/75 dark:text-ivory-300 font-light mt-2">
                Every piece in this bundle is handcrafted individually by master artisans using premium full-grain leather. Explore the specifications of each included creation below.
            </p>
        </div>

        <div class="space-y-8">
            @foreach($deal->products as $index => $product)
                <div class="bg-white dark:bg-[#1A1513] rounded-2xl border border-ivory-300 dark:border-white/10 p-6 sm:p-8 shadow-xs">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                        <!-- Product Thumbnail & Gallery -->
                        <div class="lg:col-span-4 space-y-3">
                            <div class="aspect-square rounded-xl overflow-hidden bg-[#FAF8F5] dark:bg-[#120E0C] border border-ivory-200 dark:border-white/10">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="text-center">
                                <a 
                                    href="{{ route('product.details', $product->slug) }}" 
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-gold-700 dark:text-gold-400 hover:text-gold-600 transition-colors"
                                >
                                    <span>View Single Product Page</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Product Specs & Features -->
                        <div class="lg:col-span-8 space-y-4">

                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-ivory-200 dark:border-white/10 pb-3">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-gold-400/20 text-gold-800 dark:text-gold-300">
                                            Piece #{{ $index + 1 }} • {{ $product->category_name }}
                                        </span>
                                        @if($product->is_bestseller)
                                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-espresso-950 text-white">
                                                Bestseller
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-espresso-950 dark:text-white mt-1">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="text-right">
                                    <span class="text-[10px] uppercase tracking-wider text-[#8F8379] block">Individual Value</span>
                                    <span class="font-serif text-lg font-bold text-espresso-950 dark:text-white">
                                        PKR {{ number_format($product->price) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Rating & Reviews -->
                            <div class="flex items-center gap-2 text-xs">
                                <div class="flex items-center text-gold-600">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                    <span class="font-bold ml-1 text-espresso-950 dark:text-white">{{ $product->rating ?? 4.9 }}</span>
                                </div>
                                <span class="text-[#8F8379]">•</span>
                                <span class="text-[#8F8379] dark:text-[#A09387]">({{ $product->reviews_count ?? 30 }} Verified Artisan Reviews)</span>
                                <span class="text-[#8F8379]">•</span>
                                <span class="text-emerald-700 dark:text-emerald-400 font-medium">In Stock</span>
                            </div>

                            <!-- Description -->
                            <p class="text-xs sm:text-sm text-espresso-800/80 dark:text-ivory-300 leading-relaxed font-light">
                                {{ $product->description ?: $product->short_description }}
                            </p>

                            <!-- Key Specifications Grid -->
                            @if(!empty($product->specifications))
                                <div class="p-3.5 rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-ivory-200 dark:border-white/10">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] dark:text-[#A09387] block mb-2">
                                        Material & Atelier Specifications:
                                    </span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                        @foreach($product->specifications as $specKey => $specVal)
                                            <div class="flex items-baseline justify-between py-0.5 border-b border-ivory-200/50 dark:border-white/5">
                                                <span class="text-[#8F8379] font-medium">{{ $specKey }}:</span>
                                                <span class="text-espresso-900 dark:text-ivory-100 font-semibold">{{ $specVal }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Key Features -->
                            @if(!empty($product->features))
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] dark:text-[#A09387] block mb-1.5">
                                        Craftsmanship Highlights:
                                    </span>
                                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 text-xs text-espresso-800/80 dark:text-ivory-300">
                                        @foreach($product->features as $feature)
                                            <li class="flex items-center gap-1.5">
                                                <i data-lucide="check" class="w-3.5 h-3.5 text-gold-600 shrink-0"></i>
                                                <span>{{ $feature }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ========================================================
     MORE CURATED SETS & DEALS
     ======================================================== -->
@if(!empty($otherDeals) && count($otherDeals) > 0)
<section class="py-12 bg-white dark:bg-[#0F0C0A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-gold-700 dark:text-gold-400 block mb-1">
                    Explore More Pairings
                </span>
                <h3 class="font-serif text-xl sm:text-2xl font-bold text-espresso-950 dark:text-white">
                    Complementary Atelier Sets
                </h3>
            </div>
            <a href="{{ route('deals') }}" class="text-xs font-semibold text-espresso-900 dark:text-ivory hover:text-gold-600 transition-colors flex items-center gap-1">
                <span>View All Deals</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach($otherDeals as $other)
                <div class="group bg-white dark:bg-[#181310] rounded-xl border border-ivory-300 dark:border-white/10 shadow-xs hover:shadow-md transition-all overflow-hidden flex flex-col">
                    <div class="relative w-full h-44 bg-[#F7F5F0] overflow-hidden">
                        <img src="{{ asset($other->image ?: 'images/brand/artisan-craft.jpg') }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-104 transition-transform duration-500">
                        <div class="absolute top-2.5 left-2.5 z-10">
                            <span class="px-2 py-0.5 rounded bg-espresso-950/90 text-gold-300 text-[10px] font-bold uppercase tracking-wider border border-gold/30">
                                {{ $other->badge ?: 'Curated Set' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1 justify-between">
                        <div>
                            <span class="text-[10px] font-semibold uppercase text-gold-700 block mb-0.5">{{ $other->tagline }}</span>
                            <h4 class="font-serif text-base font-bold text-espresso-950 dark:text-white truncate mb-1">
                                {{ $other->title }}
                            </h4>
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="font-serif text-base font-bold text-espresso-950 dark:text-white">
                                    PKR {{ number_format($other->deal_price) }}
                                </span>
                                @if($other->effective_original_price > $other->deal_price)
                                    <span class="text-xs text-[#8F8379] line-through">
                                        PKR {{ number_format($other->effective_original_price) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-ivory-200">
                            <a href="{{ route('deal.details', $other->slug) }}" class="px-3 py-1.5 rounded-lg border border-ivory-300 text-center text-xs font-semibold text-espresso-900 hover:bg-[#FAF8F5]">
                                Details
                            </a>
                            <button type="button" @click="addDealToCart(@js($other))" class="px-3 py-1.5 rounded-lg bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 text-center text-xs font-semibold">
                                Add Set
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- STICKY MOBILE CONVERSION BAR FOR CURATED DEAL -->
<div 
    x-data="{ showStickyDealBar: false }"
    @scroll.window="showStickyDealBar = (window.pageYOffset > 450)"
    x-show="showStickyDealBar"
    x-cloak
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    class="sm:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 dark:bg-[#181310]/95 backdrop-blur-md border-t border-ivory-300 dark:border-white/10 p-3 shadow-2xl"
>
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-11 h-11 rounded-lg overflow-hidden bg-ivory-100 shrink-0 border border-ivory-200">
                <img src="{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}" alt="{{ $deal->title }}" class="w-full h-full object-cover">
            </div>
            <div class="min-w-0">
                <span class="text-xs font-bold text-espresso-950 dark:text-white truncate block">
                    {{ $deal->title }}
                </span>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-serif text-sm font-bold text-espresso-950 dark:text-gold-400">
                        PKR {{ number_format($deal->deal_price) }}
                    </span>
                    @if($deal->effective_original_price > $deal->deal_price)
                        <span class="text-[10px] text-muted-light line-through">
                            {{ number_format($deal->effective_original_price) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <button 
            type="button" 
            @click="addDealToCart(@js($deal))" 
            class="px-4 py-2.5 rounded-xl bg-gold text-espresso-950 text-xs font-bold uppercase tracking-wider shadow-sm active:scale-95 flex items-center gap-1.5 shrink-0"
        >
            <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
            <span>Add Set</span>
        </button>
    </div>
</div>

<!-- ========================================================
     SCRIPT: CART STORE INTEGRATION
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
