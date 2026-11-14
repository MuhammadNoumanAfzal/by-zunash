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
    "telephone": "+92-321-4700545",
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
     C. REDESIGNED CINEMATIC EDITORIAL HERO SLIDER
     ======================================================== -->
<section 
    x-data="{
        currentSlide: 0,
        autoplayTimer: null,
        totalSlides: 3,
        touchStartX: 0,
        touchEndX: 0,
        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
            this.stopAutoplay();
        },
        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].screenX;
            if (this.touchStartX - this.touchEndX > 40) {
                this.next();
            } else if (this.touchEndX - this.touchStartX > 40) {
                this.prev();
            }
            this.startAutoplay();
        },
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
            }, 9000);
        },
        stopAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
                this.autoplayTimer = null;
            }
        }
    }"
    x-init="setTimeout(() => { startAutoplay(); }, 5000)"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    @touchstart.passive="handleTouchStart($event)"
    @touchend.passive="handleTouchEnd($event)"
    class="relative w-full h-[500px] sm:h-[550px] md:h-[600px] lg:h-[640px] overflow-hidden bg-espresso-950 text-ivory select-none"
>
    <!-- ================= SLIDE 1: SIGNATURE HANDBAGS (LCP HERO ELEMENT) ================= -->
    <div 
        class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out"
        :class="currentSlide === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
    >
        <!-- Background Image -->
        <picture class="absolute inset-0 w-full h-full pointer-events-none">
            <source media="(max-width: 640px)" srcset="{{ asset('images/hero/slide-bag-mobile-v2.webp') }}" type="image/webp">
            <source srcset="{{ asset('images/hero/slide-bag-v2.webp') }}" type="image/webp">
            <img 
                src="{{ asset('images/hero/slide-bag-v2.jpg') }}" 
                alt="By Zunash Handcrafted Italian Leather Bag" 
                width="1600"
                height="900"
                fetchpriority="high"
                loading="eager"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-center"
            >
        </picture>
        
        <!-- Balanced Medium Dark Luxury Contrast Overlays -->
        <div class="absolute inset-0 bg-black/20 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/45 via-50% to-transparent pointer-events-none"></div>
        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-black/60 via-black/20 to-transparent pointer-events-none"></div>

        <!-- Overlaid Animated Content -->
        <div class="absolute inset-0 z-20 w-full h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl py-3 pb-16 sm:pb-3">
                    
                    <!-- Tag / Badge -->
                    <div class="inline-flex items-center gap-2 mb-3.5 sm:mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/60 backdrop-blur-md border border-gold/50 text-gold-300 text-[11px] uppercase tracking-widest font-serif shadow-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></span>
                            Handcrafted Luxury
                        </span>
                    </div>

                    <!-- Clean Headline -->
                    <h1 class="font-serif text-2xl sm:text-4xl lg:text-[42px] font-normal tracking-tight text-white leading-[1.18] mb-3.5 sm:mb-4 drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)]">
                        Crafted for a Lifetime of 
                        <span class="italic font-light text-gold-300 drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)] block sm:inline">Elegance.</span>
                    </h1>

                    <!-- Clear Description -->
                    <p class="text-xs sm:text-sm text-white/95 font-normal leading-relaxed max-w-xl drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]" style="margin-bottom: 26px !important;">
                        Artisanal full-grain leather handbags sculpted by master craftsmen. Designed with quiet sophistication to endure with you every day.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center gap-3.5 sm:gap-4" style="margin-bottom: 26px !important;">
                        <a 
                            href="{{ route('category', 'handbags') }}" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 bg-gold hover:bg-gold-light text-espresso-950 text-[11px] sm:text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 group active:scale-95"
                        >
                            <span>Shop Handbags</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        
                        <a 
                            href="{{ route('shop') }}" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 bg-white/10 hover:bg-white/20 text-white text-[11px] sm:text-xs uppercase tracking-widest font-semibold rounded-lg border border-white/30 hover:border-gold/60 backdrop-blur-md hover:-translate-y-0.5 transition-all duration-300 text-center"
                        >
                            Explore Collection
                        </a>
                    </div>

                    <!-- Feature Row (Protected Pill - Hidden on mobile to prevent overlapping controls) -->
                    <div class="hidden sm:inline-flex flex-wrap items-center gap-3.5 px-4 py-2 rounded-full bg-black/55 backdrop-blur-md border border-white/20 text-[11px] text-white shadow-md">
                        <span class="flex items-center gap-2">
                            <i data-lucide="award" class="w-3.5 h-3.5 text-gold"></i>
                            <span>100% Full-Grain Leather</span>
                        </span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gold/50"></span>
                        <span class="flex items-center gap-2">
                            <i data-lucide="truck" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Nationwide Delivery</span>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= SLIDE 2: REVERSIBLE BELTS ================= -->
    <div 
        class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out"
        :class="currentSlide === 1 ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none'"
    >
        <!-- Background Image -->
        <picture class="absolute inset-0 w-full h-full pointer-events-none">
            <source media="(max-width: 640px)" srcset="{{ asset('images/hero/slide-belt-mobile.webp') }}" type="image/webp">
            <source srcset="{{ asset('images/hero/slide-belt.webp') }}" type="image/webp">
            <img 
                src="{{ asset('images/hero/slide-belt.jpg') }}" 
                alt="By Zunash Reversible Calfskin Leather Belts" 
                width="1920"
                height="1080"
                loading="lazy"
                decoding="async"
                class="absolute inset-0 w-full h-full object-cover object-center"
            >
        </picture>
        
        <!-- Balanced Medium Dark Luxury Contrast Overlays -->
        <div class="absolute inset-0 bg-black/20 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/45 via-50% to-transparent pointer-events-none"></div>
        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-black/60 via-black/20 to-transparent pointer-events-none"></div>

        <!-- Overlaid Animated Content -->
        <div class="absolute inset-0 z-20 w-full h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl py-3 pb-16 sm:pb-3">
                    
                    <!-- Tag / Badge -->
                    <div class="inline-flex items-center gap-2 mb-3.5 sm:mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/60 backdrop-blur-md border border-gold/50 text-gold-300 text-[11px] uppercase tracking-widest font-serif shadow-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></span>
                            The Reversible Belt
                        </span>
                    </div>

                    <!-- Clean Headline -->
                    <h2 class="font-serif text-2xl sm:text-4xl lg:text-[42px] font-normal tracking-tight text-white leading-[1.18] mb-3.5 sm:mb-4 drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)]">
                        Two Refined Looks. 
                        <span class="italic font-light text-gold-300 drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)] block sm:inline">One Smooth Twist.</span>
                    </h2>

                    <!-- Clear Description -->
                    <p class="text-xs sm:text-sm text-white/95 font-normal leading-relaxed max-w-xl drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]" style="margin-bottom: 26px !important;">
                        Handcrafted calfskin with a 360° swivel antique brass buckle. Effortlessly switches between rich cognac brown and obsidian black.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center gap-3.5 sm:gap-4" style="margin-bottom: 26px !important;">
                        <a 
                            href="{{ route('category', 'belts') }}" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 bg-gold hover:bg-gold-light text-espresso-950 text-[11px] sm:text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 group active:scale-95"
                        >
                            <span>Shop Belts</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        
                        <a 
                            href="{{ route('shop') }}" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 bg-white/10 hover:bg-white/20 text-white text-[11px] sm:text-xs uppercase tracking-widest font-semibold rounded-lg border border-white/30 hover:border-gold/60 backdrop-blur-md hover:-translate-y-0.5 transition-all duration-300 text-center"
                        >
                            View Bestsellers
                        </a>
                    </div>

                    <!-- Feature Row (Protected Pill - Hidden on mobile to prevent overlapping controls) -->
                    <div class="hidden sm:inline-flex flex-wrap items-center gap-3.5 px-4 py-2 rounded-full bg-black/55 backdrop-blur-md border border-white/20 text-[11px] text-white shadow-md">
                        <span class="flex items-center gap-2">
                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-gold"></i>
                            <span>360° Swivel Buckle</span>
                        </span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gold/50"></span>
                        <span class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Solid Antique Brass Hardware</span>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= SLIDE 3: WALLETS & ACCESSORIES ================= -->
    <div 
        class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out"
        :class="currentSlide === 2 ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none'"
    >
        <!-- Background Image -->
        <picture class="absolute inset-0 w-full h-full pointer-events-none">
            <source media="(max-width: 640px)" srcset="{{ asset('images/hero/slide-wallet-mobile.webp') }}" type="image/webp">
            <source srcset="{{ asset('images/hero/slide-wallet.webp') }}" type="image/webp">
            <img 
                src="{{ asset('images/hero/slide-wallet.jpg') }}" 
                alt="By Zunash Slim Bifold Leather Wallet" 
                width="1920"
                height="1080"
                loading="lazy"
                decoding="async"
                class="absolute inset-0 w-full h-full object-cover object-center"
            >
        </picture>
        
        <!-- Balanced Medium Dark Luxury Contrast Overlays -->
        <div class="absolute inset-0 bg-black/20 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/45 via-50% to-transparent pointer-events-none"></div>
        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-black/60 via-black/20 to-transparent pointer-events-none"></div>

        <!-- Overlaid Animated Content -->
        <div class="absolute inset-0 z-20 w-full h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl py-3 pb-16 sm:pb-3">
                    
                    <!-- Tag / Badge -->
                    <div class="inline-flex items-center gap-2 mb-3.5 sm:mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/60 backdrop-blur-md border border-gold/50 text-gold-300 text-[11px] uppercase tracking-widest font-serif shadow-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></span>
                            Minimalist Essentials
                        </span>
                    </div>

                    <!-- Clean Headline -->
                    <h2 class="font-serif text-2xl sm:text-4xl lg:text-[42px] font-normal tracking-tight text-white leading-[1.18] mb-3.5 sm:mb-4 drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)]">
                        Slim in Pocket. 
                        <span class="italic font-light text-gold-300 drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)] block sm:inline">Timeless in Hand.</span>
                    </h2>

                    <!-- Clear Description -->
                    <p class="text-xs sm:text-sm text-white/95 font-normal leading-relaxed max-w-xl drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]" style="margin-bottom: 26px !important;">
                        Hand-burnished bifold wallets and slim cardholders with certified RFID protection. Tailored for everyday carry without the bulk.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center gap-3.5 sm:gap-4" style="margin-bottom: 26px !important;">
                        <a 
                            href="{{ route('category', 'wallets') }}" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 bg-gold hover:bg-gold-light text-espresso-950 text-[11px] sm:text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 group active:scale-95"
                        >
                            <span>Shop Wallets</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1"></i>
                        </a>
                        
                        <a 
                            href="{{ route('shop') }}" 
                            class="px-5 py-2.5 sm:px-6 sm:py-3 bg-white/10 hover:bg-white/20 text-white text-[11px] sm:text-xs uppercase tracking-widest font-semibold rounded-lg border border-white/30 hover:border-gold/60 backdrop-blur-md hover:-translate-y-0.5 transition-all duration-300 text-center"
                        >
                            View New Releases
                        </a>
                    </div>

                    <!-- Feature Row (Protected Pill - Hidden on mobile to prevent overlapping controls) -->
                    <div class="hidden sm:inline-flex flex-wrap items-center gap-3.5 px-4 py-2 rounded-full bg-black/55 backdrop-blur-md border border-white/20 text-[11px] text-white shadow-md">
                        <span class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Certified RFID Protection</span>
                        </span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gold/50"></span>
                        <span class="flex items-center gap-2">
                            <i data-lucide="feather" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Wax-Burnished Edges</span>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ================= BOTTOM CONTROLS & PROGRESS ================= -->
    <div class="absolute bottom-3 sm:bottom-4 left-0 right-0 z-30 pointer-events-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            <!-- Animated Slide Progress Indicators -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <template x-for="idx in [0, 1, 2]" :key="idx">
                    <button 
                        type="button" 
                        @click="goTo(idx)" 
                        class="group py-2 px-0.5 sm:px-1 focus:outline-none"
                        aria-label="Slide indicator"
                        :aria-label="'Go to slide ' + (idx + 1)"
                    >
                        <div class="h-1 rounded-full overflow-hidden transition-all duration-300"
                             :class="currentSlide === idx ? 'w-8 sm:w-16 bg-white/25' : 'w-4 sm:w-7 bg-white/20 group-hover:bg-white/40'">
                            <div 
                                class="h-full bg-gold rounded-full"
                                :class="currentSlide === idx ? 'animate-hero-progress' : 'w-0'"
                            ></div>
                        </div>
                    </button>
                </template>
            </div>

            <!-- Prev / Next Sleek Arrow Buttons -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <button 
                    type="button" 
                    @click="prev()" 
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border border-white/20 bg-black/40 hover:bg-gold hover:text-espresso-950 hover:border-gold flex items-center justify-center text-white transition-all active:scale-95 shadow-md backdrop-blur-md"
                    aria-label="Previous Slide"
                >
                    <i data-lucide="chevron-left" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                </button>
                <button 
                    type="button" 
                    @click="next()" 
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border border-white/20 bg-black/40 hover:bg-gold hover:text-espresso-950 hover:border-gold flex items-center justify-center text-white transition-all active:scale-95 shadow-md backdrop-blur-md"
                    aria-label="Next Slide"
                >
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                </button>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     D. FEATURED CATEGORIES SECTION (Interactive Luxury Slider)
     ======================================================== -->
<section 
    x-data="{
        scrollContainer: null,
        canScrollPrev: false,
        canScrollNext: true,
        autoPlayTimer: null,
        isHovered: false,
        init() {
            this.scrollContainer = this.$refs.slider;
            this.updateScrollState();
            this.scrollContainer.addEventListener('scroll', () => this.updateScrollState(), { passive: true });
            this.startAutoPlay();
        },
        updateScrollState() {
            if (!this.scrollContainer) return;
            this.canScrollPrev = this.scrollContainer.scrollLeft > 15;
            this.canScrollNext = this.scrollContainer.scrollLeft < (this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth - 15);
        },
        startAutoPlay() {
            this.stopAutoPlay();
            this.autoPlayTimer = setInterval(() => {
                if (this.isHovered || !this.scrollContainer) return;
                const maxScroll = this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth;
                if (this.scrollContainer.scrollLeft >= maxScroll - 30) {
                    this.scrollContainer.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    this.scrollNext();
                }
            }, 4500);
        },
        stopAutoPlay() {
            if (this.autoPlayTimer) {
                clearInterval(this.autoPlayTimer);
                this.autoPlayTimer = null;
            }
        },
        scrollPrev() {
            if (!this.scrollContainer) return;
            const firstCard = this.scrollContainer.querySelector('a');
            const step = firstCard ? (firstCard.offsetWidth + 20) : 250;
            this.scrollContainer.scrollBy({ left: -step, behavior: 'smooth' });
        },
        scrollNext() {
            if (!this.scrollContainer) return;
            const firstCard = this.scrollContainer.querySelector('a');
            const step = firstCard ? (firstCard.offsetWidth + 20) : 250;
            this.scrollContainer.scrollBy({ left: step, behavior: 'smooth' });
        }
    }"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
    class="pt-6 pb-8 lg:pt-8 lg:pb-10 bg-ivory-50 overflow-hidden"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header with Title, View All Link & Slider Navigation Controls -->
        <div class="flex items-center justify-between mb-4 sm:mb-5 reveal">
            <div class="flex items-center gap-3">
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-900 tracking-tight">
                    Discover Categories
                </h2>
            </div>

            <!-- Header Actions: View All Catalog & Navigation Arrows -->
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('shop') }}" 
                    class="text-xs uppercase tracking-widest font-bold text-[#593E15] dark:text-gold-300 hover:text-espresso-950 transition-colors flex items-center gap-1.5 py-1.5 px-3 rounded-full hover:bg-gold/10 group"
                >
                    <span>View All</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5"></i>
                </a>

                <div class="flex items-center gap-1.5">
                    <button 
                        type="button" 
                        @click="scrollPrev()" 
                        :disabled="!canScrollPrev" 
                        class="w-9 h-9 rounded-full border border-espresso-950/20 bg-white text-espresso-900 flex items-center justify-center transition-all duration-200 shadow-xs focus:outline-none disabled:opacity-30 disabled:cursor-not-allowed hover:not-disabled:bg-espresso-950 hover:not-disabled:text-gold hover:not-disabled:border-espresso-950 active:scale-95"
                        aria-label="Previous categories"
                    >
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button 
                        type="button" 
                        @click="scrollNext()" 
                        :disabled="!canScrollNext" 
                        class="w-9 h-9 rounded-full border border-espresso-950/20 bg-white text-espresso-900 flex items-center justify-center transition-all duration-200 shadow-xs focus:outline-none disabled:opacity-30 disabled:cursor-not-allowed hover:not-disabled:bg-espresso-950 hover:not-disabled:text-gold hover:not-disabled:border-espresso-950 active:scale-95"
                        aria-label="Next categories"
                    >
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Slider Track (Compact Cards, Auto-scrolls, Pauses on Hover) -->
        <div class="relative">
            <div 
                x-ref="slider"
                class="flex items-stretch gap-4 sm:gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory hide-scrollbar pb-3 pt-3 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
            >
                @foreach($categories as $cat)
                    <a 
                        href="{{ route('category', $cat['slug']) }}" 
                        x-data="{
                            rotX: 0,
                            rotY: 0,
                            isHovering: false,
                            onMove(e) {
                                if (window.matchMedia('(hover: none)').matches) return;
                                const rect = $el.getBoundingClientRect();
                                const x = e.clientX - rect.left;
                                const y = e.clientY - rect.top;
                                const cx = rect.width / 2;
                                const cy = rect.height / 2;
                                this.rotX = ((y - cy) / cy) * -9;
                                this.rotY = ((x - cx) / cx) * 9;
                                this.isHovering = true;
                            },
                            onLeave() {
                                this.rotX = 0;
                                this.rotY = 0;
                                this.isHovering = false;
                            }
                        }"
                        @mousemove="onMove($event)"
                        @mouseleave="onLeave()"
                        :style="isHovering 
                            ? `transform: perspective(800px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateY(-8px) scale(1.025); transition: transform 0.12s ease-out, box-shadow 0.25s ease; border: none !important; outline: none !important;` 
                            : 'transform: perspective(800px) rotateX(0deg) rotateY(0deg) translateY(0px) scale(1); transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease; border: none !important; outline: none !important;'"
                        class="snap-start flex-shrink-0 w-[210px] sm:w-[230px] md:w-[240px] lg:w-[calc(25%-15px)] h-[250px] sm:h-[270px] lg:h-[280px] rounded-2xl overflow-hidden relative shadow-lg hover:shadow-2xl border-0 ring-0 outline-none group bg-espresso-950 flex flex-col justify-end will-change-transform"
                    >
                        <!-- Background Product Image with Smooth Hover Zoom -->
                        @php
                            $catWebp = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $cat['image']);
                        @endphp
                        <picture>
                            @if(file_exists(public_path($catWebp)))
                                <source srcset="{{ asset($catWebp) }}" type="image/webp">
                            @endif
                            <img 
                                src="{{ asset($cat['image']) }}" 
                                alt="{{ $cat['name'] }}" 
                                width="400"
                                height="500"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 w-full h-full object-cover object-center transform transition-transform duration-700 ease-out group-hover:scale-105"
                            >
                        </picture>

                        <!-- Permanent Solid Deep Bottom Gradient for 100% Legibility -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/60 via-35% to-transparent z-10 pointer-events-none"></div>

                        <!-- Hover Highlight Contrast Scrim -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 pointer-events-none"></div>

                        <!-- Bottom Content Area -->
                        <div class="relative z-20 p-4 sm:p-5 flex flex-col justify-end w-full">
                            <h3 class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-[#E9DDBC] transition-colors duration-200 drop-shadow-[0_2px_10px_rgba(0,0,0,0.95)] leading-tight mb-1">
                                {{ $cat['name'] }}
                            </h3>
                            
                            <p class="text-xs font-normal line-clamp-1 leading-snug drop-shadow-[0_1px_6px_rgba(0,0,0,0.95)]" style="color: #E9DDBC !important;">
                                {{ $cat['tagline'] }}
                            </p>

                            <div class="mt-2.5 flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-white/90 group-hover:text-white transition-colors">
                                <span class="text-[#C5A16B] group-hover:underline">Explore</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-[#C5A16B] transition-transform group-hover:translate-x-1"></i>
                            </div>
                        </div>
                    </a>
                @endforeach

                <!-- 6th Slide: View Full Atelier Card -->
                <a 
                    href="{{ route('shop') }}" 
                    x-data="{
                        rotX: 0,
                        rotY: 0,
                        isHovering: false,
                        onMove(e) {
                            const rect = $el.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;
                            const cx = rect.width / 2;
                            const cy = rect.height / 2;
                            this.rotX = ((y - cy) / cy) * -9;
                            this.rotY = ((x - cx) / cx) * 9;
                            this.isHovering = true;
                        },
                        onLeave() {
                            this.rotX = 0;
                            this.rotY = 0;
                            this.isHovering = false;
                        }
                    }"
                    @mousemove="onMove($event)"
                    @mouseleave="onLeave()"
                    :style="isHovering 
                        ? `transform: perspective(800px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateY(-8px) scale(1.025); transition: transform 0.12s ease-out, box-shadow 0.25s ease; border: none !important; outline: none !important;` 
                        : 'transform: perspective(800px) rotateX(0deg) rotateY(0deg) translateY(0px) scale(1); transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease; border: none !important; outline: none !important;'"
                    class="snap-start flex-shrink-0 w-[210px] sm:w-[230px] md:w-[240px] lg:w-[calc(25%-15px)] h-[250px] sm:h-[270px] lg:h-[280px] rounded-2xl overflow-hidden relative shadow-lg hover:shadow-2xl border-0 ring-0 outline-none group bg-gradient-to-br from-espresso-950 via-[#1c120c] to-black flex flex-col justify-between p-5 text-white will-change-transform"
                >
                    <div class="relative z-10">
                        <div class="w-9 h-9 rounded-lg bg-gold/15 border border-gold/30 flex items-center justify-center text-gold mb-3 group-hover:scale-110 transition-transform">
                            <i data-lucide="layers" class="w-4 h-4"></i>
                        </div>
                        <span class="text-gold-300 text-[10px] uppercase tracking-widest font-mono">Complete Archive</span>
                        <h3 class="font-serif text-lg sm:text-xl font-bold text-white mt-1 mb-1 group-hover:text-gold transition-colors">
                            Discover All
                        </h3>
                        <p class="text-xs leading-relaxed font-light line-clamp-2" style="color: #E9DDBC !important;">
                            Explore all handcrafted leather creations in our full catalog.
                        </p>
                    </div>

                    <div class="relative z-10 pt-3 border-t border-white/10 flex items-center justify-between">
                        <span class="text-xs uppercase tracking-widest font-bold text-gold group-hover:text-white transition-colors">
                            Browse All
                        </span>
                        <div class="w-7 h-7 rounded-full bg-gold text-espresso-950 flex items-center justify-center transition-transform group-hover:translate-x-1 shadow-sm">
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================
     E. BESTSELLERS SECTION (With Scroll-Reveal)
     ======================================================== -->
@if($bestsellers->isNotEmpty())
<section class="pt-10 pb-16 lg:pt-12 lg:pb-20 bg-white dark:bg-[#161210] border-t border-b border-ivory-200 dark:border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 reveal">
            <div>
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Client Favorites</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 dark:text-ivory mt-1">
                    Bestselling Creations
                </h2>
            </div>
            <a 
                href="{{ route('shop') }}" 
                class="mt-4 md:mt-0 inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold transition-colors group"
            >
                <span>View Full Catalog</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Product Grid with staggered animation (2-cols on mobile for seamless browsing) -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
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
@endif

<!-- ========================================================
     F. BRAND STORY (EDITORIAL ASYMMETRICAL ATELIER SECTION)
     ======================================================== -->
<section class="py-10 sm:py-12 lg:py-14 bg-[#FAF7F2] dark:bg-[#191411] border-t border-ivory-200 dark:border-white/10 relative overflow-hidden">
    <!-- Ambient subtle background glow -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-chocolate-900/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left Editorial Imagery (Interactive Overlapping Composition) -->
            <div class="lg:col-span-6 relative reveal-left">
                <!-- Outer Decorative Frame Accent -->
                <div class="absolute -top-5 -left-5 w-40 h-40 border-t-2 border-l-2 border-gold/60 rounded-tl-2xl pointer-events-none z-0"></div>
                <div class="absolute -bottom-5 -right-5 w-40 h-40 border-b-2 border-r-2 border-gold/40 rounded-br-2xl pointer-events-none z-0 hidden sm:block"></div>

                <!-- Primary Atelier Image -->
                <div class="relative z-10 w-[88%] aspect-[4/3] sm:aspect-[16/11] rounded-2xl overflow-hidden shadow-2xl border-4 border-white group">
                    <picture>
                        <source srcset="{{ asset('images/brand/artisan-craft-v2.webp') }}" type="image/webp">
                        <img 
                            src="{{ asset('images/brand/artisan-craft-v2.jpg') }}" 
                            alt="By Zunash Master Leather Artisan Workshop in Lahore" 
                            width="600"
                            height="440"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105"
                        >
                    </picture>
                    <div class="absolute inset-0 bg-gradient-to-t from-espresso-950/70 via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="absolute bottom-4 left-4 z-20 text-white">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-gold-300 block">The Bench</span>
                        <span class="font-serif text-sm font-semibold text-white">Master Artisan Edge Burnishing</span>
                    </div>
                </div>

                <!-- Secondary Floating Inset Image (Macro Stitch) -->
                <div class="absolute -bottom-7 right-2 sm:right-4 w-[52%] sm:w-[48%] aspect-square rounded-2xl overflow-hidden shadow-2xl border-4 border-white z-20 group">
                    <picture>
                        <source srcset="{{ asset('images/brand/stitch-detail-v2.webp') }}" type="image/webp">
                        <img 
                            src="{{ asset('images/brand/stitch-detail-v2.jpg') }}" 
                            alt="Macro hand-stitched waxed seam detail" 
                            width="360"
                            height="360"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-110"
                        >
                    </picture>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-50 group-hover:opacity-30 transition-opacity"></div>
                    <div class="absolute bottom-3 left-3 z-20">
                        <span class="text-[9px] uppercase font-bold tracking-wider text-gold-300 block">Waxed Thread</span>
                        <span class="font-serif text-xs font-semibold text-white">Hand-Locked Saddle Seam</span>
                    </div>
                </div>

                <!-- Floating Glassmorphic Atelier Seal Badge -->
                <div class="absolute top-4 right-6 sm:top-6 sm:right-10 z-30 bg-espresso-950/90 backdrop-blur-md border border-gold/40 py-2 px-3.5 rounded-full shadow-xl flex items-center gap-2 transform hover:scale-105 transition-transform duration-300">
                    <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-gold-200">100% Vegetable-Tanned</span>
                </div>
            </div>

            <!-- Right Story Content -->
            <div class="lg:col-span-6 lg:pl-4 reveal-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold/15 border border-gold/40 text-gold-700 dark:text-gold-300 text-xs uppercase tracking-widest font-serif font-bold mb-3.5">
                    <i data-lucide="award" class="w-3.5 h-3.5 text-gold-600 dark:text-gold-400"></i>
                    <span>The Atelier Philosophy</span>
                </div>
                
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-[40px] font-bold text-espresso-950 dark:text-ivory leading-[1.18] mb-3.5">
                    Pure Material. <br>Deliberate Details. <br><span class="italic font-light text-gold-600 dark:text-gold-400">Quiet Elegance.</span>
                </h2>

                <p class="text-[15px] text-espresso-800 dark:text-ivory-300 font-light leading-relaxed mb-3">
                    By Zunash was founded to bring thoughtful craftsmanship back to daily leather goods in Pakistan. In an era of fleeting fast fashion and synthetic bonded shortcuts, we champion honest, vegetable-tanned hides and drum-dyed skins that tell a real story.
                </p>

                <p class="text-[14px] text-muted-dark dark:text-ivory-400 leading-relaxed mb-5">
                    Every edge is beveled and wax-burnished by hand. Every seam is locked with resilient waxed thread. Our pieces are tailored not merely to turn heads on day one, but to grow softer, richer, and distinctly yours across decades of use.
                </p>

                <!-- 3 Pillars Feature Highlights with Micro-Hover & Authentic Craft Icons -->
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div class="p-3.5 rounded-xl bg-white dark:bg-[#241C18] border border-ivory-300 dark:border-white/10 shadow-2xs hover:border-gold-500/50 hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-serif text-lg font-bold text-espresso-950 dark:text-ivory group-hover:text-gold-600 transition-colors">0%</span>
                            <i data-lucide="shield-check" class="w-4 h-4 text-gold-600 dark:text-gold-400"></i>
                        </div>
                        <div class="text-[11px] font-semibold text-espresso-900 dark:text-ivory-200 leading-tight">Faux Plastics</div>
                        <div class="text-[10px] text-muted dark:text-ivory-400 leading-tight mt-1">Full-grain hides only</div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-white dark:bg-[#241C18] border border-ivory-300 dark:border-white/10 shadow-2xs hover:border-gold-500/50 hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-serif text-lg font-bold text-espresso-950 dark:text-ivory group-hover:text-gold-600 transition-colors">100%</span>
                            <i data-lucide="scissors" class="w-4 h-4 text-gold-600 dark:text-gold-400"></i>
                        </div>
                        <div class="text-[11px] font-semibold text-espresso-900 dark:text-ivory-200 leading-tight">Hand-Burnished</div>
                        <div class="text-[10px] text-muted dark:text-ivory-400 leading-tight mt-1">Natural beeswax sealed</div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-white dark:bg-[#241C18] border border-ivory-300 dark:border-white/10 shadow-2xs hover:border-gold-500/50 hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-serif text-lg font-bold text-espresso-950 dark:text-ivory group-hover:text-gold-600 transition-colors">Decades</span>
                            <i data-lucide="clock" class="w-4 h-4 text-gold-600 dark:text-gold-400"></i>
                        </div>
                        <div class="text-[11px] font-semibold text-espresso-900 dark:text-ivory-200 leading-tight">Heirloom Wear</div>
                        <div class="text-[10px] text-muted dark:text-ivory-400 leading-tight mt-1">Gains rich patina</div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-5">
                    <a 
                        href="{{ route('about') }}" 
                        class="px-8 py-3.5 bg-espresso-950 hover:bg-gold-500 text-white hover:text-espresso-950 text-xs uppercase tracking-widest font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2 group active:scale-95"
                    >
                        <span>Discover Our Story</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                    
                    <div class="flex items-center gap-3 border-l border-ivory-300 dark:border-white/10 pl-5">
                        <div class="w-10 h-10 rounded-full bg-gold/15 border border-gold/30 flex items-center justify-center text-gold-700 dark:text-gold-400 font-serif font-bold text-xs">
                            BZ
                        </div>
                        <div>
                            <span class="font-serif text-sm font-bold text-espresso-950 dark:text-ivory block leading-tight">Atelier Pakistan</span>
                            <span class="text-[11px] text-muted-dark dark:text-ivory-400">Original Leathercraft</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     G. BESPOKE LEATHER GIFT SET (INTERACTIVE CINEMATIC BANNER)
     ======================================================== -->
<section class="relative py-20 lg:py-24 bg-gradient-to-br from-espresso-950 via-[#1c120c] to-black text-ivory overflow-hidden border-t border-b border-gold/30">
    <!-- Ambient Gold Glow Radial Lighting -->
    <div class="absolute -top-40 left-1/4 w-[600px] h-[600px] bg-gold/15 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute -bottom-40 right-10 w-[500px] h-[500px] bg-gold/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Subtle Luxury Geometric Pattern -->
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
            <path d="M40 0 L80 40 L40 80 L0 40 Z" fill="none" stroke="#C5A16B" stroke-width="0.8"></path>
        </svg>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Left Column: Compelling Gift Narrative & CTA -->
            <div class="lg:col-span-7 reveal-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-gold/20 border border-gold/50 text-gold-300 text-[11px] uppercase tracking-widest font-serif rounded-full mb-5 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-gold animate-ping"></span>
                    <span>Curated Atelier Gift Experience</span>
                </div>

                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                    The Bespoke Leather Gift Box
                </h2>

                <p class="text-sm sm:text-base text-ivory-300 font-light max-w-xl mb-6 leading-relaxed">
                    The quintessential pairing for someone of refined taste. We combine our bestselling Reversible Calfskin Belt with the RFID Heritage Bifold Wallet — delivered in an embossed rigid gold-trimmed keepsake presentation box.
                </p>

                <!-- Value Proposition Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8 max-w-lg">
                    <div class="flex items-center gap-2.5 text-xs text-ivory-200 bg-white/5 backdrop-blur-sm px-3.5 py-2.5 rounded-lg border border-white/10">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-gold flex-shrink-0"></i>
                        <span>Reversible Calfskin Belt (Espresso / Black)</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-xs text-ivory-200 bg-white/5 backdrop-blur-sm px-3.5 py-2.5 rounded-lg border border-white/10">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-gold flex-shrink-0"></i>
                        <span>RFID-Shielded Bifold Wallet</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-xs text-ivory-200 bg-white/5 backdrop-blur-sm px-3.5 py-2.5 rounded-lg border border-white/10">
                        <i data-lucide="gift" class="w-4 h-4 text-gold flex-shrink-0"></i>
                        <span>Embossed Rigid Gold Magnetic Box</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-xs text-ivory-200 bg-white/5 backdrop-blur-sm px-3.5 py-2.5 rounded-lg border border-white/10">
                        <i data-lucide="truck" class="w-4 h-4 text-gold flex-shrink-0"></i>
                        <span>Complimentary Express Nationwide COD</span>
                    </div>
                </div>

                <!-- Price & Action -->
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-wider text-gold-300 font-medium">Atelier Pairing Price</span>
                        <div class="flex items-baseline gap-2">
                            <span class="font-sans text-2xl sm:text-3xl font-bold text-white tracking-tight">
                                <span class="text-xs text-gold mr-1">PKR</span>7,950
                            </span>
                            <span class="text-sm text-ivory-400/60 line-through font-sans">
                                PKR 8,800
                            </span>
                            <span class="text-[11px] font-bold text-gold-400 bg-gold/15 px-2 py-0.5 rounded border border-gold/30">
                                Save PKR 850
                            </span>
                        </div>
                    </div>

                    <a 
                        href="{{ route('deals') }}" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 sm:py-4 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-full shadow-luxury hover:shadow-gold-glow transition-all active:scale-95 group text-center"
                    >
                        <span>Explore Curated Deals</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

            <!-- Right Column: Visual Product Pairing Showcase -->
            <div class="lg:col-span-5 reveal-right">
                <div class="relative bg-espresso-900/60 backdrop-blur-md rounded-2xl p-5 border border-gold/40 shadow-2xl group hover:border-gold transition-all duration-500">
                    <!-- Gold Ribbon Pill -->
                    <div class="absolute -top-3.5 right-6 z-20 bg-gradient-to-r from-gold-500 to-gold-400 text-espresso-950 text-[10px] uppercase font-bold tracking-widest px-3.5 py-1 rounded-full shadow-lg flex items-center gap-1.5">
                        <i data-lucide="gift" class="w-3 h-3"></i>
                        <span>Gift Box Included</span>
                    </div>

                    <!-- Split visual showing the 2 items in the set -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <!-- Belt Preview -->
                        <div class="relative aspect-square rounded-xl overflow-hidden bg-black/40 border border-white/10 group-hover:border-gold/30 transition-all">
                            <picture>
                                <source srcset="{{ asset('images/products/prod-reversible-belt-thumb.webp') }}" type="image/webp">
                                <img 
                                    src="{{ asset('images/products/prod-reversible-belt-thumb.jpg') }}" 
                                    alt="Reversible Belt in Gift Set" 
                                    width="300"
                                    height="300"
                                    loading="lazy"
                                    decoding="async"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                >
                            </picture>
                            <div class="absolute bottom-2 left-2 z-10 px-2 py-0.5 rounded bg-black/70 backdrop-blur-xs text-[9px] font-semibold text-gold-300">
                                Reversible Belt
                            </div>
                        </div>

                        <!-- Wallet Preview -->
                        <div class="relative aspect-square rounded-xl overflow-hidden bg-black/40 border border-white/10 group-hover:border-gold/30 transition-all">
                            <picture>
                                <source srcset="{{ asset('images/products/prod-bifold-wallet-thumb.webp') }}" type="image/webp">
                                <img 
                                    src="{{ asset('images/products/prod-bifold-wallet-thumb.jpg') }}" 
                                    alt="Heritage Bifold Wallet in Gift Set" 
                                    width="300"
                                    height="300"
                                    loading="lazy"
                                    decoding="async"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                >
                            </picture>
                            <div class="absolute bottom-2 left-2 z-10 px-2 py-0.5 rounded bg-black/70 backdrop-blur-xs text-[9px] font-semibold text-gold-300">
                                Heritage Bifold
                            </div>
                        </div>
                    </div>

                    <!-- Box presentation description footer -->
                    <div class="pt-3 border-t border-white/10 flex items-center justify-between text-xs text-ivory-300">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="package" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Rigid Embossed Presentation Box</span>
                        </span>
                        <span class="text-[11px] text-gold font-mono">By Zunash Signature</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     H. NEW ARRIVALS SECTION (With Scroll-Reveal)
     ======================================================== -->
<section class="py-24 bg-white dark:bg-[#161210]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 reveal">
            <div>
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Fresh From The Bench</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 dark:text-ivory mt-1">
                    New Arrivals
                </h2>
            </div>
            <a 
                href="{{ route('shop', ['sort' => 'latest']) }}" 
                class="mt-4 md:mt-0 inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold text-espresso-800 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold transition-colors group"
            >
                <span>View All New Releases</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <!-- Product Grid with staggered reveal (2-cols on mobile) -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
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
     I. WHY CHOOSE BY ZUNASH? (MODERN INTERACTIVE BENEFIT CARDS)
     ======================================================== -->
<section class="py-8 lg:py-10 bg-[#FAF7F2] dark:bg-[#191411] border-t border-b border-ivory-300 dark:border-white/10 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-2xl mx-auto mb-5 reveal">
            <span class="inline-flex items-center gap-1.5 text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                <span>The By Zunash Promise</span>
            </span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-900 dark:text-ivory mt-1 mb-1">
                Uncompromising Standards
            </h2>
            <p class="text-xs text-muted-dark dark:text-ivory-400 font-light">
                From our Lahore workbench directly to your doorstep with total peace of mind.
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
            
            <!-- Card 1 -->
            <div class="cursor-pointer reveal delay-75 group relative flex flex-col items-center text-center p-3.5 sm:p-5 bg-white dark:bg-[#241C18] rounded-2xl border border-ivory-300 dark:border-white/10 hover:border-gold-500/60 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-gold-400 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-ivory-100 dark:bg-[#1A1411] group-hover:bg-espresso-950 text-gold-700 dark:text-gold-400 group-hover:text-gold-300 flex items-center justify-center transition-all duration-300 shadow-inner group-hover:scale-110 mb-2 sm:mb-3">
                    <i data-lucide="truck" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
                <h3 class="font-serif text-xs sm:text-sm font-bold text-espresso-950 dark:text-ivory mb-1 group-hover:text-gold-600 transition-colors">Nationwide Delivery</h3>
                <p class="text-[10px] sm:text-[11px] text-muted-dark dark:text-ivory-400 leading-relaxed font-light">
                    Fast courier shipping across 150+ Pakistani cities with real-time SMS updates.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="cursor-pointer reveal delay-150 group relative flex flex-col items-center text-center p-3.5 sm:p-5 bg-white dark:bg-[#241C18] rounded-2xl border border-ivory-300 dark:border-white/10 hover:border-gold-500/60 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-gold-400 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-ivory-100 dark:bg-[#1A1411] group-hover:bg-espresso-950 text-gold-700 dark:text-gold-400 group-hover:text-gold-300 flex items-center justify-center transition-all duration-300 shadow-inner group-hover:scale-110 mb-2 sm:mb-3">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M6 12h.01M18 12h.01"></path>
                    </svg>
                </div>
                <h3 class="font-serif text-xs sm:text-sm font-bold text-espresso-950 dark:text-ivory mb-1 group-hover:text-gold-600 transition-colors">Cash on Delivery</h3>
                <p class="text-[10px] sm:text-[11px] text-muted-dark dark:text-ivory-400 leading-relaxed font-light">
                    Zero risk. Inspect your parcel and pay securely with cash at your doorstep nationwide.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="cursor-pointer reveal delay-225 group relative flex flex-col items-center text-center p-3.5 sm:p-5 bg-white dark:bg-[#241C18] rounded-2xl border border-ivory-300 dark:border-white/10 hover:border-gold-500/60 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-gold-400 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-ivory-100 dark:bg-[#1A1411] group-hover:bg-espresso-950 text-gold-700 dark:text-gold-400 group-hover:text-gold-300 flex items-center justify-center transition-all duration-300 shadow-inner group-hover:scale-110 mb-2 sm:mb-3">
                    <i data-lucide="award" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
                <h3 class="font-serif text-xs sm:text-sm font-bold text-espresso-950 dark:text-ivory mb-1 group-hover:text-gold-600 transition-colors">100% Pure Leather</h3>
                <p class="text-[10px] sm:text-[11px] text-muted-dark dark:text-ivory-400 leading-relaxed font-light">
                    Full-grain & top-grain Pakistani cowhide. Zero synthetic fillers, zero peel.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="cursor-pointer reveal delay-300 group relative flex flex-col items-center text-center p-3.5 sm:p-5 bg-white dark:bg-[#241C18] rounded-2xl border border-ivory-300 dark:border-white/10 hover:border-gold-500/60 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-gold-400 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-ivory-100 dark:bg-[#1A1411] group-hover:bg-espresso-950 text-gold-700 dark:text-gold-400 group-hover:text-gold-300 flex items-center justify-center transition-all duration-300 shadow-inner group-hover:scale-110 mb-2 sm:mb-3">
                    <i data-lucide="rotate-ccw" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </div>
                <h3 class="font-serif text-xs sm:text-sm font-bold text-espresso-950 dark:text-ivory mb-1 group-hover:text-gold-600 transition-colors">7-Day Exchanges</h3>
                <p class="text-[10px] sm:text-[11px] text-muted-dark dark:text-ivory-400 leading-relaxed font-light">
                    Effortless size swaps or returns with quick doorstep pickup and zero hassle.
                </p>
            </div>

            <!-- Card 5 (Full width on mobile 2-col layout) -->
            <div class="col-span-2 sm:col-span-2 lg:col-span-1 cursor-pointer reveal delay-300 group relative flex flex-col items-center text-center p-3.5 sm:p-5 bg-white dark:bg-[#241C18] rounded-2xl border border-ivory-300 dark:border-white/10 hover:border-gold-500/60 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-gold-400 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-12 h-12 rounded-2xl bg-ivory-100 dark:bg-[#1A1411] group-hover:bg-espresso-950 text-gold-700 dark:text-gold-400 group-hover:text-gold-300 flex items-center justify-center transition-all duration-300 shadow-inner group-hover:scale-110 mb-3">
                    <i data-lucide="phone-call" class="w-5 h-5"></i>
                </div>
                <h3 class="font-serif text-sm font-bold text-espresso-950 dark:text-ivory mb-1 group-hover:text-gold-600 transition-colors">Atelier Concierge</h3>
                <p class="text-[11px] text-muted-dark dark:text-ivory-400 leading-relaxed font-light">
                    Direct concierge support via WhatsApp & phone for sizing advice, gifting, or order inquiries.
                </p>
            </div>

            <!-- Card 6 (Centered on Desktop Grid) -->
            <div class="cursor-pointer reveal delay-300 group relative flex flex-col items-center text-center p-5 bg-white dark:bg-[#241C18] rounded-2xl border border-ivory-300 dark:border-white/10 hover:border-gold-500/60 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden sm:col-span-1 lg:col-span-1 lg:col-start-3">
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-gold-400 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-12 h-12 rounded-2xl bg-ivory-100 dark:bg-[#1A1411] group-hover:bg-espresso-950 text-gold-700 dark:text-gold-400 group-hover:text-gold-300 flex items-center justify-center transition-all duration-300 shadow-inner group-hover:scale-110 mb-3">
                    <i data-lucide="headphones" class="w-5 h-5"></i>
                </div>
                <h3 class="font-serif text-sm font-bold text-espresso-950 dark:text-ivory mb-1 group-hover:text-gold-600 transition-colors">Personal Concierge</h3>
                <p class="text-[11px] text-muted-dark dark:text-ivory-400 leading-relaxed font-light">
                    Direct concierge assistance on WhatsApp for belt sizing, gift selection, and styling recommendations.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     J. CUSTOMER TESTIMONIALS (DARK LUXURY ATELIER SLIDER)
     ======================================================== -->
<section 
    x-data="{
        scrollContainer: null,
        canScrollPrev: false,
        canScrollNext: true,
        autoPlayTimer: null,
        init() {
            this.scrollContainer = this.$refs.reviewsTrack;
            this.startAutoPlay();
        },
        startAutoPlay() {
            this.stopAutoPlay();
            this.autoPlayTimer = setInterval(() => {
                if (!this.scrollContainer) return;
                const { scrollLeft, scrollWidth, clientWidth } = this.scrollContainer;
                if (scrollLeft >= (scrollWidth - clientWidth - 20)) {
                    this.scrollContainer.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    const firstCard = this.scrollContainer.querySelector('div');
                    const step = firstCard ? (firstCard.offsetWidth + 20) : 340;
                    this.scrollContainer.scrollBy({ left: step, behavior: 'smooth' });
                }
            }, 4000);
        },
        stopAutoPlay() {
            if (this.autoPlayTimer) {
                clearInterval(this.autoPlayTimer);
                this.autoPlayTimer = null;
            }
        },
        scrollPrev() {
            if (!this.scrollContainer) return;
            const firstCard = this.scrollContainer.querySelector('div');
            const step = firstCard ? (firstCard.offsetWidth + 20) : 340;
            this.scrollContainer.scrollBy({ left: -step, behavior: 'smooth' });
        },
        scrollNext() {
            if (!this.scrollContainer) return;
            const firstCard = this.scrollContainer.querySelector('div');
            const step = firstCard ? (firstCard.offsetWidth + 20) : 340;
            this.scrollContainer.scrollBy({ left: step, behavior: 'smooth' });
        }
    }"
    @mouseenter="stopAutoPlay()"
    @mouseleave="startAutoPlay()"
    class="py-12 lg:py-16 bg-gradient-to-b from-espresso-950 via-[#140C08] to-espresso-950 text-ivory border-t border-b border-gold/30 relative overflow-hidden"
>
    <!-- Ambient Gold Radial Glows -->
    <div class="absolute -top-32 left-10 w-96 h-96 bg-gold/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-32 right-10 w-96 h-96 bg-gold/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header with Modern Rating Summary -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 reveal">
            <div>
                <span class="inline-flex items-center gap-1.5 text-gold-300 text-xs uppercase tracking-widest font-serif font-bold">
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-gold"></i>
                    <span>Client Impressions</span>
                </span>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white mt-1">
                    Appreciated Across Pakistan
                </h2>
                <div class="flex items-center gap-2 mt-1.5">
                    @if(isset($testimonials) && $testimonials->isNotEmpty())
                        <div class="flex items-center text-gold">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-gold"></i>
                            @endfor
                        </div>
                        <span class="text-xs font-semibold text-white">{{ number_format($testimonials->avg('rating'), 1) }}/5 Rating</span>
                        <span class="text-xs text-ivory-300/70">• {{ $testimonials->count() }} Verified Patrons</span>
                    @else
                        <span class="text-xs text-ivory-300/70">Authentic patron evaluations of By Zunash leathercraft</span>
                    @endif
                </div>
            </div>

            <!-- Slider Navigation Buttons & All Reviews Link -->
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <a 
                    href="{{ route('reviews') }}" 
                    class="text-xs uppercase tracking-widest text-gold hover:text-white transition-colors font-semibold flex items-center gap-1.5 mr-1"
                >
                    <span>All Reviews</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
                @if(isset($testimonials) && $testimonials->isNotEmpty())
                    <button 
                        type="button" 
                        @click="scrollPrev()" 
                        class="w-9 h-9 rounded-full border border-gold/40 hover:border-gold bg-espresso-900/80 hover:bg-gold text-white hover:text-espresso-950 flex items-center justify-center transition-all duration-200 shadow-md active:scale-95"
                        aria-label="Previous review"
                    >
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button 
                        type="button" 
                        @click="scrollNext()" 
                        class="w-9 h-9 rounded-full border border-gold/40 hover:border-gold bg-espresso-900/80 hover:bg-gold text-white hover:text-espresso-950 flex items-center justify-center transition-all duration-200 shadow-md active:scale-95"
                        aria-label="Next review"
                    >
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>
        </div>

        @if(isset($testimonials) && $testimonials->isNotEmpty())
            <!-- Horizontal Multi-Card Slider Track (Shows real card shapes side-by-side!) -->
            <div 
                x-ref="reviewsTrack"
                class="flex items-stretch gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory hide-scrollbar pb-2 pt-1 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
            >
                @foreach($testimonials as $t)
                    <div class="snap-start flex-shrink-0 w-[84vw] max-w-[310px] sm:max-w-none sm:w-[340px] lg:w-[calc(33.333%-14px)] rounded-2xl bg-white/[0.05] hover:bg-white/[0.08] backdrop-blur-md border border-white/10 hover:border-gold/50 p-5 sm:p-6 flex flex-col justify-between shadow-xl transition-all duration-300 hover:-translate-y-1.5 group">
                        <div>
                            <!-- Rating & Product -->
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <div class="flex items-center gap-1 text-gold">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $t->rating ? 'fill-gold text-gold' : 'text-white/20' }}"></i>
                                    @endfor
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gold/15 text-gold-300 text-[9px] font-bold uppercase tracking-wider border border-gold/30">
                                    <i data-lucide="check" class="w-2.5 h-2.5"></i>
                                    <span>Verified</span>
                                </span>
                            </div>

                            <!-- Quote -->
                            <blockquote class="font-serif text-sm sm:text-base text-ivory-100 font-light italic leading-relaxed mb-6">
                                “{{ $t->comment }}”
                            </blockquote>
                        </div>

                        <!-- Author & Product Footer -->
                        <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gold/20 text-gold font-serif font-bold text-xs flex items-center justify-center border border-gold/40">
                                    {{ $t->initials ?: strtoupper(substr($t->author, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-serif text-xs font-bold text-white leading-tight">
                                        {{ $t->author }}
                                    </div>
                                    <div class="text-[10px] text-ivory-400/80">
                                        {{ $t->city }}
                                    </div>
                                </div>
                            </div>

                            @if($t->product_name)
                                <span class="text-[10px] text-gold-400 font-sans font-medium line-clamp-1 max-w-[120px] text-right">
                                    {{ $t->product_name }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Elegant Empty State on Home -->
            <div class="py-12 text-center bg-white/[0.03] rounded-2xl border border-white/10 p-8 backdrop-blur-md max-w-xl mx-auto">
                <div class="w-12 h-12 rounded-full bg-gold/15 text-gold mx-auto flex items-center justify-center mb-3 border border-gold/30">
                    <i data-lucide="star" class="w-5 h-5 fill-gold"></i>
                </div>
                <h3 class="font-serif text-lg font-bold text-white mb-2">Be Our First Reviewed Patron</h3>
                <p class="text-xs text-ivory-300 font-light max-w-md mx-auto mb-5 leading-relaxed">
                    Have you experienced By Zunash artisanal leathercraft? Share your verified evaluation with fellow patrons across Pakistan.
                </p>
                <a 
                    href="{{ route('reviews') }}" 
                    class="px-5 py-2.5 bg-gold hover:bg-gold-light text-espresso-950 font-serif text-xs uppercase tracking-wider font-bold rounded-xl shadow-md inline-flex items-center gap-2 transition-all active:scale-95"
                >
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-espresso-950"></i>
                    <span>Leave a Review</span>
                </a>
            </div>
        @endif
        </div>

    </div>
</section>

<!-- ========================================================
     K. NEWSLETTER SIGNUP
     ======================================================== -->
<section class="py-8 lg:py-10 bg-[#FAF7F2] dark:bg-[#191411] border-t border-ivory-200 dark:border-white/10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <x-user.components.newsletter />
    </div>
</section>

<!-- ========================================================
     L. INSTAGRAM-STYLE GALLERY
     ======================================================== -->
<section class="py-12 lg:py-16 bg-white dark:bg-[#161210] border-t border-ivory-200 dark:border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 reveal">
            <div>
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">#ByZunashLeather</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 dark:text-ivory mt-1 mb-2">
                    Moments in Leather
                </h2>
                <p class="text-xs text-muted-dark dark:text-ivory-400">
                    Follow our daily atelier craft journal on Instagram <span class="font-semibold text-espresso-900 dark:text-gold-400">@ByZunash</span>
                </p>
            </div>
            <a 
                href="https://instagram.com" 
                target="_blank" 
                rel="noopener" 
                class="mt-4 md:mt-0 inline-flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-espresso-900 dark:text-ivory-200 hover:text-gold-600 dark:hover:text-gold transition-colors group"
            >
                <i data-lucide="instagram" class="w-4 h-4 text-gold-600"></i>
                <span>Follow Our Feed</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="reveal delay-75 group relative aspect-square rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-2xs hover:shadow-xl transition-all duration-300">
                <picture>
                    <source srcset="{{ asset('images/brand/artisan-craft-v2.webp') }}" type="image/webp">
                    <img src="{{ asset('images/brand/artisan-craft-v2.jpg') }}" alt="Atelier Craftsman at work" width="200" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </picture>
                <div class="absolute inset-0 bg-espresso-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-3 text-center">
                    <i data-lucide="instagram" class="w-6 h-6 text-gold mb-1"></i>
                    <span class="text-[11px] font-semibold">@ByZunash</span>
                    <span class="text-[10px] text-ivory-300">Atelier Studio</span>
                </div>
            </div>
            <div class="reveal delay-150 group relative aspect-square rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-2xs hover:shadow-xl transition-all duration-300">
                <picture>
                    <source srcset="{{ asset('images/products/prod-signature-satchel.webp') }}" type="image/webp">
                    <img src="{{ asset('images/products/prod-signature-satchel.jpg') }}" alt="Signature Satchel" width="200" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </picture>
                <div class="absolute inset-0 bg-espresso-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-3 text-center">
                    <i data-lucide="instagram" class="w-6 h-6 text-gold mb-1"></i>
                    <span class="text-[11px] font-semibold">@ByZunash</span>
                    <span class="text-[10px] text-ivory-300">Client Favorite</span>
                </div>
            </div>
            <div class="reveal delay-225 group relative aspect-square rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-2xs hover:shadow-xl transition-all duration-300">
                <picture>
                    <source srcset="{{ asset('images/brand/stitch-detail-v2.webp') }}" type="image/webp">
                    <img src="{{ asset('images/brand/stitch-detail-v2.jpg') }}" alt="Waxed saddle stitch detail" width="200" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </picture>
                <div class="absolute inset-0 bg-espresso-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-3 text-center">
                    <i data-lucide="instagram" class="w-6 h-6 text-gold mb-1"></i>
                    <span class="text-[11px] font-semibold">@ByZunash</span>
                    <span class="text-[10px] text-ivory-300">Saddle Seam</span>
                </div>
            </div>
            <div class="reveal delay-300 group relative aspect-square rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-2xs hover:shadow-xl transition-all duration-300">
                <picture>
                    <source srcset="{{ asset('images/products/prod-reversible-belt.webp') }}" type="image/webp">
                    <img src="{{ asset('images/products/prod-reversible-belt.jpg') }}" alt="The Royal Reversible Belt" width="200" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </picture>
                <div class="absolute inset-0 bg-espresso-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-3 text-center">
                    <i data-lucide="instagram" class="w-6 h-6 text-gold mb-1"></i>
                    <span class="text-[11px] font-semibold">@ByZunash</span>
                    <span class="text-[10px] text-ivory-300">Full-Grain Calfskin</span>
                </div>
            </div>
            <div class="reveal delay-450 group relative aspect-square rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-2xs hover:shadow-xl transition-all duration-300">
                <picture>
                    <source srcset="{{ asset('images/products/prod-bifold-wallet.webp') }}" type="image/webp">
                    <img src="{{ asset('images/products/prod-bifold-wallet.jpg') }}" alt="Heritage Bifold Leather Wallet" width="200" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </picture>
                <div class="absolute inset-0 bg-espresso-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-3 text-center">
                    <i data-lucide="instagram" class="w-6 h-6 text-gold mb-1"></i>
                    <span class="text-[11px] font-semibold">@ByZunash</span>
                    <span class="text-[10px] text-ivory-300">Heritage Wallet</span>
                </div>
            </div>
            <div class="reveal delay-600 group relative aspect-square rounded-2xl overflow-hidden bg-ivory-100 border border-ivory-300 shadow-2xs hover:shadow-xl transition-all duration-300">
                <picture>
                    <source srcset="{{ asset('images/products/prod-key-fob.webp') }}" type="image/webp">
                    <img src="{{ asset('images/products/prod-key-fob.jpg') }}" alt="Brass & Leather Key Fob" width="200" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </picture>
                <div class="absolute inset-0 bg-espresso-950/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-3 text-center">
                    <i data-lucide="instagram" class="w-6 h-6 text-gold mb-1"></i>
                    <span class="text-[11px] font-semibold">@ByZunash</span>
                    <span class="text-[10px] text-ivory-300">Solid Antique Brass</span>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
