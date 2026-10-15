@extends('user.layouts.app')

@section('title', 'Privacy & Data Protection Policy | By Zunash Luxury Leather')
@section('meta_description', 'How By Zunash protects client personal data, telephone numbers, and delivery addresses in Pakistan.')

@section('content')
<div class="bg-white min-h-screen py-12 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-12 pb-6 border-b border-ivory-200">
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Client Care Guidelines</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-3">
                Privacy & Data Protection Policy
            </h1>
            <p class="text-xs text-muted">
                Last updated: October 2026 • Respecting our patrons' confidentiality across Pakistan
            </p>
        </div>

        <!-- Policy Body -->
        <div class="prose prose-sm max-w-none text-espresso-800 space-y-8 leading-relaxed font-light">
            
            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">1. Commitment to Client Confidentiality</h2>
                <p>
                    At By Zunash, we uphold the privacy and personal confidentiality of our patrons with utmost seriousness. We treat your personal details with the same meticulous care that we apply to our leathercraft.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">2. Information We Collect</h2>
                <p>When you place an order or contact our concierge, we collect only the essential details necessary to fulfill your delivery:</p>
                <ul class="list-disc pl-5 space-y-1.5 text-xs">
                    <li>Your full name and contact telephone / WhatsApp number.</li>
                    <li>Your physical shipping address, city, and postal code in Pakistan.</li>
                    <li>Your email address (for order confirmation and optional dispatch updates).</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">3. Purpose of Data Utilization</h2>
                <p>
                    Your contact information is used exclusively to:
                </p>
                <ul class="list-disc pl-5 space-y-1.5 text-xs">
                    <li>Generate shipping waybills and enable courier riders (e.g. TCS / Leopard / Trax) to reach your doorstep.</li>
                    <li>Contact you via telephone or WhatsApp for order and address confirmation.</li>
                    <li>Provide customer support regarding exchanges or care questions.</li>
                </ul>
                <p>
                    We <strong>never</strong> sell, rent, trade, or distribute your personal details to third-party advertising brokers or unauthorized marketing agencies.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif text-xl font-bold text-espresso-900">4. Data Security</h2>
                <p>
                    We employ modern cryptographic protocols and industry best practices to safeguard stored records from unauthorized access, accidental alteration, or disclosure.
                </p>
            </section>

            <!-- Editable Notice Box -->
            <div class="p-4 bg-ivory-100/70 rounded-lg border border-gold/30 text-[11px] text-muted-dark italic">
                Patron Note: This privacy statement is provided as a standard commercial disclosure and should be reviewed and customized in accordance with any specific business registration requirements of the store owner.
            </div>

        </div>

    </div>
</div>
@endsection
