@extends('user.layouts.app')

@section('title', 'Exclusive Leather Deals, Bundles & Curated Sets | By Zunash Pakistan')
@section('meta_description', 'Discover high-converting curated leather sets, bundle builders, and exclusive atelier deals by By Zunash. Save on genuine full-grain belts, wallets, and bags.')
@section('meta_keywords', 'leather deals Pakistan, buy leather bundles, leather belt and wallet set Lahore, luxury gift sets Karachi, By Zunash')
@section('canonical', route('deals'))

@section('content')

<div x-data="dealsPageManager()" x-init="initPage()" class="relative">

    <!-- ========================================================
         1. STICKY TIERED CART PROGRESS BAR
         ======================================================== -->
    <div class="sticky top-16 z-30 bg-[#161210] text-ivory border-b border-gold/30 shadow-md py-2.5 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5">
            <!-- Left Info -->
            <div class="flex items-center gap-2 text-xs">
                <i data-lucide="sparkle" class="w-4 h-4 text-gold shrink-0"></i>
                <div>
                    <template x-if="$store.cart.subtotal < 6000">
                        <span>Add <strong class="text-gold font-bold" x-text="'PKR ' + (6000 - $store.cart.subtotal).toLocaleString()"></strong> to unlock <strong class="text-white">Free Nationwide Courier</strong></span>
                    </template>
                    <template x-if="$store.cart.subtotal >= 6000 && $store.cart.subtotal < 12000">
                        <span><strong class="text-emerald-400">Free Courier Unlocked!</strong> Add <strong class="text-gold" x-text="'PKR ' + (12000 - $store.cart.subtotal).toLocaleString()"></strong> for a <strong class="text-white">Free Leather Key Fob</strong></span>
                    </template>
                    <template x-if="$store.cart.subtotal >= 12000">
                        <span class="text-gold font-bold">🎉 VIP Status Unlocked: Free Courier + Complimentary Artisan Gift Included!</span>
                    </template>
                </div>
            </div>

            <!-- Right Progress Track & Cart Quick Link -->
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="w-full sm:w-48 h-2 rounded-full bg-white/10 overflow-hidden relative">
                    <div 
                        class="h-full bg-gradient-to-r from-tan-500 to-gold rounded-full transition-all duration-500" 
                        :style="'width: ' + Math.min(100, Math.round(($store.cart.subtotal / 12000) * 100)) + '%'"
                    ></div>
                </div>
                <button 
                    type="button" 
                    @click="$store.cart.isOpen = true" 
                    class="text-[11px] uppercase tracking-wider font-bold text-gold hover:text-white transition-colors shrink-0"
                >
                    Bag (<span x-text="$store.cart.count"></span>)
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================
         2. DEAL OF THE DAY / SPOTLIGHT HERO WITH COUNTDOWN
         ======================================================== -->
    @if($spotlightDeal)
    <section class="py-8 sm:py-10 bg-gradient-to-br from-[#FAF8F5] via-[#F4EFEA] to-[#FAF8F5] dark:from-[#181310] dark:via-[#120E0C] dark:to-[#181310] border-b border-[#ECE6DE] dark:border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1E1714] rounded-2xl border border-gold/40 shadow-xl overflow-hidden p-5 sm:p-7 relative">
                
                <!-- Ambient Gold Glow -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-gold/15 rounded-full blur-2xl pointer-events-none"></div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center relative z-10">
                    
                    <!-- Left: Spotlight Image + Urgency Badges -->
                    <div class="md:col-span-5 relative rounded-xl overflow-hidden aspect-[4/3] bg-[#F2EDE6]">
                        <img 
                            src="{{ asset($spotlightDeal->image ?: ($spotlightDeal->products->first()->image ?? 'images/brand/artisan-craft.jpg')) }}" 
                            alt="{{ $spotlightDeal->title }}" 
                            class="w-full h-full object-cover"
                        >
                        <!-- Top Badges -->
                        <div class="absolute top-2.5 left-2.5 flex items-center gap-1.5">
                            <span class="px-2.5 py-1 rounded-md bg-espresso-950 text-gold-300 text-[10px] font-bold uppercase tracking-wider shadow-sm border border-gold/40">
                                Deal of the Day
                            </span>
                            @if($spotlightDeal->savings_amount > 0)
                                <span class="px-2 py-0.5 rounded-md bg-emerald-600 text-white text-[10px] font-bold">
                                    SAVE {{ $spotlightDeal->savings_percentage }}%
                                </span>
                            @endif
                        </div>

                        <!-- Scarcity Badge -->
                        <div class="absolute bottom-2.5 left-2.5 z-10 px-2.5 py-1 rounded-md bg-black/75 backdrop-blur-xs text-white text-[10px] font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                            <span>Only 4 Sets Left at This Rate</span>
                        </div>
                    </div>

                    <!-- Right: Deal Info & Live Ticking Countdown -->
                    <div class="md:col-span-7 flex flex-col justify-between space-y-4">
                        <div>
                            <!-- Countdown Urgency Bar -->
                            <div class="inline-flex items-center gap-2 p-2 rounded-xl bg-gold/10 border border-gold/30 text-espresso-950 dark:text-white mb-3">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-gold-600"></i>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-tan-700 dark:text-gold">Offer Closes In:</span>
                                <div class="flex items-center gap-1 font-mono text-xs font-bold text-espresso-950 dark:text-white">
                                    <span class="px-1.5 py-0.5 rounded bg-white dark:bg-black/40 border border-gold/20" x-text="timer.hours">08</span>:
                                    <span class="px-1.5 py-0.5 rounded bg-white dark:bg-black/40 border border-gold/20" x-text="timer.minutes">42</span>:
                                    <span class="px-1.5 py-0.5 rounded bg-white dark:bg-black/40 border border-gold/20" x-text="timer.seconds">19</span>
                                </div>
                            </div>

                            <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-tan-600 dark:text-gold block">
                                {{ $spotlightDeal->tagline ?: 'Featured Atelier Pairing' }}
                            </span>

                            <h2 class="font-serif text-xl sm:text-2xl font-bold text-espresso-950 dark:text-white mt-0.5 mb-1.5">
                                {{ $spotlightDeal->title }}
                            </h2>

                            <p class="text-xs text-espresso-800/80 dark:text-ivory-300 font-light leading-relaxed mb-3">
                                {{ $spotlightDeal->description }}
                            </p>

                            <!-- Social Proof Indicator -->
                            <div class="flex items-center gap-2 text-[11px] text-[#8F8379] dark:text-[#A09387] mb-3">
                                <i data-lucide="flame" class="w-3.5 h-3.5 text-rose-500"></i>
                                <span>14 patrons claimed this combination in the last 4 hours</span>
                            </div>

                            <!-- Included items chips -->
                            <div class="flex items-center gap-2 flex-wrap">
                                @foreach($spotlightDeal->products as $sp)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#ECE6DE] text-[11px] font-semibold text-espresso-900 dark:text-ivory">
                                        <img src="{{ asset($sp->image) }}" class="w-4 h-4 rounded object-cover">
                                        <span>{{ $sp->name }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price & CTA -->
                        <div class="pt-3 border-t border-[#ECE6DE] dark:border-white/10 flex items-center justify-between gap-3">
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-[#9E9084] font-medium block">Spotlight Rate</span>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="font-serif text-xl sm:text-2xl font-bold text-espresso-950 dark:text-white">
                                        <span class="text-xs text-tan-600 font-bold mr-0.5">PKR</span>{{ number_format($spotlightDeal->deal_price) }}
                                    </span>
                                    @if($spotlightDeal->effective_original_price > $spotlightDeal->deal_price)
                                        <span class="text-xs text-[#A89C91] line-through font-sans">
                                            PKR {{ number_format($spotlightDeal->effective_original_price) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <button 
                                type="button" 
                                @click="addDealToCart(@js($spotlightDeal))" 
                                class="px-5 py-2.5 bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 text-xs uppercase tracking-wider font-bold rounded-xl shadow-md active:scale-95 transition-all flex items-center gap-2"
                            >
                                <i data-lucide="zap" class="w-3.5 h-3.5 text-gold"></i>
                                <span>Claim Spotlight Deal</span>
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ========================================================
         3. USER INTENT QUICK-FILTER TABS
         ======================================================== -->
    <section class="py-4 bg-[#FAF8F5] dark:bg-[#120E0C] border-b border-[#ECE6DE] dark:border-white/10 sticky top-[108px] z-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex items-center justify-between gap-3 overflow-x-auto scrollbar-none">
            <div class="flex items-center gap-2 shrink-0">
                <button 
                    type="button" 
                    @click="activeFilter = 'all'" 
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all"
                    :class="activeFilter === 'all' ? 'bg-espresso-950 text-white shadow-xs' : 'bg-white dark:bg-[#1E1714] text-espresso-800 dark:text-ivory-200 border border-[#ECE6DE] hover:border-tan-500'"
                >
                    All Deals
                </button>
                <button 
                    type="button" 
                    @click="activeFilter = 'bundles'" 
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all"
                    :class="activeFilter === 'bundles' ? 'bg-espresso-950 text-white shadow-xs' : 'bg-white dark:bg-[#1E1714] text-espresso-800 dark:text-ivory-200 border border-[#ECE6DE] hover:border-tan-500'"
                >
                    Curated Bundles
                </button>
                <button 
                    type="button" 
                    @click="activeFilter = 'budget'" 
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all"
                    :class="activeFilter === 'budget' ? 'bg-espresso-950 text-white shadow-xs' : 'bg-white dark:bg-[#1E1714] text-espresso-800 dark:text-ivory-200 border border-[#ECE6DE] hover:border-tan-500'"
                >
                    Under PKR 6,000
                </button>
                <button 
                    type="button" 
                    @click="activeFilter = 'builder'" 
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all flex items-center gap-1"
                    :class="activeFilter === 'builder' ? 'bg-gold text-espresso-950 font-bold shadow-xs' : 'bg-white dark:bg-[#1E1714] text-espresso-800 dark:text-ivory-200 border border-[#ECE6DE] hover:border-tan-500'"
                >
                    <i data-lucide="sliders" class="w-3 h-3"></i>
                    <span>Custom Bundle Builder</span>
                </button>
                <button 
                    type="button" 
                    @click="activeFilter = 'volume'" 
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all"
                    :class="activeFilter === 'volume' ? 'bg-espresso-950 text-white shadow-xs' : 'bg-white dark:bg-[#1E1714] text-espresso-800 dark:text-ivory-200 border border-[#ECE6DE] hover:border-tan-500'"
                >
                    Volume Tier Savings
                </button>
            </div>

            <!-- Instant Voucher Teaser -->
            <button 
                type="button" 
                @click="openMysteryModal = true" 
                class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gold/15 border border-gold/40 text-gold-800 dark:text-gold-300 text-xs font-bold shrink-0 hover:bg-gold/25 transition-colors"
            >
                <i data-lucide="gift" class="w-3.5 h-3.5"></i>
                <span>Reveal Mystery Voucher</span>
            </button>
        </div>
    </section>

    <!-- ========================================================
         4. INTERACTIVE MIX-AND-MATCH BUNDLE BUILDER
         ======================================================== -->
    <section x-show="activeFilter === 'all' || activeFilter === 'builder'" class="py-8 bg-white dark:bg-[#0F0C0A] border-b border-[#ECE6DE] dark:border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="p-5 sm:p-6 rounded-2xl bg-[#FAF8F5] dark:bg-[#1A1411] border border-gold/30 shadow-sm">
                
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-tan-600 dark:text-gold">
                            Interactive Atelier Tool
                        </span>
                        <h3 class="font-serif text-lg sm:text-xl font-bold text-espresso-950 dark:text-white">
                            Build Your Custom Duo & Unlock 20% Off
                        </h3>
                    </div>
                    <div class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200 self-start sm:self-auto">
                        Automatic 20% Discount at Checkout
                    </div>
                </div>

                <!-- 2 Slot Selector -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    
                    <!-- Slot 1: Primary Piece -->
                    <div class="p-4 rounded-xl bg-white dark:bg-[#221A16] border border-[#ECE6DE] dark:border-white/10">
                        <label class="block text-xs font-bold text-espresso-950 dark:text-white mb-2">
                            Step 1: Choose Primary Creation
                        </label>
                        <select 
                            x-model="selectedSlot1Id" 
                            @change="updateCustomBundle()" 
                            class="w-full p-2.5 text-xs rounded-lg bg-[#FAF8F5] dark:bg-[#14100E] border border-[#E0D7CB] text-espresso-900 dark:text-ivory font-medium"
                        >
                            @foreach($builderProducts as $bp)
                                <option value="{{ $bp['id'] }}">{{ $bp['name'] }} (PKR {{ number_format($bp['price']) }})</option>
                            @endforeach
                        </select>

                        <!-- Preview -->
                        <div class="mt-3 flex items-center gap-3">
                            <img :src="slot1Product.image" class="w-12 h-12 rounded-lg object-cover border border-[#ECE6DE]">
                            <div>
                                <span class="text-xs font-bold text-espresso-950 dark:text-white block" x-text="slot1Product.name"></span>
                                <span class="text-[11px] text-tan-600 font-mono" x-text="'PKR ' + Number(slot1Product.price).toLocaleString()"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Slot 2: Companion Piece -->
                    <div class="p-4 rounded-xl bg-white dark:bg-[#221A16] border border-[#ECE6DE] dark:border-white/10">
                        <label class="block text-xs font-bold text-espresso-950 dark:text-white mb-2">
                            Step 2: Choose Companion Piece
                        </label>
                        <select 
                            x-model="selectedSlot2Id" 
                            @change="updateCustomBundle()" 
                            class="w-full p-2.5 text-xs rounded-lg bg-[#FAF8F5] dark:bg-[#14100E] border border-[#E0D7CB] text-espresso-900 dark:text-ivory font-medium"
                        >
                            @foreach($builderProducts->reverse() as $bp)
                                <option value="{{ $bp['id'] }}">{{ $bp['name'] }} (PKR {{ number_format($bp['price']) }})</option>
                            @endforeach
                        </select>

                        <!-- Preview -->
                        <div class="mt-3 flex items-center gap-3">
                            <img :src="slot2Product.image" class="w-12 h-12 rounded-lg object-cover border border-[#ECE6DE]">
                            <div>
                                <span class="text-xs font-bold text-espresso-950 dark:text-white block" x-text="slot2Product.name"></span>
                                <span class="text-[11px] text-tan-600 font-mono" x-text="'PKR ' + Number(slot2Product.price).toLocaleString()"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Custom Bundle Calculator Bar -->
                <div class="p-4 rounded-xl bg-espresso-950 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gold/20 border border-gold/40 flex items-center justify-center text-gold shrink-0">
                            <i data-lucide="package-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-[11px] text-gold-300 font-bold uppercase tracking-wider">
                                Custom Pair Price (20% Applied)
                            </div>
                            <div class="flex items-baseline gap-2">
                                <span class="font-serif text-xl sm:text-2xl font-bold text-white" x-text="'PKR ' + customBundlePrice.toLocaleString()"></span>
                                <span class="text-xs text-white/50 line-through font-sans" x-text="'PKR ' + customOriginalPrice.toLocaleString()"></span>
                                <span class="text-xs text-emerald-400 font-bold" x-text="'(Save PKR ' + customSavings.toLocaleString() + ')'"></span>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="button" 
                        @click="addCustomBundleToCart()" 
                        class="px-6 py-2.5 rounded-full bg-gold hover:bg-gold-light text-espresso-950 font-bold text-xs uppercase tracking-wider shadow-sm transition-all flex items-center justify-center gap-2"
                    >
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        <span>Add Custom Duo to Bag</span>
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================
         5. CURATED DEALS & BUNDLES (FILTERABLE LIST)
         ======================================================== -->
    <section x-show="activeFilter === 'all' || activeFilter === 'bundles' || activeFilter === 'budget'" class="py-8 sm:py-10 bg-white dark:bg-[#0F0C0A]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            <div class="flex items-center justify-between mb-6 pb-2 border-b border-[#ECE6DE] dark:border-white/10">
                <h3 class="font-serif text-lg font-bold text-espresso-950 dark:text-white">
                    Signature Atelier Deals
                </h3>
                <span class="text-xs text-[#8F8379] font-medium" x-text="filteredDealsCount + ' Sets Available'"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                @foreach($deals as $deal)
                    <div 
                        x-show="isDealVisible({{ (float)$deal->deal_price }})"
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

        </div>
    </section>

    <!-- ========================================================
         6. VOLUME TIER PRICING TABLE (MULTI-BUY SAVINGS)
         ======================================================== -->
    <section x-show="activeFilter === 'all' || activeFilter === 'volume'" class="py-8 bg-[#FAF8F5] dark:bg-[#120E0C] border-t border-[#ECE6DE] dark:border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            
            <div class="text-center mb-6">
                <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-tan-600 dark:text-gold block mb-1">
                    Multi-Quantity Privilege
                </span>
                <h3 class="font-serif text-xl sm:text-2xl font-bold text-espresso-950 dark:text-white">
                    Everyday Carry Volume Tier Savings
                </h3>
                <p class="text-xs text-muted-dark dark:text-ivory-300 font-light max-w-md mx-auto mt-1">
                    Ideal for corporate gifts, groomsmen sets, or family keepsakes. The more pieces you commission, the greater the privilege.
                </p>
            </div>

            @php
                $sampleTierProduct = $builderProducts->first();
            @endphp
            @if($sampleTierProduct)
                <div class="bg-white dark:bg-[#1A1411] rounded-2xl border border-[#ECE6DE] dark:border-white/10 p-5 sm:p-6 shadow-xs max-w-2xl mx-auto">
                    <div class="flex items-center gap-4 pb-4 border-b border-[#ECE6DE] dark:border-white/10 mb-4">
                        <img src="{{ asset($sampleTierProduct['image']) }}" class="w-16 h-16 rounded-xl object-cover border border-[#ECE6DE]">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-tan-600">{{ $sampleTierProduct['category_name'] }}</span>
                            <h4 class="font-serif text-base font-bold text-espresso-950 dark:text-white">{{ $sampleTierProduct['name'] }}</h4>
                            <span class="text-xs text-muted-dark font-mono">Regular: PKR {{ number_format($sampleTierProduct['price']) }} each</span>
                        </div>
                    </div>

                    <!-- Step-Save Tier Table -->
                    <div class="grid grid-cols-3 gap-2.5 text-center mb-4">
                        <div class="p-3 rounded-xl border border-ivory-300 dark:border-white/10 bg-[#FAF8F5] dark:bg-[#14100E]">
                            <div class="text-[10px] font-bold uppercase text-[#8F8379]">Tier 1: Buy 1</div>
                            <div class="text-sm font-bold text-espresso-950 dark:text-white mt-1">Standard</div>
                            <div class="text-[10px] text-muted-dark mt-0.5">PKR {{ number_format($sampleTierProduct['price']) }}</div>
                            <button 
                                type="button" 
                                @click="$store.cart.addItem(@js($sampleTierProduct), null, 1)" 
                                class="mt-2 w-full py-1 text-[10px] font-bold rounded-md bg-espresso-900 text-white hover:bg-gold hover:text-espresso-950 transition-colors"
                            >
                                Add 1
                            </button>
                        </div>

                        <div class="p-3 rounded-xl border-2 border-tan-600 bg-tan-50/50 dark:bg-tan-950/20 relative">
                            <span class="absolute -top-2 left-1/2 -translate-x-1/2 px-1.5 py-0.2 rounded-full text-[8px] font-bold bg-tan-600 text-white uppercase">Most Popular</span>
                            <div class="text-[10px] font-bold uppercase text-tan-700 dark:text-gold">Tier 2: Buy 2</div>
                            <div class="text-sm font-bold text-emerald-600 mt-1">15% Off</div>
                            <div class="text-[10px] text-muted-dark mt-0.5">PKR {{ number_format(round($sampleTierProduct['price'] * 0.85)) }} each</div>
                            <button 
                                type="button" 
                                @click="$store.cart.addVolumeItem(@js($sampleTierProduct), 2, 15)" 
                                class="mt-2 w-full py-1 text-[10px] font-bold rounded-md bg-tan-600 text-white hover:bg-tan-700 transition-colors"
                            >
                                Add 2 (Save 15%)
                            </button>
                        </div>

                        <div class="p-3 rounded-xl border border-gold/40 bg-gold/10 dark:bg-gold/5">
                            <div class="text-[10px] font-bold uppercase text-gold-700 dark:text-gold-300">Tier 3: Buy 3+</div>
                            <div class="text-sm font-bold text-emerald-600 mt-1">25% Off</div>
                            <div class="text-[10px] text-muted-dark mt-0.5">PKR {{ number_format(round($sampleTierProduct['price'] * 0.75)) }} each</div>
                            <button 
                                type="button" 
                                @click="$store.cart.addVolumeItem(@js($sampleTierProduct), 3, 25)" 
                                class="mt-2 w-full py-1 text-[10px] font-bold rounded-md bg-gold-600 text-espresso-950 font-bold hover:bg-gold-500 transition-colors"
                            >
                                Add 3 (Save 25%)
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- ========================================================
         7. MYSTERY DISCOUNT / REVEAL VOUCHER MODAL
         ======================================================== -->
    <div 
        x-show="openMysteryModal" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs"
        @keydown.escape.window="openMysteryModal = false"
    >
        <div 
            @click.away="openMysteryModal = false"
            class="bg-white dark:bg-[#1A1411] rounded-2xl border border-gold/40 max-w-sm w-full p-6 text-center relative shadow-2xl"
        >
            <button 
                type="button" 
                @click="openMysteryModal = false" 
                class="absolute top-3 right-3 text-[#A89C91] hover:text-espresso-950 dark:hover:text-white"
            >
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>

            <div class="w-12 h-12 rounded-xl bg-gold/15 border border-gold/40 flex items-center justify-center text-gold mx-auto mb-3">
                <i data-lucide="gift" class="w-6 h-6"></i>
            </div>

            <h3 class="font-serif text-lg font-bold text-espresso-950 dark:text-white mb-1">
                Atelier Mystery Privilege
            </h3>
            <p class="text-xs text-muted-dark dark:text-ivory-300 font-light mb-4">
                Claim your private voucher code for an instant 15% discount applied directly to your shopping bag.
            </p>

            <!-- Scratch / Reveal Box -->
            <div class="p-4 rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border-2 border-dashed border-gold/50 mb-4">
                <div class="text-[10px] uppercase font-bold text-tan-600 mb-1">Exclusive Voucher Code</div>
                <div class="font-mono text-xl font-bold tracking-widest text-espresso-950 dark:text-gold">
                    ATELIER15
                </div>
                <div class="text-[10px] text-emerald-600 font-semibold mt-1">15% Off Your Entire Bag</div>
            </div>

            <button 
                type="button" 
                @click="$store.cart.applyCoupon('ATELIER15', 15); openMysteryModal = false;" 
                class="w-full py-2.5 rounded-full bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 text-xs uppercase font-bold tracking-wider transition-all"
            >
                1-Click Apply to Bag
            </button>
        </div>
    </div>

    <!-- ========================================================
         8. EXIT-INTENT CART-SAVER MODAL
         ======================================================== -->
    <div 
        x-show="showExitModal" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs"
    >
        <div 
            @click.away="showExitModal = false"
            class="bg-gradient-to-br from-[#1C1512] to-black text-ivory rounded-2xl border border-gold/50 max-w-md w-full p-6 text-center relative shadow-2xl"
        >
            <button 
                type="button" 
                @click="showExitModal = false" 
                class="absolute top-3 right-3 text-white/50 hover:text-white"
            >
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>

            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-widest bg-gold text-espresso-950 inline-block mb-3">
                Wait! Exclusive Patron Privilege
            </span>

            <h3 class="font-serif text-xl font-bold text-white mb-2">
                Before You Go: Unlock Free Express Courier
            </h3>
            <p class="text-xs text-ivory-300 font-light leading-relaxed mb-4">
                Complete your leather commission in the next 10 minutes and receive complimentary VIP priority dispatch anywhere in Pakistan.
            </p>

            <div class="p-3 rounded-xl bg-white/5 border border-white/10 mb-4 flex items-center justify-center gap-3 font-mono text-sm text-gold">
                <i data-lucide="clock" class="w-4 h-4"></i>
                <span x-text="exitTimer.minutes + ':' + exitTimer.seconds">09:59</span>
            </div>

            <div class="flex items-center gap-2">
                <button 
                    type="button" 
                    @click="$store.cart.applyCoupon('FREESHIP', 5, 'Free VIP Express Delivery'); showExitModal = false;" 
                    class="flex-1 py-2.5 rounded-full bg-gold hover:bg-gold-light text-espresso-950 text-xs font-bold uppercase tracking-wider transition-all"
                >
                    Claim Free Courier
                </button>
                <button 
                    type="button" 
                    @click="showExitModal = false" 
                    class="px-4 py-2.5 text-xs text-white/60 hover:text-white"
                >
                    Dismiss
                </button>
            </div>
        </div>
    </div>

</div>

<!-- ========================================================
     ALPINE MANAGER SCRIPT FOR DEALS PAGE INTERACTIVITY
     ======================================================== -->
<script>
function dealsPageManager() {
    const builderProds = @json($builderProducts);

    return {
        activeFilter: 'all',
        openMysteryModal: false,
        showExitModal: false,
        hasShownExitModal: false,

        // Countdown timer for Deal of the Day
        timer: {
            hours: '08',
            minutes: '42',
            seconds: '19',
            totalSeconds: 31339
        },

        // Exit timer (10 mins)
        exitTimer: {
            minutes: '09',
            seconds: '59',
            totalSeconds: 599
        },

        // Custom Bundle Builder Slots
        selectedSlot1Id: builderProds[0] ? builderProds[0].id : 1,
        selectedSlot2Id: builderProds[1] ? builderProds[1].id : 2,
        slot1Product: builderProds[0] || {},
        slot2Product: builderProds[1] || {},

        initPage() {
            this.updateCustomBundle();
            this.startTimers();
            this.setupExitIntent();
        },

        updateCustomBundle() {
            this.slot1Product = builderProds.find(p => p.id == this.selectedSlot1Id) || builderProds[0] || {};
            this.slot2Product = builderProds.find(p => p.id == this.selectedSlot2Id) || builderProds[1] || {};
        },

        get customOriginalPrice() {
            return (Number(this.slot1Product.price) || 0) + (Number(this.slot2Product.price) || 0);
        },

        get customBundlePrice() {
            return Math.round(this.customOriginalPrice * 0.80); // 20% bundle discount
        },

        get customSavings() {
            return Math.max(0, this.customOriginalPrice - this.customBundlePrice);
        },

        addCustomBundleToCart() {
            if (!window.Alpine || !Alpine.store('cart')) return;
            const bundleName = `${this.slot1Product.name} + ${this.slot2Product.name}`;
            Alpine.store('cart').addCustomBundle(
                bundleName,
                [this.slot1Product, this.slot2Product],
                this.customBundlePrice,
                this.customOriginalPrice,
                this.slot1Product.image
            );
        },

        isDealVisible(price) {
            if (this.activeFilter === 'all' || this.activeFilter === 'bundles') return true;
            if (this.activeFilter === 'budget') return price <= 6000;
            return true;
        },

        get filteredDealsCount() {
            return {{ $deals->count() }};
        },

        startTimers() {
            setInterval(() => {
                if (this.timer.totalSeconds > 0) {
                    this.timer.totalSeconds--;
                    const h = Math.floor(this.timer.totalSeconds / 3600);
                    const m = Math.floor((this.timer.totalSeconds % 3600) / 60);
                    const s = this.timer.totalSeconds % 60;
                    this.timer.hours = String(h).padStart(2, '0');
                    this.timer.minutes = String(m).padStart(2, '0');
                    this.timer.seconds = String(s).padStart(2, '0');
                }

                if (this.showExitModal && this.exitTimer.totalSeconds > 0) {
                    this.exitTimer.totalSeconds--;
                    const m = Math.floor(this.exitTimer.totalSeconds / 60);
                    const s = this.exitTimer.totalSeconds % 60;
                    this.exitTimer.minutes = String(m).padStart(2, '0');
                    this.exitTimer.seconds = String(s).padStart(2, '0');
                }
            }, 1000);
        },

        setupExitIntent() {
            document.addEventListener('mouseleave', (e) => {
                if (e.clientY <= 0 && !this.hasShownExitModal) {
                    this.showExitModal = true;
                    this.hasShownExitModal = true;
                }
            });
        }
    };
}

function addDealToCart(deal) {
    if (!window.Alpine || !Alpine.store('cart')) return;

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
