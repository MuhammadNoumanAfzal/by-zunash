@extends('user.layouts.app')

@section('title', 'Frequently Asked Questions & Leather Care | By Zunash Pakistan')
@section('meta_description', 'Find clear answers regarding belt sizing, nationwide Cash on Delivery, genuine full-grain leather care, and shipping across Pakistan.')
@section('meta_keywords', 'by zunash faqs, leather belt sizing pakistan, leather care tips, cash on delivery pakistan leather, exchange policy by zunash')
@section('canonical', route('faq'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "FAQPage",
            "@id": "{{ route('faq') }}/#faq",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "Is Cash on Delivery (COD) available across all of Pakistan?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. We provide nationwide Cash on Delivery service covering all major urban hubs (Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, Quetta, Sialkot) as well as over 250 regional towns. You pay in cash directly to the courier rider upon delivery."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I pay via direct online bank transfer (IBFT)?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. Simply select 'Direct Bank Transfer' during checkout. Our corporate account details (Meezan Bank & HBL) will be displayed. Please share your payment receipt via WhatsApp along with your order ID to expedite dispatch."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Are prices inclusive of applicable taxes?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "All prices listed in PKR on By Zunash are all-inclusive product prices. Shipping is calculated transparently: orders of PKR 6,000 and above qualify for complimentary courier delivery."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How do I determine my correct belt size?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "The golden rule for leather belts: order exactly 2 inches larger than your tailored trouser waist size. For example, if you wear a size 34 pant, order a size 36 belt. This allows the prong to sit comfortably in the middle hole."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can the belts be shortened at home?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Our dress and casual belts feature a discreet screw-rivet buckle mount. With a simple flathead screwdriver, you can unscrew the buckle, trim the leather strap cleanly from the top end, punch a new hole, and re-tighten."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How many days does courier delivery take across Pakistan?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Orders placed before 2:00 PM are processed and handed over to courier dispatch within 24 hours. Major metropolitan cities (Lahore, Karachi, Islamabad, Rawalpindi) typically receive deliveries in 2–3 business days. Regional destinations require 3–5 business days."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Can I inspect the parcel before paying the courier rider?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Per standard courier operational regulations across Pakistan (TCS, Leopard, Trax), riders cannot allow flyers to be opened prior to payment handover. However, we back every shipment with an effortless 7-day direct exchange policy."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How do I maintain and condition pure full-grain leather?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Full-grain leather is a natural biological material that breathes. Keep it away from prolonged direct harsh sunlight or high humidity. If it gets wet from rain, pat gently with a dry microfibre towel and allow to air-dry naturally. Once every six months, apply a pea-sized dab of neutral beeswax leather balm."
                    }
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
        activeCategory: 'ordering', 
        openedIndex: 1,
        toggle(idx) {
            this.openedIndex = this.openedIndex === idx ? null : idx;
        }
    }" 
    class="bg-[#FAF8F5] min-h-screen"
>

    <!-- Hero Section (Dramatic Dark Atelier Aesthetic) -->
    <section class="relative bg-espresso-950 text-ivory py-16 lg:py-24 overflow-hidden border-b border-gold/20">
        <!-- Ambient Luxury Radial Glow -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-gold/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-chocolate-700/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#C5A16B_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- Atelier Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gold/10 border border-gold/30 text-gold text-xs uppercase tracking-widest font-semibold mb-5 shadow-xs">
                <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                <span>Client Knowledge Base & Assistance</span>
            </div>

            <!-- Page Title -->
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white mb-4">
                Frequently Asked Questions
            </h1>
            <p class="text-xs sm:text-sm text-ivory-300/80 max-w-2xl mx-auto font-light leading-relaxed mb-8">
                Clear guidance regarding waist sizing, artisan leather sourcing, nationwide courier dispatch, and doorstep handover in Pakistan.
            </p>

            <!-- Policy Navigation Pill Tabs (Smooth Hub Navigation) -->
            <div class="flex items-center justify-center gap-2 sm:gap-3 flex-wrap text-xs">
                <a 
                    href="{{ route('policy.privacy') }}" 
                    class="px-4.5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span>Privacy Policy</span>
                </a>
                <a 
                    href="{{ route('policy.shipping') }}" 
                    class="px-4.5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>Shipping & Delivery</span>
                </a>
                <a 
                    href="{{ route('policy.returns') }}" 
                    class="px-4.5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M3 21v-5h5"></path></svg>
                    <span>Returns & 7-Day Exchange</span>
                </a>
                <a 
                    href="{{ route('faq') }}" 
                    class="px-4.5 py-2.5 rounded-full bg-gold text-espresso-950 font-bold shadow-gold-glow flex items-center gap-2 transition-all active:scale-95"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>Client FAQ</span>
                </a>
            </div>

        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-18">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left: FAQ Categories & Accordion Cards (8 Cols) -->
            <div class="lg:col-span-8 space-y-6 sm:space-y-8">
                
                <!-- Category Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                    <button 
                        type="button" 
                        @click="activeCategory = 'ordering'; openedIndex = 1;" 
                        class="px-4.5 py-2 rounded-full text-xs uppercase tracking-wider font-semibold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeCategory === 'ordering' ? 'bg-espresso text-gold border border-gold/40 shadow-sm' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold/60'"
                    >
                        Ordering & Payment
                    </button>
                    <button 
                        type="button" 
                        @click="activeCategory = 'sizing'; openedIndex = 4;" 
                        class="px-4.5 py-2 rounded-full text-xs uppercase tracking-wider font-semibold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeCategory === 'sizing' ? 'bg-espresso text-gold border border-gold/40 shadow-sm' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold/60'"
                    >
                        Sizing & Fit
                    </button>
                    <button 
                        type="button" 
                        @click="activeCategory = 'shipping'; openedIndex = 6;" 
                        class="px-4.5 py-2 rounded-full text-xs uppercase tracking-wider font-semibold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeCategory === 'shipping' ? 'bg-espresso text-gold border border-gold/40 shadow-sm' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold/60'"
                    >
                        Shipping & Handover
                    </button>
                    <button 
                        type="button" 
                        @click="activeCategory = 'leather'; openedIndex = 8;" 
                        class="px-4.5 py-2 rounded-full text-xs uppercase tracking-wider font-semibold transition-all cursor-pointer whitespace-nowrap"
                        :class="activeCategory === 'leather' ? 'bg-espresso text-gold border border-gold/40 shadow-sm' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold/60'"
                    >
                        Leather Care & Patina
                    </button>
                </div>

                <!-- Questions Accordion List -->
                <div class="space-y-3.5">
                    
                    <!-- ORDERING & PAYMENT -->
                    <div x-show="activeCategory === 'ordering'" class="space-y-3.5">
                        
                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(1)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">1</span>
                                    <span>Is Cash on Delivery (COD) available across all of Pakistan?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 1" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                Yes. We provide nationwide Cash on Delivery service covering all major urban hubs (Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, Quetta, Sialkot) as well as over 250 regional towns. You pay in cash directly to the courier rider upon delivery without any advance deposit.
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(2)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">2</span>
                                    <span>Can I pay via direct online bank transfer (IBFT)?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 2" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                Yes. Simply select "Direct Bank Transfer" during checkout. Our corporate account details (Meezan Bank Limited) will be displayed along with an instant one-click IBAN copy tool. Please share your payment screenshot via WhatsApp to expedite priority workshop dispatch.
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(3)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">3</span>
                                    <span>Are prices inclusive of applicable taxes?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 3" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                All prices listed in PKR on By Zunash are all-inclusive product prices. Shipping is calculated transparently: orders of PKR 6,000 and above qualify for complimentary courier delivery nationwide.
                            </div>
                        </div>

                    </div>

                    <!-- SIZING & FIT -->
                    <div x-show="activeCategory === 'sizing'" x-cloak class="space-y-3.5">
                        
                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(4)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">1</span>
                                    <span>How do I determine my correct belt size?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 4" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                The golden rule for leather belts: order exactly <strong>2 inches larger than your tailored trouser waist size</strong>. For example, if you wear a size 34 pant, order a size 36 belt. This allows the prong to sit comfortably in the middle hole, providing 2 inches of adjustment in either direction.
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(5)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">2</span>
                                    <span>Can the belts be shortened at home?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 5 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 5" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                Our dress and casual belts feature a discreet screw-rivet buckle mount. With a simple flathead screwdriver, you can unscrew the buckle, trim the leather strap cleanly from the top end, punch a new hole, and re-tighten without damaging the hand-painted tip.
                            </div>
                        </div>

                    </div>

                    <!-- SHIPPING & DELIVERY -->
                    <div x-show="activeCategory === 'shipping'" x-cloak class="space-y-3.5">
                        
                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(6)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">1</span>
                                    <span>How many days does courier delivery take?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 6 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 6" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                Orders placed before 2:00 PM are processed and handed over to courier dispatch within 24 hours. Major metropolitan cities (Lahore, Karachi, Islamabad, Rawalpindi) typically receive deliveries in 2–3 business days. Regional destinations require 3–5 business days.
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(7)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">2</span>
                                    <span>Can I inspect the parcel before paying the courier rider?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 7 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 7" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                Per standard courier operational regulations across Pakistan (TCS, Leopard, Trax), riders cannot allow flyers to be opened prior to payment handover. However, we back every shipment with an effortless 7-day direct exchange policy. If anything does not meet your standard, our concierge replaces it promptly.
                            </div>
                        </div>

                    </div>

                    <!-- LEATHER CARE -->
                    <div x-show="activeCategory === 'leather'" x-cloak class="space-y-3.5">
                        
                        <div class="bg-white rounded-3xl border border-ivory-200/90 overflow-hidden shadow-xs hover:border-gold/30 transition-all">
                            <button 
                                type="button" 
                                @click="toggle(8)" 
                                class="w-full p-5 sm:p-6 text-left flex items-center justify-between font-serif text-sm sm:text-base font-bold text-espresso-950 focus:outline-none cursor-pointer"
                            >
                                <span class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-full bg-gold/15 text-gold-700 text-xs flex items-center justify-center font-sans font-bold flex-shrink-0">1</span>
                                    <span>How do I maintain and condition pure full-grain leather?</span>
                                </span>
                                <svg class="w-4 h-4 text-gold flex-shrink-0 transition-transform duration-300" :class="openedIndex === 8 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div x-show="openedIndex === 8" x-collapse class="px-5 sm:px-6 pb-6 text-xs sm:text-sm text-espresso-800 leading-relaxed font-light border-t border-ivory-100 pt-4 bg-[#FAF7F2]/50">
                                Full-grain leather is a natural biological material that breathes. Keep it away from prolonged direct harsh sunlight or high humidity. If it gets wet from rain, pat gently with a dry microfibre towel and allow to air-dry naturally. Once every six months, apply a pea-sized dab of neutral beeswax leather balm.
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Right: Sticky Client Concierge & Trust Hub (4 Cols) -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-6">
                
                <!-- Concierge Direct Card (Dark Accent) -->
                <div class="bg-espresso-950 text-ivory rounded-3xl p-6 sm:p-7 border border-gold/30 shadow-xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-gold/10 rounded-full blur-xl pointer-events-none"></div>

                    <div class="flex items-center justify-between pb-3.5 border-b border-ivory-300/20 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[11px] font-mono text-gold uppercase tracking-wider">Live Concierge</span>
                        </div>
                        <span class="text-[10px] text-ivory-300/70">PKT (UTC+5)</span>
                    </div>

                    <h3 class="font-serif text-lg font-bold text-white mb-2">
                        Still Have Questions?
                    </h3>
                    <p class="text-xs text-ivory-300/80 leading-relaxed font-light mb-6">
                        Our client concierge desk in Lahore is ready to assist you on WhatsApp with bespoke sizing, custom monogramming, or order verification.
                    </p>

                    <div class="space-y-3">
                        <a 
                            href="https://wa.me/923001234567?text=Assalam%20o%20Alaikum%2C%20I%20have%20a%20question%20regarding%20leather%20sizing%20and%20orders" 
                            target="_blank" 
                            class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-xs uppercase tracking-widest font-bold rounded-xl text-center block transition-all shadow-md flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                            <span>WhatsApp Concierge</span>
                        </a>

                        <a 
                            href="{{ route('contact') }}" 
                            class="w-full py-3 px-4 bg-white/10 hover:bg-white/15 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl text-center block transition-all border border-ivory-300/30 flex items-center justify-center gap-2"
                        >
                            <span>Visit Atelier Contact Desk</span>
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>

                <!-- Atelier Trust Badges Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-ivory-200/90 shadow-sm space-y-4">
                    <h4 class="font-serif text-xs uppercase tracking-wider font-bold text-espresso-950 pb-2 border-b border-ivory-200">
                        Atelier Assurance
                    </h4>
                    
                    <ul class="space-y-3 text-xs text-espresso-900 font-light">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>100% Full-Grain Drum-Dyed Leather</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M3 21v-5h5"></path></svg>
                            <span>7-Day Direct Size & Model Exchange</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>Free Priority Air Delivery on PKR 6,000+</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
