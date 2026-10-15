@extends('user.layouts.app')

@section('title', 'About Our Atelier & Heritage | By Zunash Leather Pakistan')
@section('meta_description', 'Discover the story behind By Zunash: pure drum-dyed full-grain hides, ancestral Pakistani craftsmanship, and timeless heirloom leather goods.')
@section('meta_keywords', 'about by zunash, pakistani leather brand, leather workshop lahore, full grain leather craft pakistan')
@section('canonical', route('about'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "AboutPage",
            "@id": "{{ route('about') }}/#about",
            "name": "About By Zunash Atelier",
            "description": "Discover the story behind By Zunash: pure drum-dyed full-grain hides, ancestral Pakistani craftsmanship, and timeless heirloom leather goods.",
            "url": "{{ route('about') }}"
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
                    "name": "About Atelier",
                    "item": "{{ route('about') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-white min-h-screen">
    
    <!-- Hero Header -->
    <div class="relative bg-espresso-950 text-ivory py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-25">
            <img 
                src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=2000&q=80" 
                alt="Leather atelier" 
                class="w-full h-full object-cover filter contrast-125"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-espresso-950 via-espresso-950/80 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-gold-300 text-xs uppercase tracking-widest font-serif font-semibold">The By Zunash Heritage</span>
            <h1 class="font-serif text-4xl sm:text-6xl font-bold text-white mt-3 mb-6 leading-tight">
                Crafted With Intent. <br><span class="italic font-light text-gold-200">Preserved Across Time.</span>
            </h1>
            <p class="text-base sm:text-lg text-ivory-200 font-light max-w-2xl mx-auto leading-relaxed">
                We believe true luxury is quiet, tactile, and uncompromising. By Zunash creates heirloom leather goods designed to accompany your journey through decades of daily distinction.
            </p>
        </div>
    </div>

    <!-- Editorial Narrative Section -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
            
            <div class="md:col-span-6 space-y-6 text-sm text-espresso-800 leading-relaxed font-light">
                <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Our Genesis</span>
                <h2 class="font-serif text-3xl font-bold text-espresso-900 leading-snug">
                    An Ode to Pakistani Leathercraft
                </h2>
                <p>
                    Pakistan possesses one of the world's most venerated leather tanning heritages, yet the local market has all too often been flooded with cheap bonded synthetic imitations or mass-produced dropship commodities.
                </p>
                <p>
                    By Zunash was created to restore pride to original artisanal leather goods. We reject superficial shortcuts. We source thick, supple drum-dyed full-grain hides, embrace natural grain variations, and work with master patternmakers who shape each belt, wallet, and bag by hand.
                </p>
                <p class="text-muted">
                    When you hold a By Zunash piece, you feel the density of pure cowhide, the cold solidity of brushed brass hardware, and the unmistakable aroma of vegetable extracts.
                </p>
            </div>

            <div class="md:col-span-6">
                <div class="relative aspect-[4/5] rounded-2xl overflow-hidden shadow-luxury border-4 border-ivory-200">
                    <img 
                        src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=1000&q=80" 
                        alt="Atelier Craftsman at bench" 
                        class="w-full h-full object-cover"
                    >
                </div>
            </div>

        </div>
    </div>

    <!-- The 3 Pillars of Craftsmanship -->
    <div class="bg-ivory-50 border-t border-b border-ivory-200 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-semibold">Unwavering Standards</span>
                <h2 class="font-serif text-3xl font-bold text-espresso-900 mt-2">
                    Our Craftsmanship Principles
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Pillar 1 -->
                <div class="bg-white p-8 rounded-xl border border-ivory-300 shadow-xs">
                    <div class="w-12 h-12 rounded-full bg-ivory-100 flex items-center justify-center text-gold-600 mb-6 font-serif text-lg font-bold">
                        I
                    </div>
                    <h3 class="font-serif text-lg font-bold text-espresso-900 mb-3">100% Full-Grain Hides</h3>
                    <p class="text-xs text-muted leading-relaxed">
                        We never use split leather, genuine bonded plastics, or synthetic substitutes. Full-grain preserves the uppermost layer of the hide, granting superior tensile strength and a living patina.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white p-8 rounded-xl border border-ivory-300 shadow-xs">
                    <div class="w-12 h-12 rounded-full bg-ivory-100 flex items-center justify-center text-gold-600 mb-6 font-serif text-lg font-bold">
                        II
                    </div>
                    <h3 class="font-serif text-lg font-bold text-espresso-900 mb-3">Hand-Waxed Edges</h3>
                    <p class="text-xs text-muted leading-relaxed">
                        Rather than sealing edges with brittle chemical coats that crack over time, our artisans manually bevel, sand, and burnish each edge using organic beeswax and wooden slickers.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white p-8 rounded-xl border border-ivory-300 shadow-xs">
                    <div class="w-12 h-12 rounded-full bg-ivory-100 flex items-center justify-center text-gold-600 mb-6 font-serif text-lg font-bold">
                        III
                    </div>
                    <h3 class="font-serif text-lg font-bold text-espresso-900 mb-3">Solid Bespoke Hardware</h3>
                    <p class="text-xs text-muted leading-relaxed">
                        Our buckles, rings, and zippers are cast from solid brass and antique finished alloys. Heavy in the hand, rust-free, and designed to withstand hundreds of thousands of flexes.
                    </p>
                </div>

            </div>

        </div>
    </div>

    <!-- Call to Explore -->
    <div class="py-20 text-center max-w-2xl mx-auto px-4 sm:px-6">
        <h2 class="font-serif text-3xl font-bold text-espresso-900 mb-4">
            Experience the Collection
        </h2>
        <p class="text-sm text-muted mb-8 leading-relaxed">
            Discover our full assortment of handcrafted leather belts, wallets, and bags delivered with nationwide Cash on Delivery.
        </p>
        <a 
            href="{{ route('shop') }}" 
            class="inline-flex items-center gap-2 px-8 py-4 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all border border-gold/30"
        >
            <span>Explore the Shop</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

</div>
@endsection
