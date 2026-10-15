@extends('user.layouts.app')

@section('title', 'Shipping & Nationwide Delivery Policy | By Zunash Pakistan')
@section('meta_description', 'Information regarding delivery times, TCS/Leopards courier partners, and nationwide Cash on Delivery coverage across Pakistan.')
@section('meta_keywords', 'by zunash shipping, cash on delivery delivery time pakistan, courier delivery karachi lahore islamabad')
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
            "name": "Shipping Policy",
            "item": "{{ route('policy.shipping') }}"
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-white min-h-screen py-12 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-12 pb-6 border-b border-ivory-200">
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Client Care Guidelines</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-3">
                Shipping & Nationwide Delivery Policy
            </h1>
            <p class="text-xs text-muted">
                Last updated: October 2026 • Applicable for all dispatches across the Islamic Republic of Pakistan
            </p>
        </div>

        <!-- Policy Body -->
        <div class="prose prose-sm max-w-none text-espresso-800 space-y-8 leading-relaxed font-light">
            
            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">1. Order Processing & Dispatch Timelines</h2>
                <p>
                    Every By Zunash piece undergoes a thorough final inspection and buffing at our workshop before being wrapped in anti-humidity tissue, packed in our signature rigid boxes, and sealed.
                </p>
                <ul class="list-disc pl-5 space-y-1.5 text-xs">
                    <li>Orders confirmed before 2:00 PM (Monday – Saturday) are handed over to our courier logistics partners within 24 hours.</li>
                    <li>Orders placed on Sundays or gazetted public holidays are dispatched on the next working business day.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">2. Estimated Delivery Windows by Region</h2>
                <div class="bg-ivory-50 p-6 rounded-xl border border-ivory-300 text-xs space-y-2">
                    <div class="flex justify-between border-b border-ivory-200 pb-2">
                        <span class="font-bold text-espresso-900">Karachi, Lahore, Islamabad & Rawalpindi:</span>
                        <span>2 to 3 Business Days</span>
                    </div>
                    <div class="flex justify-between border-b border-ivory-200 pb-2">
                        <span class="font-bold text-espresso-900">Faisalabad, Multan, Peshawar, Sialkot, Gujranwala:</span>
                        <span>2 to 4 Business Days</span>
                    </div>
                    <div class="flex justify-between pt-1">
                        <span class="font-bold text-espresso-900">Other Cities, Districts, and Regional Towns:</span>
                        <span>3 to 5 Business Days</span>
                    </div>
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">3. Delivery Charges & Free Shipping Threshold</h2>
                <p>
                    We offer standard flat-rate courier delivery across Pakistan for PKR 250 on smaller orders. All orders with a subtotal of <strong>PKR 6,000 or greater qualify for complimentary nationwide shipping</strong>.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">4. Cash on Delivery (COD) Protocols</h2>
                <p>
                    For Cash on Delivery shipments, the courier representative will present the sealed consignment flyer. Please ensure the exact payable amount is ready in Pakistani Rupees (PKR) upon delivery to avoid delivery delays.
                </p>
            </section>

            <!-- Editable Notice Box -->
            <div class="p-4 bg-ivory-100/70 rounded-lg border border-gold/30 text-[11px] text-muted-dark italic">
                Notice: The operational parameters outlined above represent standard guidelines subject to the store owner's periodic operational review.
            </div>

        </div>

    </div>
</div>
@endsection
