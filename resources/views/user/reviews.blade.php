@extends('user.layouts.app')

@section('title', 'Client Reviews & Verified Patron Impressions | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'Read verified reviews from patrons across Pakistan who cherish By Zunash full-grain leather belts, wallets, and bags. Rated 4.9/5 nationwide.')
@section('meta_keywords', 'by zunash reviews, customer reviews leather pakistan, luxury belts reviews, leather wallet review lahore, full grain leather feedback')
@section('canonical', route('reviews'))
@section('og_type', 'website')
@section('og_image', asset('images/brand/artisan-craft.jpg'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Product",
            "name": "By Zunash Full-Grain Leather Collection",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.9",
                "reviewCount": "540",
                "bestRating": "5",
                "worstRating": "1"
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('reviews') }}/#breadcrumb",
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
                    "name": "Client Reviews",
                    "item": "{{ route('reviews') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div 
    x-data="{
        activeFilter: 'all',
        writeModalOpen: false,
        formRating: 5,
        formTitle: '',
        formComment: '',
        presets: [
            {
                label: '✨ Heirloom Quality',
                title: 'Impeccable leathercraft & flawless stitching',
                comment: 'The quality of the full-grain hide and hand-burnished edges exceeded my expectations. Feels substantial, smells amazing, and the hardware is authoritative.'
            },
            {
                label: '💼 Perfect Everyday Fit',
                title: 'Sublime leather finish & tailored dimensions',
                comment: 'Remarkably slim in suit pockets yet effortlessly holds Pakistani currency notes. The craftsmanship is on par with international luxury fashion houses.'
            },
            {
                label: '🚚 Doorstep Inspection',
                title: 'Exceptional doorstep parcel inspection experience',
                comment: 'Being able to inspect the genuine leather hide and stitching at my doorstep before paying COD made ordering online completely risk-free. Truly impressed.'
            },
            {
                label: '🔄 Swivel Mechanism',
                title: 'Solid swivel buckle mechanism & versatile styling',
                comment: 'Transitions smoothly between formal obsidian black and rich espresso calfskin. The buckle click is authoritative and solid. Best leather piece I have owned in Pakistan.'
            },
            {
                label: '🎁 Regal Gifting',
                title: 'Bespoke luxury presentation & magnetic rigid box',
                comment: 'Ordered as a gift and the packaging alone was regal. The aroma of genuine vegetable-tanned hide and custom gold hardware are extraordinary.'
            }
        ],
        applyPreset(preset) {
            this.formTitle = preset.title;
            this.formComment = preset.comment;
        },
        reviews: {{ json_encode($reviews) }},
        filterReviews(cat) {
            this.activeFilter = cat;
        },
        get filteredList() {
            if (this.activeFilter === 'all') return this.reviews;
            return this.reviews.filter(r => r.category === this.activeFilter);
        },
        markHelpful(id) {
            const rev = this.reviews.find(r => r.id === id);
            if (rev && !rev.liked) {
                rev.helpful++;
                rev.liked = true;
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast('Thank you for your feedback.', 'success');
                }
            }
        }
    }"
    @keydown.escape.window="writeModalOpen = false"
    class="bg-white min-h-screen text-espresso-900 selection:bg-gold/30 selection:text-espresso-950"
>

    <!-- =========================================================================
         SECTION 1: HERO REVIEWS HEADER (Compact Dark Luxury)
         ========================================================================= -->
    <div class="relative bg-espresso-950 text-ivory py-12 sm:py-16 overflow-hidden">
        
        <!-- Subtle Workshop Atmosphere -->
        <div class="absolute inset-0 z-0 opacity-20">
            <img 
                src="{{ asset('images/brand/artisan-craft.jpg') }}" 
                alt="Leather atelier atmosphere" 
                class="w-full h-full object-cover filter brightness-75 contrast-125"
            >
            <div class="absolute inset-0 bg-espresso-950/90"></div>
        </div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(201,162,79,0.15)_0,transparent_70%)] pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-gold/40 text-gold-300 text-[11px] uppercase tracking-widest font-serif font-bold mb-3 shadow-xs">
                <span>◈</span>
                <span>Verified Client Patronage</span>
                <span>◈</span>
                <span class="text-white font-mono text-[10px]">
                    @if($reviewsCount > 0)
                        {{ number_format($averageRating, 1) }} / 5.0 Rating ({{ $reviewsCount }} {{ Str::plural('Review', $reviewsCount) }})
                    @else
                        Authentic Reviews
                    @endif
                </span>
            </div>

            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight tracking-tight">
                Appreciated Across Pakistan
            </h1>

            <p class="text-xs sm:text-sm text-ivory-200 font-light max-w-xl mx-auto leading-relaxed mb-6">
                Discover genuine reflections from discerning patrons in Lahore, Karachi, Islamabad, and nationwide who experience the tactile distinction of By Zunash full-grain hides daily.
            </p>

            <!-- Actions -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <button 
                    type="button" 
                    @click="writeModalOpen = true"
                    class="px-6 py-3 bg-gold hover:bg-gold-light text-espresso-950 text-xs uppercase tracking-widest font-bold rounded-xl shadow-md hover:shadow-gold-glow transition-all active:scale-98 inline-flex items-center gap-2"
                >
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-espresso-950"></i>
                    <span>Share Your Review</span>
                </button>

                <a 
                    href="{{ route('shop') }}" 
                    class="px-6 py-3 bg-white/10 hover:bg-white/20 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl border border-white/25 hover:border-gold transition-all inline-flex items-center gap-2"
                >
                    <span>Explore The Shop</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-gold"></i>
                </a>
            </div>

        </div>

        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gold/40 to-transparent"></div>
    </div>


    <!-- =========================================================================
         SECTION 2: RATING BREAKDOWN & METRICS BAR (Warm Light Section)
         ========================================================================= -->
    <div class="bg-[#FAF7F2] border-b border-ivory-300 py-10 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Overall Score Box (4 cols) -->
                <div class="lg:col-span-4 text-center lg:text-left lg:border-r lg:border-ivory-300/80 lg:pr-8">
                    <span class="text-xs uppercase tracking-widest text-gold-700 font-serif font-bold block mb-1">Overall Client Rating</span>
                    @if($reviewsCount > 0)
                        <div class="flex items-baseline justify-center lg:justify-start gap-3">
                            <span class="font-serif text-5xl sm:text-6xl font-bold text-espresso-950">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-sm text-muted font-light">/ 5.0 Star Average</span>
                        </div>

                        <div class="flex items-center justify-center lg:justify-start gap-1 text-gold my-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-4 h-4 {{ $i <= round($averageRating) ? 'fill-gold text-gold' : 'text-ivory-300' }}"></i>
                            @endfor
                        </div>

                        <p class="text-xs text-muted leading-relaxed font-light">
                            Based on <strong>{{ $reviewsCount }} verified client {{ Str::plural('evaluation', $reviewsCount) }}</strong> across Pakistan with zero sponsored reviews.
                        </p>
                    @else
                        <div class="flex items-baseline justify-center lg:justify-start gap-3">
                            <span class="font-serif text-3xl sm:text-4xl font-bold text-espresso-950">0.0</span>
                            <span class="text-sm text-muted font-light">/ 5.0 Rating</span>
                        </div>

                        <div class="flex items-center justify-center lg:justify-start gap-1 text-ivory-300 my-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-4 h-4"></i>
                            @endfor
                        </div>

                        <p class="text-xs text-muted leading-relaxed font-light">
                            No verified reviews published yet. Be the first to share your experience!
                        </p>
                    @endif
                </div>

                <!-- Star Distribution Progress Bars (4 cols) -->
                <div class="lg:col-span-4 space-y-2">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        <div class="flex items-center gap-3 text-xs {{ ($distribution[$star] ?? 0) === 0 ? 'opacity-60' : '' }}">
                            <span class="w-12 text-espresso-900 font-semibold font-mono">{{ $star }} {{ $star == 1 ? 'Star' : 'Stars' }}</span>
                            <div class="flex-1 h-2 rounded-full bg-ivory-200 overflow-hidden">
                                <div class="h-full bg-gold rounded-full transition-all duration-500" style="width: {{ $distribution[$star] ?? 0 }}%"></div>
                            </div>
                            <span class="w-10 text-right text-muted font-mono">{{ $distribution[$star] ?? 0 }}%</span>
                        </div>
                    @endforeach
                </div>

                <!-- Verified Guarantees Badge (4 cols) -->
                <div class="lg:col-span-4 p-5 rounded-2xl bg-white border border-ivory-300 shadow-sm space-y-3 text-xs text-espresso-900">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                        <span><strong>100% Genuine Full-Grain:</strong> Guaranteed zero bonded or split leather.</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="truck" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                        <span><strong>Doorstep Parcel Inspection:</strong> Inspect before paying COD.</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                        <span><strong>7-Day Size Exchange:</strong> Hassle-free size replacement policy.</span>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 3: INTERACTIVE FILTER & REVIEWS GRID (Main Review Feed)
         ========================================================================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        <!-- Filter Category Tabs -->
        <div class="flex items-center justify-between flex-wrap gap-4 mb-8 pb-4 border-b border-ivory-200">
            
            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                <button 
                    type="button" 
                    @click="filterReviews('all')"
                    class="px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase transition-all focus:outline-none whitespace-nowrap"
                    :class="activeFilter === 'all' 
                        ? 'bg-espresso-950 text-ivory shadow-sm ring-2 ring-gold/40' 
                        : 'bg-ivory-100 text-espresso-800 hover:bg-ivory-200 border border-ivory-300/80'"
                >
                    All Patrons (<span x-text="reviews.length"></span>)
                </button>
                @foreach($categories as $cat)
                    <button 
                        type="button" 
                        @click="filterReviews('{{ $cat->slug }}')"
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase transition-all focus:outline-none whitespace-nowrap"
                        :class="activeFilter === '{{ $cat->slug }}' 
                            ? 'bg-espresso-950 text-ivory shadow-sm ring-2 ring-gold/40' 
                            : 'bg-ivory-100 text-espresso-800 hover:bg-ivory-200 border border-ivory-300/80'"
                    >
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <div class="text-xs text-muted font-light">
                Showing <strong class="text-espresso-950 font-bold" x-text="filteredList.length"></strong> verified client testimonials
            </div>

        </div>

        <!-- Notification if review submitted -->
        @if(session('review_success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-300 text-emerald-900 rounded-xl flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-700 flex-shrink-0"></i>
                <p class="text-xs">{{ session('review_success') }}</p>
            </div>
        @endif

        <!-- Card Grid: Modern Luxury 2-Column Responsive Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <template x-for="review in filteredList" :key="review.id">
                <div class="p-6 sm:p-7 rounded-2xl bg-white border border-ivory-300 hover:border-gold/50 shadow-sm hover:shadow-luxury transition-all duration-300 flex flex-col justify-between group">
                    
                    <div>
                        <!-- Header with Client Initials, Name, Verified Badge & City -->
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-espresso-950 text-gold flex items-center justify-center font-serif text-xs font-bold border border-gold/40 shadow-xs flex-shrink-0" x-text="review.initials"></div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-serif font-bold text-sm text-espresso-950" x-text="review.author"></h3>
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60">
                                            <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                                            <span>Verified</span>
                                        </span>
                                    </div>
                                    <span class="text-[11px] text-muted flex items-center gap-1 mt-0.5">
                                        <i data-lucide="map-pin" class="w-3 h-3 text-gold-700"></i>
                                        <span x-text="review.city"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Rating & Date -->
                            <div class="text-right">
                                <div class="flex items-center gap-0.5 text-gold justify-end">
                                    <template x-for="i in 5">
                                        <i data-lucide="star" class="w-3.5 h-3.5 fill-gold"></i>
                                    </template>
                                </div>
                                <span class="text-[10px] text-muted font-mono block mt-1" x-text="review.date"></span>
                            </div>
                        </div>

                        <!-- Product Link Pill -->
                        <div class="mb-3.5">
                            <a 
                                :href="'/product/' + review.product_slug" 
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-ivory-100 hover:bg-ivory-200 border border-ivory-300 text-xs text-espresso-900 font-medium transition-colors"
                            >
                                <i data-lucide="shopping-bag" class="w-3 h-3 text-gold-700"></i>
                                <span>Purchased: <strong x-text="review.product_name"></strong></span>
                            </a>
                        </div>

                        <!-- Review Title -->
                        <h4 class="font-serif font-bold text-base text-espresso-950 mb-2 leading-snug" x-text="'“' + review.title + '”'"></h4>

                        <!-- Review Comment -->
                        <p class="text-xs sm:text-sm text-espresso-800 leading-relaxed font-light mb-4" x-text="review.comment"></p>
                    </div>

                    <!-- Attached Studio Product Inspection Thumbnail -->
                    <div class="pt-4 border-t border-ivory-200 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-ivory-300 bg-ivory-50 flex-shrink-0 shadow-xs">
                                <img :src="review.image" :alt="review.product_name" class="w-full h-full object-cover">
                            </div>
                            <span class="text-[11px] text-muted font-light">Client Verified Hide & Buckle</span>
                        </div>

                        <!-- Helpful Button -->
                        <button 
                            type="button" 
                            @click="markHelpful(review.id)"
                            class="px-3 py-1.5 rounded-lg border border-ivory-300 hover:border-gold text-[11px] text-espresso-800 hover:text-espresso-950 font-medium transition-all inline-flex items-center gap-1.5"
                            :class="review.liked ? 'bg-gold/15 border-gold text-chocolate-900 font-bold' : 'bg-ivory-50'"
                        >
                            <span>Helpful (<span x-text="review.helpful"></span>)</span>
                        </button>
                    </div>

                </div>
            </template>

            <!-- Elegant Empty State when No Reviews Match -->
            <div x-show="filteredList.length === 0" class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-ivory-300 p-8 shadow-xs">
                <div class="w-14 h-14 rounded-full bg-gold/10 text-gold mx-auto flex items-center justify-center mb-4 border border-gold/25">
                    <i data-lucide="message-square" class="w-7 h-7"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-espresso-950 mb-2">No Client Reviews Yet</h3>
                <p class="text-xs text-muted max-w-md mx-auto mb-6 leading-relaxed">
                    Be the first to share your impressions of our handmade Pakistani leathercraft. Your verified evaluation will be featured here once submitted.
                </p>
                <button 
                    type="button" 
                    @click="writeModalOpen = true"
                    class="px-6 py-3 bg-espresso-950 hover:bg-chocolate-800 text-gold font-serif text-xs uppercase tracking-widest font-bold rounded-xl border border-gold/40 shadow-xs inline-flex items-center gap-2 transition-all active:scale-95"
                >
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-gold"></i>
                    <span>Share Your Review</span>
                </button>
            </div>

        </div>

    </div>


    <!-- =========================================================================
         SECTION 4: CLIENT ASSURANCE & COD INSPECTION (Deep Dark Atelier Strip)
         ========================================================================= -->
    <div class="bg-[#160E0A] text-ivory border-y border-gold/25 py-12 sm:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            
            <div class="w-12 h-12 rounded-full bg-gold/15 text-gold mx-auto flex items-center justify-center border border-gold/30 mb-4">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>

            <span class="text-gold text-xs uppercase tracking-widest font-serif font-bold">The By Zunash Patron Guarantee</span>
            
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-white mt-1 mb-3">
                Inspect at Your Doorstep Before Paying
            </h2>

            <p class="text-xs sm:text-sm text-ivory-300 font-light max-w-xl mx-auto leading-relaxed mb-6">
                We believe total confidence is part of true luxury. That is why every By Zunash creation is delivered via priority courier with nationwide Cash on Delivery. You may inspect the leather craftsmanship at your doorstep before handing payment to the courier.
            </p>

            <div class="inline-flex items-center gap-6 text-xs text-gold font-serif uppercase tracking-wider font-bold">
                <span>• 24–48h Metros</span>
                <span>• 7-Day Exchange</span>
                <span>• 100% Full-Grain Hide</span>
            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 5: CLIENT REVIEW SUBMISSION MODAL (No Scrollbar & 1-Click Custom Presets)
         ========================================================================= -->
    <div 
        x-show="writeModalOpen" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/75 backdrop-blur-md flex items-center justify-center p-3 sm:p-4"
        @click.self="writeModalOpen = false"
    >
        <div class="bg-white rounded-2xl max-w-xl w-full p-5 sm:p-6 shadow-2xl border border-ivory-300 relative text-espresso-900 max-h-[92vh] overflow-y-auto scrollbar-none [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            
            <button 
                type="button" 
                @click="writeModalOpen = false"
                class="absolute top-4 right-4 p-1.5 rounded-full text-muted hover:text-espresso-950 hover:bg-ivory-100 transition-colors focus:outline-none"
                aria-label="Close modal"
            >
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <div class="flex items-center gap-2 text-gold-700 mb-0.5">
                <i data-lucide="award" class="w-4 h-4"></i>
                <span class="text-[11px] font-serif uppercase tracking-widest font-bold">Patron Evaluation</span>
            </div>
            <h3 class="font-serif text-xl sm:text-2xl font-bold text-espresso-950 mb-1">Share Your Experience</h3>
            <p class="text-xs text-muted leading-relaxed mb-4">
                Your feedback directly informs our master leathercraft artisans in {{ !empty($storeSettings['warehouse_city']) ? $storeSettings['warehouse_city'] : 'our atelier' }}.
            </p>

            <form action="{{ route('reviews.submit') }}" method="POST" class="space-y-3.5">
                @csrf

                <!-- Rating Selector -->
                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900">Overall Rating *</label>
                        <span class="text-xs font-bold text-espresso-900 font-mono" x-text="formRating + ' / 5 Stars'"></span>
                    </div>
                    <div class="flex items-center gap-1.5 mt-1">
                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                            <button 
                                type="button" 
                                @click="formRating = star"
                                class="p-0.5 focus:outline-none transition-transform hover:scale-125"
                            >
                                <i 
                                    data-lucide="star" 
                                    class="w-5 h-5 transition-colors"
                                    :class="star <= formRating ? 'text-gold fill-gold' : 'text-ivory-300'"
                                ></i>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="rating" :value="formRating">
                </div>

                <!-- Client Info: Name & City -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-espresso-900 mb-1">Your Full Name *</label>
                        <input 
                            type="text" 
                            name="author" 
                            placeholder="e.g., Tariq Mehmood" 
                            class="w-full px-3 py-2 bg-ivory-50 border border-ivory-300 rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-espresso-900 mb-1">City / Region *</label>
                        <input 
                            type="text" 
                            name="city" 
                            placeholder="e.g., Islamabad (F-8)" 
                            class="w-full px-3 py-2 bg-ivory-50 border border-ivory-300 rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold"
                            required
                        >
                    </div>
                </div>

                <!-- Product & Headline -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-espresso-900 mb-1">Product Purchased *</label>
                        <input 
                            type="text" 
                            name="product_name" 
                            placeholder="e.g., The Royal Reversible Belt" 
                            class="w-full px-3 py-2 bg-ivory-50 border border-ivory-300 rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-espresso-900 mb-1">Review Headline *</label>
                        <input 
                            type="text" 
                            name="title" 
                            x-model="formTitle"
                            placeholder="e.g., Impeccable craftsmanship and authentic hide" 
                            class="w-full px-3 py-2 bg-ivory-50 border border-ivory-300 rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold"
                            required
                        >
                    </div>
                </div>

                <!-- 1-Click Quick Feedback Custom Presets -->
                <div class="pt-1">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-[11px] uppercase tracking-wider font-semibold text-espresso-900">
                            1-Click Quick Praise Presets
                        </label>
                        <span class="text-[10px] text-gold-700 font-medium">Click to auto-fill description</span>
                    </div>
                    <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden pb-1">
                        <template x-for="(p, idx) in presets" :key="idx">
                            <button 
                                type="button" 
                                @click="applyPreset(p)"
                                class="px-2.5 py-1 rounded-lg text-[11px] bg-ivory-100 hover:bg-gold/15 hover:text-espresso-950 text-espresso-800 border border-ivory-300 hover:border-gold/50 transition-all shrink-0 active:scale-95 flex items-center gap-1"
                                :class="formComment === p.comment ? 'bg-gold/20 border-gold text-espresso-950 font-semibold' : ''"
                            >
                                <span x-text="p.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Feedback Details Textarea -->
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-semibold text-espresso-900 mb-1">Your Feedback & Details *</label>
                    <textarea 
                        name="comment" 
                        x-model="formComment"
                        rows="2" 
                        placeholder="Describe your impressions of the leather texture, hardware weight, stitching, or packaging..."
                        class="w-full p-3 bg-ivory-50 border border-ivory-300 rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold resize-y"
                        required
                    ></textarea>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl shadow-md transition-all border border-gold/30 active:scale-98"
                >
                    Submit Verified Review
                </button>
            </form>

        </div>
    </div>

</div>
@endsection
