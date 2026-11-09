@extends('user.layouts.app')

@section('title', 'Exclusive Leather Bundles & Curated Deals | By Zunash Pakistan')
@section('meta_description', 'Discover curated sets and exclusive handcrafted leather deals by Atelier By Zunash. Pair complementary belts, wallets, and bags at exceptional bespoke rates with free luxury gift packaging.')
@section('meta_keywords', 'leather deals Pakistan, leather bundles Karachi, buy leather belt and wallet combo Lahore, luxury gift sets Pakistan, By Zunash deals')
@section('canonical', route('deals'))

@section('content')

<!-- ========================================================
     HERO: CURATED ATELIER SETS & EXCLUSIVE BUNDLES
     ======================================================== -->
<section class="relative py-14 sm:py-16 lg:py-20 bg-[#FAF7F2] dark:bg-[#161210] border-b border-ivory-200 dark:border-white/10 overflow-hidden">
    <!-- Ambient subtle background glow -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-gold/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-chocolate-900/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Top Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-gold/15 border border-gold/40 text-gold-700 dark:text-gold-300 text-xs uppercase tracking-widest font-serif font-bold mb-4 shadow-2xs">
            <i data-lucide="award" class="w-3.5 h-3.5 text-gold-600 dark:text-gold-400"></i>
            <span>Curated Atelier Sets • Exclusive Bundles</span>
        </div>

        <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-normal text-espresso-950 dark:text-ivory tracking-tight leading-[1.12] mb-4">
            Harmonious Pairings. <br>
            <span class="italic font-light text-gold-600 dark:text-gold-400">Exceptional Atelier Value.</span>
        </h1>

        <p class="text-sm sm:text-base text-muted-dark dark:text-ivory-300 max-w-2xl mx-auto font-light leading-relaxed mb-8">
            Thoughtfully matched full-grain companion pieces sculpted from identical tanning drums. Bundled as cohesive executive sets with complimentary luxury presentation packaging and nationwide delivery.
        </p>

        <!-- Feature Pills -->
        <div class="inline-flex flex-wrap items-center justify-center gap-4 text-xs font-semibold text-espresso-800 dark:text-ivory-200">
            <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white dark:bg-[#241C18] border border-ivory-300 dark:border-white/10 shadow-2xs">
                <i data-lucide="gift" class="w-3.5 h-3.5 text-gold-600"></i>
                <span>Matte Gift Box Included</span>
            </span>
            <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white dark:bg-[#241C18] border border-ivory-300 dark:border-white/10 shadow-2xs">
                <i data-lucide="truck" class="w-3.5 h-3.5 text-gold-600"></i>
                <span>Free Nationwide Delivery</span>
            </span>
            <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white dark:bg-[#241C18] border border-ivory-300 dark:border-white/10 shadow-2xs">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold-600"></i>
                <span>Certified Full-Grain</span>
            </span>
        </div>
    </div>
</section>

<!-- ========================================================
     DEALS LISTING SECTION
     ======================================================== -->
<section class="py-12 sm:py-16 bg-white dark:bg-[#120E0C]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10 pb-6 border-b border-ivory-200 dark:border-white/10">
            <div class="flex items-center gap-2">
                <span class="font-serif text-lg font-bold text-espresso-950 dark:text-white">
                    Active Curated Sets
                </span>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-gold/15 text-gold-800 dark:text-gold-300">
                    {{ $deals->count() }} Available
                </span>
            </div>

            <!-- Search input -->
            <form action="{{ route('deals') }}" method="GET" class="relative w-full sm:w-72">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Search curated deals..." 
                    class="w-full pl-10 pr-4 py-2 text-xs rounded-full bg-[#FAF8F5] dark:bg-[#1A1513] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-gold-500"
                >
            </form>
        </div>

        @if($deals->count() > 0)
            <!-- Deals Cards Grid -->
            <div class="space-y-12">
                @foreach($deals as $deal)
                    <div 
                        id="{{ $deal->slug }}" 
                        class="rounded-3xl border border-ivory-300 dark:border-white/10 bg-[#FAF7F2]/60 dark:bg-[#1A1513] shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group scroll-mt-28"
                    >
                        <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">

                            <!-- Left: Deal Banner Image Showcase (5 Cols) -->
                            <div class="lg:col-span-5 relative bg-[#F4EFEA] dark:bg-[#14100E] overflow-hidden min-h-[300px] lg:min-h-full">
                                <img 
                                    src="{{ asset($deal->image ?: ($deal->products->first()->image ?? 'images/brand/artisan-craft.jpg')) }}" 
                                    alt="{{ $deal->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-espresso-950/80 via-transparent to-transparent opacity-70 group-hover:opacity-50 transition-opacity"></div>

                                <!-- Floating Badge -->
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-espresso-950/90 backdrop-blur-md border border-gold/40 text-gold-300 text-xs font-bold uppercase tracking-wider shadow-lg">
                                        <i data-lucide="tag" class="w-3.5 h-3.5 text-gold-400"></i>
                                        <span>{{ $deal->badge ?: 'Curated Set' }}</span>
                                    </span>
                                </div>

                                <!-- Savings Pill Over Image Bottom -->
                                @if($deal->savings_amount > 0)
                                    <div class="absolute bottom-4 left-4 z-10">
                                        <div class="px-3 py-1 rounded-xl bg-gold text-espresso-950 font-bold text-xs uppercase tracking-wider shadow-lg inline-flex items-center gap-1">
                                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                                            <span>Save PKR {{ number_format($deal->savings_amount) }} ({{ $deal->savings_percentage }}% Off)</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right: Deal Details, Included Products & Action (7 Cols) -->
                            <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between">
                                <div>
                                    <!-- Tagline -->
                                    @if($deal->tagline)
                                        <div class="text-[11px] font-bold uppercase tracking-[0.2em] text-gold-700 dark:text-gold-400 font-sans mb-1">
                                            {{ $deal->tagline }}
                                        </div>
                                    @endif

                                    <!-- Deal Title -->
                                    <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-ivory tracking-tight mb-3">
                                        {{ $deal->title }}
                                    </h2>

                                    <!-- Description -->
                                    @if($deal->description)
                                        <p class="text-xs sm:text-sm text-muted-dark dark:text-ivory-300 font-light leading-relaxed mb-6">
                                            {{ $deal->description }}
                                        </p>
                                    @endif

                                    <!-- Included Products Visual Row -->
                                    <div class="mb-6">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-espresso-900 dark:text-ivory-200 mb-3 flex items-center justify-between">
                                            <span class="flex items-center gap-1.5">
                                                <i data-lucide="layers" class="w-3.5 h-3.5 text-gold-600"></i>
                                                <span>{{ $deal->products->count() }} Handcrafted Pieces Included:</span>
                                            </span>
                                            <span class="text-[10px] text-muted font-normal">Individually Value Checked</span>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @foreach($deal->products as $item)
                                                <div class="p-3 rounded-2xl bg-white dark:bg-[#201A16] border border-ivory-300 dark:border-white/10 flex items-center gap-3 shadow-2xs group/item hover:border-gold-500/50 transition-colors">
                                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-ivory-100 shrink-0 border border-ivory-200">
                                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <span class="text-[9px] uppercase tracking-wider text-gold-700 dark:text-gold-400 font-semibold block">
                                                            {{ $item->category_name }}
                                                        </span>
                                                        <a href="{{ route('product.details', $item->slug) }}" class="text-xs font-serif font-bold text-espresso-950 dark:text-white truncate block hover:text-gold-600 transition-colors">
                                                            {{ $item->name }}
                                                        </a>
                                                        <div class="text-[11px] text-muted-dark dark:text-ivory-400 mt-0.5">
                                                            <span class="text-[10px] text-gold-600 font-bold">PKR</span> {{ number_format($item->price) }}
                                                            @if($item->pivot->quantity > 1)
                                                                <span class="text-[10px] text-espresso-900 dark:text-white font-bold ml-1">(Qty: {{ $item->pivot->quantity }})</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing & Add to Bag Footer -->
                                <div class="pt-6 border-t border-ivory-300 dark:border-white/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-auto">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold tracking-wider text-muted-dark dark:text-ivory-400 block mb-0.5">
                                            Curated Bundle Rate
                                        </span>
                                        <div class="flex items-baseline gap-2">
                                            <span class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                                                <span class="text-sm font-bold text-gold-600 mr-0.5">PKR</span>{{ number_format($deal->deal_price) }}
                                            </span>
                                            @if($deal->effective_original_price > $deal->deal_price)
                                                <span class="text-sm text-[#A89C91] line-through font-sans">
                                                    PKR {{ number_format($deal->effective_original_price) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Add Bundle to Bag Button -->
                                    <button 
                                        type="button" 
                                        @click="addDealToCart(@js($deal))" 
                                        class="px-8 py-3.5 rounded-full bg-espresso-950 hover:bg-gold text-white hover:text-espresso-950 text-xs uppercase tracking-widest font-bold shadow-luxury hover:shadow-gold-glow active:scale-95 transition-all flex items-center justify-center gap-2 group/btn"
                                    >
                                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                        <span>Add Bundle to Bag</span>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-20 text-center max-w-md mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-gold/15 border border-gold/40 flex items-center justify-center text-gold-700 mx-auto mb-4">
                    <i data-lucide="package" class="w-8 h-8"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-espresso-950 dark:text-white mb-2">
                    No Deals Currently Active
                </h3>
                <p class="text-xs text-muted-dark dark:text-ivory-300 font-light leading-relaxed mb-6">
                    Our atelier curates exclusive bundle releases periodically. In the meantime, explore our full collection of individual creations.
                </p>
                <a 
                    href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-espresso-950 text-white rounded-full text-xs uppercase tracking-widest font-semibold hover:bg-gold hover:text-espresso-950 transition-colors"
                >
                    <span>Browse All Creations</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
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
        alert('Cart is loading. Please try again.');
        return;
    }

    const cart = Alpine.store('cart');
    const dealKey = `deal-${deal.id}`;
    const existing = cart.items.find(item => item.key === dealKey);

    const dealItem = {
        key: dealKey,
        id: `deal-${deal.id}`,
        name: deal.title + ' (Curated Bundle)',
        price: Number(deal.deal_price),
        originalPrice: Number(deal.original_price || deal.deal_price),
        image: deal.image || (deal.products && deal.products[0] ? deal.products[0].image : '/images/brand/artisan-craft.jpg'),
        category: 'Curated Atelier Set',
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
        window.ZunashAlert.toast(`Curated Bundle "${deal.title}" added to shopping bag!`, 'success');
    }
    cart.isOpen = true;
}
</script>

@endsection
