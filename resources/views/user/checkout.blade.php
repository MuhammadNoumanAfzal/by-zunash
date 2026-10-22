@extends('user.layouts.app')

@section('title', 'Secure Checkout | By Zunash Luxury Leather')
@section('meta_description', 'Complete your order with nationwide Cash on Delivery or direct bank transfer across Pakistan.')
@section('robots', 'noindex, nofollow')

@section('content')
<div 
    x-data="checkoutForm()" 
    class="bg-[#FAF8F5] min-h-screen py-10 lg:py-16"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Luxury Breadcrumb Stepper -->
        <nav aria-label="Checkout Progress" class="max-w-xl mx-auto mb-10">
            <div class="flex items-center justify-between text-xs font-semibold">
                <!-- Step 1: Bag -->
                <a href="{{ route('cart') }}" class="flex items-center gap-2 text-espresso-800 hover:text-gold transition-colors">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-[11px] font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </span>
                    <span class="hidden sm:inline">1. Shopping Bag</span>
                </a>

                <div class="flex-1 h-0.5 mx-3 bg-ivory-300">
                    <div class="h-full bg-gold transition-all duration-500" :style="orderPlaced ? 'width: 100%' : 'width: 50%'"></div>
                </div>

                <!-- Step 2: Shipping & Payment -->
                <div class="flex items-center gap-2" :class="orderPlaced ? 'text-espresso-800' : 'text-gold font-bold'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]" :class="orderPlaced ? 'bg-emerald-100 text-emerald-800' : 'bg-gold text-espresso-950 font-bold shadow-xs'">
                        <template x-if="orderPlaced">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </template>
                        <template x-if="!orderPlaced">
                            <span>2</span>
                        </template>
                    </span>
                    <span class="hidden sm:inline">2. Shipping & Payment</span>
                </div>

                <div class="flex-1 h-0.5 mx-3 bg-ivory-300">
                    <div class="h-full bg-gold transition-all duration-500" :style="orderPlaced ? 'width: 100%' : 'width: 0%'"></div>
                </div>

                <!-- Step 3: Complete -->
                <div class="flex items-center gap-2" :class="orderPlaced ? 'text-gold font-bold' : 'text-muted'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[11px]" :class="orderPlaced ? 'bg-gold text-espresso-950 font-bold shadow-xs' : 'bg-ivory-200 text-muted'">
                        <span>3</span>
                    </span>
                    <span class="hidden sm:inline">3. Confirmation</span>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gold/15 text-gold-700 text-[11px] uppercase tracking-widest font-semibold border border-gold/30 mb-3 shadow-2xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Atelier Privilege Checkout
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-espresso-950 tracking-tight">
                Finalize Your Order
            </h1>
            <p class="text-xs sm:text-sm text-muted mt-2 font-light leading-relaxed">
                Handcrafted in pure full-grain leather. Dispatched with priority tracking across 150+ Pakistani cities.
            </p>
        </div>

        <!-- Success Order Confirmation View (Shown when order placed) -->
        <div 
            x-show="orderPlaced" 
            x-cloak 
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-6 scale-98"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            class="max-w-2xl mx-auto bg-white p-8 sm:p-12 rounded-3xl border border-gold/40 shadow-2xl text-center relative overflow-hidden"
        >
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-gold/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-gold/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-emerald-50 border-2 border-emerald-300 text-emerald-600 flex items-center justify-center shadow-lg ring-8 ring-emerald-50/50">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            
            <span class="text-xs uppercase tracking-widest text-gold-700 font-serif font-bold">Alhamdulillah • Order Confirmed</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-950 mt-1 mb-2">
                Shukriya, <span x-text="firstName" class="text-espresso-900"></span>!
            </h2>
            <p class="text-xs sm:text-sm text-muted mb-6 leading-relaxed max-w-lg mx-auto">
                Your bespoke leather commission has been received with reference <strong class="text-espresso-950 font-mono bg-ivory-100 px-2 py-0.5 rounded border border-ivory-300" x-text="orderNumber"></strong>. Our client concierge will call or WhatsApp your contact number (<span class="font-semibold text-espresso-950" x-text="phone"></span>) before final courier handover.
            </p>

            <div class="bg-[#FAF7F2] p-6 rounded-2xl border border-ivory-300 text-left text-xs text-espresso-800 space-y-3.5 mb-8 shadow-2xs">
                <div class="flex justify-between items-center border-b border-ivory-200 pb-2.5">
                    <span class="text-muted">Payment Mode:</span>
                    <span class="font-bold text-espresso-950 flex items-center gap-1.5" x-text="paymentMethod === 'cod' ? 'Cash on Delivery (Nationwide COD)' : 'Direct Bank Transfer (IBFT)'"></span>
                </div>
                <div class="flex justify-between items-center border-b border-ivory-200 pb-2.5">
                    <span class="text-muted">Delivery Destination:</span>
                    <span class="font-bold text-espresso-950" x-text="city + ', Pakistan'"></span>
                </div>
                <div class="flex justify-between items-start border-b border-ivory-200 pb-2.5">
                    <span class="text-muted flex-shrink-0">Dispatch Address:</span>
                    <span class="font-semibold text-right max-w-xs text-espresso-950" x-text="address"></span>
                </div>
                <div class="flex justify-between items-center pt-1 font-serif text-sm font-bold text-espresso-950">
                    <span class="flex items-center gap-1.5 text-gold-700">
                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        Estimated Doorstep Arrival:
                    </span>
                    <span class="text-emerald-700 font-bold">2–4 Business Days</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a 
                    href="https://wa.me/923001234567?text=Assalam%20o%20Alaikum%2C%20I%20have%20placed%20order%20reference%20" 
                    target="_blank" 
                    class="w-full sm:w-auto px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs uppercase tracking-widest font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                    <span>WhatsApp Concierge</span>
                </a>
                <a 
                    href="{{ route('shop') }}" 
                    class="w-full sm:w-auto px-6 py-3.5 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl transition-all shadow-md border border-gold/30"
                >
                    Explore Atelier Catalog
                </a>
            </div>
        </div>

        <!-- Checkout Form Grid -->
        <div x-show="!orderPlaced" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- Left: Shipping Information Form (7 Cols) -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-9 pb-10 sm:pb-12 rounded-3xl border border-ivory-200/90 shadow-md space-y-9">
                
                <!-- Error banner if validation fails -->
                <div 
                    x-show="error" 
                    x-cloak 
                    x-transition
                    class="p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700 flex items-start gap-3 shadow-xs"
                >
                    <svg class="w-5 h-5 flex-shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div>
                        <strong class="font-semibold block mb-0.5">Please check your details</strong>
                        <span x-text="error"></span>
                    </div>
                </div>

                <!-- Step 1: Contact & Shipping Details -->
                <div>
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-6">
                        <div class="w-8 h-8 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            01
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Delivery Address in Pakistan
                            </h2>
                            <p class="text-[11px] text-muted font-light -mt-0.5">
                                Dispatched via tracked courier (TCS & Leopards Courier)
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        
                        <!-- Name Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                    First Name <span class="text-gold-700">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="firstName" 
                                    placeholder="e.g. Bilal" 
                                    class="w-full px-4 py-3 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                    Last Name <span class="text-gold-700">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="lastName" 
                                    placeholder="e.g. Mansoor" 
                                    class="w-full px-4 py-3 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Phone & Email Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900">
                                        Mobile Phone <span class="text-gold-700">*</span>
                                    </label>
                                    <span class="text-[10px] text-emerald-700 font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                                        WhatsApp for Dispatch
                                    </span>
                                </div>
                                <div class="flex items-center rounded-xl border border-ivory-300 bg-[#FAF7F2]/60 focus-within:bg-white focus-within:border-gold focus-within:ring-4 focus-within:ring-gold/15 transition-all shadow-2xs overflow-hidden">
                                    <div class="flex items-center gap-1.5 px-3.5 py-3.5 bg-ivory-100/90 border-r border-ivory-300 text-xs font-semibold text-espresso-900 select-none flex-shrink-0">
                                        <span class="text-base leading-none">🇵🇰</span>
                                        <span class="font-mono text-xs font-bold">+92</span>
                                    </div>
                                    <input 
                                        type="tel" 
                                        x-model="phone" 
                                        placeholder="300 1234567" 
                                        class="w-full px-3.5 py-3.5 bg-transparent text-xs sm:text-sm text-espresso-950 focus:outline-none font-mono placeholder:text-muted/60"
                                        required
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                    Email Address <span class="text-[10px] text-muted font-normal lowercase">(for digital invoice)</span>
                                </label>
                                <input 
                                    type="email" 
                                    x-model="email" 
                                    placeholder="client@example.com" 
                                    class="w-full px-4 py-3 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs"
                                >
                            </div>
                        </div>

                        <!-- Street Address -->
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                Street Address / House / Plaza / Floor <span class="text-gold-700">*</span>
                            </label>
                            <input 
                                type="text" 
                                x-model="address" 
                                placeholder="House / Apartment #, Street Name, Sector, Phase or Mohallah" 
                                class="w-full px-4 py-3 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs"
                                required
                            >
                        </div>

                        <!-- City & Postal Code Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                    City <span class="text-gold-700">*</span>
                                </label>
                                <div class="relative">
                                    <select 
                                        x-model="city" 
                                        class="w-full appearance-none px-4 py-3 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs font-semibold cursor-pointer"
                                    >
                                        @foreach($pakistaniCities as $cityName)
                                            <option value="{{ $cityName }}">{{ $cityName }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-espresso-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                    Postal Code <span class="text-[10px] text-muted font-normal lowercase">(optional)</span>
                                </label>
                                <input 
                                    type="text" 
                                    x-model="postalCode" 
                                    placeholder="54000" 
                                    class="w-full px-4 py-3 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs font-mono"
                                >
                            </div>
                        </div>

                        <!-- Delivery Notes -->
                        <div>
                            <label class="block text-[11px] uppercase tracking-wider font-bold text-espresso-900 mb-1.5">
                                Special Packaging or Delivery Instructions <span class="text-[10px] text-muted font-normal lowercase">(optional)</span>
                            </label>
                            <textarea 
                                x-model="orderNotes" 
                                rows="2" 
                                placeholder="e.g. Please ring front bell or hand over to building concierge. Call before delivery." 
                                class="w-full px-4 py-2.5 bg-[#FAF7F2]/60 hover:bg-white focus:bg-white border border-ivory-300 focus:border-gold rounded-xl text-xs sm:text-sm text-espresso-950 focus:outline-none focus:ring-4 focus:ring-gold/15 transition-all shadow-2xs resize-none"
                            ></textarea>
                        </div>

                    </div>
                </div>

                <!-- Step 2: Payment Method Section -->
                <div>
                    <div class="flex items-center gap-3 pb-4 border-b border-ivory-200 mb-6">
                        <div class="w-8 h-8 rounded-full bg-espresso text-gold font-bold text-xs flex items-center justify-center shadow-xs border border-gold/30">
                            02
                        </div>
                        <div>
                            <h2 class="font-serif text-base sm:text-lg font-bold text-espresso-950 uppercase tracking-wider">
                                Payment Method
                            </h2>
                            <p class="text-[11px] text-muted font-light -mt-0.5">
                                Choose your preferred transaction mode
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3.5">
                        
                        <!-- Cash on Delivery -->
                        <label 
                            class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl border-2 cursor-pointer transition-all relative overflow-hidden"
                            :class="paymentMethod === 'cod' ? 'border-gold bg-[#FAF7F2] ring-2 ring-gold/20 shadow-xs' : 'border-ivory-300 hover:border-ivory-400 bg-white'"
                        >
                            <div class="pt-0.5">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="cod" 
                                    x-model="paymentMethod" 
                                    class="w-4 h-4 text-gold border-ivory-300 focus:ring-gold"
                                >
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center border border-gold/30">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                                        </div>
                                        <span class="font-serif text-sm sm:text-base font-bold text-espresso-950">Cash on Delivery (Nationwide COD)</span>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200">
                                        Zero Advance Fee
                                    </span>
                                </div>
                                <p class="text-xs text-muted leading-relaxed mt-1.5 pl-9 font-light">
                                    Pay in cash to the registered courier representative upon doorstep delivery after physical parcel inspection.
                                </p>
                            </div>
                        </label>

                        <!-- Direct Bank Transfer -->
                        <label 
                            class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl border-2 cursor-pointer transition-all relative overflow-hidden"
                            :class="paymentMethod === 'bank' ? 'border-gold bg-[#FAF7F2] ring-2 ring-gold/20 shadow-xs' : 'border-ivory-300 hover:border-ivory-400 bg-white'"
                        >
                            <div class="pt-0.5">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="bank" 
                                    x-model="paymentMethod" 
                                    class="w-4 h-4 text-gold border-ivory-300 focus:ring-gold"
                                >
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center border border-gold/30">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 21h18M3 10h18M5 10v11M19 10v11M9 10v11M15 10v11M12 2l10 5H2l10-5z"></path></svg>
                                        </div>
                                        <span class="font-serif text-sm sm:text-base font-bold text-espresso-950">Direct Bank Transfer / Instant IBFT</span>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold text-espresso-800 bg-white border border-ivory-300">
                                        Meezan / HBL / Alfalah
                                    </span>
                                </div>
                                <p class="text-xs text-muted leading-relaxed mt-1.5 pl-9 font-light">
                                    Transfer directly from your banking app. Corporate coordinates provided upon order confirmation.
                                </p>

                                <!-- Expandable IBFT Details when Bank selected -->
                                <div 
                                    x-show="paymentMethod === 'bank'" 
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-4 pt-4 border-t border-ivory-200 pl-9 space-y-2 text-xs"
                                >
                                    <div class="bg-white p-3.5 rounded-xl border border-ivory-300 space-y-1.5 shadow-2xs">
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Corporate Bank:</span>
                                            <span class="font-bold text-espresso-950">Meezan Bank Limited</span>
                                        </div>
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Account Title:</span>
                                            <span class="font-bold text-espresso-950">BY ZUNASH LEATHER ATELIER</span>
                                        </div>
                                        <div class="flex justify-between items-center text-[11px] pt-1 border-t border-ivory-200">
                                            <span class="text-muted">IBAN Coordinates:</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-mono font-bold text-espresso-950 select-all">PK64MEZN0002010108924519</span>
                                                <button 
                                                    type="button" 
                                                    @click.stop="copyIban()" 
                                                    class="px-1.5 py-0.5 bg-ivory-100 hover:bg-gold/20 text-[10px] font-semibold text-espresso-800 rounded border border-ivory-300 transition-colors"
                                                >
                                                    Copy
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-muted font-light italic">
                                        * Please share the IBFT transaction screenshot with our concierge via WhatsApp after placing the order.
                                    </p>
                                </div>
                            </div>
                        </label>

                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 pb-2 space-y-4">
                    <button 
                        type="button" 
                        @click="placeOrder()" 
                        :disabled="isSubmitting"
                        class="w-full h-14 min-h-[56px] py-4 px-6 bg-espresso hover:bg-chocolate-800 text-ivory text-xs sm:text-sm uppercase tracking-widest font-bold rounded-2xl shadow-xl hover:shadow-gold-glow border border-gold/40 flex items-center justify-center gap-3 transition-all active:scale-[0.99] cursor-pointer group disabled:opacity-75"
                    >
                        <template x-if="!isSubmitting">
                            <span class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-gold group-hover:scale-110 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <span>Confirm & Place Order</span>
                                <svg class="w-4 h-4 text-gold/80 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center gap-2.5">
                                <svg class="animate-spin w-4 h-4 text-gold flex-shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span>Securing Your Commission...</span>
                            </span>
                        </template>
                    </button>

                    <!-- Reassurance strip below button -->
                    <div class="text-center text-[11px] text-muted flex items-center justify-center gap-3 sm:gap-4 flex-wrap pt-1 font-light">
                        <span class="flex items-center gap-1.5 text-espresso-900 font-medium">
                            <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            256-Bit SSL Secured
                        </span>
                        <span class="text-ivory-300">•</span>
                        <span>No Card Required for COD</span>
                        <span class="text-ivory-300">•</span>
                        <span>7-Day Hassle-Free Size Exchange</span>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary Sidebar (5 Cols - Sticky on Desktop) -->
            <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-6">
                
                <div class="bg-white p-6 sm:p-7 rounded-3xl border border-ivory-200/90 shadow-md space-y-5">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-ivory-200">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gold/15 text-gold-700 flex items-center justify-center border border-gold/30">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            </div>
                            <h2 class="font-serif text-base font-bold text-espresso-950 uppercase tracking-wider">
                                Order Summary
                            </h2>
                        </div>
                        <span class="text-xs font-bold text-espresso-800 bg-[#FAF7F2] px-2.5 py-1 rounded-full border border-ivory-300">
                            <span x-text="$store.cart.count"></span> item(s)
                        </span>
                    </div>

                    <!-- Items in Cart (Modern Cards + Custom Clean Scrollbar) -->
                    <div class="space-y-3 max-h-80 overflow-y-auto pr-1.5 scrollbar-thin scrollbar-thumb-ivory-300">
                        <template x-for="item in $store.cart.items" :key="item.key">
                            <div class="p-3 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80 flex items-center gap-3.5 group hover:border-gold/30 transition-all shadow-2xs">
                                
                                <img 
                                    :src="item.image" 
                                    :alt="item.name" 
                                    class="w-14 h-16 object-cover rounded-xl bg-white border border-ivory-300 flex-shrink-0 group-hover:scale-102 transition-transform shadow-2xs"
                                >
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-serif text-xs font-bold text-espresso-950 truncate leading-snug" x-text="item.name"></h4>
                                    
                                    <div class="mt-1 flex items-center gap-2 flex-wrap">
                                        <span class="text-[10px] text-espresso-800 font-semibold bg-white px-2 py-0.5 rounded border border-ivory-200" x-show="item.variant" x-text="item.variant"></span>
                                        <span class="text-[11px] text-muted font-light">Qty: <strong class="text-espresso-950 font-bold" x-text="item.quantity"></strong></span>
                                    </div>
                                </div>

                                <div class="text-right flex-shrink-0">
                                    <div class="font-serif text-xs sm:text-sm font-bold text-espresso-950" x-text="'PKR ' + (item.price * item.quantity).toLocaleString()"></div>
                                    <div class="text-[10px] text-muted font-light" x-show="item.quantity > 1" x-text="'@ PKR ' + item.price.toLocaleString()"></div>
                                </div>

                            </div>
                        </template>

                        <!-- If bag is empty -->
                        <template x-if="$store.cart.items.length === 0">
                            <div class="text-center py-8 px-4">
                                <p class="text-xs text-muted mb-3 font-light">Your shopping bag is currently empty.</p>
                                <a href="{{ route('shop') }}" class="text-xs font-bold text-gold-700 hover:underline">
                                    Explore Handcrafted Catalog →
                                </a>
                            </div>
                        </template>
                    </div>

                    <!-- Free Delivery Status Banner -->
                    <div class="p-3 rounded-xl bg-emerald-50/80 border border-emerald-200/80 flex items-center gap-2.5 text-xs text-emerald-900">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span class="text-[11px] font-semibold">
                            Complimentary Priority Nationwide Delivery Unlocked!
                        </span>
                    </div>

                    <!-- Price breakdown -->
                    <div class="space-y-2 text-xs text-espresso-800 pt-3 border-t border-ivory-200">
                        <div class="flex justify-between">
                            <span class="text-muted">Bag Subtotal</span>
                            <span class="font-bold text-espresso-950">PKR <span x-text="$store.cart.subtotal.toLocaleString()"></span></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted">Priority Tracked Shipping (Pakistan)</span>
                            <span class="font-bold" :class="$store.cart.shipping === 0 ? 'text-emerald-700' : 'text-espresso-950'" x-text="$store.cart.shipping === 0 ? 'FREE' : 'PKR ' + $store.cart.shipping"></span>
                        </div>
                        <div class="pt-3 border-t border-ivory-200 flex justify-between text-base font-bold text-espresso-950 font-serif">
                            <span>Estimated Total</span>
                            <span class="text-espresso-950">PKR <span x-text="$store.cart.total.toLocaleString()"></span></span>
                        </div>
                    </div>

                    <!-- Protected Customer Guarantee -->
                    <div class="p-4 bg-[#FAF7F2] rounded-2xl border border-ivory-300 space-y-2.5 text-[11px] text-espresso-900">
                        <div class="font-bold font-serif text-xs uppercase tracking-wider text-espresso-950 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>Atelier Client Guarantees</span>
                        </div>
                        <ul class="space-y-1.5 text-muted font-light pl-6 list-disc">
                            <li>100% Genuine Pakistani Full-Grain Leather</li>
                            <li>Tamper-evident wax-sealed delivery packaging</li>
                            <li>7-Day size & model exchange nationwide</li>
                            <li>Dedicated client concierge hotline: <strong class="text-espresso-900 font-semibold">+92 300 1234567</strong></li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
function checkoutForm() {
    return {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        address: '',
        city: 'Lahore',
        postalCode: '',
        orderNotes: '',
        paymentMethod: 'cod',
        orderPlaced: false,
        orderNumber: '',
        error: '',
        isSubmitting: false,

        copyIban() {
            navigator.clipboard.writeText('PK64MEZN0002010108924519').then(() => {
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast('Meezan Bank IBAN copied to clipboard!', 'success');
                }
            });
        },

        placeOrder() {
            this.error = '';

            if (!this.firstName || !this.lastName || !this.phone || !this.address || !this.city) {
                this.error = 'Please fill out all mandatory shipping details (First Name, Last Name, WhatsApp Phone, Address, City).';
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast(this.error, 'error');
                }
                return;
            }

            if (Alpine.store('cart').items.length === 0) {
                this.error = 'Your shopping bag is empty. Please add handcrafted items before placing an order.';
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast(this.error, 'error');
                }
                return;
            }
            
            this.isSubmitting = true;

            setTimeout(() => {
                this.orderNumber = 'BZ-' + Math.floor(100000 + Math.random() * 900000);
                
                if (window.ZunashAlert) {
                    window.ZunashAlert.success(
                        'Order Placed Successfully!',
                        'Shukriya, <strong>' + this.firstName + '</strong>! Your order reference <strong style="color: #C5A16B; font-family: monospace;">' + this.orderNumber + '</strong> has been recorded. Our client concierge will contact you at <strong>' + this.phone + '</strong> prior to courier dispatch.'
                    ).then(() => {
                        this.orderPlaced = true;
                        this.isSubmitting = false;
                        Alpine.store('cart').clear();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                } else {
                    this.orderPlaced = true;
                    this.isSubmitting = false;
                    Alpine.store('cart').clear();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }, 600);
        }
    };
}
</script>
@endpush
@endsection
