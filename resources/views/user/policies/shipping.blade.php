@extends('user.layouts.app')

@section('title', 'Shipping & Nationwide Delivery Policy | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'Information regarding delivery times, TCS/Leopards courier partners, and nationwide Cash on Delivery coverage across Pakistan.')
@section('meta_keywords', 'by zunash shipping, cash on delivery delivery time pakistan, courier delivery karachi lahore islamabad, tcs leopards delivery')
@section('canonical', route('policy.shipping'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "@id": "{{ route('policy.shipping') }}/#breadcrumb",
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
            "name": "Client Care",
            "item": "{{ route('contact') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "Shipping Policy",
            "item": "{{ route('policy.shipping') }}"
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-[#FAF8F5] min-h-screen">

    <!-- Hero Section (Dramatic Dark Atelier Aesthetic) -->
    <section class="relative bg-espresso-950 text-ivory py-16 lg:py-24 overflow-hidden border-b border-gold/20">
        <!-- Ambient Luxury Radial Glow -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-gold/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-chocolate-700/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#C5A16B_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- Atelier Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gold/10 border border-gold/30 text-gold text-xs uppercase tracking-widest font-semibold mb-5 shadow-xs">
                <i data-lucide="truck" class="w-3.5 h-3.5 text-gold flex-shrink-0"></i>
                <span>Nationwide Priority Logistics</span>
            </div>

            <!-- Page Title -->
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white mb-4">
                Shipping & Delivery Policy
            </h1>
            <p class="text-xs sm:text-sm text-ivory-300/80 max-w-2xl mx-auto font-light leading-relaxed mb-8">
                Every leather piece is hand-inspected, wrapped in protective tissue, sealed in our signature presentation box, and dispatched across 150+ Pakistani cities.
            </p>

            <!-- Policy Navigation Pill Tabs (Smooth Hub Navigation) -->
            <div class="flex items-center justify-center gap-2.5 sm:gap-3 flex-wrap text-xs">
                <a 
                    href="{{ route('policy.privacy') }}" 
                    class="px-5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <i data-lucide="lock" class="w-4 h-4 flex-shrink-0 text-gold"></i>
                    <span>Privacy Policy</span>
                </a>
                <a 
                    href="{{ route('policy.shipping') }}" 
                    class="px-5 py-2.5 rounded-full bg-gold text-espresso-950 font-bold shadow-gold-glow flex items-center gap-2 transition-all active:scale-95"
                >
                    <i data-lucide="truck" class="w-4 h-4 flex-shrink-0 text-espresso-950"></i>
                    <span>Shipping & Delivery</span>
                </a>
                <a 
                    href="{{ route('policy.returns') }}" 
                    class="px-5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <i data-lucide="rotate-ccw" class="w-4 h-4 flex-shrink-0 text-gold"></i>
                    <span>Returns & 7-Day Exchange</span>
                </a>
                <a 
                    href="{{ route('faq') }}" 
                    class="px-5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <i data-lucide="help-circle" class="w-4 h-4 flex-shrink-0 text-gold"></i>
                    <span>Client FAQ</span>
                </a>
            </div>

        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-18">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left: Elevated Policy Content Cards (8 Cols) -->
            <div class="lg:col-span-8 space-y-6 sm:space-y-8">
                
                <!-- Complimentary Shipping Banner -->
                <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3.5 shadow-2xs">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center flex-shrink-0 mt-0.5 border border-emerald-300">
                        <i data-lucide="truck" class="w-4 h-4 text-emerald-700"></i>
                    </div>
                    <div>
                        <h4 class="font-serif text-sm font-bold text-emerald-950">Free Priority Delivery on Orders PKR 6,000+</h4>
                        <p class="text-xs text-emerald-800 font-light leading-relaxed mt-0.5">
                            Complimentary nationwide air courier delivery is automatically unlocked on all commissions exceeding PKR 6,000. Flat rate of PKR 250 applies for smaller orders.
                        </p>
                    </div>
                </div>

                <!-- Section 1: Processing & Dispatch -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            01
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Order Processing & Workshop Dispatch
                            </h2>
                            <span class="text-[11px] text-muted font-light">Rapid handling with artisan quality checks</span>
                        </div>
                    </div>

                    <div class="text-xs sm:text-sm text-espresso-800 space-y-3 font-light leading-relaxed">
                        <p>
                            Prior to dispatch, our atelier masters perform a comprehensive tactile review on your leather goods: verifying stitching tension, edge burnish smoothness, and hardware functionality.
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
                            <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80">
                                <span class="font-serif text-xs font-bold text-espresso-950 block mb-1">Same-Day Courier Handover</span>
                                <p class="text-[11px] text-muted leading-relaxed font-light">
                                    Orders placed before <strong>2:00 PM (Mon – Sat)</strong> are processed and handed over to courier hubs on the same day.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80">
                                <span class="font-serif text-xs font-bold text-espresso-950 block mb-1">Weekend & Gazetted Holidays</span>
                                <p class="text-[11px] text-muted leading-relaxed font-light">
                                    Orders placed on Sundays or official national holidays are queued for priority dispatch on the immediate next business day.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Section 2: Regional Delivery Timelines -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            02
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Estimated Delivery Windows Across Pakistan
                            </h2>
                            <span class="text-[11px] text-muted font-light">Dedicated express cargo with tracking codes</span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-espresso-800 font-light mb-4 leading-relaxed">
                        We partner with certified tier-one couriers including <strong>TCS Express, Leopards Courier, and Trax</strong> to guarantee safe doorstep arrivals:
                    </p>

                    <div class="space-y-2.5">
                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 flex items-center justify-between gap-3 flex-wrap">
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Major Metropolitan Hubs</h4>
                                <p class="text-[11px] text-muted font-light">Lahore, Karachi, Islamabad, Rawalpindi</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-white border border-ivory-300 text-xs font-bold text-gold-700 shadow-2xs font-mono">
                                2 – 3 Business Days
                            </span>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 flex items-center justify-between gap-3 flex-wrap">
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Industrial & Regional Cities</h4>
                                <p class="text-[11px] text-muted font-light">Faisalabad, Multan, Peshawar, Sialkot, Gujranwala, Hyderabad, Quetta</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-white border border-ivory-300 text-xs font-bold text-gold-700 shadow-2xs font-mono">
                                2 – 4 Business Days
                            </span>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 flex items-center justify-between gap-3 flex-wrap">
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Towns, Tehsils & Cantonments</h4>
                                <p class="text-[11px] text-muted font-light">All secondary districts, rural tehsils, and remote residential zones</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-white border border-ivory-300 text-xs font-bold text-espresso-800 shadow-2xs font-mono">
                                3 – 5 Business Days
                            </span>
                        </div>
                    </div>
                </article>

                <!-- Section 3: Doorstep Cash on Delivery Protocols -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            03
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Doorstep Cash on Delivery (COD) Protocols
                            </h2>
                            <span class="text-[11px] text-muted font-light">Transparent, risk-free handover</span>
                        </div>
                    </div>

                    <div class="text-xs sm:text-sm text-espresso-800 space-y-3.5 font-light leading-relaxed">
                        <p>
                            To ensure total peace of mind for our patrons across Pakistan, all orders qualify for Cash on Delivery without requiring advance credit card deposits or processing fees.
                        </p>
                        
                        <ul class="space-y-2 text-xs">
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                                <span>Please have the exact cash amount ready in Pakistani Rupees (PKR) upon rider arrival.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                                <span>Our concierge contacts every client via phone call or WhatsApp to confirm delivery coordinates before dispatch.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                                <span>All parcels travel inside tamper-evident security bags. Do not accept any bag with damaged external seals.</span>
                            </li>
                        </ul>
                    </div>
                </article>

            </div>

            <!-- Right: Sticky Client Concierge & Trust Hub (4 Cols) -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-6">
                
                <!-- Concierge Direct Card (Dark Accent) -->
                <div class="bg-espresso-950 text-ivory rounded-3xl p-6 sm:p-7 border border-gold/30 shadow-xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-gold/10 rounded-full blur-xl pointer-events-none"></div>

                    <div class="flex items-center justify-between pb-3.5 border-b border-ivory-300/20 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[11px] font-mono text-gold uppercase tracking-wider">Dispatch Helpline</span>
                        </div>
                        <span class="text-[10px] text-ivory-300/70">Mon – Sat (10am–8pm)</span>
                    </div>

                    <h3 class="font-serif text-lg font-bold text-white mb-2">
                        Need Urgently Tracked Dispatch?
                    </h3>
                    <p class="text-xs text-ivory-300/80 leading-relaxed font-light mb-6">
                        Require express gift packaging, flight cargo, or immediate tracking updates? Speak directly with our dispatch manager.
                    </p>

                    <div class="space-y-3">
                        <a 
                            href="https://wa.me/923001234567?text=Assalam%20o%20Alaikum%2C%20I%20need%20assistance%20regarding%20my%20courier%20delivery%20tracking" 
                            target="_blank" 
                            class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-xs uppercase tracking-widest font-bold rounded-xl text-center block transition-all shadow-md flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                            <span>WhatsApp Dispatch Team</span>
                        </a>

                        <a 
                            href="tel:+923001234567" 
                            class="w-full py-3 px-4 bg-white/10 hover:bg-white/15 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl text-center block transition-all border border-ivory-300/30 flex items-center justify-center gap-2"
                        >
                            <i data-lucide="phone" class="w-4 h-4 text-gold"></i>
                            <span>+92 (300) 123-4567</span>
                        </a>
                    </div>
                </div>

                <!-- Courier Partners Box -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-ivory-200/90 shadow-sm space-y-4">
                    <h4 class="font-serif text-xs uppercase tracking-wider font-bold text-espresso-950 pb-2 border-b border-ivory-200">
                        Official Logistics Partners
                    </h4>
                    
                    <div class="space-y-3 text-xs text-espresso-900 font-light">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#FAF7F2] border border-ivory-200">
                            <span class="font-bold text-espresso-950">TCS Express</span>
                            <span class="text-[10px] text-emerald-700 font-semibold">Priority Air Courier</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#FAF7F2] border border-ivory-200">
                            <span class="font-bold text-espresso-950">Leopards Courier</span>
                            <span class="text-[10px] text-emerald-700 font-semibold">Overnight Urban Hubs</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#FAF7F2] border border-ivory-200">
                            <span class="font-bold text-espresso-950">Trax Logistics</span>
                            <span class="text-[10px] text-emerald-700 font-semibold">Doorstep COD Network</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
