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
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('faq') }}/#breadcrumb",
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
                    "name": "FAQs",
                    "item": "{{ route('faq') }}"
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
        openedIndex: null,
        toggle(idx) {
            this.openedIndex = this.openedIndex === idx ? null : idx;
        }
    }" 
    class="bg-ivory-50 min-h-screen py-12 lg:py-20"
>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Client Knowledge Base</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-espresso-900 mt-2 mb-4">
                Frequently Asked Questions
            </h1>
            <p class="text-sm text-muted max-w-xl mx-auto leading-relaxed">
                Clear answers regarding our leather sourcing, sizing guidelines, nationwide delivery, and payment policies in Pakistan.
            </p>
        </div>

        <!-- FAQ Categories Navigation -->
        <div class="flex items-center justify-center gap-2 sm:gap-3 mb-10 overflow-x-auto pb-2">
            <button 
                type="button" 
                @click="activeCategory = 'ordering'; openedIndex = null;" 
                class="px-5 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-colors focus:outline-none"
                :class="activeCategory === 'ordering' ? 'bg-espresso text-gold border border-gold/40 shadow-xs' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold'"
            >
                Ordering & Payment
            </button>
            <button 
                type="button" 
                @click="activeCategory = 'sizing'; openedIndex = null;" 
                class="px-5 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-colors focus:outline-none"
                :class="activeCategory === 'sizing' ? 'bg-espresso text-gold border border-gold/40 shadow-xs' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold'"
            >
                Sizing & Fit
            </button>
            <button 
                type="button" 
                @click="activeCategory = 'shipping'; openedIndex = null;" 
                class="px-5 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-colors focus:outline-none"
                :class="activeCategory === 'shipping' ? 'bg-espresso text-gold border border-gold/40 shadow-xs' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold'"
            >
                Shipping & Delivery
            </button>
            <button 
                type="button" 
                @click="activeCategory = 'leather'; openedIndex = null;" 
                class="px-5 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-colors focus:outline-none"
                :class="activeCategory === 'leather' ? 'bg-espresso text-gold border border-gold/40 shadow-xs' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold'"
            >
                Leather Care
            </button>
        </div>

        <!-- Accordion Questions Section -->
        <div class="space-y-4">
            
            <!-- ORDERING & PAYMENT -->
            <div x-show="activeCategory === 'ordering'" class="space-y-3">
                
                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(1)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>Is Cash on Delivery (COD) available across all of Pakistan?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 1" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        Yes. We provide nationwide Cash on Delivery service covering all major urban hubs (Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, Quetta, Sialkot) as well as over 250 regional towns. You pay in cash directly to the courier rider upon delivery.
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(2)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>Can I pay via direct online bank transfer (IBFT)?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 2" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        Yes. Simply select "Direct Bank Transfer" during checkout. Our corporate account details (Meezan Bank & HBL) will be displayed. Please share your payment receipt via WhatsApp along with your order ID to expedite dispatch.
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(3)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>Are prices inclusive of applicable taxes?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 3" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        All prices listed in PKR on By Zunash are all-inclusive product prices. Shipping is calculated transparently: orders of PKR 6,000 and above qualify for complimentary courier delivery.
                    </div>
                </div>

            </div>

            <!-- SIZING & FIT -->
            <div x-show="activeCategory === 'sizing'" x-cloak class="space-y-3">
                
                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(4)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>How do I determine my correct belt size?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 4" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        The golden rule for leather belts: order exactly 2 inches larger than your tailored trouser waist size. For example, if you wear a size 34 pant, order a size 36 belt. This allows the prong to sit comfortably in the middle hole.
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(5)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>Can the belts be shortened at home?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 5 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 5" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        Our dress and casual belts feature a discreet screw-rivet buckle mount. With a simple flathead screwdriver, you can unscrew the buckle, trim the leather strap cleanly from the top end, punch a new hole, and re-tighten.
                    </div>
                </div>

            </div>

            <!-- SHIPPING & DELIVERY -->
            <div x-show="activeCategory === 'shipping'" x-cloak class="space-y-3">
                
                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(6)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>How many days does courier delivery take?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 6 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 6" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        Orders placed before 2:00 PM are processed and handed over to courier dispatch within 24 hours. Major metropolitan cities (Lahore, Karachi, Islamabad, Rawalpindi) typically receive deliveries in 2–3 business days. Regional destinations require 3–5 business days.
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(7)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>Can I inspect the parcel before paying the courier rider?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 7 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 7" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        Per standard courier operational regulations across Pakistan (TCS, Leopard, Trax), riders cannot allow flyers to be opened prior to payment handover. However, we back every shipment with an effortless 7-day direct exchange policy. If anything does not meet your standard, our concierge replaces it promptly.
                    </div>
                </div>

            </div>

            <!-- LEATHER CARE -->
            <div x-show="activeCategory === 'leather'" x-cloak class="space-y-3">
                
                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs">
                    <button 
                        type="button" 
                        @click="toggle(8)" 
                        class="w-full p-5 text-left flex items-center justify-between font-serif text-base font-semibold text-espresso-900 focus:outline-none"
                    >
                        <span>How do I maintain and condition pure full-grain leather?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gold-600 transition-transform duration-200" :class="openedIndex === 8 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openedIndex === 8" x-collapse class="px-5 pb-5 text-xs text-muted leading-relaxed border-t border-ivory-200 pt-3">
                        Full-grain leather is a natural biological material that breathes. Keep it away from prolonged direct harsh sunlight or high humidity. If it gets wet from rain, pat gently with a dry microfibre towel and allow to air-dry naturally. Once every six months, apply a pea-sized dab of neutral beeswax leather balm.
                    </div>
                </div>

            </div>

        </div>

        <!-- Still have questions footer card -->
        <div class="mt-14 p-8 bg-white rounded-2xl border border-ivory-300 text-center shadow-xs">
            <h3 class="font-serif text-xl font-bold text-espresso-900 mb-2">Still Have Questions?</h3>
            <p class="text-xs text-muted max-w-md mx-auto mb-6">
                Our client concierge is ready to assist you on WhatsApp or phone with sizing, leather consultations, or order statuses.
            </p>
            <a 
                href="{{ route('contact') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-sm transition-all"
            >
                <span>Contact Client Concierge</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

    </div>
</div>
@endsection
