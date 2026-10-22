@extends('user.layouts.app')

@section('title', 'Client Concierge & Contact | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'Contact the By Zunash client concierge for bespoke belt sizing, order tracking, corporate gifting, or WhatsApp support across Pakistan.')
@section('meta_keywords', 'contact by zunash, customer support leather pakistan, custom leather order pakistan, by zunash whatsapp, bespoke leather lahore')
@section('canonical', route('contact'))
@section('og_type', 'website')
@section('og_image', asset('images/brand/artisan-craft.jpg'))

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "ContactPage",
            "@id": "{{ route('contact') }}/#contact",
            "name": "Contact By Zunash Concierge",
            "description": "Contact the By Zunash client concierge for bespoke sizing, order tracking, corporate gifting, or WhatsApp support across Pakistan.",
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
                    "name": "Client Concierge",
                    "item": "{{ route('contact') }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-white min-h-screen text-espresso-900 selection:bg-gold/30 selection:text-espresso-950">

    <!-- =========================================================================
         SECTION 1: HERO CONCIERGE BANNER (Dark Luxury, Compact Height)
         ========================================================================= -->
    <div class="relative bg-espresso-950 text-ivory py-12 sm:py-16 overflow-hidden">
        
        <!-- Background Texture & Ambient Glow -->
        <div class="absolute inset-0 z-0 opacity-20">
            <img 
                src="{{ asset('images/brand/artisan-craft.jpg') }}" 
                alt="Leather atelier background" 
                class="w-full h-full object-cover filter brightness-75 contrast-125"
            >
            <div class="absolute inset-0 bg-espresso-950/90"></div>
        </div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(201,162,79,0.15)_0,transparent_70%)] pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center">
            
            <!-- Atelier Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-gold/40 text-gold-300 text-[11px] uppercase tracking-widest font-serif font-bold mb-3 shadow-xs">
                <span>◈</span>
                <span>By Zunash Client Concierge Desk</span>
                <span>◈</span>
            </div>

            <!-- Title -->
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight tracking-tight">
                How May We Assist You?
            </h1>

            <p class="text-xs sm:text-sm text-ivory-200 font-light max-w-xl mx-auto leading-relaxed mb-8">
                Whether you need bespoke belt sizing guidance, order dispatch updates, or corporate gifting packages, our senior concierge team in Lahore and Karachi is at your disposal.
            </p>

            <!-- 3 Quick Action Bar Cards (Interactive Lift) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-3xl mx-auto text-left">
                
                <!-- WhatsApp Channel -->
                <a 
                    href="https://wa.me/923001234567?text=Assalam-o-Alaikum%20By%20Zunash%20Concierge,%20I%20would%20like%20assistance%20with%20an%20order." 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="p-3.5 rounded-xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 hover:border-gold/60 transition-all duration-200 group flex items-center gap-3"
                >
                    <div class="w-9 h-9 rounded-full bg-[#25D366]/20 text-[#25D366] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 text-white text-xs font-bold font-serif">
                            <span>WhatsApp VIP</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        </div>
                        <span class="text-[11px] text-ivory-300 block">Instant Chat Response</span>
                    </div>
                </a>

                <!-- Telephone Support -->
                <a 
                    href="tel:+923001234567" 
                    class="p-3.5 rounded-xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 hover:border-gold/60 transition-all duration-200 group flex items-center gap-3"
                >
                    <div class="w-9 h-9 rounded-full bg-gold/20 text-gold flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-xs font-bold font-serif">Direct Telephone</div>
                        <span class="text-[11px] text-ivory-300 block">+92 (300) 123-4567</span>
                    </div>
                </a>

                <!-- Email Desk -->
                <a 
                    href="mailto:concierge@byzunash.com" 
                    class="p-3.5 rounded-xl bg-white/10 hover:bg-white/15 backdrop-blur-md border border-white/15 hover:border-gold/60 transition-all duration-200 group flex items-center gap-3"
                >
                    <div class="w-9 h-9 rounded-full bg-gold/20 text-gold flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="text-white text-xs font-bold font-serif">Email Atelier</div>
                        <span class="text-[11px] text-ivory-300 block">24h Guaranteed Reply</span>
                    </div>
                </a>

            </div>

        </div>

        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gold/40 to-transparent"></div>
    </div>


    <!-- =========================================================================
         SECTION 2: MAIN INQUIRY WORKSPACE (Warm Light Section)
         ========================================================================= -->
    <div class="bg-[#FAF7F2] py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                
                <!-- Left Column: Interactive Concierge Form (7 Cols) -->
                <div 
                    x-data="{ 
                        selectedTopic: 'Bespoke Belt Sizing',
                        topics: [
                            'Bespoke Belt Sizing',
                            'Order Status & Tracking',
                            'Corporate & Gifting',
                            'Exchange & Returns',
                            'General Inquiry'
                        ],
                        messagePlaceholder: 'Please tell us your waist size and which belt design you are considering...',
                        setTopic(t) {
                            this.selectedTopic = t;
                            if (t === 'Bespoke Belt Sizing') {
                                this.messagePlaceholder = 'Please tell us your tailored trouser waist size or current belt measurement...';
                            } else if (t === 'Order Status & Tracking') {
                                this.messagePlaceholder = 'Please share your Order Number (e.g. BZ-1042) and delivery city...';
                            } else if (t === 'Corporate & Gifting') {
                                this.messagePlaceholder = 'Please describe the estimated quantity, monogram preferences, and delivery timeline...';
                            } else if (t === 'Exchange & Returns') {
                                this.messagePlaceholder = 'Please provide your order details and the size/model you would like to exchange for...';
                            } else {
                                this.messagePlaceholder = 'How can our atelier concierge assist you today?';
                            }
                        }
                    }" 
                    class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-2xl border border-ivory-300 shadow-luxury"
                >
                    
                    <div class="mb-6">
                        <span class="text-xs uppercase tracking-widest text-gold-700 font-serif font-bold">Priority Correspondence</span>
                        <h2 class="font-serif text-2xl font-bold text-espresso-950 mt-1">
                            Send a Private Inquiry
                        </h2>
                        <p class="text-xs text-muted mt-1 font-light">
                            Select an inquiry topic below to connect directly with the specialized department.
                        </p>
                    </div>

                    <!-- Topic Selection Pills -->
                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-wider font-bold text-espresso-900 mb-2">
                            Inquiry Category:
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="topic in topics" :key="topic">
                                <button 
                                    type="button" 
                                    @click="setTopic(topic)"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 focus:outline-none"
                                    :class="selectedTopic === topic 
                                        ? 'bg-espresso-950 text-ivory shadow-sm ring-2 ring-gold/40 scale-[1.02]' 
                                        : 'bg-ivory-100 text-espresso-800 hover:bg-ivory-200 border border-ivory-300/80'"
                                    x-text="topic"
                                ></button>
                            </template>
                        </div>
                    </div>

                    <!-- Form Error Alert -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-300 text-emerald-900 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-800 flex-shrink-0">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-serif font-bold text-xs uppercase">Message Delivered</h4>
                                <p class="text-xs text-emerald-800 mt-0.5">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Interactive Form -->
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Hidden Subject Bound to Topic -->
                        <input type="hidden" name="subject" :value="selectedTopic">

                        <!-- Name & Email Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1">
                                    Your Full Name <span class="text-gold-700">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        placeholder="e.g. Ayesha Tariq" 
                                        class="w-full pl-9 pr-3.5 py-2.5 bg-ivory-50/60 border @error('name') border-red-500 @else border-ivory-300 @enderror rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-all"
                                        required
                                    >
                                </div>
                                @error('name')
                                    <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1">
                                    Email Address <span class="text-gold-700">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                                        <i data-lucide="mail" class="w-4 h-4"></i>
                                    </span>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email') }}"
                                        placeholder="client@example.com" 
                                        class="w-full pl-9 pr-3.5 py-2.5 bg-ivory-50/60 border @error('email') border-red-500 @else border-ivory-300 @enderror rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-all"
                                        required
                                    >
                                </div>
                                @error('email')
                                    <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone & City Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1">
                                    Phone / WhatsApp (Optional)
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-muted">
                                        <i data-lucide="phone" class="w-4 h-4"></i>
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="phone" 
                                        value="{{ old('phone') }}"
                                        placeholder="0300 1234567" 
                                        class="w-full pl-9 pr-3.5 py-2.5 bg-ivory-50/60 border border-ivory-300 rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-all"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1">
                                    Selected Subject
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gold-700">
                                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        readonly 
                                        :value="selectedTopic"
                                        class="w-full pl-9 pr-3.5 py-2.5 bg-ivory-100 border border-ivory-300 rounded-xl text-xs text-espresso-900 font-semibold cursor-default"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Message Textarea -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900">
                                    Detailed Message <span class="text-gold-700">*</span>
                                </label>
                                <span class="text-[11px] text-muted font-light">Min. 10 characters</span>
                            </div>
                            <textarea 
                                name="message" 
                                rows="4" 
                                :placeholder="messagePlaceholder"
                                class="w-full p-3.5 bg-ivory-50/60 border @error('message') border-red-500 @else border-ivory-300 @enderror rounded-xl text-xs text-espresso-950 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-all resize-y"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Action Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full py-3.5 px-6 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl shadow-md transition-all border border-gold/30 flex items-center justify-center gap-2 active:scale-[0.98] group"
                        >
                            <span>Send Message to Atelier</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-gold group-hover:translate-x-1 transition-transform"></i>
                        </button>

                        <div class="flex items-center justify-center gap-4 text-[11px] text-muted font-light pt-2">
                            <span class="flex items-center gap-1">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold-700"></i>
                                <span>Strict Client Confidentiality</span>
                            </span>
                            <span>•</span>
                            <span>Direct Response within 24 Hours</span>
                        </div>

                    </form>

                </div>

                <!-- Right Column: Direct Channels & Atelier Hub (5 Cols) -->
                <div class="lg:col-span-5 space-y-5">
                    
                    <!-- Direct VIP WhatsApp Box -->
                    <div class="p-6 rounded-2xl bg-white border border-ivory-300 shadow-sm relative overflow-hidden group">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-10 h-10 rounded-full bg-[#25D366]/15 text-[#25D366] flex items-center justify-center flex-shrink-0">
                                <i data-lucide="message-square" class="w-5 h-5"></i>
                            </div>
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                Concierge Online
                            </span>
                        </div>

                        <h3 class="font-serif text-lg font-bold text-espresso-950 mb-1">
                            Direct WhatsApp Chat
                        </h3>
                        <p class="text-xs text-muted leading-relaxed font-light mb-4">
                            Connect with an artisan advisor for instant size recommendations, photos of leather hides, or immediate courier tracking.
                        </p>

                        <a 
                            href="https://wa.me/923001234567?text=Assalam-o-Alaikum%20By%20Zunash%20Concierge,%20I%20would%20like%20assistance." 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-full py-3 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white text-xs uppercase tracking-widest font-bold shadow-sm transition-all flex items-center justify-center gap-2 active:scale-98"
                        >
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                            <span>Open WhatsApp Consultation</span>
                        </a>
                    </div>

                    <!-- Atelier Presence & Operating Hours Card -->
                    <div class="p-6 rounded-2xl bg-white border border-ivory-300 shadow-sm space-y-4">
                        <h3 class="font-serif text-base font-bold text-espresso-950 uppercase tracking-wider pb-2 border-b border-ivory-200">
                            Atelier Presence & Hours
                        </h3>

                        <!-- Telephones -->
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-ivory-100 flex items-center justify-center text-gold-700 flex-shrink-0 mt-0.5">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-espresso-900 block">Telephone Concierge</span>
                                <span class="text-xs text-muted font-mono">+92 (300) 123-4567</span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-ivory-100 flex items-center justify-center text-gold-700 flex-shrink-0 mt-0.5">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-espresso-900 block">General Inquiries</span>
                                <span class="text-xs text-muted font-mono">concierge@byzunash.com</span>
                            </div>
                        </div>

                        <!-- Operating Hours -->
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-ivory-100 flex items-center justify-center text-gold-700 flex-shrink-0 mt-0.5">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-espresso-900 block">Hours of Operation</span>
                                <span class="text-xs text-muted">Monday – Saturday: 10:00 AM – 8:00 PM PKT</span>
                                <span class="text-[11px] text-muted-dark block">Sunday: WhatsApp Emergency Support</span>
                            </div>
                        </div>

                        <!-- Locations -->
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-ivory-100 flex items-center justify-center text-gold-700 flex-shrink-0 mt-0.5">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-espresso-900 block">Studios & Dispatch Hubs</span>
                                <span class="text-xs text-muted">Gulberg III, Lahore & Clifton, Karachi</span>
                                <span class="text-[11px] text-muted-dark block">Nationwide Express Delivery to 120+ Cities</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bespoke Corporate & Wedding Gifting Box -->
                    <div class="p-6 rounded-2xl bg-espresso-950 text-ivory border border-gold/30 shadow-luxury relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gold/10 rounded-full blur-xl"></div>
                        <span class="text-gold text-xs uppercase tracking-widest font-serif block mb-1">Bespoke Orders</span>
                        <h4 class="font-serif text-base font-bold text-white mb-2">Corporate & Wedding Gifting</h4>
                        <p class="text-xs text-ivory-300 leading-relaxed font-light mb-4">
                            Custom hot-stamped gold foil monograms, corporate executive sets, and bespoke presentation packaging for orders of 10+ units.
                        </p>
                        <a 
                            href="mailto:bespoke@byzunash.com?subject=Corporate%20or%20Wedding%20Gifting%20Inquiry" 
                            class="inline-flex items-center gap-1.5 text-xs text-gold hover:text-white font-semibold transition-colors"
                        >
                            <span>Inquire With Bespoke Desk</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 3: INTERACTIVE FAQ ACCORDION (Deep Dark Luxury Section)
         ========================================================================= -->
    <div class="bg-[#160E0A] text-ivory border-y border-gold/25 py-12 sm:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-gold text-xs uppercase tracking-widest font-serif font-bold">Frequently Addressed</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-white mt-1">
                    Client Inquiries & Protocol
                </h2>
                <p class="text-xs text-ivory-300 font-light mt-1">
                    Answers to common questions regarding delivery, Cash on Delivery, sizing, and leather care.
                </p>
            </div>

            <!-- Accordion items powered by Alpine -->
            <div 
                x-data="{ activeFaq: 1 }" 
                class="space-y-3"
            >
                
                <!-- FAQ 1 -->
                <div class="rounded-xl bg-white/[0.04] border border-white/10 overflow-hidden transition-colors">
                    <button 
                        type="button" 
                        @click="activeFaq = activeFaq === 1 ? null : 1" 
                        class="w-full p-4 sm:p-5 text-left flex items-center justify-between gap-4 focus:outline-none"
                    >
                        <span class="font-serif text-sm font-bold text-white flex items-center gap-2.5">
                            <span class="text-gold font-mono text-xs">01.</span>
                            <span>Can I inspect my leather parcel before paying the courier?</span>
                        </span>
                        <i 
                            data-lucide="chevron-down" 
                            class="w-4 h-4 text-gold transition-transform duration-300 flex-shrink-0"
                            :class="activeFaq === 1 ? 'rotate-180' : ''"
                        ></i>
                    </button>
                    <div 
                        x-show="activeFaq === 1" 
                        x-collapse
                        class="px-5 pb-5 pt-1 text-xs text-ivory-300 font-light leading-relaxed border-t border-white/5"
                    >
                        Yes, absolutely. With By Zunash nationwide Doorstep Cash on Delivery (COD), the courier representative will hand you the parcel. You may verify the tamper-evident packaging and authenticity seal at your doorstep prior to handing over the payment.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-xl bg-white/[0.04] border border-white/10 overflow-hidden transition-colors">
                    <button 
                        type="button" 
                        @click="activeFaq = activeFaq === 2 ? null : 2" 
                        class="w-full p-4 sm:p-5 text-left flex items-center justify-between gap-4 focus:outline-none"
                    >
                        <span class="font-serif text-sm font-bold text-white flex items-center gap-2.5">
                            <span class="text-gold font-mono text-xs">02.</span>
                            <span>How do I exchange my belt if the size is too tight or loose?</span>
                        </span>
                        <i 
                            data-lucide="chevron-down" 
                            class="w-4 h-4 text-gold transition-transform duration-300 flex-shrink-0"
                            :class="activeFaq === 2 ? 'rotate-180' : ''"
                        ></i>
                    </button>
                    <div 
                        x-show="activeFaq === 2" 
                        x-collapse
                        class="px-5 pb-5 pt-1 text-xs text-ivory-300 font-light leading-relaxed border-t border-white/5"
                    >
                        We offer a complimentary 7-Day Hassle-Free Exchange Policy. Simply message our WhatsApp concierge at <strong class="text-white">+92 (300) 123-4567</strong> with your order ID. We will promptly dispatch the replacement size and arrange a reverse pickup from your address.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-xl bg-white/[0.04] border border-white/10 overflow-hidden transition-colors">
                    <button 
                        type="button" 
                        @click="activeFaq = activeFaq === 3 ? null : 3" 
                        class="w-full p-4 sm:p-5 text-left flex items-center justify-between gap-4 focus:outline-none"
                    >
                        <span class="font-serif text-sm font-bold text-white flex items-center gap-2.5">
                            <span class="text-gold font-mono text-xs">03.</span>
                            <span>How long does nationwide delivery take?</span>
                        </span>
                        <i 
                            data-lucide="chevron-down" 
                            class="w-4 h-4 text-gold transition-transform duration-300 flex-shrink-0"
                            :class="activeFaq === 3 ? 'rotate-180' : ''"
                        ></i>
                    </button>
                    <div 
                        x-show="activeFaq === 3" 
                        x-collapse
                        class="px-5 pb-5 pt-1 text-xs text-ivory-300 font-light leading-relaxed border-t border-white/5"
                    >
                        Major metros including Karachi, Lahore, Islamabad, and Rawalpindi arrive within 24–48 hours via priority air couriers. Other cities (Faisalabad, Multan, Peshawar, Sialkot, Quetta) arrive within 2–3 business days. You will receive an SMS with live tracking upon dispatch.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="rounded-xl bg-white/[0.04] border border-white/10 overflow-hidden transition-colors">
                    <button 
                        type="button" 
                        @click="activeFaq = activeFaq === 4 ? null : 4" 
                        class="w-full p-4 sm:p-5 text-left flex items-center justify-between gap-4 focus:outline-none"
                    >
                        <span class="font-serif text-sm font-bold text-white flex items-center gap-2.5">
                            <span class="text-gold font-mono text-xs">04.</span>
                            <span>Are all By Zunash products 100% genuine full-grain leather?</span>
                        </span>
                        <i 
                            data-lucide="chevron-down" 
                            class="w-4 h-4 text-gold transition-transform duration-300 flex-shrink-0"
                            :class="activeFaq === 4 ? 'rotate-180' : ''"
                        ></i>
                    </button>
                    <div 
                        x-show="activeFaq === 4" 
                        x-collapse
                        class="px-5 pb-5 pt-1 text-xs text-ivory-300 font-light leading-relaxed border-t border-white/5"
                    >
                        Yes, unconditionally. We never use split leather, bonded scrap composites, or PU vinyl plastics. Every piece is crafted from top-layer vegetable-tanned steer and calfskin hides that breathe and develop a lustrous patina over years of wear.
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- =========================================================================
         SECTION 4: CLIENT TRUST PACT & GUARANTEES (Warm Light Section)
         ========================================================================= -->
    <div class="bg-[#FAF7F2] py-8 border-t border-ivory-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div class="flex items-center justify-center gap-2 text-xs text-espresso-950 font-semibold">
                    <i data-lucide="truck" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                    <span>24–48h Nationwide Courier</span>
                </div>
                <div class="flex items-center justify-center gap-2 text-xs text-espresso-950 font-semibold">
                    <i data-lucide="banknote" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                    <span>Cash on Delivery Supported</span>
                </div>
                <div class="flex items-center justify-center gap-2 text-xs text-espresso-950 font-semibold">
                    <i data-lucide="rotate-ccw" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                    <span>7-Day Easy Size Exchange</span>
                </div>
                <div class="flex items-center justify-center gap-2 text-xs text-espresso-950 font-semibold">
                    <i data-lucide="gift" class="w-4 h-4 text-gold-700 flex-shrink-0"></i>
                    <span>Rigid Magnetic Gift Box</span>
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
                window.ZunashAlert.toast('{{ session('success') }}', 'success');
            }
        });
    </script>
    @endpush
@endif
@endsection
