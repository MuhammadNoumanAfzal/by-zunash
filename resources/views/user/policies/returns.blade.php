@extends('user.layouts.app')

@section('title', 'Returns & 7-Day Exchange Policy | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'Learn about our 7-day direct exchange policy, conditions of return, and dedicated client concierge support across Pakistan.')
@section('meta_keywords', 'by zunash return policy, leather exchange pakistan, 7 days return by zunash, belt size swap lahore karachi')
@section('canonical', route('policy.returns'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "@id": "{{ route('policy.returns') }}/#breadcrumb",
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
            "name": "Returns & Exchanges",
            "item": "{{ route('policy.returns') }}"
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
                <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M3 21v-5h5"></path></svg>
                <span>Client Satisfaction Guarantee</span>
            </div>

            <!-- Page Title -->
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white mb-4">
                Returns & 7-Day Exchange
            </h1>
            <p class="text-xs sm:text-sm text-ivory-300/80 max-w-2xl mx-auto font-light leading-relaxed mb-8">
                We stand unreservedly behind the heirloom quality of every handcrafted leather commission. If your fit, shade, or preference requires adjustment, our concierge makes exchanges seamless.
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
                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>Shipping & Delivery</span>
                </a>
                <a 
                    href="{{ route('policy.returns') }}" 
                    class="px-4.5 py-2.5 rounded-full bg-gold text-espresso-950 font-bold shadow-gold-glow flex items-center gap-2 transition-all active:scale-95"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M3 21v-5h5"></path></svg>
                    <span>Returns & 7-Day Exchange</span>
                </a>
                <a 
                    href="{{ route('faq') }}" 
                    class="px-4.5 py-2.5 rounded-full bg-espresso-900/80 hover:bg-espresso-800 text-ivory-200 border border-ivory-300/20 hover:border-gold/50 flex items-center gap-2 transition-all"
                >
                    <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
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
                
                <!-- Guarantee Highlight Banner -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gold/10 border border-gold/30 flex items-start gap-3.5 shadow-2xs">
                    <div class="w-8 h-8 rounded-full bg-gold/20 text-gold-800 flex items-center justify-center flex-shrink-0 mt-0.5 border border-gold/40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-serif text-sm font-bold text-espresso-950">7-Day Hassle-Free Size & Model Exchange</h4>
                        <p class="text-xs text-espresso-800 font-light leading-relaxed mt-0.5">
                            Order with absolute confidence. If your belt size requires swapping or you prefer another leather tone, notify our concierge within 7 calendar days of receipt.
                        </p>
                    </div>
                </div>

                <!-- Section 1: 7-Day Window -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            01
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Direct Exchange Window
                            </h2>
                            <span class="text-[11px] text-muted font-light">7 calendar days from doorstep delivery</span>
                        </div>
                    </div>

                    <div class="text-xs sm:text-sm text-espresso-800 space-y-3 font-light leading-relaxed">
                        <p>
                            We understand that selecting the exact waist fit or hue of full-grain leather online can occasionally call for a tactile adjustment. All patrons across Pakistan are entitled to a direct exchange within <strong>7 calendar days</strong> from the timestamp marked on your courier tracking slip.
                        </p>
                        <p>
                            Exchanges can be performed for alternate belt sizes (e.g. 34 to 36), alternate leather finishes (Espresso Brown to Obsidian Black), or credited toward any other atelier piece of equal or greater value.
                        </p>
                    </div>
                </article>

                <!-- Section 2: Standards for Eligible Return -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            02
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Eligibility & Condition Guidelines
                            </h2>
                            <span class="text-[11px] text-muted font-light">Preserving raw natural leather integrity</span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-espresso-800 font-light mb-4 leading-relaxed">
                        Because genuine full-grain leather is an organic material that rapidly conforms and patinas to bodily wear, items submitted for exchange must meet the following criteria:
                    </p>

                    <div class="space-y-3">
                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200 flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Pristine & Uncreased</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">The leather strap must not show buckle notch creasing, stretch marks, perfume scent, or surface fingernail scratches.</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200 flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Complete Original Packaging</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">Must include the signature embossed rigid gift box, breathable microfiber dust pouch, and authenticity booklet.</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200 flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <div>
                                <h4 class="font-serif text-xs font-bold text-espresso-950">Unmodified Structure</h4>
                                <p class="text-[11px] text-muted font-light mt-0.5">Belts that have been trimmed, shortened, or had additional holes pierced by the patron are ineligible for exchange.</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Section 3: Simple 4-Step Process -->
                <article class="bg-white rounded-3xl p-6 sm:p-8 border border-ivory-200/90 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-5">
                        <div class="w-9 h-9 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            03
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                How to Initiate an Exchange
                            </h2>
                            <span class="text-[11px] text-muted font-light">Simple concierge-assisted process</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 space-y-1.5">
                            <span class="w-6 h-6 rounded-full bg-gold text-espresso-950 font-bold text-xs flex items-center justify-center">1</span>
                            <h4 class="font-serif text-xs font-bold text-espresso-950 pt-1">Contact Concierge</h4>
                            <p class="text-[11px] text-muted font-light leading-relaxed">
                                WhatsApp our client care desk (+92 300 123-4567) quoting your Order Number and preferred new size.
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 space-y-1.5">
                            <span class="w-6 h-6 rounded-full bg-gold text-espresso-950 font-bold text-xs flex items-center justify-center">2</span>
                            <h4 class="font-serif text-xs font-bold text-espresso-950 pt-1">Photo Verification</h4>
                            <p class="text-[11px] text-muted font-light leading-relaxed">
                                Share 2 quick photos confirming the item and its packaging are in uncreased, pristine condition.
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 space-y-1.5">
                            <span class="w-6 h-6 rounded-full bg-gold text-espresso-950 font-bold text-xs flex items-center justify-center">3</span>
                            <h4 class="font-serif text-xs font-bold text-espresso-950 pt-1">Courier Pickup / Return</h4>
                            <p class="text-[11px] text-muted font-light leading-relaxed">
                                Our concierge arranges a reverse courier pickup or provides our central Lahore atelier return address.
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#FAF7F2] border border-ivory-200 space-y-1.5">
                            <span class="w-6 h-6 rounded-full bg-gold text-espresso-950 font-bold text-xs flex items-center justify-center">4</span>
                            <h4 class="font-serif text-xs font-bold text-espresso-950 pt-1">Priority Re-Dispatch</h4>
                            <p class="text-[11px] text-muted font-light leading-relaxed">
                                Your fresh replacement item is buffed, boxed, and dispatched within 48 hours with express tracking.
                            </p>
                        </div>

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
                            <span class="text-[11px] font-mono text-gold uppercase tracking-wider">Exchange Concierge</span>
                        </div>
                        <span class="text-[10px] text-ivory-300/70">Fast Resolution</span>
                    </div>

                    <h3 class="font-serif text-lg font-bold text-white mb-2">
                        Need an Immediate Size Swap?
                    </h3>
                    <p class="text-xs text-ivory-300/80 leading-relaxed font-light mb-6">
                        Our sizing experts in Lahore will help determine your ideal waist fit and reserve the replacement piece immediately.
                    </p>

                    <div class="space-y-3">
                        <a 
                            href="https://wa.me/923001234567?text=Assalam%20o%20Alaikum%2C%20I%20would%20like%20to%20request%20a%20size%20exchange%20for%20my%20order" 
                            target="_blank" 
                            class="w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white text-xs uppercase tracking-widest font-bold rounded-xl text-center block transition-all shadow-md flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                            <span>WhatsApp Exchange Desk</span>
                        </a>

                        <a 
                            href="tel:+923001234567" 
                            class="w-full py-3 px-4 bg-white/10 hover:bg-white/15 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl text-center block transition-all border border-ivory-300/30 flex items-center justify-center gap-2"
                        >
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>+92 (300) 123-4567</span>
                        </a>
                    </div>
                </div>

                <!-- Atelier Trust Badges Card -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-ivory-200/90 shadow-sm space-y-4">
                    <h4 class="font-serif text-xs uppercase tracking-wider font-bold text-espresso-950 pb-2 border-b border-ivory-200">
                        Patron Guarantees
                    </h4>
                    
                    <ul class="space-y-3 text-xs text-espresso-900 font-light">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Lifetime Warranty against Hardware Rivet Defects</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M3 21v-5h5"></path></svg>
                            <span>Free Size Adjustment Concierge Support</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>Priority Re-Dispatch with SMS Tracking</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
