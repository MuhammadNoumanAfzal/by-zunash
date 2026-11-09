@extends('user.layouts.app')

@section('title', 'Curated Leather Sets & Deals | By Zunash Pakistan')
@section('meta_description', 'Discover curated sets and exclusive handcrafted leather deals by Atelier By Zunash. Pair complementary belts, wallets, and bags at exceptional bespoke rates.')
@section('meta_keywords', 'leather deals Pakistan, buy leather belt and wallet combo, luxury leather sets Pakistan, By Zunash')
@section('canonical', route('deals'))

@section('content')

<!-- ========================================================
     CLEAN, REFINED ATELIER HEADER
     ======================================================== -->
<section class="pt-10 pb-4 text-center bg-[#FAF8F5] dark:bg-[#14100E] border-b border-[#ECE6DE] dark:border-white/10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <span class="text-[10px] uppercase tracking-[0.25em] font-semibold text-gold-700 dark:text-gold-400 block mb-1">
            Atelier Curations
        </span>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white tracking-tight">
            Curated Leather Sets
        </h1>
        <p class="text-xs sm:text-sm text-espresso-800/80 dark:text-ivory-300 font-light max-w-md mx-auto mt-1.5 mb-2 leading-relaxed">
            Complementary creations sculpted from matching full-grain hides, paired at special bundle rates with complimentary gift packaging.
        </p>
    </div>
</section>

<!-- ========================================================
     COMPACT 3-COLUMN LUXURY SETS GRID
     ======================================================== -->
<section class="py-8 sm:py-10 bg-white dark:bg-[#0F0C0A]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($deals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($deals as $deal)
                    <div 
                        id="{{ $deal->slug }}" 
                        class="group bg-white dark:bg-[#181310] rounded-xl border border-ivory-300 dark:border-white/10 shadow-xs hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col scroll-mt-24"
                    >
                        <!-- Image Container (Compact Landscape Height) -->
                        <div class="relative w-full h-44 sm:h-48 md:h-52 bg-[#F7F5F0] dark:bg-[#14100E] overflow-hidden">
                            <img 
                                src="{{ asset($deal->image ?: ($deal->products->first()->image ?? 'images/brand/artisan-craft.jpg')) }}" 
                                alt="{{ $deal->title }}" 
                                class="w-full h-full object-cover object-center group-hover:scale-104 transition-transform duration-500 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-40 group-hover:opacity-20 transition-opacity"></div>

                            <!-- Top-Left Badge (Discount) -->
                            <div class="absolute top-2.5 left-2.5 z-10">
                                <span class="px-2.5 py-1 rounded bg-espresso-950/90 text-gold-300 text-[10px] font-bold uppercase tracking-wider backdrop-blur-xs shadow-xs border border-gold/30">
                                    {{ $deal->badge ?: 'Curated Set' }}
                                </span>
                            </div>

                            <!-- Top-Right Gift Box Indicator -->
                            <div class="absolute top-2.5 right-2.5 z-10">
                                <span class="px-2 py-0.5 rounded bg-black/60 backdrop-blur-xs text-white text-[9px] font-medium flex items-center gap-1">
                                    <i data-lucide="gift" class="w-3 h-3 text-gold"></i>
                                    <span>Gift Box Included</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 flex flex-col flex-1 justify-between">
                            <div>
                                @if($deal->tagline)
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-gold-700 dark:text-gold-400 block mb-0.5">
                                        {{ $deal->tagline }}
                                    </span>
                                @endif

                                <h3 class="font-serif text-[15px] sm:text-base font-bold text-espresso-950 dark:text-white truncate mb-1 group-hover:text-gold-600 transition-colors">
                                    {{ $deal->title }}
                                </h3>

                                @if($deal->description)
                                    <p class="text-xs text-espresso-800/75 dark:text-ivory-300 font-light line-clamp-2 leading-relaxed mb-3">
                                        {{ $deal->description }}
                                    </p>
                                @endif

                                <!-- Included Pieces Mini-List -->
                                <div class="p-2.5 rounded-lg bg-[#FAF8F5] dark:bg-[#201A16] border border-ivory-200 dark:border-white/10 mb-3">
                                    <div class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] dark:text-[#A09387] mb-1.5 flex items-center justify-between">
                                        <span>Included Pieces</span>
                                        <span class="text-gold-700 dark:text-gold-400 font-semibold">{{ $deal->products->count() }} Items</span>
                                    </div>

                                    <div class="space-y-1">
                                        @foreach($deal->products as $item)
                                            <div class="flex items-center justify-between gap-2 text-xs">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <div class="w-6 h-6 rounded overflow-hidden bg-white shrink-0 border border-ivory-200">
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
                            </div>

                            <!-- Bottom Price & CTA Bar -->
                            <div class="pt-2.5 border-t border-ivory-200 dark:border-white/10 flex items-center justify-between gap-2 mt-auto">
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-[#8F8379] dark:text-[#A09387] font-semibold block leading-none mb-0.5">
                                        Set Price
                                    </span>
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="font-serif text-base sm:text-lg font-bold text-espresso-950 dark:text-white">
                                            <span class="text-[10px] font-bold text-gold-600 mr-0.5">PKR</span>{{ number_format($deal->deal_price) }}
                                        </span>
                                        @if($deal->effective_original_price > $deal->deal_price)
                                            <span class="text-[11px] text-muted-light line-through font-sans">
                                                {{ number_format($deal->effective_original_price) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Add Set Button -->
                                <button 
                                    type="button" 
                                    @click="addDealToCart(@js($deal))" 
                                    class="px-3.5 py-1.5 bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 text-xs uppercase tracking-wider font-semibold rounded-lg shadow-2xs active:scale-95 transition-all flex items-center gap-1.5 shrink-0"
                                >
                                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5 text-gold"></i>
                                    <span>Add Set</span>
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-14 text-center max-w-sm mx-auto">
                <div class="w-12 h-12 rounded-xl bg-gold/15 border border-gold/40 flex items-center justify-center text-gold-700 mx-auto mb-3">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <h3 class="font-serif text-lg font-bold text-espresso-950 dark:text-white mb-1">
                    No Sets Currently Active
                </h3>
                <p class="text-xs text-[#8F8379] font-light mb-4 leading-relaxed">
                    Our atelier curates exclusive pairings periodically. In the meantime, explore our catalog of individual creations.
                </p>
                <a 
                    href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-espresso-950 text-white rounded-lg text-xs uppercase tracking-wider font-semibold hover:bg-gold hover:text-espresso-950 transition-colors"
                >
                    <span>Browse All Pieces</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        @endif

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
