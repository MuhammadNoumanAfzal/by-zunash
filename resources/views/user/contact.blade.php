@extends('user.layouts.app')

@section('title', 'Client Concierge & Contact | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'Contact the By Zunash client concierge for custom sizing, order tracking, corporate gifting, or WhatsApp support across Pakistan.')
@section('meta_keywords', 'contact by zunash, customer support leather pakistan, custom leather order pakistan, by zunash whatsapp')
@section('canonical', route('contact'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "ContactPage",
            "@id": "{{ route('contact') }}/#contact",
            "name": "Contact By Zunash Concierge",
            "description": "Contact the By Zunash client concierge for custom sizing, order tracking, corporate gifting, or WhatsApp support across Pakistan.",
            "url": "{{ route('contact') }}",
            "mainEntity": {
                "@type": "Organization",
                "name": "By Zunash",
                "telephone": "+92-300-1234567",
                "email": "concierge@byzunash.com",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Lahore",
                    "addressRegion": "Punjab",
                    "addressCountry": "PK"
                }
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('contact') }}/#breadcrumb",
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
                    "name": "Contact Concierge",
                    "item": "{{ route('contact') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-ivory-50 min-h-screen py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Client Concierge</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-espresso-900 mt-2 mb-4">
                We Are Here to Assist
            </h1>
            <p class="text-sm text-muted leading-relaxed">
                Whether you need bespoke belt sizing guidance, corporate gifting packages, or an update on your courier dispatch, our concierge team is at your disposal.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Contact Form (7 cols) -->
            <div class="lg:col-span-7 bg-white p-8 sm:p-10 rounded-2xl border border-ivory-300 shadow-xs">
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-espresso text-ivory rounded-xl border border-gold/40 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gold/20 flex items-center justify-center text-gold flex-shrink-0">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs text-ivory-200">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Your Full Name *</label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}"
                                placeholder="e.g. Ayesha Tariq" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border @error('name') border-red-500 @else border-ivory-300 @enderror rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                required
                            >
                            @error('name')
                                <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Email Address *</label>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="client@example.com" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border @error('email') border-red-500 @else border-ivory-300 @enderror rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                required
                            >
                            @error('email')
                                <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Phone / WhatsApp Number</label>
                            <input 
                                type="tel" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                placeholder="0300 1234567" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                            >
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Inquiry Subject *</label>
                            <input 
                                type="text" 
                                name="subject" 
                                value="{{ old('subject') }}"
                                placeholder="e.g. Order Tracking or Custom Sizing" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border @error('subject') border-red-500 @else border-ivory-300 @enderror rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                required
                            >
                            @error('subject')
                                <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Your Message *</label>
                        <textarea 
                            name="message" 
                            rows="5" 
                            placeholder="Please share the details of your inquiry or requirements..." 
                            class="w-full px-4 py-2.5 bg-ivory-50 border @error('message') border-red-500 @else border-ivory-300 @enderror rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-4 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all border border-gold/30 flex items-center justify-center gap-2 active:scale-98"
                    >
                        <span>Send Message to Atelier</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

            <!-- Contact Information Cards (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Direct Channels -->
                <div class="bg-white p-6 rounded-xl border border-ivory-300 shadow-xs space-y-4">
                    <h3 class="font-serif text-base font-bold text-espresso-900 uppercase tracking-wider pb-2 border-b border-ivory-200">
                        Direct Assistance
                    </h3>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-ivory-100 flex items-center justify-center text-gold-600 flex-shrink-0">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-espresso-900">Telephone Concierge</div>
                            <div class="text-xs text-muted mt-0.5">+92 (300) 123-4567</div>
                            <div class="text-[11px] text-muted-dark">Mon – Sat: 10:00 AM – 8:00 PM PKT</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-ivory-100 flex items-center justify-center text-gold-600 flex-shrink-0">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-espresso-900">Email Inquiries</div>
                            <div class="text-xs text-muted mt-0.5">concierge@byzunash.com</div>
                            <div class="text-[11px] text-muted-dark">Guaranteed response within 24 hours</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-ivory-100 flex items-center justify-center text-gold-600 flex-shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase font-semibold text-espresso-900">Studios & Presence</div>
                            <div class="text-xs text-muted mt-0.5">Gulberg III, Lahore & Clifton, Karachi</div>
                            <div class="text-[11px] text-muted-dark">Pakistan Nationwide Operations</div>
                        </div>
                    </div>
                </div>

                <!-- Corporate & Custom Orders Note -->
                <div class="bg-espresso-950 text-ivory p-6 rounded-xl border border-gold/30 shadow-luxury">
                    <span class="text-gold text-xs uppercase tracking-widest font-serif block mb-2">Bespoke & Corporate</span>
                    <h4 class="font-serif text-lg font-bold text-white mb-2">Custom Embossing & Gifting</h4>
                    <p class="text-xs text-ivory-300 leading-relaxed font-light mb-4">
                        We collaborate with executive corporations and private patrons across Pakistan to craft hot-stamped monogram gift sets in bespoke wooden cases.
                    </p>
                    <a href="mailto:bespoke@byzunash.com" class="text-xs text-gold underline underline-offset-4 hover:text-gold-light font-medium">
                        Email Bespoke Desk &rarr;
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

@if(session('success'))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.ZunashAlert) {
                window.ZunashAlert.success('Inquiry Received', '{{ session('success') }}');
            }
        });
    </script>
    @endpush
@endif
@endsection
