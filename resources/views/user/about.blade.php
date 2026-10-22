@extends('user.layouts.app')

@section('title', 'Our Story & Atelier Heritage | Handcrafted Full-Grain Leather | By Zunash Pakistan')
@section('meta_description', 'Discover the story behind By Zunash: pure vegetable-tanned full-grain hides, ancestral Pakistani leathercraft, and timeless heirloom goods designed to endure.')
@section('meta_keywords', 'about by zunash, our story, pakistani leather brand, leather workshop lahore, full grain leather craft pakistan, luxury leather goods')
@section('canonical', route('about'))
@section('og_type', 'website')
@section('og_image', asset('images/brand/artisan-craft.jpg'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "AboutPage",
            "@id": "{{ route('about') }}/#about",
            "name": "About By Zunash Atelier",
            "description": "Discover the story behind By Zunash: pure vegetable-tanned full-grain hides, ancestral Pakistani leathercraft, and timeless heirloom goods designed to endure.",
            "url": "{{ route('about') }}"
        },
        {
            "@type": "Organization",
            "@id": "{{ route('home') }}/#organization",
            "name": "By Zunash",
            "url": "{{ route('home') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "description": "Purveyors of handcrafted 100% full-grain leather belts, wallets, and bespoke bags in Pakistan.",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Lahore",
                "addressCountry": "PK"
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('about') }}/#breadcrumb",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ route('home') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Our Story & Atelier",
                    "item": "{{ route('about') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-white min-h-screen text-espresso-900 selection:bg-gold/30 selection:text-espresso-950">
    
    <!-- =========================================================================
         SECTION 1: HERO ATELIER HEADER (Visible Photo, Compact Height, Dark Luxury)
         ========================================================================= -->
    <div class="relative bg-espresso-950 text-ivory py-14 sm:py-18 lg:py-20 overflow-hidden">
        
        <!-- Background High-Res Leather Craft Atmosphere: Brightness tuned to 0.62 so workshop is clearly visible -->
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ asset('images/brand/artisan-craft.jpg') }}" 
                alt="By Zunash Artisan Leather Workshop" 
                class="w-full h-full object-cover object-center filter brightness-[0.62] contrast-105 scale-100"
            >
            <!-- Lighter, warm vignette so the photo details shine through -->
            <div class="absolute inset-0 bg-gradient-to-t from-espresso-950/95 via-espresso-950/50 to-espresso-950/75"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(201,162,79,0.12)_0,transparent_65%)]"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Atelier Crest Pretitle -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-black/40 backdrop-blur-md border border-gold/40 text-gold-300 text-[11px] uppercase tracking-widest font-serif font-bold mb-4 shadow-sm">
                <span>◈</span>
                <span>The By Zunash Atelier Narrative</span>
                <span>◈</span>
                <span class="text-ivory-300 font-mono text-[10px]">Est. 2026</span>
            </div>

            <!-- Grand Editorial Headline (Refined compact sizing) -->
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight tracking-tight drop-shadow-sm">
                Crafted With Intent. <br>
                <span class="italic font-light text-gold-200">Preserved Across Decades.</span>
            </h1>

            <!-- Narrative Intro (Compact & readable) -->
            <p class="text-xs sm:text-sm lg:text-base text-ivory-200 font-light max-w-2xl mx-auto leading-relaxed mb-8 drop-shadow-sm">
                We believe true luxury is quiet, tactile, and unapologetically authentic. Handcrafted in Pakistan using 100% full-grain vegetable-tanned hides, our pieces are enduring companions born to age with timeless grace.
            </p>

            <!-- 4 Quick Atelier Distinction Badges (Compact) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 max-w-3xl mx-auto text-left">
                <div class="p-3 rounded-xl bg-black/45 backdrop-blur-md border border-white/15 hover:border-gold/50 transition-colors">
                    <span class="block text-gold text-xs font-serif uppercase tracking-wider font-bold">100% Full-Grain</span>
                    <span class="text-[11px] text-ivory-300">Pure upper steer & calf hides</span>
                </div>
                <div class="p-3 rounded-xl bg-black/45 backdrop-blur-md border border-white/15 hover:border-gold/50 transition-colors">
                    <span class="block text-gold text-xs font-serif uppercase tracking-wider font-bold">Wax-Burnished</span>
                    <span class="text-[11px] text-ivory-300">Sealed with local beeswax</span>
                </div>
                <div class="p-3 rounded-xl bg-black/45 backdrop-blur-md border border-white/15 hover:border-gold/50 transition-colors">
                    <span class="block text-gold text-xs font-serif uppercase tracking-wider font-bold">Solid Brass</span>
                    <span class="text-[11px] text-ivory-300">Heavy antique cast hardware</span>
                </div>
                <div class="p-3 rounded-xl bg-black/45 backdrop-blur-md border border-white/15 hover:border-gold/50 transition-colors">
                    <span class="block text-gold text-xs font-serif uppercase tracking-wider font-bold">Doorstep COD</span>
                    <span class="text-[11px] text-ivory-300">Inspect parcel nationwide</span>
                </div>
            </div>

        </div>

        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gold/40 to-transparent"></div>
    </div>


    <!-- =========================================================================
         SECTION 2: CHAPTER I — THE GENESIS (Warm Light Linen / Ivory Section)
         ========================================================================= -->
    <div class="bg-[#FAF7F2] border-b border-ivory-300/80 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Text Column -->
                <div class="lg:col-span-6 space-y-4">
                    
                    <div class="flex items-center gap-2 text-gold-700 text-xs uppercase tracking-widest font-serif font-bold">
                        <span>Chapter I</span>
                        <span class="text-ivory-400">•</span>
                        <span>Our Genesis</span>
                    </div>

                    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-espresso-950 leading-tight">
                        Restoring Honor to Pakistani Leathercraft
                    </h2>

                    <p class="text-xs sm:text-sm text-espresso-800 leading-relaxed font-light">
                        Pakistan possesses one of the world's most historic leather tanning legacies dating back centuries along the Indus. Yet in modern retail, cheap bonded scraps chemically glued with plastic have crowded the market.
                    </p>

                    <p class="text-xs sm:text-sm text-espresso-800 leading-relaxed font-light">
                        By Zunash was founded to restore pride to original artisanal leather goods. We source thick, supple drum-dyed full-grain hides, embrace natural grain marks, and work with master patternmakers who shape each belt, wallet, and bag by hand.
                    </p>

                    <!-- Quoted Atelier Philosophy Callout -->
                    <div class="p-4 sm:p-5 rounded-xl bg-white border-l-4 border-gold shadow-sm my-4">
                        <p class="font-serif italic text-xs sm:text-sm text-espresso-950 leading-relaxed">
                            “We did not establish By Zunash to chase fast fashion. We founded it to celebrate the slow dignity of true hide, where every stitch and burnish honors our ancestral artisans.”
                        </p>
                        <div class="mt-2 text-[10px] text-gold-700 uppercase tracking-widest font-bold">
                            — The Master Patternmakers of By Zunash (Lahore & Karachi)
                        </div>
                    </div>

                    <div class="pt-1 flex items-center gap-5 text-xs text-espresso-950 font-serif uppercase tracking-wider font-bold">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4 text-gold-700"></i>
                            <span>Zero Synthetic Fillers</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="check" class="w-4 h-4 text-gold-700"></i>
                            <span>Small Artisan Batches</span>
                        </div>
                    </div>

                </div>

                <!-- Right Visual Composition: Layered Media -->
                <div class="lg:col-span-6 relative">
                    
                    <!-- Main Photo -->
                    <div class="relative aspect-[4/3.8] max-h-[380px] rounded-2xl overflow-hidden shadow-luxury border-2 border-ivory-300 group bg-ivory-100">
                        <img 
                            src="{{ asset('images/brand/artisan-craft.jpg') }}" 
                            alt="By Zunash Master Artisan Handcrafting Leather" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="text-[10px] uppercase tracking-widest text-gold-300 font-serif font-bold block">
                                Atelier Workshop • Lahore
                            </span>
                            <p class="font-serif text-sm font-bold">The Master Patternmaker's Bench</p>
                        </div>
                    </div>

                    <!-- Floating Macro Detail Photo -->
                    <div class="hidden sm:block absolute -bottom-5 -left-5 w-48 rounded-xl overflow-hidden shadow-xl border-2 border-white bg-white group/sub">
                        <div class="aspect-square overflow-hidden">
                            <img 
                                src="{{ asset('images/brand/stitch-detail.jpg') }}" 
                                alt="Precision Saddle Stitching" 
                                class="w-full h-full object-cover group-hover/sub:scale-110 transition-transform duration-300"
                            >
                        </div>
                        <div class="p-2 bg-espresso-950 text-ivory text-left">
                            <span class="text-[9px] uppercase tracking-widest text-gold font-bold block">Macro Detail</span>
                            <p class="text-[11px] font-serif">Hand-Beveled & Waxed Edges</p>
                        </div>
                    </div>

                    <!-- Floating Stamp Badge -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-gold/90 backdrop-blur-md p-1 shadow-md flex items-center justify-center text-espresso-950 text-center border-2 border-white pointer-events-none">
                        <div class="w-full h-full rounded-full border border-dashed border-espresso-950/40 flex flex-col items-center justify-center p-1">
                            <span class="text-[8px] font-bold uppercase tracking-widest font-mono">100% Pure</span>
                            <span class="font-serif text-[10px] font-bold leading-none my-0.5">FULL GRAIN</span>
                            <span class="text-[7px] uppercase tracking-tighter">Guaranteed</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- =========================================================================
         SECTION 3: CHAPTER II — THE 4 SACRED STAGES (Deep Luxury Dark Section)
         ========================================================================= -->
    <div class="bg-[#160E0A] text-ivory border-y border-gold/25 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-gold text-xs uppercase tracking-widest font-serif font-bold">Chapter II • Artisanal Protocol</span>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white mt-1 mb-2">
                    The Four Sacred Stages of Creation
                </h2>
                <p class="text-xs text-ivory-300 font-light">
                    Every piece in our collection travels through weeks of painstaking ritual before earning the By Zunash imprint.
                </p>
            </div>

            <!-- 4 Stage Grid in Dark Glass Luxury Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                
                <!-- Stage 1 -->
                <div class="bg-white/[0.04] p-5 rounded-2xl border border-white/10 hover:border-gold/60 shadow-md hover:bg-white/[0.07] transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-serif text-2xl font-bold text-gold group-hover:scale-110 transition-transform">01</span>
                        <div class="w-9 h-9 rounded-full bg-gold/15 text-gold flex items-center justify-center border border-gold/30">
                            <i data-lucide="feather" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-widest text-ivory-400 font-bold block mb-1">Raw Selection</span>
                    <h3 class="font-serif text-base font-bold text-white mb-2">
                        Vegetable Tanning & Hide Curation
                    </h3>
                    <p class="text-xs text-ivory-300 leading-relaxed font-light mb-3">
                        Immersed in oak, chestnut, and mimosa bark baths for 45 days. Retains natural grain pores and breathing resilience that deepens into a rich personal patina.
                    </p>
                    <div class="pt-2 border-t border-white/10 text-[10px] font-mono text-gold">
                        45 Days in Bark Extract
                    </div>
                </div>

                <!-- Stage 2 -->
                <div class="bg-white/[0.04] p-5 rounded-2xl border border-white/10 hover:border-gold/60 shadow-md hover:bg-white/[0.07] transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-serif text-2xl font-bold text-gold group-hover:scale-110 transition-transform">02</span>
                        <div class="w-9 h-9 rounded-full bg-gold/15 text-gold flex items-center justify-center border border-gold/30">
                            <i data-lucide="scissors" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-widest text-ivory-400 font-bold block mb-1">Directional Cutting</span>
                    <h3 class="font-serif text-base font-bold text-white mb-2">
                        Grain Alignment & Hand-Skiving
                    </h3>
                    <p class="text-xs text-ivory-300 leading-relaxed font-light mb-3">
                        Patternmakers orient cuts strictly along the natural spine line of each hide to guarantee structural elasticity, zero warping, and uniform bend over decades.
                    </p>
                    <div class="pt-2 border-t border-white/10 text-[10px] font-mono text-gold">
                        Hand-inspected hide by hide
                    </div>
                </div>

                <!-- Stage 3 -->
                <div class="bg-white/[0.04] p-5 rounded-2xl border border-white/10 hover:border-gold/60 shadow-md hover:bg-white/[0.07] transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-serif text-2xl font-bold text-gold group-hover:scale-110 transition-transform">03</span>
                        <div class="w-9 h-9 rounded-full bg-gold/15 text-gold flex items-center justify-center border border-gold/30">
                            <i data-lucide="git-commit" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-widest text-ivory-400 font-bold block mb-1">Heritage Construction</span>
                    <h3 class="font-serif text-base font-bold text-white mb-2">
                        Two-Needle Saddle Stitching
                    </h3>
                    <p class="text-xs text-ivory-300 leading-relaxed font-light mb-3">
                        Waxed Japanese polyester thread passing from opposite sides through prepierced diamond awl holes. Even if one stitch is abraded, the seam never unzips.
                    </p>
                    <div class="pt-2 border-t border-white/10 text-[10px] font-mono text-gold">
                        Tensile retention > 180 kg/cm²
                    </div>
                </div>

                <!-- Stage 4 -->
                <div class="bg-white/[0.04] p-5 rounded-2xl border border-white/10 hover:border-gold/60 shadow-md hover:bg-white/[0.07] transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-serif text-2xl font-bold text-gold group-hover:scale-110 transition-transform">04</span>
                        <div class="w-9 h-9 rounded-full bg-gold/15 text-gold flex items-center justify-center border border-gold/30">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-widest text-ivory-400 font-bold block mb-1">The Final Seal</span>
                    <h3 class="font-serif text-base font-bold text-white mb-2">
                        Beveling & Beeswax Edge Burnishing
                    </h3>
                    <p class="text-xs text-ivory-300 leading-relaxed font-light mb-3">
                        Every raw edge is beveled, hand-rubbed with organic local beeswax, and heat-burnished with dense rosewood slickers to seal fibers against humidity.
                    </p>
                    <div class="pt-2 border-t border-white/10 text-[10px] font-mono text-gold">
                        Triple-burnished glass finish
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 4: CHAPTER III — CONSUMER CLARITY (Warm Light Cream Section)
         ========================================================================= -->
    <div class="bg-white py-12 sm:py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-gold-700 text-xs uppercase tracking-widest font-serif font-bold">Chapter III • Consumer Clarity</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 mt-1">
                    Understanding True Leather Quality
                </h2>
                <p class="text-xs text-muted mt-1 font-light">
                    Why "Genuine Leather" in big-box retail often disappoints, and why Full-Grain is the gold standard of heirloom luxury.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Card 1: By Zunash 100% Full-Grain (Dark Luxury Card) -->
                <div class="p-6 rounded-2xl bg-espresso-950 text-ivory border-2 border-gold/40 shadow-luxury relative overflow-hidden">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gold/20 text-gold-300 text-[10px] font-bold uppercase tracking-wider mb-3 border border-gold/30">
                        <i data-lucide="award" class="w-3 h-3"></i>
                        <span>The By Zunash Standard</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-white mb-1.5">100% Pure Full-Grain Hide</h3>
                    <p class="text-xs text-ivory-300 leading-relaxed font-light mb-4">
                        Preserves the uppermost dense grain layer where hide fibers are tightest and strongest.
                    </p>

                    <ul class="space-y-2.5 text-xs text-ivory-200">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span><strong>Develops Rich Living Patina:</strong> Deepens in luster with body heat and everyday touch.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span><strong>Never Peels or Cracks:</strong> Naturally porous and breathable hide that stays supple.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span><strong>Generational Longevity:</strong> Built to last 15–20+ years of active daily rotation.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span><strong>Authentic Aroma:</strong> Natural notes of plant bark, sweet oil, and beeswax.</span>
                        </li>
                    </ul>
                </div>

                <!-- Card 2: Mass Market "Genuine" / Bonded (Warm Light Card) -->
                <div class="p-6 rounded-2xl bg-ivory-100/80 text-espresso-900 border border-ivory-300 relative">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-stone-200 text-espresso-700 text-[10px] font-bold uppercase tracking-wider mb-3">
                        <i data-lucide="alert-circle" class="w-3 h-3 text-stone-500"></i>
                        <span>Mass-Market Retail</span>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-espresso-900 mb-1.5">"Genuine" & Bonded Leather</h3>
                    <p class="text-xs text-muted leading-relaxed font-light mb-4">
                        Made by pressing shredded leather dust with polyurethane plastic resin and stamping a fake print on top.
                    </p>

                    <ul class="space-y-2.5 text-xs text-espresso-800">
                        <li class="flex items-start gap-2">
                            <i data-lucide="x" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                            <span><strong>Peels within 6–12 Months:</strong> Plastic laminate coating flakes off at flex points.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="x" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                            <span><strong>Zero Natural Patina:</strong> Turns discolored and sticky rather than enriching over time.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="x" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                            <span><strong>Chemical Odor:</strong> Smells of synthetic adhesives and petroleum solvents.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="x" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                            <span><strong>Weak Tear Resistance:</strong> Prone to tearing around belt holes and card banks.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 5: THE VISUAL ATELIER GALLERY (Deep Midnight Dark Section)
         ========================================================================= -->
    <div class="bg-[#120B08] py-12 sm:py-16 text-ivory border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8">
                <div>
                    <span class="text-gold text-xs uppercase tracking-widest font-serif font-bold">The Atelier Gallery</span>
                    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white mt-1">
                        Silent Poetry in Pure Hide
                    </h2>
                </div>
                <a 
                    href="{{ route('shop') }}" 
                    class="mt-3 sm:mt-0 inline-flex items-center gap-1.5 text-xs uppercase tracking-widest text-gold hover:text-white transition-colors font-semibold"
                >
                    <span>View Atelier Catalog</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <!-- 3 Editorial Photos Grid (Compact Aspect Ratio) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Photo 1: Belts on stone -->
                <div class="group relative rounded-xl overflow-hidden aspect-[4/4.2] bg-espresso-900 border border-white/10 shadow-luxury">
                    <img 
                        src="{{ asset('images/hero/slide-belt.jpg') }}" 
                        alt="By Zunash Hand-Burnished Leather Belts" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <span class="text-[9px] uppercase tracking-widest text-gold font-bold">Bespoke Belts</span>
                        <h4 class="font-serif text-base font-bold text-white mt-0.5">The Royal Reversible Suite</h4>
                        <p class="text-[11px] text-ivory-300 font-light mt-0.5">Swivel antique brass buckle with dual-tone full-grain calfskin.</p>
                    </div>
                </div>

                <!-- Photo 2: Bags on stone -->
                <div class="group relative rounded-xl overflow-hidden aspect-[4/4.2] bg-espresso-900 border border-white/10 shadow-luxury">
                    <img 
                        src="{{ asset('images/hero/slide-bag.jpg') }}" 
                        alt="By Zunash Handcrafted Structured Bags" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <span class="text-[9px] uppercase tracking-widest text-gold font-bold">Heirloom Handbags</span>
                        <h4 class="font-serif text-base font-bold text-white mt-0.5">Architectural Carryalls</h4>
                        <p class="text-[11px] text-ivory-300 font-light mt-0.5">Rolled leather handles, reinforced brass base studs, and suede lining.</p>
                    </div>
                </div>

                <!-- Photo 3: Wallets on stone -->
                <div class="group relative rounded-xl overflow-hidden aspect-[4/4.2] bg-espresso-900 border border-white/10 shadow-luxury">
                    <img 
                        src="{{ asset('images/hero/slide-wallet.jpg') }}" 
                        alt="By Zunash Bifold Wallets & Cardholders" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <span class="text-[9px] uppercase tracking-widest text-gold font-bold">Everyday Essentials</span>
                        <h4 class="font-serif text-base font-bold text-white mt-0.5">Calibrated PKR Bifolds</h4>
                        <p class="text-[11px] text-ivory-300 font-light mt-0.5">Precision slots designed for Pakistani currency and RFID protection.</p>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 6: CLIENT TRUST PACT & GUARANTEES (Warm Light Linen Section)
         ========================================================================= -->
    <div class="bg-[#FAF7F2] border-t border-b border-ivory-300 py-12 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-gold-700 text-xs uppercase tracking-widest font-serif font-bold">The Client Trust Pact</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-espresso-950 mt-1">
                    Our Atelier Guarantees
                </h2>
            </div>

            <!-- 4 Guarantees with Verified Icons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                
                <div class="p-5 rounded-xl bg-white border border-ivory-300 hover:border-gold transition-colors shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-ivory-100 text-gold-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-serif text-sm font-bold text-espresso-950 mb-1">Express Delivery</h4>
                    <p class="text-[11px] text-muted leading-relaxed">
                        24–48h to Karachi, Lahore, Islamabad & Rawalpindi. 2–3 days nationwide.
                    </p>
                </div>

                <div class="p-5 rounded-xl bg-white border border-ivory-300 hover:border-gold transition-colors shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-ivory-100 text-gold-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="banknote" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-serif text-sm font-bold text-espresso-950 mb-1">Cash on Delivery</h4>
                    <p class="text-[11px] text-muted leading-relaxed">
                        Doorstep parcel inspection before paying via cash or direct bank transfer.
                    </p>
                </div>

                <div class="p-5 rounded-xl bg-white border border-ivory-300 hover:border-gold transition-colors shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-ivory-100 text-gold-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-serif text-sm font-bold text-espresso-950 mb-1">7-Day Exchange</h4>
                    <p class="text-[11px] text-muted leading-relaxed">
                        Need another belt size or color? Concierge doorstep replacement arranged easily.
                    </p>
                </div>

                <div class="p-5 rounded-xl bg-white border border-ivory-300 hover:border-gold transition-colors shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-ivory-100 text-gold-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="gift" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-serif text-sm font-bold text-espresso-950 mb-1">Rigid Presentation Box</h4>
                    <p class="text-[11px] text-muted leading-relaxed">
                        Presented in an embossed magnetic gift box with a breathable linen dust pouch.
                    </p>
                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 7: GRAND CLOSING INVITATION (Compact Dark Section)
         ========================================================================= -->
    <div class="relative bg-espresso-950 text-ivory py-12 sm:py-16 overflow-hidden border-t border-gold/30">
        
        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 text-center">
            
            <span class="text-gold text-xs uppercase tracking-widest font-serif font-bold">Your Everyday Heirloom Awaits</span>
            
            <h2 class="font-serif text-2xl sm:text-4xl font-bold text-white mt-2 mb-4 leading-tight">
                Begin Your Journey With By Zunash
            </h2>
            
            <p class="text-xs sm:text-sm text-ivory-300 font-light max-w-xl mx-auto leading-relaxed mb-6">
                Explore our current release of full-grain reversible belts, tailored bifold wallets, and sculpted handbags — delivered with nationwide Cash on Delivery.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a 
                    href="{{ route('shop') }}" 
                    class="w-full sm:w-auto px-7 py-3.5 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl shadow-md hover:shadow-gold-glow transition-all active:scale-[0.98] inline-flex items-center justify-center gap-2"
                >
                    <span>Explore The Entire Shop</span>
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                </a>

                <a 
                    href="{{ route('contact') }}" 
                    class="w-full sm:w-auto px-7 py-3.5 bg-transparent hover:bg-white/10 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl border border-white/25 hover:border-gold transition-all inline-flex items-center justify-center gap-2"
                >
                    <span>Speak With Atelier Concierge</span>
                    <i data-lucide="message-square" class="w-4 h-4 text-gold"></i>
                </a>
            </div>

            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-ivory-400 font-serif uppercase tracking-wider">
                <span>• Handcrafted in Pakistan</span>
                <span>• Doorstep Cash on Delivery</span>
                <span>• 7-Day Exchange</span>
            </div>

        </div>

    </div>

</div>
@endsection
