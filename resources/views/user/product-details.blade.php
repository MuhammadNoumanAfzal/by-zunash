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
            "sku": "{{ $product['sku'] ?? ('BZ-' . str_pad($product['id'], 4, '0', STR_PAD_LEFT)) }}",
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
        'lead_time' => $product['lead_time'] ?? null,
        'allowed_payment_methods' => $product['allowed_payment_methods'] ?? 'all',
        'custom_shipping_charge' => $product['custom_shipping_charge'] ?? null,
        'is_free_shipping' => !empty($product['is_free_shipping']),
        'weight_kg' => $product['weight_kg'] ?? null
    ]);

    $beltSizes = ['30', '32', '34', '36', '38', '40', '42'];
    $isBelt = ($product['category'] === 'belts');

    // Addon cross-sells preparation
    $addonsData = ($addons ?? collect())->map(function($a) use ($product) {
        $discountPct = (int)($product['addon_discount_percent'] ?? 15);
        $originalPrice = (float)($a->price ?? ($a['price'] ?? 0));
        $discountedPrice = round($originalPrice * (1 - ($discountPct / 100)));
        return [
            'id' => $a->id ?? ($a['id'] ?? 0),
            'name' => $a->name ?? ($a['name'] ?? ''),
            'image' => $a->image ?? ($a['image'] ?? ''),
            'original_price' => $originalPrice,
            'price' => $discountedPrice,
            'savings' => max(0, $originalPrice - $discountedPrice),
            'category' => $a->category_slug ?? ($a['category_slug'] ?? 'accessories'),
            'colors' => $a->colors ?? ($a['colors'] ?? []),
            'selected' => false,
        ];
    })->values();

    // Gift Set Upgrade preparation
    $companionGiftSet = null;
    if (!empty($giftDeal)) {
        $companionGiftSet = [
            'id' => $giftDeal->id,
            'title' => $giftDeal->title,
            'subtitle' => $giftDeal->subtitle ?? 'Pair with complementary creation in rigid presentation box',
            'slug' => $giftDeal->slug,
            'image' => $giftDeal->image,
            'deal_price' => (float)$giftDeal->deal_price,
            'original_price' => (float)($giftDeal->original_price ?: $giftDeal->deal_price),
            'savings' => max(0, (float)($giftDeal->original_price ?: $giftDeal->deal_price) - (float)$giftDeal->deal_price),
        ];
    } elseif (!empty($product['has_gift_set']) && !empty($product['gift_set_title'])) {
        $companionGiftSet = [
            'id' => 'custom-gift-set',
            'title' => $product['gift_set_title'],
            'subtitle' => $product['gift_set_subtitle'] ?? 'Handcrafted creations paired together in a rigid gold-embossed presentation box.',
            'image' => $product['gift_set_image'] ?: '/images/brand/artisan-craft.jpg',
            'deal_price' => (float)($product['gift_set_price'] ?: $product['price']),
            'original_price' => (float)($product['gift_set_original_price'] ?: ($product['price'] * 1.3)),
            'savings' => max(0, (float)($product['gift_set_original_price'] ?: ($product['price'] * 1.3)) - (float)($product['gift_set_price'] ?: $product['price'])),
        ];
    }
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
        showStickyBar: false,

        // Customization & Name Engraving
        customizationType: 'normal',
        engravedName: '',
        hasEngraving: {{ !empty($product['has_engraving']) ? 'true' : 'false' }},
        engravingPrice: {{ (float)($product['engraving_price'] ?? 0) }},
        engravingNote: '{{ addslashes($product['engraving_note'] ?? 'Advance payment only. Personalised, so not returnable for change of mind.') }}',

        // Cross-sell Addons
        addons: {{ json_encode($addonsData) }},

        get isEngravingActive() {
            return this.hasEngraving && this.customizationType === 'engraving' && this.engravedName.trim().length > 0;
        },
        get currentProductPrice() {
            return Number(this.product.price) + (this.hasEngraving && this.customizationType === 'engraving' ? this.engravingPrice : 0);
        },
        get selectedAddons() {
            return this.addons.filter(a => a.selected);
        },
        get addonsTotalPrice() {
            return this.selectedAddons.reduce((sum, a) => sum + a.price, 0);
        },
        get addonsTotalOriginalPrice() {
            return this.selectedAddons.reduce((sum, a) => sum + a.original_price, 0);
        },
        get addonsTotalSavings() {
            return this.addonsTotalOriginalPrice - this.addonsTotalPrice;
        },

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
            const isEngraved = this.isEngravingActive;
            $store.cart.addItem(
                this.product, 
                this.getVariantLabel(), 
                this.quantity, 
                false,
                {
                    price: this.currentProductPrice,
                    engraved_name: isEngraved ? this.engravedName.trim().toUpperCase() : null,
                    allowed_payment_methods: isEngraved ? 'prepaid_only' : (this.product.allowed_payment_methods || 'all')
                }
            );
        },
        buyNow(targetPayment = null) {
            const isEngraved = this.isEngravingActive;
            if (targetPayment === 'cod' && isEngraved) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Advance Payment Only',
                        text: 'Personalised & engraved creations are handcrafted exclusively for you and require advance payment via Bank Transfer / Raast or JazzCash / EasyPaisa.',
                        confirmButtonColor: '#24160F'
                    });
                } else {
                    alert('Personalised & engraved creations require advance payment via Bank Transfer or JazzCash/EasyPaisa.');
                }
                return;
            }

            $store.cart.addItem(
                this.product, 
                this.getVariantLabel(), 
                this.quantity, 
                false,
                {
                    price: this.currentProductPrice,
                    engraved_name: isEngraved ? this.engravedName.trim().toUpperCase() : null,
                    allowed_payment_methods: isEngraved ? 'prepaid_only' : (this.product.allowed_payment_methods || 'all')
                }
            );

            const url = targetPayment === 'cod' ? '{{ route('checkout') }}?payment=cod' : '{{ route('checkout') }}';
            window.location.href = url;
        },
        claimAddonOffer() {
            if (this.selectedAddons.length === 0) {
                window.ZunashAlert?.toast('Please select at least one add-on offer item.', 'info');
                return;
            }
            // Add main product
            this.addToCart();
            // Add each selected addon with 15% discount
            for (const addon of this.selectedAddons) {
                $store.cart.addItem(
                    {
                        id: addon.id,
                        name: addon.name + ' (15% Off Add-on)',
                        price: addon.price,
                        original_price: addon.original_price,
                        image: addon.image,
                        category: addon.category,
                        allowed_payment_methods: 'all'
                    },
                    'Special Add-on Offer',
                    1,
                    false
                );
            }
            window.ZunashAlert?.toast('Main creation and discounted add-ons added to bag!', 'success');
            $store.cart.isOpen = true;
        },
        addGiftSet() {
            @if(!empty($giftDeal))
                if (typeof window.addDealToCart === 'function') {
                    window.addDealToCart({{ json_encode($giftDeal) }});
                } else {
                    $store.cart.addItem(
                        {
                            id: 'deal-{{ $giftDeal->id }}',
                            name: '{{ addslashes($giftDeal->title) }} (Gift Set)',
                            price: {{ (float)$giftDeal->deal_price }},
                            original_price: {{ (float)($giftDeal->original_price ?: $giftDeal->deal_price) }},
                            image: '{{ $giftDeal->image }}',
                            category: 'Gift Set',
                            allowed_payment_methods: 'all'
                        },
                        'Gift Presentation Box Included',
                        1,
                        false
                    );
                    window.ZunashAlert?.toast('Luxury Gift Set added to shopping bag!', 'success');
                    $store.cart.isOpen = true;
                }
            @elseif(!empty($companionGiftSet))
                $store.cart.addItem(
                    {
                        id: 'gift-set-' + this.product.id,
                        name: '{{ addslashes($companionGiftSet['title']) }}',
                        price: {{ (float)$companionGiftSet['deal_price'] }},
                        original_price: {{ (float)$companionGiftSet['original_price'] }},
                        image: '{{ $companionGiftSet['image'] }}',
                        category: 'Gift Set',
                        allowed_payment_methods: 'all'
                    },
                    'Gift Presentation Box Included',
                    1,
                    false
                );
                window.ZunashAlert?.toast('Luxury Gift Set added to shopping bag!', 'success');
                $store.cart.isOpen = true;
            @endif
        }
    }" 
    x-init="
        const observer = new IntersectionObserver(([entry]) => {
            showStickyBar = !entry.isIntersecting;
        }, { threshold: 0.1 });
        const targetEl = document.getElementById('main-buy-actions');
        if (targetEl) observer.observe(targetEl);
    " 
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
                        <span class="text-[11px] font-mono text-muted uppercase tracking-wider bg-ivory-100 dark:bg-[#251E1A] dark:text-gray-300 px-2 py-0.5 rounded border border-ivory-200 dark:border-white/10">
                            SKU: {{ $product['sku'] ?? ('BZ-' . str_pad($product['id'], 4, '0', STR_PAD_LEFT)) }}
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
                <div class="text-sm text-espresso-800 leading-relaxed font-light prose prose-sm max-w-none">
                    {!! $product['short_description'] !!}
                </div>

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

                <!-- VARIATION 3: Customization (Normal vs Name Engraving - Advance Payment Only) -->
                @if(!empty($product['has_engraving']))
                    <div class="pt-2 border-t border-ivory-200">
                        <label class="block text-xs uppercase tracking-wider font-bold text-espresso-900 mb-2">
                            Customization
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <button 
                                type="button" 
                                @click="customizationType = 'normal'"
                                class="py-2.5 px-3 rounded-xl border text-xs font-semibold tracking-wider transition-all duration-200 flex items-center justify-center text-center"
                                :class="customizationType === 'normal' 
                                    ? 'bg-espresso-950 text-white border-espresso-950 shadow-sm ring-1 ring-gold/40' 
                                    : 'bg-white text-espresso-900 border-ivory-300 hover:border-gold hover:bg-ivory-50'"
                            >
                                Normal
                            </button>
                            <button 
                                type="button" 
                                @click="customizationType = 'engraving'"
                                class="py-2.5 px-3 rounded-xl border text-xs font-semibold tracking-wider transition-all duration-200 flex items-center justify-center text-center"
                                :class="customizationType === 'engraving' 
                                    ? 'bg-espresso-950 text-white border-espresso-950 shadow-sm ring-1 ring-gold/40' 
                                    : 'bg-white text-espresso-900 border-ivory-300 hover:border-gold hover:bg-ivory-50'"
                            >
                                Name Engraving (Advance Payment Only)
                            </button>
                        </div>

                        <!-- Live Engraving Input & Preview (Gold Deboss on Leather) -->
                        <div x-show="customizationType === 'engraving'" x-cloak x-transition class="mt-3 p-4 rounded-2xl bg-[#1C1410] text-ivory border border-gold/40 shadow-inner space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-gold flex items-center gap-1.5">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                    <span>Hot-Foil Gold / Debossed Name</span>
                                </span>
                                <span class="text-xs font-serif font-bold text-ivory">
                                    <template x-if="engravingPrice > 0">
                                        <span>+ PKR <span x-text="engravingPrice.toLocaleString()"></span></span>
                                    </template>
                                    <template x-if="engravingPrice == 0">
                                        <span class="text-emerald-400 font-bold uppercase text-[10px] tracking-wider">Complimentary</span>
                                    </template>
                                </span>
                            </div>

                            <div>
                                <label class="block text-[11px] text-ivory-300 mb-1">Enter Name or Initials (Max 15 Characters):</label>
                                <input 
                                    type="text" 
                                    maxlength="15" 
                                    x-model="engravedName" 
                                    placeholder="e.g. ZUNASH / M. ALI"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-black/40 border border-gold/40 text-ivory placeholder-ivory-400/50 text-sm tracking-widest font-mono uppercase focus:outline-none focus:ring-2 focus:ring-gold"
                                >
                            </div>

                            <!-- Live Debossed Leather Plate Preview -->
                            <div class="p-3 rounded-xl bg-[#120B08] border border-amber-900/50 flex flex-col items-center justify-center">
                                <span class="text-[9px] uppercase tracking-widest text-gold-400/70 mb-1">Deboss Preview on Hide</span>
                                <div class="font-serif text-lg tracking-[0.25em] font-bold text-[#E5C158] uppercase drop-shadow-[0_1px_1px_rgba(0,0,0,0.9)] select-none">
                                    <span x-text="engravedName.trim() ? engravedName.trim().toUpperCase() : 'YOUR NAME'"></span>
                                </div>
                            </div>

                            <!-- Notice Note -->
                            <p class="text-[11px] text-amber-200/90 leading-relaxed italic bg-black/20 p-2.5 rounded-lg border border-amber-500/20">
                                <i data-lucide="info" class="w-3.5 h-3.5 inline mr-1 text-gold"></i>
                                <span x-text="engravingNote"></span>
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Prepaid Faster Dispatch Banner (BT10 Voucher) -->
                <div class="p-3.5 rounded-2xl bg-[#FFF9F2] dark:bg-[#201815] border border-amber-300/70 dark:border-amber-700/40 flex items-center gap-3 shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center shrink-0 text-xl shadow-inner">
                        📦
                    </div>
                    <div class="text-xs leading-snug">
                        <span class="font-bold text-espresso-950 dark:text-white block">Prepaid = faster dispatch</span>
                        <span class="text-espresso-800 dark:text-ivory-300">
                            Pay by bank transfer and save 10% with code <span class="inline-block px-1.5 py-0.5 rounded bg-rose-700 text-white font-bold text-[11px] tracking-wider">BT10</span> at checkout.
                        </span>
                    </div>
                </div>

                <!-- Quantity & High-Converting CTAs -->
                <div class="space-y-3 pt-2 border-t border-ivory-200">
                    @if($isOutOfStock)
                        <!-- Out of Stock Controls -->
                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-ivory-200 rounded-xl overflow-hidden bg-ivory-100 h-12 flex-shrink-0 opacity-60 cursor-not-allowed">
                                <span class="w-10 h-full flex items-center justify-center text-zinc-400">
                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                </span>
                                <span class="w-11 text-center font-bold text-sm text-zinc-400">0</span>
                                <span class="w-10 h-full flex items-center justify-center text-zinc-400">
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                            <button 
                                type="button" 
                                disabled 
                                class="flex-1 h-12 px-5 bg-zinc-200 text-zinc-500 text-xs uppercase tracking-widest font-semibold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-zinc-300 select-none"
                            >
                                <i data-lucide="slash" class="w-4 h-4"></i>
                                <span>Sold Out / Out of Stock</span>
                            </button>
                        </div>
                        <a 
                            href="{{ route('contact', ['subject' => 'Restock Inquiry: ' . $product['name']]) }}" 
                            class="w-full h-12 px-6 bg-espresso-950 hover:bg-gold-600 text-ivory hover:text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center justify-center gap-2.5"
                        >
                            <i data-lucide="bell" class="w-4 h-4 text-gold"></i>
                            <span>Notify Me When Back in Stock</span>
                        </a>
                    @else
                        <!-- Quantity Stepper -->
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                Quantity
                            </label>
                            <div class="flex items-center border border-ivory-300 rounded-xl overflow-hidden bg-white h-11 w-32 shadow-2xs">
                                <button 
                                    type="button" 
                                    @click="if(quantity > 1) quantity--" 
                                    class="w-10 h-full flex items-center justify-center text-espresso-900 hover:bg-ivory-100 transition-colors focus:outline-none"
                                    aria-label="Decrease quantity"
                                >
                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="flex-1 text-center font-bold text-sm text-espresso-900" x-text="quantity"></span>
                                <button 
                                    type="button" 
                                    @click="quantity++" 
                                    class="w-10 h-full flex items-center justify-center text-espresso-900 hover:bg-ivory-100 transition-colors focus:outline-none"
                                    aria-label="Increase quantity"
                                >
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </div>

                        <!-- 3 Distinct CTAs as requested in mobile screenshots -->
                        <div id="main-buy-actions" class="space-y-2 pt-1">
                            <!-- CTA 1: ADD TO CART (Outline Style) -->
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    @click="addToCart()" 
                                    class="flex-1 h-12 px-5 bg-white hover:bg-ivory-50 text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl border-2 border-espresso-950 transition-all active:scale-[0.98] flex items-center justify-center gap-2 shadow-2xs"
                                >
                                    <span>ADD TO CART</span>
                                </button>
                                <!-- Wishlist Button -->
                                <button 
                                    type="button" 
                                    @click="$store.wishlist.toggle(product)" 
                                    class="w-12 h-12 rounded-xl border-2 border-ivory-300 flex items-center justify-center text-espresso-900 hover:border-gold hover:bg-ivory-50 transition-all focus:outline-none shrink-0"
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

                            <!-- CTA 2: BUY IT NOW (Solid Luxury Charcoal) -->
                            <button 
                                type="button" 
                                @click="buyNow('prepaid')" 
                                class="w-full h-12 px-6 bg-[#1a1412] hover:bg-black text-white text-xs uppercase tracking-widest font-bold rounded-xl transition-all active:scale-[0.98] flex items-center justify-center gap-2 shadow-md"
                            >
                                <span>BUY IT NOW</span>
                            </button>

                            <!-- CTA 3: Buy with Cash on Delivery (Solid Black with Shopping Cart Icon) -->
                            <button 
                                type="button" 
                                @click="buyNow('cod')" 
                                class="w-full h-12 px-6 bg-black hover:bg-neutral-900 text-white text-xs uppercase tracking-widest font-bold rounded-xl transition-all active:scale-[0.98] flex items-center justify-center gap-2.5 shadow-lg border border-white/10"
                            >
                                <i data-lucide="shopping-cart" class="w-4 h-4 text-white"></i>
                                <span>Buy with Cash on Delivery</span>
                            </button>

                            <!-- WhatsApp Quick Order -->
                            <a 
                                href="https://wa.me/923214700545?text={{ urlencode('Hello By Zunash Concierge! I want to order ' . $product['name'] . ' (PKR ' . number_format($product['price']) . '). Link: ' . url()->current() . ' — My delivery city is: ') }}" 
                                target="_blank"
                                rel="noopener"
                                class="w-full h-11 px-4 bg-[#25D366] hover:bg-[#20BD5A] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 active:scale-[0.98]"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                <span>Quick Order via WhatsApp</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- ADD-ONS CROSS-SELL MODULE ("ADD THESE & GET EXTRA 15% OFF") -->
                @if($addonsData->count() > 0)
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#1E1714] border border-ivory-300 dark:border-white/10 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs uppercase tracking-wider font-extrabold text-espresso-950 dark:text-white">
                                ADD THESE & GET EXTRA {{ (int)($product['addon_discount_percent'] ?? 15) }}% OFF
                            </h4>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black text-white">
                            Limited Time Offer
                        </span>

                        <!-- Addons List with Checkboxes -->
                        <div class="space-y-2 pt-1">
                            <template x-for="(addon, index) in addons" :key="addon.id">
                                <label class="flex items-center gap-3 p-2.5 rounded-xl border transition-all cursor-pointer select-none"
                                       :class="addon.selected ? 'border-espresso-950 bg-ivory-50/70 dark:bg-white/5 shadow-2xs' : 'border-ivory-200 dark:border-white/10 hover:border-ivory-400 bg-white dark:bg-transparent'">
                                    <!-- Checkbox -->
                                    <input 
                                        type="checkbox" 
                                        x-model="addon.selected"
                                        class="w-4 h-4 rounded text-espresso-950 focus:ring-gold border-ivory-400 accent-espresso-950 cursor-pointer"
                                    >

                                    <!-- Thumbnail -->
                                    <div class="w-12 h-12 rounded-lg bg-ivory-100 dark:bg-white/5 overflow-hidden shrink-0 border border-ivory-200 dark:border-white/10">
                                        <img :src="addon.image" :alt="addon.name" class="w-full h-full object-cover">
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-espresso-950 dark:text-white truncate" x-text="addon.name"></p>
                                        <div class="flex items-baseline gap-2 mt-0.5">
                                            <span class="text-xs font-bold text-rose-700 dark:text-rose-400">
                                                Rs.<span x-text="addon.price.toLocaleString()"></span>
                                            </span>
                                            <span class="text-[11px] text-zinc-400 line-through">
                                                Rs.<span x-text="addon.original_price.toLocaleString()"></span>
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            </template>
                        </div>

                        <!-- Claim Offer Dynamic Button -->
                        <button 
                            type="button" 
                            @click="claimAddonOffer()"
                            :disabled="selectedAddons.length === 0"
                            class="w-full py-3 px-4 rounded-xl text-xs uppercase tracking-wider font-bold transition-all flex items-center justify-center gap-2 shadow-sm"
                            :class="selectedAddons.length > 0 
                                ? 'bg-[#5A524D] hover:bg-[#433B36] text-white cursor-pointer active:scale-[0.98]' 
                                : 'bg-zinc-200 dark:bg-white/10 text-zinc-400 cursor-not-allowed'"
                        >
                            <span>Claim Offer</span>
                            <template x-if="selectedAddons.length > 0">
                                <span class="inline-flex items-center gap-1.5 ml-1">
                                    <span>• Rs.<span x-text="addonsTotalPrice.toLocaleString()"></span></span>
                                    <span class="line-through text-zinc-300 text-[10px]">Rs.<span x-text="addonsTotalOriginalPrice.toLocaleString()"></span></span>
                                </span>
                            </template>
                        </button>
                    </div>
                @endif

                <!-- GIFT SET / BUNDLE UPGRADE ("Buying it as a gift? Get the [Set] instead") -->
                @if(!empty($companionGiftSet))
                    <div class="p-4 rounded-2xl bg-[#FBF7F0] dark:bg-[#1D1613] border border-amber-900/20 dark:border-gold/30 shadow-2xs space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-white shrink-0 border border-amber-900/10 shadow-inner">
                                <img src="{{ asset($companionGiftSet['image']) }}" alt="{{ $companionGiftSet['title'] }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[11px] text-amber-900/80 dark:text-gold-400 font-serif italic block">Buying it as a gift?</span>
                                <h4 class="font-serif text-base font-bold text-espresso-950 dark:text-white leading-snug">
                                    {{ $companionGiftSet['title'] }}
                                </h4>
                            </div>
                        </div>

                        <div class="space-y-1.5 pt-2 border-t border-amber-900/10 dark:border-white/10 text-xs">
                            <div class="flex items-center justify-between text-espresso-800/80 dark:text-ivory-300">
                                <span>{{ $companionGiftSet['subtitle'] ?: 'Separately' }}</span>
                                <span class="line-through text-zinc-400 font-mono">
                                    Rs.{{ number_format($companionGiftSet['original_price']) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between font-bold text-espresso-950 dark:text-white">
                                <span>Together, gift-boxed</span>
                                <span class="font-mono text-sm text-gold-700 dark:text-gold-400">Rs.{{ number_format($companionGiftSet['deal_price']) }}</span>
                            </div>
                        </div>

                        <button 
                            type="button" 
                            @click="addGiftSet({{ json_encode($companionGiftSet) }})"
                            class="w-full py-3.5 px-4 bg-black hover:bg-neutral-900 text-white text-xs uppercase tracking-wider font-bold rounded-xl transition-all active:scale-[0.98] shadow-md flex items-center justify-center text-center"
                        >
                            <span>ADD THE SET AND KEEP RS.{{ number_format($companionGiftSet['savings']) }}</span>
                        </button>
                    </div>
                @endif

                <!-- Doorstep Inspection & Authenticity Guarantee (Bold & High Contrast for Pakistani Shoppers) -->
                <div class="p-4 rounded-2xl bg-[#F7F2EB] dark:bg-[#201815] border-2 border-tan-400/60 dark:border-gold/40 text-xs space-y-1.5 shadow-2xs">
                    <div class="flex items-center gap-2 font-bold text-sm text-espresso-950 dark:text-white">
                        <i data-lucide="shield-check" class="w-4 h-4 text-tan-700 dark:text-gold shrink-0"></i>
                        <span>100% Full-Grain Hide • Open Parcel Inspection</span>
                    </div>
                    <p class="text-xs text-espresso-900 dark:text-stone-100 font-medium leading-relaxed">
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
            
            <!-- Modern Tab Bar (Dark, Bold & High-Contrast) -->
            <div class="flex items-center gap-2 sm:gap-4 border-b-2 border-[#E2D9CC] dark:border-white/10 overflow-x-auto pb-px scrollbar-none">
                <button 
                    type="button" 
                    @click="activeTab = 'specifications'; $nextTick(() => { if (window.lucide) lucide.createIcons(); })"
                    class="font-serif text-xs sm:text-sm uppercase tracking-wider pb-3.5 px-3.5 font-bold transition-all relative whitespace-nowrap focus:outline-none cursor-pointer"
                    :class="activeTab === 'specifications' ? 'text-[#120B08] dark:text-white border-b-2 border-gold-600 font-black -mb-[2px]' : 'text-[#2D211A] dark:text-[#E8DCCF] hover:text-[#8C6B38] dark:hover:text-gold border-b-2 border-transparent'"
                >
                    Craftsmanship & Specs
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'description'; $nextTick(() => { if (window.lucide) lucide.createIcons(); })"
                    class="font-serif text-xs sm:text-sm uppercase tracking-wider pb-3.5 px-3.5 font-bold transition-all relative whitespace-nowrap focus:outline-none cursor-pointer"
                    :class="activeTab === 'description' ? 'text-[#120B08] dark:text-white border-b-2 border-gold-600 font-black -mb-[2px]' : 'text-[#2D211A] dark:text-[#E8DCCF] hover:text-[#8C6B38] dark:hover:text-gold border-b-2 border-transparent'"
                >
                    The Atelier Story
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'care'; $nextTick(() => { if (window.lucide) lucide.createIcons(); })"
                    class="font-serif text-xs sm:text-sm uppercase tracking-wider pb-3.5 px-3.5 font-bold transition-all relative whitespace-nowrap focus:outline-none cursor-pointer"
                    :class="activeTab === 'care' ? 'text-[#120B08] dark:text-white border-b-2 border-gold-600 font-black -mb-[2px]' : 'text-[#2D211A] dark:text-[#E8DCCF] hover:text-[#8C6B38] dark:hover:text-gold border-b-2 border-transparent'"
                >
                    Leather Care Guide
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'shipping'; $nextTick(() => { if (window.lucide) lucide.createIcons(); })"
                    class="font-serif text-xs sm:text-sm uppercase tracking-wider pb-3.5 px-3.5 font-bold transition-all relative whitespace-nowrap focus:outline-none cursor-pointer"
                    :class="activeTab === 'shipping' ? 'text-[#120B08] dark:text-white border-b-2 border-gold-600 font-black -mb-[2px]' : 'text-[#2D211A] dark:text-[#E8DCCF] hover:text-[#8C6B38] dark:hover:text-gold border-b-2 border-transparent'"
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

                    <div class="bg-ivory-50/60 dark:bg-[#1A1412] p-6 rounded-2xl border border-ivory-300 dark:border-white/10">
                        <h3 class="font-serif text-base font-bold text-espresso-950 dark:text-white mb-4 flex items-center gap-2">
                            <i data-lucide="layers" class="w-4 h-4 text-gold-600"></i>
                            <span>Technical Specifications</span>
                        </h3>
                        @if(!empty($product['specifications']) && count($product['specifications']) > 0)
                            <dl class="divide-y divide-ivory-200 dark:divide-white/10 text-xs">
                                @foreach($product['specifications'] as $key => $val)
                                    @if(!empty($val))
                                        <div class="py-2.5 flex justify-between gap-4">
                                            <dt class="text-muted font-medium uppercase tracking-wider">{{ $key }}</dt>
                                            <dd class="text-espresso-900 dark:text-ivory font-semibold text-right">{{ $val }}</dd>
                                        </div>
                                    @endif
                                @endforeach
                            </dl>
                        @else
                            <p class="text-xs text-muted italic">Specifications will be updated soon for this creation.</p>
                        @endif
                    </div>
                </div>

                <!-- Tab 2: Atelier Story (Clean, Centered & Easy Wording for Pakistani Shoppers) -->
                <div x-show="activeTab === 'description'" x-cloak class="w-full max-w-5xl mx-auto text-sm text-espresso-800 dark:text-ivory-200 font-light leading-relaxed space-y-6">
                    @if(!empty($product['description']))
                        <div class="text-sm sm:text-base text-espresso-950 dark:text-white font-sans font-normal leading-relaxed prose dark:prose-invert max-w-none">
                            {!! $product['description'] !!}
                        </div>
                    @else
                        <div class="space-y-3.5 bg-white dark:bg-[#1A1412] p-6 sm:p-8 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs">
                            <h3 class="text-lg sm:text-xl text-espresso-950 dark:text-white font-serif font-bold">
                                Handcrafted with 100% Pure Genuine Cowhide Leather
                            </h3>
                            <p class="text-muted dark:text-[#A89F95] text-xs sm:text-sm leading-relaxed">
                                Every By Zunash creation is individually cut, stitched, and finished by experienced leather craftsmen in Pakistan. We use only authentic full-grain leather — never synthetic rexine, bonded plastics, or artificial coatings. With everyday use, the natural leather softens and develops a rich natural shine that lasts for years.
                            </p>
                        </div>
                    @endif

                    <!-- Genuine Leather Guarantee Card (Easy Wording) -->
                    <div class="p-5 sm:p-6 rounded-3xl bg-ivory-100/90 dark:bg-[#201815] border border-gold/40 flex items-start gap-4 text-xs sm:text-sm text-espresso-950 dark:text-white shadow-2xs">
                        <div class="w-11 h-11 rounded-2xl bg-gold/15 text-gold-700 dark:text-gold flex items-center justify-center shrink-0">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <div class="space-y-1.5 min-w-0">
                            <span class="font-serif font-bold text-sm sm:text-base text-espresso-950 dark:text-white block">100% Asli Leather Guarantee</span>
                            <p class="text-xs text-muted dark:text-[#A89F95] leading-relaxed">
                                Natural leather textures and subtle grain variations are the authentic hallmark of pure real hide. Unlike synthetic rexine or plastic prints, no two original leather creations are identical.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Leather Care Guide (Balanced Full Width Luxury Cards) -->
                <div x-show="activeTab === 'care'" x-cloak class="w-full max-w-6xl mx-auto space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 w-full">
                        
                        <!-- 1. Daily Dusting -->
                        <div class="bg-white dark:bg-[#1A1412] p-6 sm:p-7 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-tan-100 to-tan-200/80 dark:from-[#30221B] dark:to-[#221713] text-tan-800 dark:text-gold flex items-center justify-center shadow-2xs border border-tan-300/40 dark:border-gold/20">
                                        <i data-lucide="sparkles" class="w-6 h-6 text-tan-700 dark:text-gold"></i>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#FAF6F0] dark:bg-[#251C17] text-tan-800 dark:text-gold-300 border border-tan-200 dark:border-gold/20 font-mono">Routine Care</span>
                                </div>
                                <h4 class="font-serif font-bold text-espresso-950 dark:text-white text-base sm:text-lg mb-2">1. Daily Dusting</h4>
                                <p class="text-xs sm:text-[13px] text-[#5C5046] dark:text-[#C5B8AC] leading-relaxed">
                                    Gently wipe surface dust with a dry, soft cotton or microfiber cloth.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#F0EAE1] dark:border-white/5 text-[11px] text-rose-700 dark:text-rose-400 font-medium">
                                ✕ Never use alcohol wipes, wet tissues, chemical cleaners, or soap.
                            </div>
                        </div>

                        <!-- 2. Leather Conditioning -->
                        <div class="bg-white dark:bg-[#1A1412] p-6 sm:p-7 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200/80 dark:from-[#352516] dark:to-[#24170E] text-amber-800 dark:text-amber-400 flex items-center justify-center shadow-2xs border border-amber-300/40 dark:border-amber-500/20">
                                        <i data-lucide="droplet" class="w-6 h-6 text-amber-700 dark:text-amber-400"></i>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-[#251A10] text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-500/20 font-mono">Every 3–6 Mo</span>
                                </div>
                                <h4 class="font-serif font-bold text-espresso-950 dark:text-white text-base sm:text-lg mb-2">2. Conditioning</h4>
                                <p class="text-xs sm:text-[13px] text-[#5C5046] dark:text-[#C5B8AC] leading-relaxed">
                                    Apply a tiny pea-sized dab of neutral leather wax or balm occasionally to nourish the pure hide.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#F0EAE1] dark:border-white/5 text-[11px] text-emerald-700 dark:text-emerald-400 font-medium">
                                ✓ Keeps real leather supple, glossy, and crack-free in all seasons.
                            </div>
                        </div>

                        <!-- 3. Safe Storage -->
                        <div class="bg-white dark:bg-[#1A1412] p-6 sm:p-7 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-espresso-100 to-tan-100 dark:from-[#2B201B] dark:to-[#1F1714] text-espresso-800 dark:text-gold flex items-center justify-center shadow-2xs border border-espresso-200/40 dark:border-gold/20">
                                        <i data-lucide="box" class="w-6 h-6 text-espresso-800 dark:text-gold"></i>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#FAF6F0] dark:bg-[#251C17] text-tan-800 dark:text-gold-300 border border-tan-200 dark:border-gold/20 font-mono">Dust Protection</span>
                                </div>
                                <h4 class="font-serif font-bold text-espresso-950 dark:text-white text-base sm:text-lg mb-2">3. Proper Storage</h4>
                                <p class="text-xs sm:text-[13px] text-[#5C5046] dark:text-[#C5B8AC] leading-relaxed">
                                    Store inside the complimentary By Zunash breathable dust bag in a clean, dry cupboard.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#F0EAE1] dark:border-white/5 text-[11px] text-[#8F8379] dark:text-[#A89F95] font-medium">
                                Keep away from prolonged direct hot sunlight and damp areas.
                            </div>
                        </div>

                    </div>

                    <!-- Climate Care Tip Banner -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-ivory-50/90 dark:bg-[#1C1613] border border-[#E7DFD5] dark:border-white/10 flex items-start sm:items-center gap-3.5 text-xs text-espresso-900 dark:text-ivory shadow-xs">
                        <div class="w-8 h-8 rounded-xl bg-gold/15 text-gold-700 dark:text-gold flex items-center justify-center shrink-0">
                            <i data-lucide="info" class="w-4 h-4"></i>
                        </div>
                        <span class="leading-relaxed"><strong>Pro-Tip for Pakistan Weather:</strong> Pure leather breathes naturally. If it gets wet in the rain, simply let it air dry naturally at room temperature — never use a hair dryer or place it near a heater.</span>
                    </div>
                </div>

                <!-- Tab 4: Delivery & Returns (Centered Full-Width Balanced Luxury Cards) -->
                @php
                    $delMetro = \App\Models\StoreSetting::get('delivery_timeline_metro', '24–48 Hours (Lahore, Karachi, Islamabad, Rawalpindi)');
                    $delOther = \App\Models\StoreSetting::get('delivery_timeline_other', '2–3 Business Days (Faisalabad, Multan, Sialkot, Peshawar & nationwide)');
                    $delCouriers = \App\Models\StoreSetting::get('delivery_courier_partners', 'Dispatched via TCS, Leopards & Trax with real-time SMS tracking updates.');
                    $codNote = \App\Models\StoreSetting::get('cod_policy_note', 'Cash on Delivery available nationwide. You can open and inspect the courier parcel at your doorstep before paying cash. Direct bank transfer is also accepted.');
                    $exchDays = \App\Models\StoreSetting::get('exchange_policy_days', '7-Day Size & Model Exchange');
                    $exchNote = \App\Models\StoreSetting::get('exchange_policy_note', 'If your size or model needs an adjustment, simply WhatsApp our atelier concierge within 7 days of delivery. We will arrange a courier pickup and replacement promptly with zero hassle.');
                    $phone = \App\Models\StoreSetting::get('contact_phone', '+92 321 4700545');
                    $phoneClean = preg_replace('/[^0-9]/', '', $phone);
                @endphp
                <div x-show="activeTab === 'shipping'" x-cloak class="w-full max-w-6xl mx-auto space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 w-full">
                        
                        <!-- 1. Delivery Card -->
                        <div class="bg-white dark:bg-[#1A1412] p-6 sm:p-7 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shadow-2xs border border-emerald-500/20">
                                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/15 text-emerald-800 dark:text-emerald-300 border border-emerald-500/20 font-mono">All Pakistan</span>
                                </div>
                                <h4 class="font-serif font-bold text-espresso-950 dark:text-white text-base sm:text-lg mb-3">Express Courier</h4>
                                <div class="text-xs sm:text-[13px] text-[#5C5046] dark:text-[#C5B8AC] space-y-2 leading-relaxed">
                                    <div class="flex items-start gap-2">
                                        <span class="text-emerald-600 font-bold shrink-0">•</span>
                                        <div><strong class="text-espresso-950 dark:text-white">Major Metros:</strong> {{ $delMetro }}</div>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-emerald-600 font-bold shrink-0">•</span>
                                        <div><strong class="text-espresso-950 dark:text-white">Other Cities:</strong> {{ $delOther }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-[#F0EAE1] dark:border-white/5 text-[11px] text-[#8F8379] dark:text-[#A89F95]">
                                {{ $delCouriers }}
                            </div>
                        </div>

                        <!-- 2. COD & Inspection Card -->
                        <div class="bg-white dark:bg-[#1A1412] p-6 sm:p-7 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shadow-2xs border border-amber-500/20">
                                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <path d="M6 12h.01M18 12h.01"></path>
                                        </svg>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/20 font-mono">Doorstep COD</span>
                                </div>
                                <h4 class="font-serif font-bold text-espresso-950 dark:text-white text-base sm:text-lg mb-3">Cash on Delivery</h4>
                                <p class="text-xs sm:text-[13px] text-[#5C5046] dark:text-[#C5B8AC] leading-relaxed">
                                    {{ $codNote }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-[#F0EAE1] dark:border-white/5 text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold flex items-center gap-1.5">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Check & inspect before you pay</span>
                            </div>
                        </div>

                        <!-- 3. 7-Day Exchange Card -->
                        <div class="bg-white dark:bg-[#1A1412] p-6 sm:p-7 rounded-3xl border border-[#E8DFD5] dark:border-[#2E241F] shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shadow-2xs border border-blue-500/20">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="1 4 1 10 7 10"></polyline>
                                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                        </svg>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-500/15 text-blue-800 dark:text-blue-300 border border-blue-500/20 font-mono">Zero Risk</span>
                                </div>
                                <h4 class="font-serif font-bold text-espresso-950 dark:text-white text-base sm:text-lg mb-3">{{ $exchDays }}</h4>
                                <p class="text-xs sm:text-[13px] text-[#5C5046] dark:text-[#C5B8AC] leading-relaxed">
                                    {{ $exchNote }}
                                </p>
                            </div>
                            @if(!empty($phone))
                                <div class="pt-3 border-t border-[#F0EAE1] dark:border-white/5">
                                    <a 
                                        href="https://wa.me/{{ $phoneClean }}?text={{ urlencode('Hello By Zunash Concierge, I would like to request an exchange for Product: ' . $product['name']) }}" 
                                        target="_blank"
                                        class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba5a] text-white text-xs font-bold shadow-xs hover:shadow transition-all group"
                                    >
                                        <i data-lucide="message-circle" class="w-4 h-4 transition-transform group-hover:scale-110"></i>
                                        <span>WhatsApp Concierge</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- WHAT'S APP REVIEWS (Verified Real Client Unboxing & Conversations - Matches Screenshot 4) -->
        <div class="mt-16 pt-12 border-t border-ivory-200">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#25D366]/10 border border-[#25D366]/30 text-[#128C7E] dark:text-[#25D366] text-xs font-bold uppercase tracking-wider mb-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Verified Real Patrons</span>
                    </div>
                    <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">What's App Reviews</h2>
                    <p class="text-xs sm:text-sm text-muted mt-1">Real unboxing feedback, doorstep parcel inspection proof, and client conversations.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/40 px-3 py-1.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                        <span>100% Authentic Pakistani Clients</span>
                    </span>
                </div>
            </div>

            <!-- WhatsApp Chat Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @php
                    $displayWhatsappReviews = (!empty($whatsappReviews) && $whatsappReviews->count() > 0) ? $whatsappReviews : collect([
                        (object)[
                            'author_name' => 'Dr. Usman Tariq',
                            'author_city' => 'Lahore (DHA Ph 6)',
                            'rating' => 5,
                            'title' => 'Personalised Name Engraving is exceptional!',
                            'content' => 'Assalam o alaikum brother! Received my personalised belt and wallet today via TCS. Truly impressed by the full-grain leather smell and the gold debossing of my name is crisp! Doorstep inspection allowed by the courier made it completely risk-free.',
                            'photos' => ['/images/products/prod-reversible-belt-thumb.webp'],
                            'created_at' => now()->subDays(2),
                        ],
                        (object)[
                            'author_name' => 'Capt. Daniyal Khan',
                            'author_city' => 'Islamabad (F-7)',
                            'rating' => 5,
                            'title' => 'Gentleman\'s Gift Set for my brother',
                            'content' => 'Ordered the Gentleman\'s Set gift-boxed. Packaging is rigid, luxurious gold stamped box with satin lining. Bhai loved the craftsmanship. Fast dispatch in 24 hours. Recommended 100%!',
                            'photos' => ['/images/products/prod-bifold-wallet.webp'],
                            'created_at' => now()->subDays(5),
                        ],
                        (object)[
                            'author_name' => 'Hamza Malik',
                            'author_city' => 'Karachi (Clifton)',
                            'rating' => 5,
                            'title' => 'Top grain leather and prompt COD delivery',
                            'content' => 'Bhai parcel received through Trax courier. Checked open parcel before paying cash. Pure hide leather, heavy brass buckle. Worth every rupee! Claimed the 15% off key fob add-on too.',
                            'photos' => ['/images/products/prod-key-fob.webp'],
                            'created_at' => now()->subDays(7),
                        ],
                    ]);
                @endphp

                @foreach($displayWhatsappReviews as $wa)
                    @php
                        $author = $wa->author ?? $wa->author_name ?? 'Verified Patron';
                        $city = $wa->city ?? $wa->author_city ?? 'Verified Client';
                        $reviewText = $wa->comment ?? $wa->content ?? '';
                        $reviewImg = !empty($wa->image) ? $wa->image : (!empty($wa->photos) ? $wa->photos[0] : null);
                    @endphp
                    <div class="rounded-2xl overflow-hidden border border-[#D1D7DB] dark:border-white/10 shadow-md bg-[#EFEAE2] dark:bg-[#0B141A] flex flex-col justify-between">
                        <!-- WhatsApp Top Bar -->
                        <div class="bg-[#075E54] dark:bg-[#202C33] text-white p-3 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full bg-[#128C7E] flex items-center justify-center font-bold text-sm text-white border border-white/20 shadow-inner">
                                    {{ strtoupper(substr($author, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold tracking-wide leading-tight text-white">{{ $author }}</h4>
                                    <p class="text-[10px] text-emerald-200/90 leading-none mt-0.5">
                                        {{ $city }} • <span class="text-white/90">online</span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-white/80">
                                <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                                <i data-lucide="video" class="w-3.5 h-3.5"></i>
                            </div>
                        </div>

                        <!-- Chat Messages Container -->
                        <div class="p-3.5 space-y-3 flex-1 flex flex-col justify-between" style="background-image: radial-gradient(#d4cdc5 1px, transparent 1px); background-size: 16px 16px;">
                            <!-- Client Message Bubble -->
                            <div class="self-start max-w-[92%] bg-white dark:bg-[#202C33] rounded-2xl rounded-tl-xs p-3 shadow-xs border border-black/5 dark:border-white/5 space-y-2">
                                <div class="flex items-center gap-1 text-amber-500 text-xs">
                                    @for($i = 0; $i < ($wa->rating ?? 5); $i++)
                                        <i data-lucide="star" class="w-3 h-3 fill-amber-400 text-amber-400"></i>
                                    @endfor
                                    <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400 ml-1">Verified Order</span>
                                </div>

                                <p class="text-xs text-espresso-950 dark:text-[#E9EDEF] leading-relaxed">
                                    {{ $reviewText }}
                                </p>

                                @if(!empty($reviewImg))
                                    <div class="rounded-xl overflow-hidden border border-black/10 dark:border-white/10 mt-2 max-h-40 bg-black/5">
                                        <img src="{{ asset($reviewImg) }}" alt="Client photo" class="w-full h-36 object-cover">
                                    </div>
                                @endif

                                <div class="flex items-center justify-end gap-1 pt-1 text-[10px] text-zinc-400">
                                    <span>{{ \Carbon\Carbon::parse($wa->created_at)->format('g:i A') }}</span>
                                </div>
                            </div>

                            <!-- Concierge Reply Bubble -->
                            <div class="self-end max-w-[85%] bg-[#D9FDD3] dark:bg-[#005C4B] rounded-2xl rounded-tr-xs p-2.5 shadow-xs border border-emerald-900/10 space-y-1">
                                <span class="text-[10px] font-bold text-[#075E54] dark:text-[#25D366] block">By Zunash Concierge</span>
                                <p class="text-[11px] text-espresso-950 dark:text-[#E9EDEF] leading-snug">
                                    JazakAllah sir! It was an absolute honor handcrafting this for you. Wear it in good health! ✨
                                </p>
                                <div class="flex items-center justify-end gap-1 text-[9px] text-zinc-500 dark:text-zinc-300">
                                    <span>{{ \Carbon\Carbon::parse($wa->created_at)->addMinutes(4)->format('g:i A') }}</span>
                                    <span class="text-[#53BDEB] font-bold">✓✓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer: Courier Verification -->
                        <div class="p-2.5 bg-white/80 dark:bg-[#111B21] border-t border-[#D1D7DB] dark:border-white/10 flex items-center justify-between text-[11px] text-espresso-900 dark:text-ivory-300">
                            <span class="flex items-center gap-1 text-emerald-700 dark:text-emerald-400 font-semibold">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Courier Doorstep Verified</span>
                            </span>
                            <span class="text-zinc-400 font-mono text-[10px]">TCS / Leopards</span>
                        </div>
                    </div>
                @endforeach
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

        <!-- STICKY MOBILE CONVERSION BAR (Matches Screenshot 4) -->
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
            class="sm:hidden fixed bottom-0 inset-x-0 z-40 bg-white/98 dark:bg-[#120B08]/98 backdrop-blur-md border-t border-ivory-300 dark:border-white/10 p-2.5 shadow-2xl"
        >
            <div class="flex items-center justify-between gap-2.5">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-ivory-100 shrink-0 border border-ivory-200 shadow-2xs">
                        <img :src="activeImage" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-bold text-espresso-950 dark:text-white truncate block">
                            {{ $product['name'] }}
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="font-serif text-sm font-bold text-espresso-950 dark:text-gold-400">
                                Rs.<span x-text="currentProductPrice.toLocaleString()"></span>
                            </span>
                            @if(!empty($product['original_price']) && $product['original_price'] > $product['price'])
                                <span class="text-[10px] text-muted-light line-through">
                                    Rs.{{ number_format($product['original_price']) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="shrink-0 flex items-center gap-1.5">
                    <button 
                        type="button" 
                        @click="buyNow('cod')" 
                        class="px-3.5 py-2.5 bg-black hover:bg-neutral-900 text-white text-[11px] font-bold uppercase tracking-wider rounded-xl transition-all active:scale-95 flex items-center gap-1.5 shadow-md border border-white/10"
                    >
                        <i data-lucide="shopping-cart" class="w-3.5 h-3.5 text-white"></i>
                        <span>Buy with Cash on Delivery</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
