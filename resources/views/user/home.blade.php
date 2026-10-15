@extends('user.layouts.app')

@section('title', 'By Zunash | Crafted to Be Yours — Luxury Pakistani Leather Goods')
@section('meta_description', 'Experience heirloom Pakistani leathercraft. Handcrafted full-grain belts, structured handbags, slim wallets, and accessories. Nationwide Cash on Delivery.')

@section('content')

<!-- ========================================================
     C. REDESIGNED HIGH-END EDITORIAL HERO SECTION
     ======================================================== -->
<section 
    x-data="{
        activeHeroTab: 0,
        heroItems: [
            {
                name: 'The Zunash Signature Satchel',
                category: 'Luxury Handbag',
                price: 14950,
                rating: '5.0',
                reviews: '58',
                image: 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=1200&q=85',
                slug: 'the-zunash-signature-satchel',
                tag: 'Flagship Edition'
            },
            {
                name: 'The Royal Reversible Calfskin Belt',
                category: 'Dress & Casual Belt',
                price: 4950,
                rating: '4.9',
                reviews: '42',
                image: 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=1200&q=85',
                slug: 'the-royal-reversible-calfskin-belt',
                tag: 'Reversible Dual-Tone'
            },
            {
                name: 'The Heritage Bifold Leather Wallet',
                category: 'Full-Grain RFID Wallet',
                price: 3850,
                rating: '4.9',
                reviews: '64',
                image: 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=1200&q=85',
                slug: 'the-heritage-bifold-leather-wallet',
                tag: 'Sized for PKR Notes'
            }
        ]
    }"
    class="relative bg-espresso-950 text-ivory overflow-hidden min-h-[92vh] flex items-center pt-8 pb-16 lg:py-20"
>
    <!-- Ambient Luxury Background Lighting & Textures -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Radial gold glow top right -->
        <div class="absolute -top-32 -right-32 w-[600px] h-[600px] rounded-full bg-gold/10 blur-[130px] animate-pulse-gold"></div>
        <!-- Deep chocolate glow bottom left -->
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] rounded-full bg-chocolate-700/20 blur-[140px]"></div>
        <!-- Subtle leather grain overlay -->
        <div class="absolute inset-0 bg-[radial-gradient(#C5A16B_1px,transparent_1px)] [background-size:32px_32px] opacity-[0.04]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- LEFT COLUMN: Brand Manifesto & Primary CTAs (7 Cols) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Floating Gold Heritage Badge -->
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-espresso-900/90 to-chocolate-900/90 border border-gold/40 text-gold text-xs uppercase tracking-widest font-serif backdrop-blur-md shadow-xs animate-fade-in">
                    <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                    <span>Bespoke Pakistani Leathercraft</span>
                    <span class="text-gold-300">•</span>
                    <span class="text-[10px] text-ivory-300 tracking-wider">The Heirloom Edition</span>
                </div>

                <!-- Main Editorial Headline -->
                <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white leading-[1.08] animate-slide-up">
                    Crafted to Be <br>
                    <span class="italic font-light text-gold-300 relative inline-block">
                        Yours.
                        <!-- Delicate gold underline rule -->
                        <span class="absolute left-0 -bottom-1 w-full h-[2px] bg-gradient-to-r from-gold via-gold-light to-transparent"></span>
                    </span>
                </h1>

                <!-- Supporting Description -->
                <p class="text-base sm:text-lg text-ivory-300 font-light leading-relaxed max-w-xl animate-fade-in delay-150">
                    Born from vegetable-tanned full-grain cowhide and drum-dyed skins, our leather accessories merge ancestral Pakistani leatherworking disciplines with understated contemporary poise. Made to acquire character with every passing journey.
                </p>

                <!-- Primary & Secondary CTAs -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2 animate-fade-in delay-225">
                    <a 
                        href="{{ route('shop') }}" 
                        class="px-8 py-4 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-lg shadow-luxury hover:shadow-gold-glow transition-all duration-300 text-center flex items-center justify-center gap-2 group active:scale-95"
                    >
                        <span>Shop The Collection</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                    
                    <a 
                        href="{{ route('about') }}" 
                        class="px-8 py-4 bg-white/5 hover:bg-white/15 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg border border-gold/30 backdrop-blur-sm transition-all duration-300 text-center flex items-center justify-center gap-2"
                    >
                        <span>Our Atelier Story</span>
                    </a>
                </div>

                <!-- Trust Points Grid -->
                <div class="pt-8 border-t border-white/10 grid grid-cols-3 gap-4 text-xs text-ivory-300 animate-fade-in delay-300">
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="shield-check" class="w-5 h-5 text-gold flex-shrink-0 mt-0.5"></i>
                        <div>
                            <div class="font-serif font-bold text-white text-sm">100% Pure Hide</div>
                            <div class="text-[11px] text-ivory-400">Zero synthetic plastics</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="truck" class="w-5 h-5 text-gold flex-shrink-0 mt-0.5"></i>
                        <div>
                            <div class="font-serif font-bold text-white text-sm">Nationwide COD</div>
                            <div class="text-[11px] text-ivory-400">Doorstep delivery in Pakistan</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="rotate-ccw" class="w-5 h-5 text-gold flex-shrink-0 mt-0.5"></i>
                        <div>
                            <div class="font-serif font-bold text-white text-sm">7-Day Exchange</div>
                            <div class="text-[11px] text-ivory-400">Hassle-free guarantee</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Interactive Luxury Product Spotlight Showcase (5 Cols) -->
            <div class="lg:col-span-5 relative mt-6 lg:mt-0">
                
                <!-- Rotating Decorative Ring -->
                <div class="absolute -top-10 -right-10 w-44 h-44 rounded-full border border-gold/20 animate-slow-spin pointer-events-none hidden sm:block"></div>

                <!-- Main Showcase Card -->
                <div class="relative rounded-2xl overflow-hidden bg-espresso-900 border border-gold/30 shadow-2xl group">
                    
                    <!-- Dynamic Featured Image with subtle zoom on hover -->
                    <div class="relative aspect-[4/5] overflow-hidden bg-espresso-950">
                        <img 
                            :src="heroItems[activeHeroTab].image" 
                            :alt="heroItems[activeHeroTab].name" 
                            class="w-full h-full object-cover object-center transform transition-all duration-700 ease-out group-hover:scale-105"
                        >
                        <!-- Gradient wash -->
                        <div class="absolute inset-0 bg-gradient-to-t from-espresso-950/95 via-espresso-950/20 to-transparent"></div>

                        <!-- Top Floating Tag -->
                        <div class="absolute top-4 left-4 z-10">
                            <span 
                                x-text="heroItems[activeHeroTab].tag" 
                                class="px-3 py-1 bg-espresso-950/90 text-gold border border-gold/40 text-[10px] uppercase tracking-widest font-serif rounded-full backdrop-blur-md shadow-md"
                            ></span>
                        </div>

                        <!-- Top Right Hallmark Emblem -->
                        <div class="absolute top-4 right-4 z-10 w-11 h-11 rounded-full bg-espresso-900/80 border border-gold/50 backdrop-blur-md flex items-center justify-center text-gold shadow-lg">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                    </div>

                    <!-- Bottom Floating Spotlight Details Card -->
                    <div class="p-6 bg-gradient-to-b from-espresso-900/90 to-espresso-950 border-t border-gold/20">
                        
                        <!-- Mini Tabs Switcher -->
                        <div class="flex items-center gap-1.5 mb-4 pb-3 border-b border-white/10">
                            <template x-for="(item, idx) in heroItems" :key="idx">
                                <button 
                                    type="button" 
                                    @click="activeHeroTab = idx"
                                    class="text-[11px] uppercase tracking-wider py-1 px-3 rounded-md transition-all font-medium"
                                    :class="activeHeroTab === idx ? 'bg-gold text-espresso-950 font-bold shadow-xs' : 'text-ivory-300 hover:text-white bg-white/5'"
                                    x-text="item.category"
                                ></button>
                            </template>
                        </div>

                        <!-- Active Item Summary -->
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-widest text-gold font-serif block mb-0.5" x-text="heroItems[activeHeroTab].category"></span>
                                <h3 class="font-serif text-lg font-bold text-white line-clamp-1" x-text="heroItems[activeHeroTab].name"></h3>
                                <div class="flex items-center gap-1.5 text-xs text-gold mt-1">
                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-gold"></i>
                                    <span class="font-bold text-white" x-text="heroItems[activeHeroTab].rating"></span>
                                    <span class="text-ivory-400 text-[11px]" x-text="'(' + heroItems[activeHeroTab].reviews + ' reviews)'"></span>
                                </div>
                            </div>

                            <div class="text-right flex-shrink-0">
                                <div class="font-serif text-xl font-bold text-gold">
                                    PKR <span x-text="heroItems[activeHeroTab].price.toLocaleString()"></span>
                                </div>
                                <a 
                                    :href="'/product/' + heroItems[activeHeroTab].slug" 
                                    class="inline-flex items-center gap-1 text-[11px] uppercase tracking-widest text-white hover:text-gold-200 mt-1 font-semibold underline underline-offset-4"
                                >
                                    <span>Inspect Piece</span>
                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Floating Artisan Accent Badge (Bottom Left overlap with gentle float) -->
                <div class="absolute -bottom-6 -left-6 z-20 hidden sm:flex items-center gap-3 bg-white text-espresso-900 p-3.5 rounded-xl border border-gold/40 shadow-2xl animate-gentle-float">
                    <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-chocolate-800">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="font-serif text-xs font-bold uppercase tracking-wider text-espresso-950">Artisan Hallmark</div>
                        <div class="text-[10px] text-muted-dark">Hand-Beveled & Waxed in Pakistan</div>
                    </div>
                </div>

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
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
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
