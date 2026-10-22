@extends('user.layouts.app')

@section('title', 'Privacy & Data Protection Policy | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'How By Zunash protects client personal data, telephone numbers, and delivery addresses in Pakistan under strict confidentiality.')
@section('meta_keywords', 'by zunash privacy policy, data protection pakistan, customer confidentiality, leather atelier privacy')
@section('canonical', route('policy.privacy'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "@id": "{{ route('policy.privacy') }}/#breadcrumb",
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
            "name": "Privacy Policy",
            "item": "{{ route('policy.privacy') }}"
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
                <i data-lucide="shield" class="w-3.5 h-3.5 text-gold flex-shrink-0"></i>
                <span>Atelier Client Care & Confidentiality</span>
            </div>

            <!-- Page Title -->
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white mb-4">
                Privacy & Data Protection
            </h1>
            <p class="text-xs sm:text-sm text-ivory-300/80 max-w-2xl mx-auto font-light leading-relaxed mb-8">
                We hold our patrons' personal confidentiality to the same exacting standards of integrity and devotion that define our handcrafted leathergoods across Pakistan.
            </p>

            <!-- Policy Navigation Pill Tabs (Smooth Hub Navigation) -->
            <div class="flex items-center justify-center gap-2.5 sm:gap-3 flex-wrap text-xs">
                <a 
                    href="{{ route('policy.privacy') }}" 
                    class="px-5 py-2.5 rounded-full bg-gold text-espresso-950 font-bold shadow-gold-glow flex items-center gap-2 transition-all active:scale-95"
                >
                    <i data-lucide="lock" class="w-4 h-4 flex-shrink-0 text-espresso-950"></i>
                    <span>Privacy Policy</span>
                </a>
                <a 
                    href="{{ route('policy.shipping') }}" 
                    class="px-5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <i data-lucide="truck" class="w-4 h-4 flex-shrink-0 text-gold"></i>
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
                
                <!-- Notice Banner -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gold/10 border border-gold/30 flex items-start gap-3.5 shadow-2xs">
                    <div class="w-8 h-8 rounded-full bg-gold/20 text-gold-800 flex items-center justify-center flex-shrink-0 mt-0.5 border border-gold/40">
                        <i data-lucide="shield-check" class="w-4 h-4 text-gold-800"></i>
                    </div>
                    <div>
                        <h4 class="font-serif text-sm font-bold text-espresso-950">Strict Zero-Monetization Pledge</h4>
                        <p class="text-xs text-espresso-800 font-light leading-relaxed mt-0.5">
                            By Zunash <strong>never sells, leases, or trades</strong> patron telephone numbers, postal addresses, or order archives to any commercial data broker or external telemarketer.
                        </p>
                    </div>
                </div>

                <!-- Section 1: Commitment -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            01
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Commitment to Client Confidentiality
                            </h2>
                            <span class="text-[11px] text-muted font-light">Honoring discretion for every patron</span>
                        </div>
                    </div>

                    <div class="text-xs sm:text-sm text-espresso-800 space-y-3 font-light leading-relaxed">
                        <p>
                            At By Zunash, we uphold the personal confidentiality of our patrons with utmost discretion. Whether placing a bespoke commission for an executive briefcase or ordering a handcrafted reversible leather belt, we treat your contact coordinates with rigorous institutional care.
                        </p>
                        <p>
                            All records are processed solely for order fulfillment, dispatch verification via phone/WhatsApp, and warranty authentication across Pakistan.
                        </p>
                    </div>
                </article>

                <!-- Section 2: Information We Collect -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            02
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Information We Collect
                            </h2>
                            <span class="text-[11px] text-muted font-light">Essential data gathered solely for delivery</span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-espresso-800 font-light mb-4 leading-relaxed">
                        When commissioning an item through our digital boutique or contacting our concierge desk, we collect only the mandatory coordinates required to ensure safe delivery:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        
                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80 flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="user" class="w-4 h-4 text-gold-700"></i>
                            </div>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Identity & Name</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">Full patron name for personalized packaging and courier consignment slips.</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80 flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="phone" class="w-4 h-4 text-gold-700"></i>
                            </div>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Mobile / WhatsApp</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">For pre-dispatch address verification calls and courier rider coordination.</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80 flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="map-pin" class="w-4 h-4 text-gold-700"></i>
                            </div>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Delivery Destination</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">Complete street address, sector/phase, city, and optional postal code.</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80 flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="mail" class="w-4 h-4 text-gold-700"></i>
                            </div>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Email (Optional)</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">Used exclusively to transmit electronic PDF tax receipts and tracking codes.</p>
                            </div>
                        </div>

                    </div>
                </article>

                <!-- Section 3: Utilization & Security -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            03
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Data Security & Authorized Courier Access
                            </h2>
                            <span class="text-[11px] text-muted font-light">End-to-end encrypted protocol</span>
                        </div>
                    </div>

                    <div class="text-xs sm:text-sm text-espresso-800 space-y-3 font-light leading-relaxed">
                        <p>
                            Our digital boutique operates with industry-standard 256-bit SSL encryption. Delivery coordinates are shared strictly on a need-to-know basis with registered national logistics partners (such as TCS Express, Leopards Courier, and Trax Logistics) solely to complete physical parcel delivery.
                        </p>
                        <p>
                            We maintain zero payment card data on our servers. For Cash on Delivery, transactions occur physically at your doorstep. For Direct Bank Transfer (IBFT), transactions occur within your personal banking application.
                        </p>
                    </div>

                    <div class="mt-5 pt-4 border-t border-ivory-200 flex items-center justify-between text-[11px] text-muted flex-wrap gap-2">
                        <span>• Data Retention: Maintained only for active warranty & exchange validity</span>
                        <span class="text-emerald-700 font-semibold flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>256-Bit SSL Encryption Active</span>
                        </span>
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
                            <span class="text-[11px] font-mono text-gold uppercase tracking-wider">Concierge Active</span>
                        </div>
                        <span class="text-[10px] text-ivory-300/70">PKT (UTC+5)</span>
                    </div>

                    <h3 class="font-serif text-lg font-bold text-white mb-2">
                        Have Questions Regarding Your Data?
                    </h3>
                    <p class="text-xs text-ivory-300/80 leading-relaxed font-light mb-6">
                        Contact our dedicated privacy officer in Lahore directly for data modification or deletion requests.
                    </p>

                    <div class="space-y-3">
                        <a 
                            href="https://wa.me/923001234567?text=Assalam%20o%20Alaikum%2C%20I%20have%20a%20query%20regarding%20my%20privacy%20and%20order%20data" 
                            target="_blank" 
                            class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-xs uppercase tracking-widest font-bold rounded-xl text-center block transition-all shadow-md flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                            <span>WhatsApp Concierge</span>
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

                <!-- Atelier Trust Badges Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-ivory-200/90 shadow-sm space-y-4">
                    <h4 class="font-serif text-xs uppercase tracking-wider font-bold text-espresso-950 pb-2 border-b border-ivory-200">
                        Atelier Integrity Standards
                    </h4>
                    
                    <ul class="space-y-3 text-xs text-espresso-900 font-light">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="shield" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span>Zero Third-Party Marketing Distribution</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="lock" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span>No Credit Card Numbers Ever Recorded</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="package" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                            <span>Dispatched in Tamper-Proof Wax Sealed Parcels</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
