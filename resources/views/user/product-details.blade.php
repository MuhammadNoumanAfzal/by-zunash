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
                "availability": "https://schema.org/InStock",
                "seller": {
                    "@type": "Organization",
                    "name": "By Zunash"
                }
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ $product['rating'] ?? 4.9 }}",
                "reviewCount": "{{ $product['reviews_count'] ?? 35 }}",
                "bestRating": "5",
                "worstRating": "1"
            }
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
    $productJson = json_encode([
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'original_price' => $product['original_price'] ?? null,
        'image' => $product['image'],
        'category' => $product['category'],
        'category_name' => $product['category_name'] ?? '',
        'slug' => $product['slug'],
        'colors' => $product['colors'] ?? []
    ]);
@endphp

<div 
    x-data="{ 
        product: {{ $productJson }},
        activeImage: '{{ $product['image'] }}',
        selectedColor: '{{ !empty($product['colors']) ? $product['colors'][0]['name'] : '' }}',
        quantity: 1,
        activeTab: 'specifications',
        addToCart() {
            $store.cart.addItem(this.product, this.selectedColor, this.quantity, true);
        },
        buyNow() {
            $store.cart.addItem(this.product, this.selectedColor, this.quantity);
            window.location.href = '{{ route('checkout') }}';
        }
    }" 
    class="bg-white min-h-screen py-8 lg:py-12"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-muted mb-8 uppercase tracking-widest font-serif">
            <a href="{{ route('home') }}" class="hover:text-espresso-900">Home</a>
            <span>/</span>
            <a href="{{ route('category', $product['category']) }}" class="hover:text-espresso-900">{{ $product['category_name'] }}</a>
            <span>/</span>
            <span class="text-espresso-900 font-semibold truncate">{{ $product['name'] }}</span>
        </nav>

        <!-- Product Presentation Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
            
            <!-- Gallery Section (Left 7 Cols) -->
            <div class="lg:col-span-7 space-y-4">
                <!-- Large Active Image -->
                <div class="relative aspect-[4/5] rounded-xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-luxury group">
                    <img 
                        :src="activeImage" 
                        alt="{{ $product['name'] }}" 
                        class="w-full h-full object-cover object-center transition-all duration-500 group-hover:scale-105"
                    >
                    @if(!empty($product['badge']))
                        <div class="absolute top-4 left-4 z-10">
                            <x-user.components.product-badge :badge="$product['badge']" />
                        </div>
                    @endif
                </div>

                <!-- Thumbnails Strip -->
                @if(!empty($product['gallery']) && count($product['gallery']) > 1)
                    <div class="flex items-center gap-3 overflow-x-auto pb-2">
                        @foreach($product['gallery'] as $img)
                            <button 
                                type="button" 
                                @click="activeImage = '{{ $img }}'" 
                                class="w-20 h-24 rounded-lg overflow-hidden border-2 flex-shrink-0 transition-all focus:outline-none"
                                :class="activeImage === '{{ $img }}' ? 'border-gold shadow-md' : 'border-ivory-300 opacity-70 hover:opacity-100'"
                            >
                                <img src="{{ $img }}" alt="{{ $product['name'] }} Thumbnail" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Action Details (Right 5 Cols) -->
            <div class="lg:col-span-5 flex flex-col justify-between">
                <div>
                    <!-- Collection Category Tag -->
                    <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold block mb-2">
                        {{ $product['category_name'] }}
                    </span>

                    <!-- Product Name -->
                    <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mb-3 leading-tight">
                        {{ $product['name'] }}
                    </h1>

                    <!-- Rating & Reviews Count -->
                    <div class="flex items-center gap-2 mb-6">
                        <div class="flex items-center gap-1 text-gold">
                            @for($i = 0; $i < 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                            @endfor
                        </div>
                        <span class="text-xs font-semibold text-espresso-900">{{ $product['rating'] }}</span>
                        <span class="text-xs text-muted">({{ $product['reviews_count'] }} client reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3 pb-6 border-b border-ivory-200 mb-6">
                        <span class="font-serif text-3xl font-bold text-espresso-950">
                            PKR {{ number_format($product['price']) }}
                        </span>
                        @if(!empty($product['original_price']))
                            <span class="text-sm text-muted-light line-through font-sans">
                                PKR {{ number_format($product['original_price']) }}
                            </span>
                            <span class="text-xs px-2 py-0.5 bg-gold/15 text-chocolate-800 rounded font-medium">
                                Save PKR {{ number_format($product['original_price'] - $product['price']) }}
                            </span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-sm text-espresso-800 leading-relaxed mb-6 font-light">
                        {{ $product['short_description'] }}
                    </p>

                    <!-- Color / Variant Selection -->
                    @if(!empty($product['colors']))
                        <div class="mb-6">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-2">
                                Leather Tone: <span class="font-normal text-muted" x-text="selectedColor"></span>
                            </label>
                            <div class="flex items-center gap-3">
                                @foreach($product['colors'] as $c)
                                    <button 
                                        type="button" 
                                        @click="selectedColor = '{{ $c['name'] }}'"
                                        class="p-1 rounded-full border-2 transition-all focus:outline-none"
                                        :class="selectedColor === '{{ $c['name'] }}' ? 'border-gold shadow-sm scale-110' : 'border-transparent hover:border-ivory-300'"
                                        title="{{ $c['name'] }}"
                                    >
                                        <span class="block w-6 h-6 rounded-full border border-black/20" style="background-color: {{ $c['hex'] }};"></span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity Selector & Actions -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center gap-4">
                            <!-- Qty Control -->
                            <div class="flex items-center border border-ivory-300 rounded-lg overflow-hidden bg-ivory-50">
                                <button 
                                    type="button" 
                                    @click="if(quantity > 1) quantity--" 
                                    class="w-10 h-12 flex items-center justify-center text-espresso-900 hover:bg-ivory-200 transition-colors"
                                >
                                    <i data-lucide="minus" class="w-4 h-4"></i>
                                </button>
                                <span class="w-12 text-center font-bold text-sm text-espresso-900" x-text="quantity"></span>
                                <button 
                                    type="button" 
                                    @click="quantity++" 
                                    class="w-10 h-12 flex items-center justify-center text-espresso-900 hover:bg-ivory-200 transition-colors"
                                >
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <!-- Add to Bag Button -->
                            <button 
                                type="button" 
                                @click="addToCart()" 
                                class="flex-1 py-3.5 px-6 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all flex items-center justify-center gap-2 border border-gold/30 active:scale-98"
                            >
                                <i data-lucide="shopping-bag" class="w-4 h-4 text-gold"></i>
                                <span>Add to Shopping Bag</span>
                            </button>

                            <!-- Wishlist Toggle Button -->
                            <button 
                                type="button" 
                                @click="$store.wishlist.toggle(product)" 
                                class="w-12 h-12 rounded-lg border border-ivory-300 flex items-center justify-center text-espresso-900 hover:border-gold hover:bg-ivory-50 transition-all focus:outline-none flex-shrink-0"
                                :class="$store.wishlist.has(product.id) ? 'border-chocolate-700 bg-ivory-100' : ''"
                                aria-label="Toggle wishlist"
                            >
                                <i 
                                    data-lucide="heart" 
                                    class="w-5 h-5 transition-colors" 
                                    :class="$store.wishlist.has(product.id) ? 'fill-chocolate-700 text-chocolate-700' : 'text-espresso-800'"
                                ></i>
                            </button>
                        </div>

                        <!-- Buy Now Button -->
                        <button 
                            type="button" 
                            @click="buyNow()" 
                            class="w-full py-3.5 px-6 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-lg shadow-md hover:shadow-gold-glow transition-all active:scale-98"
                        >
                            Buy Now (Cash on Delivery)
                        </button>
                    </div>

                    <!-- Trust & Shipping Badges -->
                    <div class="p-4 bg-ivory-50 rounded-lg border border-ivory-300 space-y-2.5 text-xs text-espresso-800">
                        <div class="flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4 text-gold-600 flex-shrink-0"></i>
                            <span>Dispatched via priority courier across Pakistan in 24–48 hours.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-gold-600 flex-shrink-0"></i>
                            <span>Cash on Delivery & Direct Bank Transfer available.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-4 h-4 text-gold-600 flex-shrink-0"></i>
                            <span>7-Day Easy Exchange Policy on unused leather goods.</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Specifications & Narrative Tabs -->
        <div class="mt-16 pt-12 border-t border-ivory-200">
            <!-- Tab Headers -->
            <div class="flex items-center gap-8 border-b border-ivory-200 pb-3">
                <button 
                    type="button" 
                    @click="activeTab = 'specifications'"
                    class="font-serif text-sm uppercase tracking-widest pb-3 font-semibold transition-colors relative"
                    :class="activeTab === 'specifications' ? 'text-espresso-900 border-b-2 border-gold' : 'text-muted hover:text-espresso-800'"
                >
                    Craftsmanship & Specs
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'description'"
                    class="font-serif text-sm uppercase tracking-widest pb-3 font-semibold transition-colors relative"
                    :class="activeTab === 'description' ? 'text-espresso-900 border-b-2 border-gold' : 'text-muted hover:text-espresso-800'"
                >
                    Full Atelier Story
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'shipping'"
                    class="font-serif text-sm uppercase tracking-widest pb-3 font-semibold transition-colors relative"
                    :class="activeTab === 'shipping' ? 'text-espresso-900 border-b-2 border-gold' : 'text-muted hover:text-espresso-800'"
                >
                    Delivery & Returns
                </button>
            </div>

            <!-- Tab Content -->
            <div class="py-8">
                <!-- Specifications Tab -->
                <div x-show="activeTab === 'specifications'" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-serif text-base font-bold text-espresso-900 mb-4">Highlights</h3>
                        <ul class="space-y-2 text-xs text-espresso-800 leading-relaxed">
                            @foreach($product['features'] as $feature)
                                <li class="flex items-start gap-2">
                                    <i data-lucide="check" class="w-4 h-4 text-gold-600 flex-shrink-0 mt-0.5"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-serif text-base font-bold text-espresso-900 mb-4">Technical Details</h3>
                        <dl class="divide-y divide-ivory-200 text-xs">
                            @foreach($product['specifications'] as $key => $val)
                                <div class="py-2.5 flex justify-between">
                                    <dt class="text-muted font-medium uppercase tracking-wider">{{ $key }}</dt>
                                    <dd class="text-espresso-900 font-semibold text-right">{{ $val }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" x-cloak class="max-w-3xl text-sm text-espresso-800 font-light leading-relaxed space-y-4">
                    <p>{{ $product['description'] }}</p>
                    <p class="text-xs text-muted italic">
                        Note on Natural Leather: Because each hide is distinct, subtle variations in grain pattern and warm tonal shading are natural hallmarks of authentic full-grain hide, making each By Zunash creation uniquely yours.
                    </p>
                </div>

                <!-- Shipping Tab -->
                <div x-show="activeTab === 'shipping'" x-cloak class="max-w-2xl text-xs text-espresso-800 space-y-4">
                    <p><strong class="font-serif uppercase tracking-wider text-espresso-900">Delivery Timeline:</strong> Major cities (Karachi, Lahore, Islamabad, Rawalpindi) arrive within 2–3 business days. Other regional cities and towns take 3–5 business days.</p>
                    <p><strong class="font-serif uppercase tracking-wider text-espresso-900">Exchange Window:</strong> Unworn products with original dust bags and tags may be exchanged within 7 days of delivery.</p>
                    <p><strong class="font-serif uppercase tracking-wider text-espresso-900">Payment:</strong> Cash on Delivery (COD) is supported nationwide. Direct online banking is available at checkout.</p>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(!empty($relatedProducts) && count($relatedProducts) > 0)
            <div class="mt-16 pt-12 border-t border-ivory-200">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Complementary Pieces</span>
                        <h2 class="font-serif text-2xl font-bold text-espresso-900 mt-1">You May Also Appreciate</h2>
                    </div>
                    <a href="{{ route('category', $product['category']) }}" class="text-xs uppercase tracking-wider text-muted hover:text-gold-600">
                        View All {{ $product['category_name'] }}
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <x-user.components.product-card :product="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
