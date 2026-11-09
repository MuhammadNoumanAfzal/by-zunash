@extends('user.layouts.app')

@section('title', 'Curated Sets & Exclusive Deals | By Zunash Pakistan')
@section('meta_description', 'Discover curated sets and exclusive handcrafted leather deals by Atelier By Zunash. Pair complementary belts, wallets, and bags at exceptional bespoke rates.')
@section('meta_keywords', 'leather deals Pakistan, leather bundles Karachi, buy leather belt and wallet combo Lahore, luxury gift sets Pakistan, By Zunash deals')
@section('canonical', route('deals'))

@section('content')

<!-- ========================================================
     CLEAN, QUIET LUXURY HEADER
     ======================================================== -->
<section class="pt-8 pb-6 sm:pt-10 sm:pb-8 bg-[#FAF8F5] dark:bg-[#14100E] border-b border-[#ECE6DE] dark:border-white/10 text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <span class="text-[10px] uppercase tracking-[0.25em] font-semibold text-tan-600 dark:text-gold block mb-1.5 font-sans">
            Atelier Pairings
        </span>
        <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-normal text-espresso-950 dark:text-white tracking-tight">
            Curated Sets & Bundles
        </h1>
        <p class="text-xs sm:text-sm text-espresso-800/80 dark:text-ivory-300 font-light max-w-md mx-auto mt-2 leading-relaxed">
            Complementary leather creations sculpted from matching hides, paired at special atelier rates with complimentary gift packaging.
        </p>
    </div>
</section>

<!-- ========================================================
     COMPACT & REFINED DEALS GRID
     ======================================================== -->
<section class="py-8 sm:py-10 bg-white dark:bg-[#0F0C0A]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($deals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                @foreach($deals as $deal)
                    <div 
                        id="{{ $deal->slug }}" 
                        class="bg-[#FAF8F5] dark:bg-[#181310] rounded-2xl border border-[#ECE6DE] dark:border-white/10 shadow-2xs hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col group scroll-mt-24"
                    >
                        <!-- Image Container with Aspect Ratio -->
                        <div class="relative w-full aspect-[16/10] bg-[#F2EDE6] dark:bg-[#14100E] overflow-hidden">
                            <img 
                                src="{{ asset($deal->image ?: ($deal->products->first()->image ?? 'images/brand/artisan-craft.jpg')) }}" 
                                alt="{{ $deal->title }}" 
                                class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500 ease-out"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-espresso-950/60 via-transparent to-transparent opacity-50 group-hover:opacity-30 transition-opacity"></div>

                            <!-- Top-Left Badge -->
                            <div class="absolute top-3 left-3 z-10">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/95 dark:bg-black/90 backdrop-blur-xs text-espresso-950 dark:text-gold text-[9px] font-bold uppercase tracking-wider shadow-xs border border-ivory-300 dark:border-white/10">
                                    {{ $deal->badge ?: 'Curated Set' }}
                                </span>
                            </div>

                            <!-- Top-Right Savings Tag -->
                            @if($deal->savings_amount > 0)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-espresso-950/90 text-gold text-[10px] font-semibold tracking-tight border border-gold/40 shadow-xs">
                                        Save PKR {{ number_format($deal->savings_amount) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Bottom Item Count Pill -->
                            <div class="absolute bottom-2.5 left-3 z-10 text-[10px] font-semibold text-white/95 drop-shadow-sm flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
                                <span>{{ $deal->products->count() }}-Piece Atelier Set</span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 sm:p-5 flex flex-col flex-1 justify-between">
                            <div>
                                @if($deal->tagline)
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-tan-600 dark:text-gold block mb-1">
                                        {{ $deal->tagline }}
                                    </span>
                                @endif

                                <h3 class="font-serif text-base sm:text-lg font-bold text-espresso-950 dark:text-white leading-snug mb-1.5">
                                    {{ $deal->title }}
                                </h3>

                                @if($deal->description)
                                    <p class="text-xs text-espresso-800/75 dark:text-ivory-300 font-light line-clamp-2 leading-relaxed mb-3.5">
                                        {{ $deal->description }}
                                    </p>
                                @endif

                                <!-- Included Pieces: Minimal Duet Bar -->
                                <div class="p-2.5 rounded-xl bg-white dark:bg-[#201915] border border-[#ECE6DE] dark:border-white/10 mb-4">
                                    <div class="text-[9px] font-bold uppercase tracking-wider text-[#9E9084] mb-2 flex items-center justify-between">
                                        <span>Included Pieces</span>
                                        <span class="text-tan-600 dark:text-gold">Complimentary Gift Box</span>
                                    </div>

                                    <div class="flex items-center justify-between gap-2">
                                        @foreach($deal->products as $item)
                                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                                <div class="w-8 h-8 rounded-lg overflow-hidden bg-[#F2EDE6] shrink-0 border border-[#ECE6DE]">
                                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="min-w-0">
                                                    <a href="{{ route('product.details', $item->slug) }}" class="text-[11px] font-semibold text-espresso-950 dark:text-white truncate block hover:text-tan-600 transition-colors leading-tight">
                                                        {{ $item->name }}
                                                    </a>
                                                    <span class="text-[10px] text-[#8F8379] font-mono leading-none">
                                                        PKR {{ number_format($item->price) }}
                                                    </span>
                                                </div>
                                            </div>

                                            @if(!$loop->last)
                                                <span class="text-tan-500 font-bold text-xs shrink-0 px-1">+</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Price & Action Bar -->
                            <div class="pt-3 border-t border-[#ECE6DE] dark:border-white/10 flex items-center justify-between gap-3 mt-auto">
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-[#9E9084] font-medium block leading-none mb-0.5">
                                        Set Price
                                    </span>
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="font-serif text-lg sm:text-xl font-bold text-espresso-950 dark:text-white">
                                            <span class="text-xs text-tan-600 font-bold mr-0.5">PKR</span>{{ number_format($deal->deal_price) }}
                                        </span>
                                        @if($deal->effective_original_price > $deal->deal_price)
                                            <span class="text-xs text-[#A89C91] line-through font-sans">
                                                {{ number_format($deal->effective_original_price) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Add Set Button -->
                                <button 
                                    type="button" 
                                    @click="addDealToCart(@js($deal))" 
                                    class="px-4 py-2 bg-espresso-950 hover:bg-tan-600 text-white text-xs uppercase tracking-wider font-semibold rounded-full shadow-2xs hover:shadow-xs active:scale-95 transition-all flex items-center gap-1.5 shrink-0"
                                >
                                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5 text-gold"></i>
                                    <span>Add Set to Bag</span>
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-14 text-center max-w-sm mx-auto">
                <div class="w-12 h-12 rounded-xl bg-tan-50 dark:bg-tan-950/40 border border-tan-200 dark:border-tan-800 flex items-center justify-center text-tan-600 mx-auto mb-3">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <h3 class="font-serif text-lg font-bold text-espresso-950 dark:text-white mb-1">
                    No Deals Currently Active
                </h3>
                <p class="text-xs text-[#8F8379] font-light mb-4 leading-relaxed">
                    Our atelier curates exclusive pairings periodically. In the meantime, explore our catalog of individual pieces.
                </p>
                <a 
                    href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-espresso-950 text-white rounded-full text-xs uppercase tracking-wider font-semibold hover:bg-tan-600 transition-colors"
                >
                    <span>Browse All Creations</span>
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
        window.ZunashAlert.toast(`"${deal.title}" added to shopping bag.`, 'success');
    }
    cart.isOpen = true;
}
</script>

@endsection
