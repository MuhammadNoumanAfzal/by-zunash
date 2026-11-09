@props(['product'])

@php
    $isOutOfStock = ($product['availability'] ?? '') === 'out_of_stock' || (isset($product['in_stock']) && !$product['in_stock']);
    $isOnDemand = ($product['availability'] ?? '') === 'on_demand';

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
@endphp

<div 
    x-data="{ 
        product: {{ $productJson }},
        isHovered: false,
        rotX: 0,
        rotY: 0,
        isTilting: false,
        onMove(e) {
            const rect = $el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const cx = rect.width / 2;
            const cy = rect.height / 2;
            this.rotX = ((y - cy) / cy) * -5;
            this.rotY = ((x - cx) / cx) * 5;
            this.isTilting = true;
        },
        onLeave() {
            this.rotX = 0;
            this.rotY = 0;
            this.isTilting = false;
            this.isHovered = false;
        }
    }" 
    @mousemove="onMove($event)"
    @mouseenter="isHovered = true"
    @mouseleave="onLeave()"
    :style="isTilting 
        ? `transform: perspective(1000px) rotateX(${rotX.toFixed(2)}deg) rotateY(${rotY.toFixed(2)}deg) translateY(-6px) scale(1.015); transition: transform 0.18s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.35s ease;` 
        : 'transform: perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px) scale(1); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;'"
    class="group relative flex flex-col bg-white rounded-xl border {{ $isOutOfStock ? 'border-ivory-300 opacity-95' : 'border-ivory-300 hover:border-gold-500/50' }} overflow-hidden shadow-xs hover:shadow-2xl hover:z-20 h-full will-change-transform"
>
    <!-- Image & Badges Container -->
    <div class="relative w-full aspect-square bg-[#F7F5F0] overflow-hidden">
        <!-- Badges -->
        <div class="absolute top-3 left-3 z-10 pointer-events-none">
            @if($isOutOfStock)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] uppercase tracking-wider font-bold border rounded-full backdrop-blur-md shadow-xs bg-rose-900/90 text-rose-100 border-rose-700/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                    Sold Out
                </span>
            @elseif($isOnDemand)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] uppercase tracking-wider font-bold border rounded-full backdrop-blur-md shadow-xs bg-amber-950/90 text-amber-200 border-amber-600/50">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    On Demand
                </span>
            @elseif(!empty($product['badge']))
                <x-user.components.product-badge :badge="$product['badge']" />
            @endif
        </div>

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
        <a href="{{ route('product.details', $product['slug']) }}" class="block w-full h-full relative" aria-label="View {{ $product['name'] }} details">
            <img 
                src="{{ asset($product['image']) }}" 
                alt="{{ $product['name'] }} - Handcrafted Full-Grain Leather by Zunash Pakistan" 
                loading="lazy"
                class="w-full h-full object-cover object-center transform transition-transform duration-700 ease-out group-hover:scale-105 {{ $isOutOfStock ? 'grayscale-[20%] opacity-85' : '' }}"
            >
            <!-- Secondary Image Hover Transition (if gallery has 2+ images) -->
            @if(!empty($product['gallery']) && count($product['gallery']) > 1 && !$isOutOfStock)
                <img 
                    src="{{ asset($product['gallery'][1]) }}" 
                    alt="{{ $product['name'] }} - Atelier Craftsmanship Detail Angle" 
                    loading="lazy"
                    class="absolute inset-0 w-full h-full object-cover object-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out"
                >
            @endif

            @if($isOutOfStock)
                <div class="absolute inset-0 bg-espresso-950/20 flex items-center justify-center pointer-events-none">
                    <span class="px-3 py-1 rounded bg-espresso-950/90 text-ivory text-[10px] uppercase tracking-widest font-bold border border-white/20 shadow-md">
                        Temporarily Sold Out
                    </span>
                </div>
            @endif
        </a>

        <!-- Quick Action Button Overlay (Slide Up on Hover) -->
        <div class="absolute inset-x-3 bottom-3 z-10 translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out">
            @if($isOutOfStock)
                <a 
                    href="{{ route('product.details', $product['slug']) }}"
                    class="w-full py-2 px-3 bg-zinc-900/95 backdrop-blur-sm text-ivory text-[11px] uppercase tracking-widest font-semibold rounded-lg shadow-lg hover:bg-gold-600 hover:text-espresso-950 transition-all flex items-center justify-center gap-1.5 border border-zinc-700"
                >
                    <i data-lucide="bell" class="w-3.5 h-3.5 text-gold-400"></i>
                    <span>Notify When In Stock</span>
                </a>
            @elseif($isOnDemand)
                <a 
                    href="{{ route('product.details', $product['slug']) }}"
                    class="w-full py-2 px-3 bg-amber-950/95 backdrop-blur-sm text-amber-200 text-[11px] uppercase tracking-widest font-semibold rounded-lg shadow-lg hover:bg-gold-500 hover:text-espresso-950 transition-all flex items-center justify-center gap-1.5 border border-gold/40"
                >
                    <i data-lucide="hammer" class="w-3.5 h-3.5 text-gold-400"></i>
                    <span>Order On Demand</span>
                </a>
            @else
                <button 
                    type="button" 
                    @click.stop="$store.cart.addItem(product)"
                    class="w-full py-2 px-3 bg-espresso-950/95 backdrop-blur-sm text-ivory text-[11px] uppercase tracking-widest font-semibold rounded-lg shadow-lg hover:bg-gold-500 hover:text-espresso-950 active:scale-95 transition-all flex items-center justify-center gap-1.5 border border-gold/40"
                >
                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
                    <span>Quick Add to Bag</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Product Details -->
    <div class="p-3 sm:p-3.5 flex flex-col flex-grow justify-between bg-white">
        <div>
            <!-- Category Tag -->
            <div class="flex items-center justify-between gap-1 mb-1">
                <span class="text-[10px] uppercase tracking-[0.16em] text-gold-700 font-semibold font-sans block">
                    {{ $product['category_name'] ?? $product['category'] }}
                </span>
                @if($isOutOfStock)
                    <span class="text-[10px] font-bold text-rose-700 uppercase tracking-wider font-sans">
                        Out of stock
                    </span>
                @elseif($isOnDemand)
                    <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider font-sans">
                        Bespoke
                    </span>
                @endif
            </div>

            <!-- Title -->
            <h3 class="font-serif text-[14px] sm:text-[15px] font-bold text-espresso-950 group-hover:text-gold-600 transition-colors line-clamp-1 mb-1.5 leading-snug">
                <a href="{{ route('product.details', $product['slug']) }}">
                    {{ $product['name'] }}
                </a>
            </h3>

            <!-- Color Swatches preview if available -->
            @if(!empty($product['colors']))
                <div class="flex items-center gap-1.5 mb-2">
                    @foreach($product['colors'] as $c)
                        <span 
                            class="w-2.5 h-2.5 rounded-full border border-black/20 shadow-xs inline-block" 
                            style="background-color: {{ $c['hex'] }};" 
                            title="{{ $c['name'] }}"
                        ></span>
                    @endforeach
                    <span class="text-[10px] text-muted-dark font-sans">({{ count($product['colors']) }} colors)</span>
                </div>
            @endif
        </div>

        <!-- Price & Details Button Section -->
        <div class="pt-2 border-t border-ivory-200 flex flex-col gap-2 mt-auto">
            <div class="flex items-baseline justify-between gap-1">
                <div class="flex flex-col">
                    <span class="text-[9px] uppercase tracking-wider text-muted-dark font-medium leading-none mb-0.5">Price</span>
                    <div class="flex items-baseline gap-1.5 flex-wrap">
                        <span class="font-sans text-[14px] sm:text-[15px] font-bold text-espresso-950 tracking-tight">
                            <span class="text-[10px] font-semibold text-gold-700 mr-0.5">PKR</span>{{ number_format($product['price']) }}
                        </span>
                        @if(!empty($product['original_price']))
                            <span class="text-[10px] sm:text-[11px] text-muted-light line-through font-sans">
                                {{ number_format($product['original_price']) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details Button - Full Width Touch Target -->
            <a 
                href="{{ route('product.details', $product['slug']) }}" 
                class="w-full py-1.5 px-2 rounded-lg bg-ivory-100 hover:bg-espresso-950 text-espresso-950 hover:text-white border border-ivory-300 hover:border-espresso-950 text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase transition-all duration-200 flex items-center justify-center gap-1.5 group/btn shadow-2xs active:scale-[0.98]"
            >
                <span>View Details</span>
                <i data-lucide="arrow-right" class="w-3 h-3 text-gold-600 group-hover/btn:text-gold-300 transition-transform group-hover/btn:translate-x-0.5"></i>
            </a>
        </div>
    </div>
</div>
