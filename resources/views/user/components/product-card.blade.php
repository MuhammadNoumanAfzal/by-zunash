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
    class="group relative flex flex-col bg-white rounded-xl border border-ivory-300 hover:border-gold-500/50 overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
>
    <!-- Image & Badges Container -->
    <div class="relative w-full aspect-[4/5] bg-[#F7F5F0] overflow-hidden">
        <!-- Badge -->
        @if(!empty($product['badge']))
            <div class="absolute top-3 left-3 z-10 pointer-events-none">
                <x-user.components.product-badge :badge="$product['badge']" />
            </div>
        @endif

        <!-- Wishlist Button -->
        <button 
            type="button"
            @click.stop="$store.wishlist.toggle(product)"
            class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md border border-ivory-300 flex items-center justify-center text-espresso-900 transition-all duration-200 hover:scale-110 hover:bg-white shadow-xs focus:outline-none"
            :aria-label="$store.wishlist.has(product.id) ? 'Remove from wishlist' : 'Save to wishlist'"
        >
            <i 
                data-lucide="heart" 
                class="w-4 h-4 transition-colors duration-200"
                :class="$store.wishlist.has(product.id) ? 'fill-red-500 text-red-500' : 'text-espresso-700 hover:text-gold-600'"
            ></i>
        </button>

        <!-- Product Image Link -->
        <a href="{{ route('product.details', $product['slug']) }}" class="block w-full h-full">
            <img 
                src="{{ asset($product['image']) }}" 
                alt="{{ $product['name'] }}" 
                loading="lazy"
                class="w-full h-full object-cover object-center transform transition-transform duration-700 ease-out group-hover:scale-105"
            >
            <!-- Secondary Image Hover Transition (if gallery has 2+ images) -->
            @if(!empty($product['gallery']) && count($product['gallery']) > 1)
                <img 
                    src="{{ asset($product['gallery'][1]) }}" 
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
                class="w-full py-2.5 px-4 bg-espresso-950/95 backdrop-blur-sm text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-lg hover:bg-gold-500 hover:text-espresso-950 active:scale-95 transition-all flex items-center justify-center gap-2 border border-gold/40"
            >
                <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
                <span>Quick Add to Bag</span>
            </button>
        </div>
    </div>

    <!-- Product Details -->
    <div class="p-4 sm:p-5 flex flex-col flex-grow justify-between bg-white">
        <div>
            <!-- Category Tag -->
            <span class="text-[11px] uppercase tracking-[0.16em] text-gold-700 font-semibold font-sans block mb-1.5">
                {{ $product['category_name'] ?? $product['category'] }}
            </span>

            <!-- Title -->
            <h3 class="font-serif text-[16px] sm:text-[17px] font-bold text-espresso-950 group-hover:text-gold-600 transition-colors line-clamp-1 mb-2 leading-snug">
                <a href="{{ route('product.details', $product['slug']) }}">
                    {{ $product['name'] }}
                </a>
            </h3>

            <!-- Color Swatches preview if available -->
            @if(!empty($product['colors']))
                <div class="flex items-center gap-1.5 mb-3">
                    @foreach($product['colors'] as $c)
                        <span 
                            class="w-3 h-3 rounded-full border border-black/20 shadow-xs inline-block" 
                            style="background-color: {{ $c['hex'] }};" 
                            title="{{ $c['name'] }}"
                        ></span>
                    @endforeach
                    <span class="text-[11px] text-muted-dark font-sans">({{ count($product['colors']) }} colors)</span>
                </div>
            @endif
        </div>

        <!-- Price & Details Button Section -->
        <div class="pt-3 border-t border-ivory-200 flex items-center justify-between gap-2 mt-auto">
            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-wider text-muted-dark font-medium leading-none mb-1">Price</span>
                <div class="flex items-baseline gap-1.5">
                    <span class="font-sans text-base sm:text-[17px] font-bold text-espresso-950 tracking-tight">
                        <span class="text-[11px] font-semibold text-gold-700 mr-0.5">PKR</span>{{ number_format($product['price']) }}
                    </span>
                    @if(!empty($product['original_price']))
                        <span class="text-xs text-muted-light line-through font-sans">
                            {{ number_format($product['original_price']) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Details Button -->
            <a 
                href="{{ route('product.details', $product['slug']) }}" 
                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-ivory-100 hover:bg-espresso-950 text-espresso-950 hover:text-white border border-ivory-300 hover:border-espresso-950 text-xs font-semibold tracking-wider uppercase transition-all duration-200 group/btn shadow-2xs"
            >
                <span>Details</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-gold-600 group-hover/btn:text-gold-300 transition-transform group-hover/btn:translate-x-0.5"></i>
            </a>
        </div>
    </div>
</div>
