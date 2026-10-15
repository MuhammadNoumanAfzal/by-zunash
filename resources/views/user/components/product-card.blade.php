@props(['product'])

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
        isHovered: false 
    }" 
    class="group relative flex flex-col bg-white rounded-lg border border-ivory-300/80 overflow-hidden shadow-xs hover:shadow-luxury hover:border-gold/40 transition-all duration-300"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
>
    <!-- Image & Badges Container -->
    <div class="relative w-full aspect-[4/5] bg-ivory-100 overflow-hidden">
        <!-- Badge -->
        @if(!empty($product['badge']))
            <div class="absolute top-3 left-3 z-10">
                <x-user.components.product-badge :badge="$product['badge']" />
            </div>
        @endif

        <!-- Wishlist Button -->
        <button 
            type="button"
            @click.stop="$store.wishlist.toggle(product)"
            class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm border border-ivory-300 flex items-center justify-center text-espresso-900 transition-all duration-200 hover:scale-110 hover:bg-white shadow-xs focus:outline-none"
            :aria-label="$store.wishlist.has(product.id) ? 'Remove from wishlist' : 'Save to wishlist'"
        >
            <i 
                data-lucide="heart" 
                class="w-4 h-4 transition-colors duration-200"
                :class="$store.wishlist.has(product.id) ? 'fill-red-600 text-red-600' : 'text-espresso-700 group-hover:text-gold-600'"
            ></i>
        </button>

        <!-- Product Image Link -->
        <a href="{{ route('product.details', $product['slug']) }}" class="block w-full h-full">
            <img 
                src="{{ $product['image'] }}" 
                alt="{{ $product['name'] }}" 
                loading="lazy"
                class="w-full h-full object-cover object-center transform transition-transform duration-700 ease-out group-hover:scale-105"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80';"
            >
            <!-- Secondary Image Hover Transition (if gallery has 2+ images) -->
            @if(!empty($product['gallery']) && count($product['gallery']) > 1)
                <img 
                    src="{{ $product['gallery'][1] }}" 
                    alt="{{ $product['name'] }} Alternate Angle" 
                    loading="lazy"
                    class="absolute inset-0 w-full h-full object-cover object-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out"
                >
            @endif
        </a>

        <!-- Quick Add Button Overlay (Slide Up on Hover) -->
        <div class="absolute inset-x-3 bottom-3 z-10 translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out">
            <button 
                type="button" 
                @click.stop="$store.cart.addItem(product)"
                class="w-full py-2.5 px-4 bg-espresso text-ivory text-xs uppercase tracking-widest font-medium rounded shadow-md hover:bg-chocolate-700 active:scale-95 transition-all flex items-center justify-center gap-2 border border-gold/30"
            >
                <i data-lucide="shopping-bag" class="w-3.5 h-3.5 text-gold"></i>
                <span>Quick Add to Bag</span>
            </button>
        </div>
    </div>

    <!-- Product Details -->
    <div class="p-4 flex flex-col flex-grow justify-between bg-white">
        <div>
            <!-- Category Tag -->
            <span class="text-[11px] uppercase tracking-wider text-muted font-medium block mb-1">
                {{ $product['category_name'] ?? $product['category'] }}
            </span>

            <!-- Title -->
            <h3 class="font-serif text-base font-semibold text-espresso-900 group-hover:text-tan-600 transition-colors line-clamp-1 mb-1.5">
                <a href="{{ route('product.details', $product['slug']) }}">
                    {{ $product['name'] }}
                </a>
            </h3>

            <!-- Color Swatches preview if available -->
            @if(!empty($product['colors']))
                <div class="flex items-center gap-1.5 mb-2.5">
                    @foreach($product['colors'] as $c)
                        <span 
                            class="w-3 h-3 rounded-full border border-black/20 shadow-xs inline-block" 
                            style="background-color: {{ $c['hex'] }};" 
                            title="{{ $c['name'] }}"
                        ></span>
                    @endforeach
                    <span class="text-[10px] text-muted-dark">({{ count($product['colors']) }} colors)</span>
                </div>
            @endif
        </div>

        <!-- Price Section -->
        <div class="pt-2 border-t border-ivory-200 flex items-baseline justify-between">
            <div class="flex items-baseline gap-2">
                <span class="font-serif text-base font-bold text-espresso-900">
                    PKR {{ number_format($product['price']) }}
                </span>
                @if(!empty($product['original_price']))
                    <span class="text-xs text-muted-light line-through font-sans">
                        PKR {{ number_format($product['original_price']) }}
                    </span>
                @endif
            </div>

            <!-- Detail link icon -->
            <a 
                href="{{ route('product.details', $product['slug']) }}" 
                class="text-muted hover:text-gold-600 transition-colors"
                title="View Details"
            >
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</div>
