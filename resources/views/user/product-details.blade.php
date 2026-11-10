@extends('user.layouts.app')

@section('title', $product['name'] . ' | Luxury Leather Pakistan | By Zunash')
@section('meta_description', $product['short_description'] . ' Handcrafted pure full-grain leather ' . $product['name'] . '. Nationwide Cash on Delivery across Pakistan.')
@section('meta_keywords', $product['name'] . ', ' . $product['category_name'] . ', pure leather Pakistan, full grain leather ' . $product['category'] . ', By Zunash, Cash on Delivery')
@section('canonical', route('product.details', $product['slug']))
@section('og_type', 'product')
@section('og_image', $product['image'])

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Product",
            "@id": "{{ route('product.details', $product['slug']) }}/#product",
            "name": "{{ addslashes($product['name']) }}",
            "image": [
                "{{ $product['image'] }}"
                @if(!empty($product['gallery']))
                    @foreach($product['gallery'] as $img)
                        ,"{{ $img }}"
                    @endforeach
                @endif
            ],
            "description": "{{ addslashes(strip_tags($product['description'] ?? $product['short_description'])) }}",
            "sku": "BZ-{{ str_pad($product['id'], 4, '0', STR_PAD_LEFT) }}",
            "mpn": "BZ-{{ $product['id'] }}",
            "brand": {
                "@type": "Brand",
                "name": "By Zunash"
            },
            "category": "{{ addslashes($product['category_name']) }}",
            "offers": {
                "@type": "Offer",
                "url": "{{ route('product.details', $product['slug']) }}",
                "priceCurrency": "PKR",
                "price": "{{ $product['price'] }}",
                "priceValidUntil": "2027-12-31",
                "itemCondition": "https://schema.org/NewCondition",
                "availability": "{{ (($product['availability'] ?? '') === 'out_of_stock' || (isset($product['in_stock']) && !$product['in_stock'])) ? 'https://schema.org/OutOfStock' : ((($product['availability'] ?? '') === 'on_demand') ? 'https://schema.org/PreOrder' : 'https://schema.org/InStock') }}",
                "seller": {
                    "@type": "Organization",
                    "name": "By Zunash"
                }
            },
            @if(($product['reviews_count'] ?? 0) > 0)
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ $product['rating'] }}",
                "reviewCount": "{{ $product['reviews_count'] }}",
                "bestRating": "5",
                "worstRating": "1"
            },
            @endif
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('product.details', $product['slug']) }}/#breadcrumb",
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
                    "name": "{{ addslashes($product['category_name']) }}",
                    "item": "{{ route('category', $product['category']) }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($product['name']) }}",
                    "item": "{{ route('product.details', $product['slug']) }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
@php
    $isOutOfStock = (($product['availability'] ?? '') === 'out_of_stock' || (isset($product['in_stock']) && !$product['in_stock']));
    $isOnDemand = (($product['availability'] ?? '') === 'on_demand');

    $productJson = json_encode([
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'original_price' => $product['original_price'] ?? null,
        'image' => $product['image'],
        'category' => $product['category'],
        'category_name' => $product['category_name'] ?? '',
        'slug' => $product['slug'],
        'colors' => $product['colors'] ?? [],
        'availability' => $product['availability'] ?? ($isOutOfStock ? 'out_of_stock' : ($isOnDemand ? 'on_demand' : 'in_stock')),
        'in_stock' => !$isOutOfStock,
        'lead_time' => $product['lead_time'] ?? null
    ]);

    $beltSizes = ['30', '32', '34', '36', '38', '40', '42'];
    $isBelt = ($product['category'] === 'belts');
@endphp

<div 
    x-data="{ 
        product: {{ $productJson }},
        activeImage: '{{ $product['image'] }}',
        activeImageIndex: 0,
        gallery: {{ json_encode($product['gallery'] ?? [$product['image']]) }},
        selectedColor: '{{ !empty($product['colors']) ? $product['colors'][0]['name'] : '' }}',
        selectedSize: '{{ $isBelt ? '34' : '' }}',
        sizeGuideOpen: false,
        quantity: 1,
        activeTab: 'specifications',
        isZoomed: false,
        zoomX: 50,
        zoomY: 50,
        lightboxOpen: false,
        touchStartX: 0,
        touchEndX: 0,
        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
        },
        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].screenX;
            if (this.touchStartX - this.touchEndX > 40) {
                this.nextImage();
            } else if (this.touchEndX - this.touchStartX > 40) {
                this.prevImage();
            }
        },
        handleMouseMove(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            this.zoomX = Math.max(0, Math.min(100, x));
            this.zoomY = Math.max(0, Math.min(100, y));
        },
        setActiveImage(url, index) {
            this.activeImage = url;
            this.activeImageIndex = index;
        },
        nextImage() {
            this.activeImageIndex = (this.activeImageIndex + 1) % this.gallery.length;
            this.activeImage = this.gallery[this.activeImageIndex];
        },
        prevImage() {
            this.activeImageIndex = (this.activeImageIndex - 1 + this.gallery.length) % this.gallery.length;
            this.activeImage = this.gallery[this.activeImageIndex];
        },
        getVariantLabel() {
            const parts = [];
            if (this.selectedColor) parts.push(this.selectedColor);
            if (this.selectedSize) parts.push('Size ' + this.selectedSize + (this.product.category === 'belts' ? '″' : ''));
            return parts.length ? parts.join(' • ') : null;
        },
        addToCart() {
            $store.cart.addItem(this.product, this.getVariantLabel(), this.quantity, true);
        },
        buyNow() {
            $store.cart.addItem(this.product, this.getVariantLabel(), this.quantity);
            window.location.href = '{{ route('checkout') }}';
        }
    }" 
    @keydown.escape.window="lightboxOpen = false; sizeGuideOpen = false"
    @keydown.arrow-right.window="if (lightboxOpen) nextImage()"
    @keydown.arrow-left.window="if (lightboxOpen) prevImage()"
    class="bg-white min-h-screen py-6 sm:py-8 lg:py-10"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-muted mb-6 uppercase tracking-widest font-serif">
            <a href="{{ route('home') }}" class="hover:text-gold-600 transition-colors">Home</a>
            <span class="text-ivory-400">/</span>
            <a href="{{ route('category', $product['category']) }}" class="hover:text-gold-600 transition-colors">{{ $product['category_name'] }}</a>
            <span class="text-ivory-400">/</span>
            <span class="text-espresso-950 font-semibold truncate">{{ $product['name'] }}</span>
        </nav>

        <!-- Product Presentation Grid: Balanced 6/6 split with compact image -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Gallery Section (Left 6 Cols) - Sticky & Compact -->
            <div class="lg:col-span-6 space-y-4 lg:sticky lg:top-24 lg:self-start">
                
                <!-- Main Product Photo Viewport (Touch Swipeable on Mobile) -->
                <div 
                    class="relative aspect-[4/3.8] max-h-[460px] sm:max-h-[500px] w-full rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300/80 shadow-luxury group select-none cursor-crosshair transition-all"
                    @mouseenter="isZoomed = true"
                    @mouseleave="isZoomed = false"
                    @mousemove="handleMouseMove($event)"
                    @touchstart.passive="handleTouchStart($event)"
                    @touchend.passive="handleTouchEnd($event)"
                    @click="lightboxOpen = true"
                >
                    <img 
                        :src="activeImage" 
                        alt="{{ $product['name'] }}" 
                        class="w-full h-full object-cover object-center transition-transform duration-150 ease-out will-change-transform"
                        :style="isZoomed ? `transform-origin: ${zoomX}% ${zoomY}%; transform: scale(2.2);` : 'transform-origin: center center; transform: scale(1);'"
                    >

                    <!-- Product Badge -->
                    @if(!empty($product['badge']))
                        <div class="absolute top-4 left-4 z-10 pointer-events-none">
                            <x-user.components.product-badge :badge="$product['badge']" />
                        </div>
                    @endif

                    <!-- Expand / Fullscreen Lightbox Button -->
                    <button 
                        type="button"
                        @click.stop="lightboxOpen = true"
                        class="absolute top-4 right-4 z-10 p-2.5 rounded-full bg-white/90 backdrop-blur-md text-espresso-900 border border-ivory-300 shadow-sm hover:bg-white hover:text-gold-600 transition-all transform hover:scale-110 focus:outline-none"
                        title="View Fullscreen"
                        aria-label="Expand image"
                    >
                        <i data-lucide="maximize-2" class="w-4 h-4"></i>
                    </button>

                    <!-- Interactive Zoom Guide Indicator Pill -->
                    <div class="absolute bottom-4 right-4 z-10 pointer-events-none flex items-center gap-2 px-3 py-1.5 rounded-full bg-espresso-950/75 backdrop-blur-md border border-white/15 text-white text-[11px] font-medium tracking-wide shadow-md">
                        <i data-lucide="zoom-in" class="w-3.5 h-3.5 text-gold"></i>
                        <span x-text="isZoomed ? 'Inspecting Grain (2.2x)' : 'Hover to Inspect Grain'"></span>
                    </div>

                    <!-- Slide Position Indicator -->
                    <div class="absolute bottom-4 left-4 z-10 pointer-events-none px-3 py-1 rounded-full bg-white/90 backdrop-blur-md border border-ivory-300 text-espresso-950 text-xs font-serif font-bold tracking-wider shadow-sm">
                        <span x-text="(activeImageIndex + 1) + ' / ' + gallery.length"></span>
                    </div>
                </div>

                <!-- Mobile Swiper Pagination Dots -->
                @if(!empty($product['gallery']) && count($product['gallery']) > 1)
                    <div class="flex sm:hidden items-center justify-center gap-1.5 pt-1">
                        @foreach($product['gallery'] as $idx => $img)
                            <button 
                                type="button" 
                                @click="setActiveImage('{{ $img }}', {{ $idx }})"
                                class="h-1.5 rounded-full transition-all duration-300"
                                :class="activeImageIndex === {{ $idx }} ? 'w-6 bg-gold' : 'w-1.5 bg-ivory-300'"
                                aria-label="Go to slide {{ $idx + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                @endif

                <!-- Sleek Minimalist Thumbnails Strip (No ugly badge numbers) -->
                @if(!empty($product['gallery']) && count($product['gallery']) > 1)
                    <div class="flex items-center gap-3 overflow-x-auto pb-1 pt-1 scrollbar-none">
                        @foreach($product['gallery'] as $idx => $img)
                            <button 
                                type="button" 
                                @click="setActiveImage('{{ $img }}', {{ $idx }})" 
                                class="relative w-20 sm:w-22 h-20 sm:h-22 rounded-xl overflow-hidden border-2 flex-shrink-0 transition-all duration-200 focus:outline-none group/thumb bg-ivory-100"
                                :class="activeImage === '{{ $img }}' ? 'border-gold shadow-md ring-2 ring-gold/30 scale-[1.03]' : 'border-ivory-300 opacity-60 hover:opacity-100 hover:border-gold/50'"
                            >
                                <img src="{{ $img }}" alt="{{ $product['name'] }} Angle {{ $idx + 1 }}" class="w-full h-full object-cover group-hover/thumb:scale-105 transition-transform duration-300">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Action Details (Right 6 Cols) -->
            <div class="lg:col-span-6 space-y-6">
                
                <!-- Category & SKU Header -->
                <div>
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">
                            {{ $product['category_name'] }} • Pure Full-Grain
                        </span>
                        <span class="text-[11px] font-mono text-muted uppercase tracking-wider bg-ivory-100 px-2 py-0.5 rounded border border-ivory-200">
                            SKU: BZ-{{ str_pad($product['id'], 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="font-serif text-2xl sm:text-3xl lg:text-[34px] font-bold text-espresso-950 leading-tight">
                        {{ $product['name'] }}
                    </h1>
                </div>

                <!-- Rating, Client Reviews & Stock Status -->
                <div class="flex flex-wrap items-center gap-3 pt-1">
                    @if(($product['reviews_count'] ?? 0) > 0)
                        <div class="flex items-center gap-1.5 text-gold">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 {{ $i < round($product['rating'] ?? 5) ? 'fill-gold text-gold' : 'text-ivory-300' }}"></i>
                            @endfor
                            <span class="text-xs font-bold text-espresso-900 ml-1">{{ $product['rating'] }}</span>
                        </div>
                        <span class="text-ivory-400">•</span>
                        <a href="{{ route('reviews') }}" class="text-xs text-muted hover:text-gold-700 underline underline-offset-2 transition-colors">({{ $product['reviews_count'] }} {{ Str::plural('client review', $product['reviews_count']) }})</a>
                    @else
                        <div class="flex items-center gap-1 text-ivory-300">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="w-3.5 h-3.5"></i>
                            @endfor
                        </div>
                        <a href="{{ route('reviews') }}" class="text-xs text-muted hover:text-gold-700 transition-colors">No reviews yet — <span class="text-gold-700 underline">Leave a review</span></a>
                    @endif
                    <span class="text-ivory-400">•</span>
                    <!-- Stock Status Badge -->
                    @if($isOutOfStock)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-800 bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                            Out of Stock — Restock In Progress
                        </span>
                    @elseif($isOnDemand)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-900 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                            On Demand — Handcrafted Upon Order ({{ $product['lead_time'] ?? '7–10 Working Days' }})
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/70">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                            In Stock — Dispatched in 24 Hours
                        </span>
                    @endif
                </div>

                <!-- Price & Savings Card -->
                <div class="p-4 sm:p-5 rounded-2xl bg-ivory-50/70 border border-ivory-300">
                    <div class="flex items-baseline flex-wrap gap-3">
                        <span class="font-serif text-3xl sm:text-4xl font-bold text-espresso-950">
                            PKR {{ number_format($product['price']) }}
                        </span>
                        @if(!empty($product['original_price']) && $product['original_price'] > $product['price'])
                            <span class="text-base text-muted-light line-through font-sans">
                                PKR {{ number_format($product['original_price']) }}
                            </span>
                            @php
                                $savings = $product['original_price'] - $product['price'];
                                $pct = round(($savings / $product['original_price']) * 100);
                            @endphp
                            <span class="text-xs px-2.5 py-1 bg-gold/20 text-chocolate-900 rounded-full font-bold uppercase tracking-wider">
                                Save PKR {{ number_format($savings) }} ({{ $pct }}% OFF)
                            </span>
                        @endif
                    </div>
                    @if($isOutOfStock)
                        <p class="text-xs text-rose-800 mt-2 flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-rose-600"></i>
                            <span>Temporarily sold out. Leave your inquiry below for priority restock notification.</span>
                        </p>
                    @elseif($isOnDemand)
                        <p class="text-xs text-amber-900 mt-2 flex items-center gap-1.5">
                            <i data-lucide="gem" class="w-3.5 h-3.5 text-amber-600"></i>
                            <span>Bespoke artisan production. Handcrafted upon client commission ({{ $product['lead_time'] ?? '7–10 working days' }}).</span>
                        </p>
                    @else
                        <p class="text-xs text-muted mt-2 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold-600"></i>
                            <span>Includes all duties & packaging. Cash on Delivery supported across Pakistan.</span>
                        </p>
                    @endif
                </div>

                <!-- Short Narrative Summary -->
                <p class="text-sm text-espresso-800 leading-relaxed font-light">
                    {{ $product['short_description'] }}
                </p>

                <!-- VARIATION 1: Belt Size Selector (Interactive with Size Guide) -->
                @if($isBelt)
                    <div class="pt-2 border-t border-ivory-200">
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="text-xs uppercase tracking-wider font-bold text-espresso-900">
                                Belt Size: <span class="text-gold-700 font-bold" x-text="selectedSize + ' INCHES'"></span>
                            </label>
                            <button 
                                type="button" 
                                @click="sizeGuideOpen = true"
                                class="inline-flex items-center gap-1 text-xs text-gold-700 hover:text-espresso-950 font-semibold underline underline-offset-4 transition-colors"
                            >
                                <i data-lucide="ruler" class="w-3.5 h-3.5"></i>
                                <span>Size Guide</span>
                            </button>
                        </div>

                        <!-- Size Pills Grid -->
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                            @foreach($beltSizes as $sz)
                                <button 
                                    type="button" 
                                    @click="selectedSize = '{{ $sz }}'"
                                    class="py-2.5 px-3 rounded-xl border text-xs font-semibold tracking-wider transition-all duration-200 focus:outline-none flex flex-col items-center justify-center gap-0.5"
                                    :class="selectedSize === '{{ $sz }}' 
                                        ? 'bg-espresso-950 text-ivory border-espresso-950 shadow-md ring-2 ring-gold/40 scale-[1.02]' 
                                        : 'bg-white text-espresso-900 border-ivory-300 hover:border-gold hover:bg-ivory-50'"
                                >
                                    <span>{{ $sz }}″</span>
                                    <span class="text-[9px] opacity-75 font-normal uppercase tracking-tight">Waist {{ (int)$sz - 2 }}″</span>
                                </button>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-muted mt-2 italic">
                            Fitting Rule: Select 2 inches larger than your tailored trouser waist size.
                        </p>
                    </div>
                @else
                    <!-- Non-belt Silhouette / Dimension Pill -->
                    <div class="pt-2 border-t border-ivory-200">
                        <div class="flex items-center justify-between text-xs text-espresso-900 mb-1">
                            <span class="uppercase tracking-wider font-bold">Standard Silhouette:</span>
                            <span class="text-muted font-mono">{{ $product['specifications']['Dimensions'] ?? 'Tailored Proportion' }}</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-ivory-100 border border-ivory-300 text-xs text-espresso-900 font-medium">
                            <i data-lucide="check" class="w-3.5 h-3.5 text-gold-600"></i>
                            <span>One Size • Universal Master Cut</span>
                        </div>
                    </div>
                @endif

                <!-- VARIATION 2: Color / Leather Tone Selection -->
                @if(!empty($product['colors']))
                    <div class="pt-2 border-t border-ivory-200">
                        <label class="block text-xs uppercase tracking-wider font-bold text-espresso-900 mb-2.5">
                            Leather Tone: <span class="text-gold-700 font-semibold" x-text="selectedColor"></span>
                        </label>
                        <div class="flex items-center gap-3">
                            @foreach($product['colors'] as $c)
                                <button 
                                    type="button" 
                                    @click="selectedColor = '{{ $c['name'] }}'"
                                    class="group/swatch relative p-1 rounded-full border-2 transition-all duration-200 focus:outline-none flex items-center justify-center"
                                    :class="selectedColor === '{{ $c['name'] }}' ? 'border-gold shadow-md ring-2 ring-gold/30 scale-110' : 'border-transparent hover:border-ivory-300'"
                                    title="{{ $c['name'] }}"
                                >
                                    <span 
                                        class="block w-8 h-8 rounded-full border border-black/25 shadow-inner transition-transform relative flex items-center justify-center" 
                                        style="background-color: {{ $c['hex'] }};"
                                    >
                                        <!-- Active Selected Checkmark -->
                                        <template x-if="selectedColor === '{{ $c['name'] }}'">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-white drop-shadow-md"></i>
                                        </template>
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quantity, Add to Bag, Buy Now Buttons -->
                <div class="space-y-3.5 pt-2 border-t border-ivory-200">
                    @if($isOutOfStock)
                        <!-- Out of Stock Controls -->
                        <div class="flex items-center gap-3 sm:gap-4">
                            <!-- Disabled Tactile Quantity Stepper -->
                            <div class="flex items-center border border-ivory-200 rounded-xl overflow-hidden bg-ivory-100 h-12 flex-shrink-0 opacity-60 cursor-not-allowed">
                                <span class="w-10 h-full flex items-center justify-center text-zinc-400">
                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                </span>
                                <span class="w-11 text-center font-bold text-sm text-zinc-400">0</span>
                                <span class="w-10 h-full flex items-center justify-center text-zinc-400">
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>

                            <!-- Sold Out Button -->
                            <button 
                                type="button" 
                                disabled 
                                class="flex-1 h-12 px-5 sm:px-6 bg-zinc-200 text-zinc-500 text-xs uppercase tracking-widest font-semibold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-zinc-300 select-none"
                            >
                                <i data-lucide="slash" class="w-4 h-4"></i>
                                <span>Sold Out / Out of Stock</span>
                            </button>

                            <!-- Wishlist Toggle Button (Still active so clients can save it!) -->
                            <button 
                                type="button" 
                                @click="$store.wishlist.toggle(product)" 
                                class="w-12 h-12 rounded-xl border border-ivory-300 flex items-center justify-center text-espresso-900 hover:border-gold hover:bg-ivory-50 transition-all focus:outline-none flex-shrink-0"
                                :class="$store.wishlist.has(product.id) ? 'border-chocolate-700 bg-ivory-100' : ''"
                                aria-label="Toggle wishlist"
                            >
                                <i 
                                    data-lucide="heart" 
                                    class="w-5 h-5 transition-all" 
                                    :class="$store.wishlist.has(product.id) ? 'fill-chocolate-700 text-chocolate-700 scale-110' : 'text-espresso-800 hover:text-gold-600'"
                                ></i>
                            </button>
                        </div>

                        <!-- Notify Me When Back in Stock / Concierge -->
                        <a 
                            href="{{ route('contact', ['subject' => 'Restock Inquiry: ' . $product['name']]) }}" 
                            class="w-full h-12 px-6 bg-espresso-950 hover:bg-gold-600 text-ivory hover:text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center justify-center gap-2.5"
                        >
                            <i data-lucide="bell" class="w-4 h-4 text-gold"></i>
                            <span>Notify Me When Back in Stock (Concierge)</span>
                        </a>

                    @elseif($isOnDemand)
                        <!-- On Demand Controls -->
                        <div class="flex items-center gap-3 sm:gap-4">
                            <!-- Tactile Quantity Stepper -->
                            <div class="flex items-center border border-ivory-300 rounded-xl overflow-hidden bg-ivory-50 h-12 flex-shrink-0">
                                <button 
                                    type="button" 
                                    @click="if(quantity > 1) quantity--" 
                                    class="w-10 h-full flex items-center justify-center text-espresso-900 hover:bg-ivory-200 transition-colors focus:outline-none"
                                    aria-label="Decrease quantity"
                                >
                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="w-11 text-center font-bold text-sm text-espresso-900" x-text="quantity"></span>
                                <button 
                                    type="button" 
                                    @click="quantity++" 
                                    class="w-10 h-full flex items-center justify-center text-espresso-900 hover:bg-ivory-200 transition-colors focus:outline-none"
                                    aria-label="Increase quantity"
                                >
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>

                            <!-- Pre-Order on Demand Button -->
                            <button 
                                type="button" 
                                @click="addToCart()" 
                                class="flex-1 h-12 px-5 sm:px-6 bg-amber-950 hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 border border-gold/40 active:scale-[0.98] group/btn"
                            >
                                <i data-lucide="hammer" class="w-4 h-4 text-gold group-hover/btn:scale-110 transition-transform"></i>
                                <span>Pre-Order On Demand</span>
                            </button>

                            <!-- Wishlist Toggle Button -->
                            <button 
                                type="button" 
                                @click="$store.wishlist.toggle(product)" 
                                class="w-12 h-12 rounded-xl border border-ivory-300 flex items-center justify-center text-espresso-900 hover:border-gold hover:bg-ivory-50 transition-all focus:outline-none flex-shrink-0"
                                :class="$store.wishlist.has(product.id) ? 'border-chocolate-700 bg-ivory-100' : ''"
                                aria-label="Toggle wishlist"
                            >
                                <i 
                                    data-lucide="heart" 
                                    class="w-5 h-5 transition-all" 
                                    :class="$store.wishlist.has(product.id) ? 'fill-chocolate-700 text-chocolate-700 scale-110' : 'text-espresso-800 hover:text-gold-600'"
                                ></i>
                            </button>
                        </div>

                        <!-- Bespoke Creation Standout Button -->
                        <button 
                            type="button" 
                            @click="buyNow()" 
                            class="w-full h-12 px-6 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl shadow-md hover:shadow-gold-glow transition-all active:scale-[0.98] flex items-center justify-center gap-2.5"
                        >
                            <i data-lucide="gem" class="w-4 h-4"></i>
                            <span>Commission Bespoke Piece ({{ $product['lead_time'] ?? '7–10 Days' }})</span>
                        </button>

                    @else
                        <!-- Regular In-Stock Controls -->
                        <div class="flex items-center gap-3 sm:gap-4">
                            <!-- Tactile Quantity Stepper -->
                            <div class="flex items-center border border-ivory-300 rounded-xl overflow-hidden bg-ivory-50 h-12 flex-shrink-0">
                                <button 
                                    type="button" 
                                    @click="if(quantity > 1) quantity--" 
                                    class="w-10 h-full flex items-center justify-center text-espresso-900 hover:bg-ivory-200 transition-colors focus:outline-none"
                                    aria-label="Decrease quantity"
                                >
                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="w-11 text-center font-bold text-sm text-espresso-900" x-text="quantity"></span>
                                <button 
                                    type="button" 
                                    @click="quantity++" 
                                    class="w-10 h-full flex items-center justify-center text-espresso-900 hover:bg-ivory-200 transition-colors focus:outline-none"
                                    aria-label="Increase quantity"
                                >
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>

                            <!-- Add to Shopping Bag Button -->
                            <button 
                                type="button" 
                                @click="addToCart()" 
                                class="flex-1 h-12 px-5 sm:px-6 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 border border-gold/30 active:scale-[0.98] group/btn"
                            >
                                <i data-lucide="shopping-bag" class="w-4 h-4 text-gold group-hover/btn:scale-110 transition-transform"></i>
                                <span>Add to Shopping Bag</span>
                            </button>

                            <!-- Wishlist Toggle Button -->
                            <button 
                                type="button" 
                                @click="$store.wishlist.toggle(product)" 
                                class="w-12 h-12 rounded-xl border border-ivory-300 flex items-center justify-center text-espresso-900 hover:border-gold hover:bg-ivory-50 transition-all focus:outline-none flex-shrink-0"
                                :class="$store.wishlist.has(product.id) ? 'border-chocolate-700 bg-ivory-100' : ''"
                                aria-label="Toggle wishlist"
                            >
                                <i 
                                    data-lucide="heart" 
                                    class="w-5 h-5 transition-all" 
                                    :class="$store.wishlist.has(product.id) ? 'fill-chocolate-700 text-chocolate-700 scale-110' : 'text-espresso-800 hover:text-gold-600'"
                                ></i>
                            </button>
                        </div>

                        <!-- Buy Now (Cash on Delivery) Standout Button -->
                        <button 
                            type="button" 
                            @click="buyNow()" 
                            class="w-full h-12 px-6 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl shadow-md hover:shadow-gold-glow transition-all active:scale-[0.98] flex items-center justify-center gap-2.5"
                        >
                            <i data-lucide="truck" class="w-4 h-4"></i>
                            <span>Buy Now (Doorstep Cash on Delivery)</span>
                        </button>

                        <!-- WhatsApp Quick Order (High Converting for Pakistani Ad Traffic) -->
                        <a 
                            href="https://wa.me/923214700545?text={{ urlencode('Hello By Zunash Concierge! I want to order ' . $product['name'] . ' (PKR ' . number_format($product['price']) . '). Link: ' . url()->current() . ' — My delivery city is: ') }}" 
                            target="_blank"
                            rel="noopener"
                            class="w-full h-11 px-4 bg-[#25D366] hover:bg-[#20BD5A] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 active:scale-[0.98]"
                        >
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Quick Order via WhatsApp</span>
                        </a>

                        <!-- Live Scarcity & Conversion Nudge -->
                        <div class="flex items-center justify-between text-[11px] p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-950">
                            <span class="flex items-center gap-1.5 font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                <span>High Demand: <strong>16 patrons</strong> ordered this week</span>
                            </span>
                            <span class="font-bold text-emerald-700">In Stock for Immediate Dispatch</span>
                        </div>
                    @endif
                </div>

                <!-- Doorstep Inspection & Authenticity Guarantee (Key Ad Trust Factor) -->
                <div class="p-3.5 rounded-xl bg-ivory-100/80 border border-gold/40 text-xs space-y-1.5">
                    <div class="flex items-center gap-2 font-bold text-espresso-950">
                        <i data-lucide="shield-check" class="w-4 h-4 text-gold-600"></i>
                        <span>100% Full-Grain Hide • Open Parcel Inspection</span>
                    </div>
                    <p class="text-[11px] text-muted leading-relaxed">
                        Every piece is genuine drum-dyed full-grain leather. You can open and inspect the courier parcel at your doorstep before handing cash. If not 100% delighted, return it on the spot with zero hassle.
                    </p>
                </div>

                <!-- Reassurance / Trust Highlights Card -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 p-4 rounded-xl bg-ivory-50/80 border border-ivory-300 text-xs text-espresso-900">
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="truck" class="w-4 h-4 text-gold-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <span class="font-bold block">Priority Courier</span>
                            <span class="text-[11px] text-muted">24–48h Nationwide</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="banknote" class="w-4 h-4 text-gold-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <span class="font-bold block">Cash on Delivery</span>
                            <span class="text-[11px] text-muted">Doorstep Inspection</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 text-gold-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <span class="font-bold block">7-Day Exchange</span>
                            <span class="text-[11px] text-muted">Hassle-Free Policy</span>
                        </div>
                    </div>
                </div>

                <!-- Curated Pair Deal / Bundle & Save Integration -->
                @if(!empty($companionDeals) && count($companionDeals) > 0)
                    @foreach($companionDeals as $compDeal)
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-espresso-950 via-[#1C1410] to-black text-ivory border border-gold/40 shadow-lg">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gold text-espresso-950">
                                    {{ $compDeal->badge ?: 'Curated Bundle Deal' }}
                                </span>
                                @if($compDeal->savings_amount > 0)
                                    <span class="text-[11px] font-bold text-gold-300">
                                        Save PKR {{ number_format($compDeal->savings_amount) }}
                                    </span>
                                @endif
                            </div>

                            <h4 class="font-serif text-sm font-bold text-white mb-0.5">
                                {{ $compDeal->title }}
                            </h4>
                            <p class="text-[11px] text-ivory-300 font-light line-clamp-1 mb-2.5">
                                {{ $compDeal->tagline ?: 'Complementary leather pairing at special bundle rate.' }}
                            </p>

                            <!-- Mini Items Thumbnails -->
                            <div class="flex items-center gap-2 mb-3 bg-white/5 p-2 rounded-xl border border-white/10">
                                @foreach($compDeal->products as $cp)
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <div class="w-8 h-8 rounded-lg overflow-hidden bg-ivory-100 shrink-0 border border-white/20">
                                            <img src="{{ asset($cp->image) }}" alt="{{ $cp->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-[10px] text-ivory-200 truncate max-w-[100px]">{{ $cp->name }}</span>
                                    </div>
                                    @if(!$loop->last)
                                        <span class="text-gold font-bold text-xs">+</span>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Bundle Pricing & 1-Click Action -->
                            <div class="flex items-center justify-between pt-2 border-t border-white/10">
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-gold-400 block">Bundle Deal Price</span>
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="font-serif text-base font-bold text-white">
                                            PKR {{ number_format($compDeal->deal_price) }}
                                        </span>
                                        @if($compDeal->effective_original_price > $compDeal->deal_price)
                                            <span class="text-xs text-white/50 line-through">
                                                PKR {{ number_format($compDeal->effective_original_price) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <a 
                                    href="{{ route('deals') }}#{{ $compDeal->slug }}" 
                                    class="px-3.5 py-1.5 rounded-full bg-gold hover:bg-gold-light text-espresso-950 text-[11px] uppercase font-bold tracking-wider transition-all shadow-xs flex items-center gap-1"
                                >
                                    <span>View Bundle Deal</span>
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

        </div>

        <!-- Specifications, Narrative & Care Tabs -->
        <div class="mt-14 pt-10 border-t border-ivory-200">
            
            <!-- Modern Tab Bar -->
            <div class="flex items-center gap-2 sm:gap-4 border-b border-ivory-200 overflow-x-auto pb-px scrollbar-none">
                <button 
                    type="button" 
                    @click="activeTab = 'specifications'"
                    class="font-serif text-xs sm:text-sm uppercase tracking-widest pb-3.5 px-3 font-semibold transition-all relative whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'specifications' ? 'text-espresso-950 border-b-2 border-gold font-bold' : 'text-muted hover:text-espresso-800'"
                >
                    Craftsmanship & Specs
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'description'"
                    class="font-serif text-xs sm:text-sm uppercase tracking-widest pb-3.5 px-3 font-semibold transition-all relative whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'description' ? 'text-espresso-950 border-b-2 border-gold font-bold' : 'text-muted hover:text-espresso-800'"
                >
                    The Atelier Story
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'care'"
                    class="font-serif text-xs sm:text-sm uppercase tracking-widest pb-3.5 px-3 font-semibold transition-all relative whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'care' ? 'text-espresso-950 border-b-2 border-gold font-bold' : 'text-muted hover:text-espresso-800'"
                >
                    Leather Care Guide
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'shipping'"
                    class="font-serif text-xs sm:text-sm uppercase tracking-widest pb-3.5 px-3 font-semibold transition-all relative whitespace-nowrap focus:outline-none"
                    :class="activeTab === 'shipping' ? 'text-espresso-950 border-b-2 border-gold font-bold' : 'text-muted hover:text-espresso-800'"
                >
                    Delivery & Returns
                </button>
            </div>

            <!-- Tab Content Viewport -->
            <div class="py-8">
                
                <!-- Tab 1: Specifications & Features -->
                <div x-show="activeTab === 'specifications'" class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    <div class="bg-ivory-50/60 p-6 rounded-2xl border border-ivory-300">
                        <h3 class="font-serif text-base font-bold text-espresso-950 mb-4 flex items-center gap-2">
                            <i data-lucide="award" class="w-4 h-4 text-gold-600"></i>
                            <span>Artisanal Highlights</span>
                        </h3>
                        <ul class="space-y-3 text-xs text-espresso-800 leading-relaxed">
                            @foreach($product['features'] as $feature)
                                <li class="flex items-start gap-2.5">
                                    <i data-lucide="check" class="w-4 h-4 text-gold-600 flex-shrink-0 mt-0.5"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-ivory-50/60 p-6 rounded-2xl border border-ivory-300">
                        <h3 class="font-serif text-base font-bold text-espresso-950 mb-4 flex items-center gap-2">
                            <i data-lucide="layers" class="w-4 h-4 text-gold-600"></i>
                            <span>Technical Specifications</span>
                        </h3>
                        <dl class="divide-y divide-ivory-200 text-xs">
                            @foreach($product['specifications'] as $key => $val)
                                <div class="py-2.5 flex justify-between gap-4">
                                    <dt class="text-muted font-medium uppercase tracking-wider">{{ $key }}</dt>
                                    <dd class="text-espresso-900 font-semibold text-right">{{ $val }}</dd>
                                </div>
                            @endforeach
                            <div class="py-2.5 flex justify-between gap-4">
                                <dt class="text-muted font-medium uppercase tracking-wider">Origin</dt>
                                <dd class="text-espresso-900 font-semibold text-right">Handcrafted in Pakistan (Lahore & Karachi)</dd>
                            </div>
                            <div class="py-2.5 flex justify-between gap-4">
                                <dt class="text-muted font-medium uppercase tracking-wider">Packaging</dt>
                                <dd class="text-espresso-900 font-semibold text-right">Rigid Embossed Magnetic Gift Box & Dust Pouch</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Tab 2: Atelier Story -->
                <div x-show="activeTab === 'description'" x-cloak class="max-w-3xl text-sm text-espresso-800 font-light leading-relaxed space-y-4">
                    <p class="text-base text-espresso-950 font-serif font-medium leading-relaxed">
                        {{ $product['description'] }}
                    </p>
                    <p>
                        Each piece by By Zunash is hand-selected from top-tier vegetable-tanned full-grain cattle hides. Rather than artificial vinyl coatings or synthetic corrected grains, our master artisans celebrate the authentic natural pore structure and depth of tone. Over time and wear, this pure hide will absorb natural oils, creating a lustrous patina distinct to your everyday journey.
                    </p>
                    <div class="p-4 rounded-xl bg-ivory-100 border border-ivory-300 flex items-start gap-3 text-xs text-espresso-900">
                        <i data-lucide="feather" class="w-4 h-4 text-gold-600 flex-shrink-0 mt-0.5"></i>
                        <span><strong>Artisan Mark:</strong> Subtle tonal gradations and natural grain marks are uncompromised testaments of genuine full-grain leather, certifying that no two pieces are ever identical.</span>
                    </div>
                </div>

                <!-- Tab 3: Leather Care Guide -->
                <div x-show="activeTab === 'care'" x-cloak class="max-w-3xl text-xs text-espresso-800 space-y-4 leading-relaxed">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl bg-ivory-50 border border-ivory-300">
                            <h4 class="font-serif font-bold text-espresso-950 text-sm mb-2">1. Routine Cleaning</h4>
                            <p class="text-muted leading-relaxed">Gently wipe dust and surface debris using a dry, soft cotton or microfiber cloth. Avoid wet wipes or household chemicals.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-ivory-50 border border-ivory-300">
                            <h4 class="font-serif font-bold text-espresso-950 text-sm mb-2">2. Conditioning</h4>
                            <p class="text-muted leading-relaxed">Every 3–6 months, apply a pea-sized dab of natural neutral leather balm to restore moisture and protect the grain from drying.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-ivory-50 border border-ivory-300">
                            <h4 class="font-serif font-bold text-espresso-950 text-sm mb-2">3. Storage</h4>
                            <p class="text-muted leading-relaxed">Store hanging or loosely coiled in the breathable By Zunash dust pouch. Keep away from prolonged direct heat or dampness.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Delivery & Returns -->
                <div x-show="activeTab === 'shipping'" x-cloak class="max-w-3xl text-xs text-espresso-800 space-y-4 leading-relaxed">
                    <div class="p-4 rounded-xl bg-ivory-50 border border-ivory-300 space-y-3">
                        <p><strong class="font-serif uppercase tracking-wider text-espresso-950">Nationwide Express Delivery:</strong></p>
                        <p class="text-muted">
                            • Major Metros (Lahore, Karachi, Islamabad, Rawalpindi): 24–48 hours.<br>
                            • Other Regional Cities (Faisalabad, Multan, Peshawar, Sialkot, Gujranwala, Quetta): 2–3 business days.<br>
                            • Real-time courier SMS tracking provided once dispatched.
                        </p>
                        <p><strong class="font-serif uppercase tracking-wider text-espresso-950">Doorstep Cash on Delivery:</strong></p>
                        <p class="text-muted">
                            Pay in cash to the courier representative after inspecting the parcel seal at your doorstep. Direct bank transfer is also accepted.
                        </p>
                        <p><strong class="font-serif uppercase tracking-wider text-espresso-950">7-Day Size & Model Exchange:</strong></p>
                        <p class="text-muted">
                            If your belt or accessory size needs an adjustment, simply WhatsApp our atelier concierge at <strong class="text-espresso-950">+92 321 4700545</strong> within 7 days of receiving your parcel. We will arrange a courier pickup and replacement promptly.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Related Products Section (Clean leather photos) -->
        @if(!empty($relatedProducts) && count($relatedProducts) > 0)
            <div class="mt-14 pt-10 border-t border-ivory-200">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Complementary Pieces</span>
                        <h2 class="font-serif text-2xl font-bold text-espresso-950 mt-1">You May Also Appreciate</h2>
                    </div>
                    <a href="{{ route('category', $product['category']) }}" class="text-xs uppercase tracking-wider text-muted hover:text-gold-600 font-medium transition-colors">
                        View All {{ $product['category_name'] }} →
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                    @foreach($relatedProducts as $rel)
                        <x-user.components.product-card :product="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Sizing Guide Interactive Modal -->
        <div 
            x-show="sizeGuideOpen" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/75 backdrop-blur-md flex items-center justify-center p-4"
            @click.self="sizeGuideOpen = false"
        >
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-ivory-300 relative text-espresso-900">
                <button 
                    type="button" 
                    @click="sizeGuideOpen = false"
                    class="absolute top-5 right-5 p-2 rounded-full text-muted hover:text-espresso-950 hover:bg-ivory-100 transition-colors focus:outline-none"
                    aria-label="Close modal"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

                <div class="flex items-center gap-2 text-gold-600 mb-1">
                    <i data-lucide="ruler" class="w-5 h-5"></i>
                    <span class="text-xs font-serif uppercase tracking-widest font-bold">Atelier Measurement Guide</span>
                </div>
                <h3 class="font-serif text-2xl font-bold text-espresso-950 mb-3">How to Find Your Belt Size</h3>

                <p class="text-xs text-muted leading-relaxed mb-4">
                    By Zunash belts feature 5 precision prong holes. Our belts are measured from the fold of the leather at the buckle to the <strong>middle hole</strong> (hole #3), giving you 2 inches of adjustment in either direction.
                </p>

                <!-- Golden Rule Callout -->
                <div class="p-3.5 bg-ivory-100 rounded-xl border border-ivory-300 mb-5 text-xs text-espresso-950">
                    <strong class="text-gold-700">The Simple Rule:</strong> Trouser Waist Size + 2 Inches = Your By Zunash Belt Size.
                    <div class="text-muted mt-0.5">Example: If you wear size 32 waist trousers, choose size <strong>34</strong>.</div>
                </div>

                <!-- Sizing Table -->
                <div class="overflow-hidden rounded-xl border border-ivory-200 mb-5 text-xs">
                    <table class="w-full text-left">
                        <thead class="bg-ivory-100 text-espresso-950 font-serif uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="py-2.5 px-3">Belt Size</th>
                                <th class="py-2.5 px-3">Trouser Waist</th>
                                <th class="py-2.5 px-3">Middle Hole</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ivory-200">
                            @foreach([
                                ['30″', '28 inches (71 cm)', '30 inches (76 cm)'],
                                ['32″', '30 inches (76 cm)', '32 inches (81 cm)'],
                                ['34″', '32 inches (81 cm)', '34 inches (86 cm)'],
                                ['36″', '34 inches (86 cm)', '36 inches (91 cm)'],
                                ['38″', '36 inches (91 cm)', '38 inches (96 cm)'],
                                ['40″', '38 inches (96 cm)', '40 inches (101 cm)'],
                                ['42″', '40 inches (101 cm)', '42 inches (106 cm)']
                            ] as $row)
                                <tr class="hover:bg-ivory-50 transition-colors">
                                    <td class="py-2 px-3 font-bold text-espresso-950">{{ $row[0] }}</td>
                                    <td class="py-2 px-3 text-muted">{{ $row[1] }}</td>
                                    <td class="py-2 px-3 text-espresso-900">{{ $row[2] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button 
                    type="button" 
                    @click="sizeGuideOpen = false"
                    class="w-full py-3 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl transition-all"
                >
                    Got It, Continue Shopping
                </button>
            </div>
        </div>

        <!-- Fullscreen Editorial Lightbox Modal -->
        <div 
            x-show="lightboxOpen" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/95 backdrop-blur-xl flex items-center justify-center p-4 sm:p-8"
            @click.self="lightboxOpen = false"
        >
            <!-- Close Button -->
            <button 
                type="button" 
                @click="lightboxOpen = false"
                class="absolute top-6 right-6 z-50 p-3 rounded-full bg-white/10 hover:bg-white/20 text-white transition-all transform hover:scale-110 focus:outline-none"
                aria-label="Close fullscreen view"
            >
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <!-- Navigation Buttons -->
            <button 
                type="button" 
                @click="prevImage()"
                class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 p-3.5 rounded-full bg-white/10 hover:bg-white/25 text-white transition-all transform hover:scale-110 focus:outline-none"
                aria-label="Previous image"
            >
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>
            <button 
                type="button" 
                @click="nextImage()"
                class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 p-3.5 rounded-full bg-white/10 hover:bg-white/25 text-white transition-all transform hover:scale-110 focus:outline-none"
                aria-label="Next image"
            >
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>

            <!-- Image View Container -->
            <div class="max-w-5xl max-h-[85vh] flex flex-col items-center">
                <img 
                    :src="activeImage" 
                    alt="{{ $product['name'] }}" 
                    class="max-h-[78vh] max-w-full object-contain rounded-2xl shadow-2xl border border-white/10"
                >
                <div class="mt-4 flex items-center gap-3 text-ivory-300 text-xs font-serif tracking-widest uppercase">
                    <span>{{ $product['name'] }}</span>
                    <span>•</span>
                    <span>Angle <span x-text="activeImageIndex + 1"></span> of <span x-text="gallery.length"></span></span>
                </div>
            </div>
        </div>

        <!-- STICKY MOBILE CONVERSION BAR (Appears on Mobile when User Scrolls Past Hero) -->
        <div 
            x-data="{ showStickyBar: false }"
            @scroll.window="showStickyBar = (window.pageYOffset > 450)"
            x-show="showStickyBar"
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
                        <img :src="activeImage" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-bold text-espresso-950 dark:text-white truncate block">
                            {{ $product['name'] }}
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="font-serif text-sm font-bold text-espresso-950 dark:text-gold-400">
                                PKR {{ number_format($product['price']) }}
                            </span>
                            @if(!empty($product['original_price']) && $product['original_price'] > $product['price'])
                                <span class="text-[10px] text-muted-light line-through">
                                    {{ number_format($product['original_price']) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 shrink-0">
                    <button 
                        type="button" 
                        @click="addToCart()" 
                        class="p-2.5 rounded-xl bg-espresso-950 text-white flex items-center justify-center active:scale-95 shadow-sm"
                        title="Add to Shopping Bag"
                    >
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-gold"></i>
                    </button>
                    <button 
                        type="button" 
                        @click="buyNow()" 
                        class="px-4 py-2.5 rounded-xl bg-gold text-espresso-950 text-xs font-bold uppercase tracking-wider shadow-sm active:scale-95 flex items-center gap-1"
                    >
                        <i data-lucide="truck" class="w-3.5 h-3.5"></i>
                        <span>Order COD</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
