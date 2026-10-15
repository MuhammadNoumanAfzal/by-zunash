@extends('user.layouts.app')

@section('title', 'By Zunash | Crafted to Be Yours — Luxury Pakistani Leather Goods')
@section('meta_description', 'Experience heirloom Pakistani leathercraft. Handcrafted full-grain belts, structured handbags, slim wallets, and accessories. Nationwide Cash on Delivery.')
@section('meta_keywords', 'luxury leather Pakistan, pure leather belts Lahore, handcrafted leather wallets Karachi, genuine leather handbags Islamabad, Pakistani leather brands, By Zunash atelier, cash on delivery leather')
@section('canonical', route('home'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Store",
    "@id": "{{ route('home') }}/#store",
    "name": "By Zunash",
    "image": "{{ asset('images/hero/slide-bag.jpg') }}",
    "url": "{{ route('home') }}",
    "telephone": "+92-300-1234567",
    "priceRange": "PKR 1,850 - PKR 18,900",
    "currenciesAccepted": "PKR",
    "paymentAccepted": "Cash on Delivery, Direct Bank Transfer, Visa, MasterCard",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Gulberg III",
        "addressLocality": "Lahore",
        "addressRegion": "Punjab",
        "postalCode": "54000",
        "addressCountry": "PK"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": 31.5204,
        "longitude": 74.3587
    },
    "openingHoursSpecification": [
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "opens": "10:00",
            "closes": "21:00"
        }
    ]
}
</script>
@endpush

@section('content')

<!-- ========================================================
     C. REDESIGNED HIGH-END EDITORIAL HERO SECTION
     ======================================================== -->
<!-- ========================================================
     C. COMPACT CINEMATIC EDITORIAL HERO SLIDER
     ======================================================== -->
<section 
    x-data="{
        currentSlide: 0,
        autoplayTimer: null,
        totalSlides: 3,
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        goTo(idx) {
            this.currentSlide = idx;
        },
        startAutoplay() {
            this.stopAutoplay();
            this.autoplayTimer = setInterval(() => {
                this.next();
            }, 6000);
        },
        stopAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
                this.autoplayTimer = null;
            }
        }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    class="relative w-full h-[460px] sm:h-[500px] lg:h-[540px] overflow-hidden bg-black text-ivory select-none"
>
    <!-- ================= SLIDE 1: HANDBAGS / SATCHEL ================= -->
    <div 
        x-show="currentSlide === 0"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-400 absolute inset-0"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 w-full h-full"
    >
        <!-- Generated Background Image (Absolute so it doesn't push down text) -->
        <img 
            src="{{ asset('images/hero/slide-bag.jpg') }}" 
            alt="By Zunash Handcrafted Italian Leather Bag" 
            class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.95] contrast-[1.02]"
        >
        <!-- Lighter Subtle Luxury Gradient Scrim (Lets the leather photo shine through) -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/65 via-black/35 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-black/15"></div>

        <!-- Overlaid Animated Text Content -->
        <div class="relative z-10 w-full h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl py-6">
                    
                    <!-- Tag / Badge (NO numbers) -->
                    <div class="inline-flex items-center gap-2 mb-3 animate-hero-tag">
                        <span class="px-3.5 py-1.5 rounded-full bg-black/45 border border-gold/45 text-gold-300 text-xs uppercase tracking-widest font-serif backdrop-blur-md shadow-sm flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                            The Heirloom Collection
                        </span>
                    </div>

                    <!-- Animated Headline -->
                    <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-[1.1] mb-3.5 drop-shadow-[0_4px_14px_rgba(0,0,0,0.65)] animate-hero-title">
                        Crafted to Be 
                        <span class="italic font-light text-gold-300 relative inline-block ml-1">
                            Yours.
                            <span class="absolute left-0 -bottom-1 w-full h-[2px] bg-gradient-to-r from-gold via-gold-light to-transparent"></span>
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="text-sm sm:text-base text-white/95 font-light leading-relaxed max-w-xl mb-6 drop-shadow-[0_2px_8px_rgba(0,0,0,0.75)] line-clamp-2 animate-hero-desc">
                        Hand-sculpted full-grain leather silhouettes and bespoke antique gold accents tailored for Pakistan's most discerning patrons. Created to mature with quiet grace.
                    </p>

                    <!-- CTAs & Spec Pill -->
                    <div class="flex flex-wrap items-center gap-4 animate-hero-actions">
                        <a 
                            href="{{ route('category', 'handbags') }}" 
                            class="px-7 py-3.5 bg-gold hover:bg-gold-light text-black text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow transition-all duration-300 flex items-center gap-2 group active:scale-95"
                        >
                            <span>Shop Handbags</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        
                        <a 
                            href="{{ route('about') }}" 
                            class="px-6 py-3.5 bg-black/40 hover:bg-white/20 text-white text-xs uppercase tracking-widest font-semibold rounded-lg border border-white/35 hover:border-gold/50 backdrop-blur-md transition-all duration-300 text-center"
                        >
                            Discover Atelier
                        </a>

                        <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2.5 rounded-full bg-black/45 border border-white/25 text-xs text-white/90 backdrop-blur-md">
                            <i data-lucide="award" class="w-3.5 h-3.5 text-gold"></i>
                            <span>100% Full-Grain Italian Hide</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= SLIDE 2: LEATHER BELTS ================= -->
    <div 
        x-show="currentSlide === 1"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-400 absolute inset-0"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 w-full h-full"
    >
        <!-- Generated Background Image (Absolute so it doesn't push down text) -->
        <img 
            src="{{ asset('images/hero/slide-belt.jpg') }}" 
            alt="By Zunash Reversible Calfskin Leather Belts" 
            class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.95] contrast-[1.02]"
        >
        <!-- Lighter Subtle Luxury Gradient Scrim -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/65 via-black/35 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-black/15"></div>

        <!-- Overlaid Animated Text Content -->
        <div class="relative z-10 w-full h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl py-6">
                    
                    <!-- Tag / Badge (NO numbers) -->
                    <div class="inline-flex items-center gap-2 mb-3 animate-hero-tag">
                        <span class="px-3.5 py-1.5 rounded-full bg-black/45 border border-gold/45 text-gold-300 text-xs uppercase tracking-widest font-serif backdrop-blur-md shadow-sm flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                            Dual-Tone Reversible Luxury
                        </span>
                    </div>

                    <!-- Animated Headline -->
                    <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-[1.1] mb-3.5 drop-shadow-[0_4px_14px_rgba(0,0,0,0.65)] animate-hero-title">
                        The Art of 
                        <span class="italic font-light text-gold-300 relative inline-block ml-1">
                            Dual Tone.
                            <span class="absolute left-0 -bottom-1 w-full h-[2px] bg-gradient-to-r from-gold via-gold-light to-transparent"></span>
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="text-sm sm:text-base text-white/95 font-light leading-relaxed max-w-xl mb-6 drop-shadow-[0_2px_8px_rgba(0,0,0,0.75)] line-clamp-2 animate-hero-desc">
                        Italian calfskin with a 360-degree brushed antique brass swivel buckle. Transition seamlessly from obsidian formal trousers to casual chinos in one smooth rotation.
                    </p>

                    <!-- CTAs & Spec Pill -->
                    <div class="flex flex-wrap items-center gap-4 animate-hero-actions">
                        <a 
                            href="{{ route('category', 'belts') }}" 
                            class="px-7 py-3.5 bg-gold hover:bg-gold-light text-black text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow transition-all duration-300 flex items-center gap-2 group active:scale-95"
                        >
                            <span>Explore Belts</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        
                        <a 
                            href="{{ route('shop') }}" 
                            class="px-6 py-3.5 bg-black/40 hover:bg-white/20 text-white text-xs uppercase tracking-widest font-semibold rounded-lg border border-white/35 hover:border-gold/50 backdrop-blur-md transition-all duration-300 text-center"
                        >
                            View Bestsellers
                        </a>

                        <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2.5 rounded-full bg-black/45 border border-white/25 text-xs text-white/90 backdrop-blur-md">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold"></i>
                            <span>360° Swivel Buckle • Wax-Burnished Edges</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= SLIDE 3: WALLETS & ACCESSORIES ================= -->
    <div 
        x-show="currentSlide === 2"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-400 absolute inset-0"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 w-full h-full"
    >
        <!-- Generated Background Image (Absolute so it doesn't push down text) -->
        <img 
            src="{{ asset('images/hero/slide-wallet.jpg') }}" 
            alt="By Zunash Slim Bifold Leather Wallet" 
            class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.95] contrast-[1.02]"
        >
        <!-- Lighter Subtle Luxury Gradient Scrim -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/65 via-black/35 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-black/15"></div>

        <!-- Overlaid Animated Text Content -->
        <div class="relative z-10 w-full h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl py-6">
                    
                    <!-- Tag / Badge (NO numbers) -->
                    <div class="inline-flex items-center gap-2 mb-3 animate-hero-tag">
                        <span class="px-3.5 py-1.5 rounded-full bg-black/45 border border-gold/45 text-gold-300 text-xs uppercase tracking-widest font-serif backdrop-blur-md shadow-sm flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                            Everyday Architecture
                        </span>
                    </div>

                    <!-- Animated Headline -->
                    <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-[1.1] mb-3.5 drop-shadow-[0_4px_14px_rgba(0,0,0,0.65)] animate-hero-title">
                        Pure Form. 
                        <span class="italic font-light text-gold-300 relative inline-block ml-1">
                            Enduring Touch.
                            <span class="absolute left-0 -bottom-1 w-full h-[2px] bg-gradient-to-r from-gold via-gold-light to-transparent"></span>
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="text-sm sm:text-base text-white/95 font-light leading-relaxed max-w-xl mb-6 drop-shadow-[0_2px_8px_rgba(0,0,0,0.75)] line-clamp-2 animate-hero-desc">
                        Calibrated for Pakistani 5000-rupee notes and integrated with certified German RFID protective shielding. Drum-dyed vegetable tanned hides with dual dividers.
                    </p>

                    <!-- CTAs & Spec Pill -->
                    <div class="flex flex-wrap items-center gap-4 animate-hero-actions">
                        <a 
                            href="{{ route('category', 'wallets') }}" 
                            class="px-7 py-3.5 bg-gold hover:bg-gold-light text-black text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow transition-all duration-300 flex items-center gap-2 group active:scale-95"
                        >
                            <span>Shop Wallets</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        
                        <a 
                            href="{{ route('shop', ['sort' => 'latest']) }}" 
                            class="px-6 py-3.5 bg-black/40 hover:bg-white/20 text-white text-xs uppercase tracking-widest font-semibold rounded-lg border border-white/35 hover:border-gold/50 backdrop-blur-md transition-all duration-300 text-center"
                        >
                            View Releases
                        </a>

                        <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2.5 rounded-full bg-black/45 border border-white/25 text-xs text-white/90 backdrop-blur-md">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold"></i>
                            <span>RFID Shielded • PKR 5,000 Note Calibrated</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= BOTTOM CONTROLS & PROGRESS (NO NUMBERS) ================= -->
    <div class="absolute bottom-5 left-0 right-0 z-20 pointer-events-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            <!-- Minimalist Slide Progress Bars (NO 1 2 3 numbers) -->
            <div class="flex items-center gap-2.5">
                <template x-for="idx in [0, 1, 2]" :key="idx">
                    <button 
                        type="button" 
                        @click="goTo(idx)" 
                        class="group py-2 px-1 focus:outline-none"
                        :aria-label="'Go to slide ' + (idx + 1)"
                    >
                        <div class="h-1 rounded-full overflow-hidden transition-all duration-300"
                             :class="currentSlide === idx ? 'w-10 sm:w-14 bg-white/30' : 'w-5 sm:w-7 bg-white/20 group-hover:bg-white/40'">
                            <div 
                                class="h-full bg-gold transition-all duration-300"
                                :class="currentSlide === idx ? 'w-full' : 'w-0'"
                            ></div>
                        </div>
                    </button>
                </template>
            </div>

            <!-- Prev / Next Arrows -->
            <div class="flex items-center gap-2.5">
                <button 
                    type="button" 
                    @click="prev()" 
                    class="w-10 h-10 rounded-full border border-white/25 bg-black/40 hover:bg-gold hover:text-black hover:border-gold flex items-center justify-center text-white transition-all active:scale-95 shadow-md backdrop-blur-md"
                    aria-label="Previous Slide"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button 
                    type="button" 
                    @click="next()" 
                    class="w-10 h-10 rounded-full border border-white/25 bg-black/40 hover:bg-gold hover:text-black hover:border-gold flex items-center justify-center text-white transition-all active:scale-95 shadow-md backdrop-blur-md"
                    aria-label="Next Slide"
                >
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     D. FEATURED CATEGORIES SECTION (With Scroll-Reveal)
     ======================================================== -->
<section class="py-24 bg-ivory-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-16 reveal">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Distinguished Lines</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-3">
                Curated by Category
            </h2>
            <p class="text-sm text-muted leading-relaxed">
                Explore our signature leather creations, each cut and assembled with uncompromising attention to longevity and tactile warmth.
            </p>
        </div>

        <!-- 5 Category Cards Grid with staggered reveal -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach($categories as $index => $cat)
                @php
                    $delayClass = ['delay-75', 'delay-150', 'delay-225', 'delay-300', 'delay-450'][$loop->index % 5];
                @endphp
                <a 
                    href="{{ route('category', $cat['slug']) }}" 
                    class="reveal {{ $delayClass }} group relative h-96 rounded-xl overflow-hidden shadow-xs hover:shadow-luxury hover:border-gold/50 transition-all duration-500 flex flex-col justify-end p-6 border border-ivory-300 bg-espresso-950"
                >
                    <!-- Background Image -->
                    <img 
                        src="{{ $cat['image'] }}" 
                        alt="{{ $cat['name'] }}" 
                        class="absolute inset-0 w-full h-full object-cover object-center transform transition-transform duration-700 group-hover:scale-110"
                    >
                    <!-- Dark Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-espresso-950/95 via-espresso-950/40 to-transparent group-hover:from-espresso-950 transition-all duration-500"></div>

                    <!-- Content -->
                    <div class="relative z-10 text-ivory">
                        <span class="text-[10px] uppercase tracking-widest text-gold font-serif block mb-1">
                            {{ $cat['count'] }} Distinct Designs
                        </span>
                        <h3 class="font-serif text-xl font-bold text-white mb-1.5 group-hover:text-gold-200 transition-colors">
                            {{ $cat['name'] }}
                        </h3>
                        <p class="text-xs text-ivory-300 font-light line-clamp-2 opacity-90 mb-3">
                            {{ $cat['tagline'] }}
                        </p>
                        <div class="inline-flex items-center gap-1 text-xs text-gold font-medium uppercase tracking-wider group-hover:translate-x-1.5 transition-transform">
                            <span>Explore</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>

<!-- ========================================================
     E. BESTSELLERS SECTION (With Scroll-Reveal)
     ======================================================== -->
<section class="py-24 bg-white border-t border-b border-ivory-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 reveal">
            <div>
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Client Favorites</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-1">
                    Bestselling Creations
                </h2>
            </div>
            <a 
                href="{{ route('shop') }}" 
                class="mt-4 md:mt-0 inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold text-espresso-800 hover:text-gold-600 transition-colors group"
            >
                <span>View Full Catalog</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Product Grid with staggered animation -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestsellers as $index => $product)
                @php
                    $delayClass = ['delay-75', 'delay-150', 'delay-225', 'delay-300'][$loop->index % 4];
                @endphp
                <div class="reveal {{ $delayClass }}">
                    <x-user.components.product-card :product="$product" />
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ========================================================
     F. BRAND STORY (EDITORIAL ASYMMETRICAL SECTION)
     ======================================================== -->
<section class="py-24 bg-ivory-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Editorial Imagery (Slide from Left) -->
            <div class="lg:col-span-6 relative reveal-left">
                <div class="relative z-10 w-4/5 aspect-[4/5] rounded-xl overflow-hidden shadow-luxury border-4 border-white">
                    <img 
                        src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=1000&q=80" 
                        alt="By Zunash Atelier Leather Studio" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <!-- Offset Secondary Image -->
                <div class="absolute -bottom-8 right-0 w-3/5 aspect-square rounded-xl overflow-hidden shadow-2xl border-4 border-white z-20">
                    <img 
                        src="https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80" 
                        alt="Hand burnished wallet detail" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <!-- Decorative Gold Accent Frame -->
                <div class="absolute -top-4 -left-4 w-32 h-32 border-t-2 border-l-2 border-gold/50 pointer-events-none z-0"></div>
            </div>

            <!-- Right Story Content (Slide from Right) -->
            <div class="lg:col-span-6 lg:pl-8 reveal-right">
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">The Atelier Philosophy</span>
                
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-6 leading-tight">
                    Pure Material. <br>Deliberate Details. <br><span class="italic font-light text-chocolate-700">Quiet Elegance.</span>
                </h2>

                <p class="text-sm text-espresso-800 font-light leading-relaxed mb-6">
                    By Zunash was founded to bring thoughtful craftsmanship back to daily leather accessories in Pakistan. In an era of fleeting fast fashion and bonded synthetic compromises, we champion honest, vegetable-tanned hides and drum-dyed skins that tell a real story.
                </p>

                <p class="text-sm text-muted leading-relaxed mb-8">
                    Every edge is beveled and wax-burnished by hand. Every seam is locked with resilient waxed thread. Our pieces are tailored not just to turn heads on day one, but to grow softer, richer, and distinctly yours across decades of use.
                </p>

                <div class="flex items-center gap-6">
                    <a 
                        href="{{ route('about') }}" 
                        class="px-7 py-3.5 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded shadow-md transition-all flex items-center gap-2 group active:scale-95"
                    >
                        <span>Discover Our Story</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                    
                    <div class="border-l border-ivory-300 pl-6">
                        <span class="font-serif text-lg font-bold text-espresso-900 block">Atelier Pakistan</span>
                        <span class="text-xs text-muted">Original Leathercraft</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     G. PROMOTIONAL COLLECTION BANNER (With Scale Reveal)
     ======================================================== -->
<section class="relative py-24 bg-chocolate-900 text-ivory overflow-hidden">
    <!-- Subtle Background Texture -->
    <div class="absolute inset-0 opacity-15">
        <img 
            src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=1800&q=80" 
            alt="Texture background" 
            class="w-full h-full object-cover filter contrast-125"
        >
    </div>
    
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 text-center reveal-scale">
        <span class="inline-block px-3 py-1 bg-gold/20 border border-gold/40 text-gold-200 text-[11px] uppercase tracking-widest font-serif rounded-full mb-4">
            Curated Gift Sets
        </span>

        <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
            The Bespoke Leather Gift Box
        </h2>

        <p class="text-sm sm:text-base text-ivory-300 font-light max-w-xl mx-auto mb-8 leading-relaxed">
            Pair our bestselling reversible calfskin belt with an RFID-shielded bifold wallet. Packaged in an embossed rigid gold-trimmed presentation box.
        </p>

        <a 
            href="{{ route('shop') }}" 
            class="inline-flex items-center gap-2 px-8 py-4 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded shadow-luxury hover:shadow-gold-glow transition-all active:scale-95"
        >
            <span>Explore Gift Sets</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>

<!-- ========================================================
     H. NEW ARRIVALS SECTION (With Scroll-Reveal)
     ======================================================== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 reveal">
            <div>
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Fresh From The Bench</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-1">
                    New Arrivals
                </h2>
            </div>
            <a 
                href="{{ route('shop', ['sort' => 'latest']) }}" 
                class="mt-4 md:mt-0 inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold text-espresso-800 hover:text-gold-600 transition-colors group"
            >
                <span>View All New Releases</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Product Grid with staggered reveal -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($newArrivals as $index => $product)
                @php
                    $delayClass = ['delay-75', 'delay-150', 'delay-225', 'delay-300'][$loop->index % 4];
                @endphp
                <div class="reveal {{ $delayClass }}">
                    <x-user.components.product-card :product="$product" />
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ========================================================
     I. WHY SHOP WITH US? (BENEFITS ACCENT)
     ======================================================== -->
<section class="py-20 bg-ivory-50 border-t border-b border-ivory-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8 text-center">
            
            <div class="reveal delay-75 flex flex-col items-center p-4">
                <div class="w-12 h-12 rounded-full bg-white border border-ivory-300 shadow-xs flex items-center justify-center text-gold-600 mb-3">
                    <i data-lucide="truck" class="w-6 h-6"></i>
                </div>
                <h4 class="font-serif text-sm font-semibold text-espresso-900 mb-1">Nationwide Delivery</h4>
                <p class="text-xs text-muted leading-relaxed">
                    Fast courier shipping to all Pakistani cities with live tracking updates.
                </p>
            </div>

            <div class="reveal delay-150 flex flex-col items-center p-4">
                <div class="w-12 h-12 rounded-full bg-white border border-ivory-300 shadow-xs flex items-center justify-center text-gold-600 mb-3">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h4 class="font-serif text-sm font-semibold text-espresso-900 mb-1">Cash on Delivery</h4>
                <p class="text-xs text-muted leading-relaxed">
                    Pay with confidence at your doorstep anywhere in Pakistan.
                </p>
            </div>

            <div class="reveal delay-225 flex flex-col items-center p-4">
                <div class="w-12 h-12 rounded-full bg-white border border-ivory-300 shadow-xs flex items-center justify-center text-gold-600 mb-3">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <h4 class="font-serif text-sm font-semibold text-espresso-900 mb-1">100% Pure Leather</h4>
                <p class="text-xs text-muted leading-relaxed">
                    Uncompromising full-grain & top-grain hides with zero faux plastics.
                </p>
            </div>

            <div class="reveal delay-300 flex flex-col items-center p-4">
                <div class="w-12 h-12 rounded-full bg-white border border-ivory-300 shadow-xs flex items-center justify-center text-gold-600 mb-3">
                    <i data-lucide="rotate-ccw" class="w-6 h-6"></i>
                </div>
                <h4 class="font-serif text-sm font-semibold text-espresso-900 mb-1">Easy Exchanges</h4>
                <p class="text-xs text-muted leading-relaxed">
                    Simple 7-day hassle-free exchange policy for complete peace of mind.
                </p>
            </div>

            <div class="reveal delay-450 flex flex-col items-center p-4">
                <div class="w-12 h-12 rounded-full bg-white border border-ivory-300 shadow-xs flex items-center justify-center text-gold-600 mb-3">
                    <i data-lucide="headphones" class="w-6 h-6"></i>
                </div>
                <h4 class="font-serif text-sm font-semibold text-espresso-900 mb-1">Personal Concierge</h4>
                <p class="text-xs text-muted leading-relaxed">
                    Attentive support via WhatsApp and phone for sizing and styling guidance.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     J. CUSTOMER TESTIMONIALS
     ======================================================== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 reveal">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Client Words</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-3">
                Appreciated Across Pakistan
            </h2>
            <p class="text-xs text-muted">
                (Sample impressions collected from our private pilot clients; replaceable prior to production launch)
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="reveal delay-75 bg-ivory-50 p-8 rounded-xl border border-ivory-300 relative shadow-xs">
                <div class="flex items-center gap-1 text-gold mb-4">
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                </div>
                <blockquote class="text-sm text-espresso-800 italic leading-relaxed mb-6 font-serif">
                    "The Royal Reversible Belt is without question the best belt I have owned in Pakistan. The swivel buckle feels solid and clicks with authoritative precision. The espresso calfskin is flawless."
                </blockquote>
                <div class="pt-4 border-t border-ivory-200">
                    <div class="font-bold text-xs uppercase tracking-wider text-espresso-900">Dr. Hamza K.</div>
                    <div class="text-[11px] text-muted">Lahore, Pakistan</div>
                </div>
            </div>

            <div class="reveal delay-150 bg-ivory-50 p-8 rounded-xl border border-ivory-300 relative shadow-xs">
                <div class="flex items-center gap-1 text-gold mb-4">
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                </div>
                <blockquote class="text-sm text-espresso-800 italic leading-relaxed mb-6 font-serif">
                    "I ordered The Zunash Signature Satchel for my anniversary. The packaging alone was regal. The leather scent, gold lock, and micro-suede lining easily rival international luxury labels."
                </blockquote>
                <div class="pt-4 border-t border-ivory-200">
                    <div class="font-bold text-xs uppercase tracking-wider text-espresso-900">Ayesha Tariq</div>
                    <div class="text-[11px] text-muted">Islamabad, Pakistan</div>
                </div>
            </div>

            <div class="reveal delay-225 bg-ivory-50 p-8 rounded-xl border border-ivory-300 relative shadow-xs">
                <div class="flex items-center gap-1 text-gold mb-4">
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-gold"></i>
                </div>
                <blockquote class="text-sm text-espresso-800 italic leading-relaxed mb-6 font-serif">
                    "Finding a wallet properly proportioned for Pakistani 5000-rupee notes that remains slim in a suit jacket is tough. The Heritage Bifold does it effortlessly. Fantastic COD experience."
                </blockquote>
                <div class="pt-4 border-t border-ivory-200">
                    <div class="font-bold text-xs uppercase tracking-wider text-espresso-900">Bilal Mansoor</div>
                    <div class="text-[11px] text-muted">Karachi, Pakistan</div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     K. NEWSLETTER SIGNUP
     ======================================================== -->
<section class="py-16 bg-ivory-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <x-user.components.newsletter />
    </div>
</section>

<!-- ========================================================
     L. INSTAGRAM-STYLE GALLERY
     ======================================================== -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-xl mx-auto mb-14 reveal">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">#ByZunashLeather</span>
            <h2 class="font-serif text-3xl font-bold text-espresso-900 mt-2 mb-2">
                Moments in Leather
            </h2>
            <p class="text-xs text-muted">
                Follow our daily craft journal on Instagram <span class="font-semibold text-espresso-900">@ByZunash</span>
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="reveal delay-75 group relative aspect-square rounded-lg overflow-hidden bg-ivory-100">
                <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=600&q=80" alt="Instagram 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-espresso-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="reveal delay-150 group relative aspect-square rounded-lg overflow-hidden bg-ivory-100">
                <img src="https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=600&q=80" alt="Instagram 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-espresso-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="reveal delay-225 group relative aspect-square rounded-lg overflow-hidden bg-ivory-100">
                <img src="https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80" alt="Instagram 3" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-espresso-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="reveal delay-300 group relative aspect-square rounded-lg overflow-hidden bg-ivory-100">
                <img src="https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=600&q=80" alt="Instagram 4" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-espresso-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="reveal delay-450 group relative aspect-square rounded-lg overflow-hidden bg-ivory-100">
                <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=600&q=80" alt="Instagram 5" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-espresso-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="reveal delay-600 group relative aspect-square rounded-lg overflow-hidden bg-ivory-100">
                <img src="https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=600&q=80" alt="Instagram 6" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-espresso-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
