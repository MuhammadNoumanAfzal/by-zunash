@extends('user.layouts.app')

@section('title', 'Returns & Exchanges Policy | By Zunash Luxury Leather')
@section('meta_description', 'Learn about our 7-day exchange window, conditions of return, and bespoke support for By Zunash leather goods in Pakistan.')

@section('content')
<div class="bg-white min-h-screen py-12 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-12 pb-6 border-b border-ivory-200">
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Client Care Guidelines</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-3">
                Returns & Exchange Policy
            </h1>
            <p class="text-xs text-muted">
                Last updated: October 2026 • Dedicated to client satisfaction across Pakistan
            </p>
        </div>

        <!-- Policy Body -->
        <div class="prose prose-sm max-w-none text-espresso-800 space-y-8 leading-relaxed font-light">
            
            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">1. 7-Day Exchange Window</h2>
                <p>
                    We stand wholeheartedly behind the material honesty and craftsmanship of every leather creation. If your belt sizing requires adjustment or you wish to exchange an item for an alternate shade or model, you may initiate an exchange within <strong>7 calendar days</strong> of receiving your parcel.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">2. Conditions for Eligible Exchanges</h2>
                <p>Because genuine full-grain leather is a natural material that conforms quickly to initial use, returned items must comply with the following standards:</p>
                <ul class="list-disc pl-5 space-y-1.5 text-xs">
                    <li>The item must be completely unworn, uncreased, and free of scratches, perfume, or cosmetic marks.</li>
                    <li>All original packaging, including dust bags, rigid gift boxes, warranty cards, and security hangtags, must accompany the product.</li>
                    <li>Belts that have been custom-punched or modified after receipt are ineligible for exchange.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">3. How to Initiate an Exchange</h2>
                <ol class="list-decimal pl-5 space-y-2 text-xs">
                    <li>Send a WhatsApp message or email to our client concierge desk (+92 300 123-4567 / concierge@byzunash.com) mentioning your Order Number.</li>
                    <li>Share clear photographs of the product and its packaging.</li>
                    <li>Our concierge will book a return courier collection or provide the return dispatch address for our Lahore atelier.</li>
                    <li>Upon inspection and clearance, your replacement item will be dispatched within 48 hours.</li>
                </ol>
            </section>

            <!-- Editable Notice Box -->
            <div class="p-4 bg-ivory-100/70 rounded-lg border border-gold/30 text-[11px] text-muted-dark italic">
                Note for patrons: Custom monogrammed or personalized bespoke items are crafted exclusively for the patron and cannot be exchanged unless a structural material defect is identified upon arrival.
            </div>

        </div>

    </div>
</div>
@endsection
