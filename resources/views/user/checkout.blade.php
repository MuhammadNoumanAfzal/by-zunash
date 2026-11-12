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
        <nav aria-label="Checkout Progress" class="max-w-xl mx-auto mb-10 no-print" x-show="!orderPlaced">
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
        <div class="mb-10 text-center max-w-2xl mx-auto no-print" x-show="!orderPlaced">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] uppercase tracking-widest font-semibold border border-emerald-200 mb-3 shadow-2xs">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Guest Checkout • No Account Required
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
            class="max-w-2xl mx-auto bg-white p-6 sm:p-10 rounded-3xl border border-gold/40 shadow-2xl text-center relative overflow-hidden print-invoice"
        >
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-gold/10 rounded-full blur-2xl pointer-events-none no-print"></div>
            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-gold/10 rounded-full blur-2xl pointer-events-none no-print"></div>

            <div class="text-[11px] font-cinzel tracking-widest text-[#8F8379] font-bold uppercase mb-2">By Zunash Leather Atelier</div>

            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 rounded-full bg-emerald-50 border-2 border-emerald-300 text-emerald-600 flex items-center justify-center shadow-lg ring-8 ring-emerald-50/50">
                <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            
            <span class="text-xs uppercase tracking-widest text-gold-700 font-serif font-bold">Alhamdulillah • Order Confirmed</span>
            <h2 class="font-serif text-2xl sm:text-4xl font-bold text-espresso-950 mt-1 mb-2">
                Shukriya, <span x-text="firstName" class="text-espresso-900"></span>!
            </h2>
            <p class="text-xs sm:text-sm text-muted mb-6 leading-relaxed max-w-lg mx-auto">
                Your bespoke leather commission has been received with reference <strong class="text-espresso-950 font-mono bg-ivory-100 px-2 py-0.5 rounded border border-ivory-300 select-all" x-text="orderNumber"></strong>. Our client concierge will call or WhatsApp your contact number (<span class="font-semibold text-espresso-950" x-text="phone"></span>) before courier dispatch.
            </p>

            <div class="bg-[#FAF7F2] p-5 sm:p-6 rounded-2xl border border-ivory-300 text-left text-xs text-espresso-800 space-y-3 mb-6 shadow-2xs">
                <div class="flex justify-between items-center border-b border-ivory-200 pb-2">
                    <span class="text-muted">Payment Mode:</span>
                    <span class="font-bold text-espresso-950 flex items-center gap-1.5" x-text="{
                        'cod': 'Cash on Delivery (Nationwide COD)',
                        'bank': 'Direct Bank Transfer (Instant IBFT)',
                        'jazzcash': 'JazzCash Mobile Account',
                        'easypaisa': 'EasyPaisa Mobile Account'
                    }[paymentMethod] || 'Cash on Delivery'"></span>
                </div>

                <div class="flex justify-between items-center border-b border-ivory-200 pb-2" x-show="transactionId">
                    <span class="text-muted">Transaction ID:</span>
                    <span class="font-mono font-bold text-espresso-950 select-all" x-text="transactionId"></span>
                </div>

                <div class="flex justify-between items-center border-b border-ivory-200 pb-2">
                    <span class="text-muted">Delivery Destination:</span>
                    <span class="font-bold text-espresso-950" x-text="city + ', Pakistan'"></span>
                </div>

                <div class="flex justify-between items-start border-b border-ivory-200 pb-2">
                    <span class="text-muted flex-shrink-0">Dispatch Address:</span>
                    <span class="font-semibold text-right max-w-xs text-espresso-950" x-text="address"></span>
                </div>

                <div class="flex justify-between items-center border-b border-ivory-200 pb-2 font-serif text-sm font-bold text-espresso-950">
                    <span class="flex items-center gap-1.5 text-gold-700">
                        <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        Estimated Doorstep Arrival:
                    </span>
                    <span class="text-emerald-700 font-bold">2–4 Business Days</span>
                </div>

                <!-- Ordered Items Breakdown Table in Receipt -->
                <div class="pt-2 divide-y divide-ivory-200" x-show="placedOrderItems && placedOrderItems.length > 0">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] pb-2 flex justify-between">
                        <span>Ordered Items Breakdown</span>
                        <span x-text="placedOrderDate"></span>
                    </div>

                    <template x-for="item in placedOrderItems" :key="'placed-' + item.key">
                        <div class="py-2.5 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <img :src="item.image" class="w-10 h-10 object-cover rounded-lg border border-ivory-300 shrink-0">
                                <div class="min-w-0">
                                    <div class="font-bold text-espresso-950 truncate" x-text="item.name"></div>
                                    <div class="text-[10px] text-muted flex items-center gap-1.5">
                                        <span x-show="item.variant" x-text="item.variant"></span>
                                        <span>•</span>
                                        <span class="font-bold text-espresso-900" x-text="'Qty: ' + item.quantity"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="font-serif font-bold text-espresso-950 shrink-0" x-text="'PKR ' + (item.price * item.quantity).toLocaleString()"></div>
                        </div>
                    </template>

                    <div class="pt-3 space-y-1.5 text-xs">
                        <div class="flex justify-between text-muted">
                            <span>Subtotal:</span>
                            <span class="font-bold text-espresso-900" x-text="'PKR ' + Number(placedOrderSubtotal).toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between text-emerald-700 font-semibold" x-show="placedOrderDiscount > 0">
                            <span>Promo Discount:</span>
                            <span x-text="'- PKR ' + Number(placedOrderDiscount).toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between text-muted">
                            <span>Tracked Delivery:</span>
                            <span class="font-bold text-emerald-700">FREE</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-ivory-300 font-serif text-sm font-bold text-espresso-950">
                            <span>Grand Total:</span>
                            <span class="text-tan-700 font-bold" x-text="'PKR ' + Number(placedOrderTotal).toLocaleString()"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons: Print Slip, WhatsApp, Continue Shopping -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 no-print">
                <button 
                    type="button" 
                    @click="window.print()" 
                    class="w-full sm:w-auto px-5 py-3 bg-tan-600 hover:bg-espresso-900 text-white text-xs uppercase tracking-widest font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer border border-gold/30"
                    title="Print or Save Order Invoice as PDF"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Order Receipt</span>
                </button>

                <a 
                    :href="'https://wa.me/923214700545?text=' + encodeURIComponent('Assalam o Alaikum, I have placed order reference ' + orderNumber + '. Please confirm my order dispatch.')" 
                    target="_blank" 
                    class="w-full sm:w-auto px-5 py-3 bg-emerald-700 hover:bg-emerald-800 text-white text-xs uppercase tracking-widest font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.449.741.964 1.2 0.663.59 1.223.773 1.396.86.173.086.274.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                    <span>WhatsApp Concierge</span>
                </a>

                <a 
                    href="{{ route('shop') }}" 
                    class="w-full sm:w-auto px-5 py-3 bg-espresso hover:bg-chocolate-800 text-ivory text-xs uppercase tracking-widest font-semibold rounded-xl transition-all shadow-md border border-gold/30"
                >
                    Continue Shopping
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
                                        placeholder="321 4700545" 
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

                    @php
                        $codActive = ($storeSettings['payment_cod_enabled'] ?? '1') === '1';
                        $bankActive = ($storeSettings['payment_bank_enabled'] ?? '1') === '1';
                        $jazzcashActive = ($storeSettings['payment_jazzcash_enabled'] ?? '1') === '1';
                        $easypaisaActive = ($storeSettings['payment_easypaisa_enabled'] ?? '1') === '1';
                        $defaultPaymentMethod = $codActive ? 'cod' : ($bankActive ? 'bank' : ($jazzcashActive ? 'jazzcash' : ($easypaisaActive ? 'easypaisa' : 'cod')));
                    @endphp

                    <div class="space-y-3.5">
                        
                        <!-- 1. Cash on Delivery (COD) -->
                        @if($codActive)
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
                                        <span class="font-serif text-sm sm:text-base font-bold text-espresso-950">{{ $storeSettings['payment_cod_title'] ?? 'Cash on Delivery (Nationwide COD)' }}</span>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200">
                                        Zero Advance Fee
                                    </span>
                                </div>
                                <p class="text-xs text-muted leading-relaxed mt-1.5 pl-9 font-light">
                                    {{ $storeSettings['payment_cod_desc'] ?? 'Pay in cash to the registered courier representative upon doorstep delivery after physical parcel inspection.' }}
                                </p>
                            </div>
                        </label>
                        @endif

                        <!-- 2. Direct Bank Transfer (IBFT) -->
                        @if($bankActive)
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
                                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center border border-blue-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 21h18M3 10h18M5 10v11M19 10v11M9 10v11M15 10v11M12 2l10 5H2l10-5z"></path></svg>
                                        </div>
                                        <span class="font-serif text-sm sm:text-base font-bold text-espresso-950">{{ $storeSettings['payment_bank_title'] ?? 'Direct Bank Transfer / Instant IBFT' }}</span>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold text-blue-800 bg-blue-50 border border-blue-200">
                                        {{ $storeSettings['payment_bank_name'] ?? 'Meezan Bank Limited' }}
                                    </span>
                                </div>
                                <p class="text-xs text-muted leading-relaxed mt-1.5 pl-9 font-light">
                                    {{ $storeSettings['payment_bank_instructions'] ?? 'Transfer directly from your banking app. Corporate coordinates provided below.' }}
                                </p>

                                <!-- Expandable IBFT Details when Bank selected -->
                                <div 
                                    x-show="paymentMethod === 'bank'" 
                                    x-transition:enter="transition ease-out duration-300"
                                    class="mt-4 pt-4 border-t border-ivory-200 pl-9 space-y-2 text-xs"
                                >
                                    <div class="bg-white p-3.5 rounded-xl border border-ivory-300 space-y-2 shadow-2xs">
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Corporate Bank:</span>
                                            <span class="font-bold text-espresso-950">{{ $storeSettings['payment_bank_name'] ?? 'Meezan Bank Limited' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Account Title:</span>
                                            <span class="font-bold text-espresso-950">{{ $storeSettings['payment_bank_account_title'] ?? 'BY ZUNASH LEATHER ATELIER' }}</span>
                                        </div>
                                        @if(!empty($storeSettings['payment_bank_account_number']))
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Account Number:</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-mono font-bold text-espresso-950 select-all">{{ $storeSettings['payment_bank_account_number'] }}</span>
                                                <button 
                                                    type="button" 
                                                    @click.stop="copyText('{{ $storeSettings['payment_bank_account_number'] }}')" 
                                                    class="px-1.5 py-0.5 bg-ivory-100 hover:bg-gold/20 text-[10px] font-semibold text-espresso-800 rounded border border-ivory-300 transition-colors"
                                                >
                                                    Copy
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="flex justify-between items-center text-[11px] pt-1 border-t border-ivory-200">
                                            <span class="text-muted">IBAN Coordinates:</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-mono font-bold text-espresso-950 select-all">{{ $storeSettings['payment_bank_iban'] ?? 'PK64MEZN0002010108924519' }}</span>
                                                <button 
                                                    type="button" 
                                                    @click.stop="copyText('{{ $storeSettings['payment_bank_iban'] ?? 'PK64MEZN0002010108924519' }}')" 
                                                    class="px-1.5 py-0.5 bg-ivory-100 hover:bg-gold/20 text-[10px] font-semibold text-espresso-800 rounded border border-ivory-300 transition-colors"
                                                >
                                                    Copy
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endif

                        <!-- 3. JazzCash Mobile Account -->
                        @if($jazzcashActive)
                        <label 
                            class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl border-2 cursor-pointer transition-all relative overflow-hidden"
                            :class="paymentMethod === 'jazzcash' ? 'border-amber-500 bg-[#FAF7F2] ring-2 ring-amber-500/20 shadow-xs' : 'border-ivory-300 hover:border-ivory-400 bg-white'"
                        >
                            <div class="pt-0.5">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="jazzcash" 
                                    x-model="paymentMethod" 
                                    class="w-4 h-4 text-amber-600 border-ivory-300 focus:ring-amber-500"
                                >
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-amber-500/15 text-amber-700 flex items-center justify-center font-bold text-xs border border-amber-500/30">
                                            JC
                                        </div>
                                        <span class="font-serif text-sm sm:text-base font-bold text-espresso-950">{{ $storeSettings['payment_jazzcash_title'] ?? 'JazzCash Mobile Account' }}</span>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200">
                                        JazzCash Instant
                                    </span>
                                </div>
                                <p class="text-xs text-muted leading-relaxed mt-1.5 pl-9 font-light">
                                    {{ $storeSettings['payment_jazzcash_instructions'] ?? 'Send money to our JazzCash mobile account and upload the transaction receipt below.' }}
                                </p>

                                <!-- Expandable JazzCash Details when selected -->
                                <div 
                                    x-show="paymentMethod === 'jazzcash'" 
                                    x-transition:enter="transition ease-out duration-300"
                                    class="mt-4 pt-4 border-t border-ivory-200 pl-9 space-y-2 text-xs"
                                >
                                    <div class="bg-white p-3.5 rounded-xl border border-ivory-300 space-y-2 shadow-2xs">
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Account Title:</span>
                                            <span class="font-bold text-espresso-950">{{ $storeSettings['payment_jazzcash_account_title'] ?? 'By Zunash Leather Atelier' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-[11px] pt-1 border-t border-ivory-200">
                                            <span class="text-muted">JazzCash Mobile Number:</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-mono font-bold text-espresso-950 select-all">{{ $storeSettings['payment_jazzcash_number'] ?? '03001234567' }}</span>
                                                <button 
                                                    type="button" 
                                                    @click.stop="copyText('{{ $storeSettings['payment_jazzcash_number'] ?? '03001234567' }}')" 
                                                    class="px-1.5 py-0.5 bg-ivory-100 hover:bg-amber-100 text-[10px] font-semibold text-espresso-800 rounded border border-ivory-300 transition-colors"
                                                >
                                                    Copy
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endif

                        <!-- 4. EasyPaisa Mobile Account -->
                        @if($easypaisaActive)
                        <label 
                            class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl border-2 cursor-pointer transition-all relative overflow-hidden"
                            :class="paymentMethod === 'easypaisa' ? 'border-teal-500 bg-[#FAF7F2] ring-2 ring-teal-500/20 shadow-xs' : 'border-ivory-300 hover:border-ivory-400 bg-white'"
                        >
                            <div class="pt-0.5">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="easypaisa" 
                                    x-model="paymentMethod" 
                                    class="w-4 h-4 text-teal-600 border-ivory-300 focus:ring-teal-500"
                                >
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-teal-500/15 text-teal-700 flex items-center justify-center font-bold text-xs border border-teal-500/30">
                                            EP
                                        </div>
                                        <span class="font-serif text-sm sm:text-base font-bold text-espresso-950">{{ $storeSettings['payment_easypaisa_title'] ?? 'EasyPaisa Mobile Account' }}</span>
                                    </div>
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold text-teal-800 bg-teal-50 border border-teal-200">
                                        EasyPaisa Instant
                                    </span>
                                </div>
                                <p class="text-xs text-muted leading-relaxed mt-1.5 pl-9 font-light">
                                    {{ $storeSettings['payment_easypaisa_instructions'] ?? 'Send money to our EasyPaisa mobile account and upload the transaction receipt below.' }}
                                </p>

                                <!-- Expandable EasyPaisa Details when selected -->
                                <div 
                                    x-show="paymentMethod === 'easypaisa'" 
                                    x-transition:enter="transition ease-out duration-300"
                                    class="mt-4 pt-4 border-t border-ivory-200 pl-9 space-y-2 text-xs"
                                >
                                    <div class="bg-white p-3.5 rounded-xl border border-ivory-300 space-y-2 shadow-2xs">
                                        <div class="flex justify-between items-center text-[11px]">
                                            <span class="text-muted">Account Title:</span>
                                            <span class="font-bold text-espresso-950">{{ $storeSettings['payment_easypaisa_account_title'] ?? 'By Zunash Leather Atelier' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-[11px] pt-1 border-t border-ivory-200">
                                            <span class="text-muted">EasyPaisa Mobile Number:</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-mono font-bold text-espresso-950 select-all">{{ $storeSettings['payment_easypaisa_number'] ?? '03451234567' }}</span>
                                                <button 
                                                    type="button" 
                                                    @click.stop="copyText('{{ $storeSettings['payment_easypaisa_number'] ?? '03451234567' }}')" 
                                                    class="px-1.5 py-0.5 bg-ivory-100 hover:bg-teal-100 text-[10px] font-semibold text-espresso-800 rounded border border-ivory-300 transition-colors"
                                                >
                                                    Copy
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endif

                        <!-- Advance Payment Screenshot / Receipt Upload Container -->
                        <div 
                            x-show="['bank', 'jazzcash', 'easypaisa'].includes(paymentMethod)" 
                            x-transition:enter="transition ease-out duration-300"
                            class="p-4 sm:p-5 rounded-2xl bg-[#FAF8F5] dark:bg-[#1C1613] border-2 border-tan-400/50 dark:border-tan-600/30 space-y-3.5 shadow-2xs"
                        >
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-tan-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                </div>
                                <div>
                                    <div class="text-xs sm:text-sm font-bold text-espresso-950 dark:text-white">Upload Payment Screenshot / Receipt Proof</div>
                                    <div class="text-[11px] text-[#6E645E] dark:text-[#A89C91]">Attach your transaction receipt to guarantee immediate dispatch priority</div>
                                </div>
                            </div>

                            <!-- File Upload Area with Drag & Drop -->
                            <div class="relative border-2 border-dashed border-[#D5CDC2] dark:border-[#382D27] rounded-xl p-4 text-center hover:border-gold transition-colors bg-white dark:bg-[#16100E]">
                                <input 
                                    type="file" 
                                    id="receiptFileInput"
                                    accept="image/jpeg,image/png,image/webp,image/jpg,application/pdf" 
                                    @change="handleReceiptUpload($event)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                >
                                
                                <template x-if="!receiptPreview">
                                    <div class="space-y-1.5 pointer-events-none py-1">
                                        <svg class="w-7 h-7 mx-auto text-tan-600 dark:text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                        <div class="text-xs font-bold text-espresso-900 dark:text-white">Click or drag payment screenshot here</div>
                                        <div class="text-[10px] text-gray-400">JPG, PNG, WEBP or PDF receipt (Max 10 MB)</div>
                                    </div>
                                </template>

                                <template x-if="receiptPreview">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <template x-if="receiptPreview !== 'pdf'">
                                                <img :src="receiptPreview" class="w-14 h-14 object-cover rounded-xl border border-gray-200 dark:border-white/10 shrink-0">
                                            </template>
                                            <template x-if="receiptPreview === 'pdf'">
                                                <div class="w-14 h-14 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">PDF</div>
                                            </template>
                                            <div class="text-left min-w-0">
                                                <div class="text-xs font-bold text-espresso-950 dark:text-white truncate" x-text="receiptFileName"></div>
                                                <div class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1 mt-0.5">
                                                    <span>✓</span>
                                                    <span>Screenshot Attached</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button 
                                            type="button" 
                                            @click.stop="removeReceipt()"
                                            class="px-2.5 py-1 text-xs font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg border border-rose-200 transition-colors z-20"
                                        >
                                            Change
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <!-- Optional Transaction ID / TID -->
                            <div>
                                <label class="block text-[11px] font-semibold text-espresso-900 dark:text-white mb-1">
                                    Transaction ID / Reference Number (From SMS or Banking App)
                                </label>
                                <input 
                                    type="text" 
                                    x-model="transactionId" 
                                    placeholder="e.g. TID-98421035 or TRX-54019"
                                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#D5CDC2] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono placeholder:text-gray-400 focus:outline-hidden focus:border-gold"
                                >
                            </div>
                        </div>

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
                            <div class="p-3.5 rounded-2xl bg-[#FAF7F2] border border-ivory-200/80 flex items-start gap-3.5 group hover:border-gold/30 transition-all shadow-2xs">
                                
                                <img 
                                    :src="item.image" 
                                    :alt="item.name" 
                                    class="w-14 h-16 object-cover rounded-xl bg-white border border-ivory-300 flex-shrink-0 group-hover:scale-102 transition-transform shadow-2xs"
                                >
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-1">
                                        <h4 class="font-serif text-xs font-bold text-espresso-950 truncate leading-snug" x-text="item.name"></h4>
                                        <div class="font-serif text-xs sm:text-sm font-bold text-espresso-950 flex-shrink-0" x-text="'PKR ' + (item.price * item.quantity).toLocaleString()"></div>
                                    </div>
                                    
                                    <div class="mt-1 flex items-center justify-between gap-2 flex-wrap">
                                        <span class="text-[10px] text-espresso-800 font-semibold bg-white px-2 py-0.5 rounded border border-ivory-200" x-show="item.variant" x-text="item.variant"></span>
                                        <span class="text-[10px] text-muted font-light" x-show="item.quantity > 1" x-text="'@ PKR ' + item.price.toLocaleString()"></span>
                                    </div>

                                    <!-- Interactive Quantity Controls & Remove -->
                                    <div class="mt-2.5 flex items-center justify-between pt-2 border-t border-ivory-200/80">
                                        <div class="h-6 rounded-lg bg-white border border-ivory-300 shadow-2xs flex items-center overflow-hidden">
                                            <button 
                                                type="button" 
                                                @click.stop="$store.cart.updateQuantity(item.key, item.quantity - 1)" 
                                                class="w-6 h-full flex items-center justify-center hover:bg-ivory-100 text-espresso-800 transition-colors focus:outline-none cursor-pointer"
                                                :disabled="item.quantity <= 1"
                                                title="Decrease quantity"
                                            >
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            </button>
                                            <span class="w-6 text-center text-xs font-bold text-espresso-950" x-text="item.quantity"></span>
                                            <button 
                                                type="button" 
                                                @click.stop="$store.cart.updateQuantity(item.key, item.quantity + 1)" 
                                                class="w-6 h-full flex items-center justify-center hover:bg-ivory-100 text-espresso-800 transition-colors focus:outline-none cursor-pointer"
                                                title="Increase quantity"
                                            >
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            </button>
                                        </div>

                                        <button 
                                            type="button" 
                                            @click.stop="$store.cart.removeItem(item.key)" 
                                            class="text-[11px] text-rose-600 hover:text-rose-700 font-semibold hover:underline flex items-center gap-1 cursor-pointer"
                                            title="Remove item"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            <span>Remove</span>
                                        </button>
                                    </div>
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

                    <!-- Promo Code / Coupon Box -->
                    <div class="pt-3 border-t border-ivory-200 space-y-2">
                        <div class="flex items-center gap-2" x-show="!couponApplied">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </span>
                                <input 
                                    type="text" 
                                    x-model="promoInput" 
                                    placeholder="PROMO CODE (e.g. ZUNASH15)" 
                                    style="text-transform: uppercase;"
                                    @keydown.enter.prevent="applyPromoCode()"
                                    class="w-full pl-8 pr-3 py-2 text-xs rounded-xl bg-[#FAF7F2] border border-ivory-300 focus:border-gold focus:outline-none font-mono uppercase tracking-wider text-espresso-950 placeholder:normal-case placeholder:text-muted/60"
                                >
                            </div>
                            <button 
                                type="button" 
                                @click="applyPromoCode()" 
                                :disabled="isValidatingPromo"
                                class="px-3.5 py-2 text-xs font-semibold rounded-xl bg-espresso-900 hover:bg-gold-600 text-white transition-colors disabled:opacity-50 shrink-0"
                            >
                                <span x-show="!isValidatingPromo">Apply</span>
                                <span x-show="isValidatingPromo">Checking...</span>
                            </button>
                        </div>

                        <!-- Active Coupon Badge Banner -->
                        <div x-show="couponApplied" class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs text-emerald-900">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <div>
                                    <span class="font-mono font-bold" x-text="couponCode"></span>
                                    <span class="text-[10px] text-emerald-700 ml-1 font-semibold" x-text="'(' + couponBadge + ')'"></span>
                                </div>
                            </div>
                            <button 
                                type="button" 
                                @click="removeCoupon()" 
                                class="text-xs text-rose-600 hover:text-rose-800 font-semibold transition-colors"
                            >
                                Remove
                            </button>
                        </div>
                    </div>

                    <!-- Price breakdown -->
                    <div class="space-y-2 text-xs text-espresso-800 pt-3 border-t border-ivory-200">
                        <div class="flex justify-between">
                            <span class="text-muted">Bag Subtotal</span>
                            <span class="font-bold text-espresso-950">PKR <span x-text="$store.cart.subtotal.toLocaleString()"></span></span>
                        </div>
                        <template x-if="couponApplied">
                            <div class="flex justify-between text-emerald-700 font-semibold">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    Courtesy Promo (<span x-text="couponBadge"></span>)
                                </span>
                                <span>- PKR <span x-text="discountAmount.toLocaleString()"></span></span>
                            </div>
                        </template>
                        <div class="flex justify-between">
                            <span class="text-muted">Priority Tracked Shipping (Pakistan)</span>
                            <span class="font-bold" :class="$store.cart.shipping === 0 ? 'text-emerald-700' : 'text-espresso-950'" x-text="$store.cart.shipping === 0 ? 'FREE' : 'PKR ' + $store.cart.shipping"></span>
                        </div>
                        <div class="pt-3 border-t border-ivory-200 flex justify-between text-base font-bold text-espresso-950 font-serif">
                            <span>Estimated Total</span>
                            <span class="text-espresso-950">PKR <span x-text="calculatedTotal.toLocaleString()"></span></span>
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
                            <li>Dedicated client concierge hotline: <strong class="text-espresso-900 font-semibold">+92 321 4700545</strong></li>
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
        paymentMethod: '{{ $defaultPaymentMethod ?? 'cod' }}',
        orderPlaced: false,
        orderNumber: '',
        error: '',
        isSubmitting: false,

        // Placed Order Snapshot for Receipt / Print
        placedOrderItems: [],
        placedOrderTotal: 0,
        placedOrderSubtotal: 0,
        placedOrderDiscount: 0,
        placedOrderDate: '',

        // Payment Proof & Screenshot State
        receiptFile: null,
        receiptFileName: '',
        receiptPreview: null,
        transactionId: '',

        handleReceiptUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.receiptFile = file;
            this.receiptFileName = file.name;
            if (file.type === 'application/pdf') {
                this.receiptPreview = 'pdf';
            } else if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => { this.receiptPreview = e.target.result; };
                reader.readAsDataURL(file);
            } else {
                this.receiptPreview = 'file';
            }
        },

        removeReceipt() {
            this.receiptFile = null;
            this.receiptFileName = '';
            this.receiptPreview = null;
            const input = document.getElementById('receiptFileInput');
            if (input) input.value = '';
        },

        copyText(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text);
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast('Copied: ' + text, 'success');
                } else {
                    alert('Copied to clipboard: ' + text);
                }
            }
        },

        // Abandoned cart tracking state
        cartToken: localStorage.getItem('bz_cart_token') || ('bz_' + Math.random().toString(36).substring(2, 12)),
        dropoffTimer: null,

        // Promotional Coupon State
        promoInput: '',
        isValidatingPromo: false,
        couponCode: '',
        couponApplied: false,
        couponBadge: '',
        discountAmount: 0,

        get calculatedTotal() {
            if (!Alpine.store('cart')) return 0;
            const sub = Alpine.store('cart').subtotal || 0;
            const ship = Alpine.store('cart').shipping || 0;
            return Math.max(0, sub - this.discountAmount + ship);
        },

        init() {
            localStorage.setItem('bz_cart_token', this.cartToken);

            // Check if coupon parameter is present in URL (e.g. ?coupon=ZUNASH15 or ?coupon=ATELIER5)
            const urlParams = new URLSearchParams(window.location.search);
            const urlCoupon = urlParams.get('coupon');
            if (urlCoupon) {
                setTimeout(() => {
                    this.applyPromoCode(urlCoupon);
                }, 400);
            }

            // Real-time drop-off watchers
            this.$watch('phone', () => this.syncDropoff());
            this.$watch('firstName', () => this.syncDropoff());
            this.$watch('lastName', () => this.syncDropoff());
            this.$watch('email', () => this.syncDropoff());
            this.$watch('city', () => this.syncDropoff());
            this.$watch('address', () => this.syncDropoff());
        },

        applyPromoCode(customCode = null) {
            const code = (customCode || this.promoInput || '').trim();
            if (!code) {
                if (window.ZunashAlert) window.ZunashAlert.toast('Please enter a promotional code.', 'info');
                return;
            }

            this.isValidatingPromo = true;
            const subtotal = Alpine.store('cart') ? Alpine.store('cart').subtotal : 0;

            fetch('{{ route('coupon.validate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code, subtotal: subtotal })
            })
            .then(res => res.json())
            .then(data => {
                this.isValidatingPromo = false;
                if (data.success) {
                    this.couponCode = data.code;
                    this.couponBadge = data.badge;
                    this.discountAmount = data.discount;
                    this.couponApplied = true;
                    this.promoInput = '';
                    if (window.ZunashAlert) {
                        window.ZunashAlert.toast(data.message, 'success');
                    }
                } else {
                    if (window.ZunashAlert) {
                        window.ZunashAlert.toast(data.message, 'error');
                    }
                }
            })
            .catch(() => {
                this.isValidatingPromo = false;
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast('Unable to validate promo code. Please try again.', 'error');
                }
            });
        },

        removeCoupon() {
            this.couponCode = '';
            this.couponBadge = '';
            this.discountAmount = 0;
            this.couponApplied = false;
            if (window.ZunashAlert) {
                window.ZunashAlert.toast('Promotional code removed.', 'info');
            }
        },

        syncDropoff() {
            clearTimeout(this.dropoffTimer);
            this.dropoffTimer = setTimeout(() => {
                const cleanPhone = (this.phone || '').trim();
                const fullName = ((this.firstName || '') + ' ' + (this.lastName || '')).trim();

                if (cleanPhone.length >= 7 || fullName.length >= 3) {
                    fetch('{{ route('checkout.track-abandoned') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cart_token: this.cartToken,
                            name: fullName,
                            phone: cleanPhone,
                            email: this.email,
                            city: this.city,
                            address: this.address,
                            items: Alpine.store('cart') ? Alpine.store('cart').items : [],
                            subtotal: Alpine.store('cart') ? Alpine.store('cart').subtotal : 0,
                            total: this.calculatedTotal
                        })
                    }).catch(() => {});
                }
            }, 500);
        },

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

            if (!Alpine.store('cart') || Alpine.store('cart').items.length === 0) {
                this.error = 'Your shopping bag is empty. Please add handcrafted items before placing an order.';
                if (window.ZunashAlert) {
                    window.ZunashAlert.toast(this.error, 'error');
                }
                return;
            }
            
            this.isSubmitting = true;

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('first_name', this.firstName);
            formData.append('last_name', this.lastName);
            formData.append('email', this.email || (this.phone.replace(/[^0-9]/g, '') + '@byzunash.store'));
            formData.append('phone', this.phone);
            formData.append('address', this.address);
            formData.append('city', this.city);
            formData.append('postal_code', this.postalCode || '');
            formData.append('order_notes', this.orderNotes || '');
            formData.append('payment_method', this.paymentMethod);
            formData.append('transaction_id', this.transactionId || '');
            if (this.receiptFile) {
                formData.append('payment_receipt_file', this.receiptFile);
            }
            formData.append('coupon_code', this.couponCode || '');
            formData.append('discount', this.discountAmount || 0);
            formData.append('items', JSON.stringify(Alpine.store('cart').items));
            formData.append('subtotal', Alpine.store('cart').subtotal);
            formData.append('total', this.calculatedTotal);

            fetch('{{ route('checkout.process') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                this.isSubmitting = false;
                if (data.success) {
                    this.orderNumber = data.order_number;
                    localStorage.removeItem('bz_cart_token');

                    // Save snapshot of order before clearing shopping bag
                    this.placedOrderItems = JSON.parse(JSON.stringify(Alpine.store('cart').items || []));
                    this.placedOrderTotal = this.calculatedTotal;
                    this.placedOrderSubtotal = Alpine.store('cart').subtotal || 0;
                    this.placedOrderDiscount = this.discountAmount || 0;
                    this.placedOrderDate = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });

                    if (window.ZunashAlert) {
                        window.ZunashAlert.success(
                            'Order Placed Successfully!',
                            'Shukriya, <strong>' + this.firstName + '</strong>! Your order reference <strong style="color: #C5A16B; font-family: monospace;">' + this.orderNumber + '</strong> has been recorded. Our client concierge will contact you at <strong>' + this.phone + '</strong> prior to courier dispatch.'
                        ).then(() => {
                            this.orderPlaced = true;
                            Alpine.store('cart').clear();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                    } else {
                        this.orderPlaced = true;
                        Alpine.store('cart').clear();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                } else {
                    this.error = data.message || 'Something went wrong while placing order.';
                    if (window.ZunashAlert) {
                        window.ZunashAlert.toast(this.error, 'error');
                    }
                }
            })
            .catch(() => {
                this.isSubmitting = false;
                this.orderNumber = 'BZ-' + Math.floor(100000 + Math.random() * 900000);
                this.placedOrderItems = JSON.parse(JSON.stringify(Alpine.store('cart').items || []));
                this.placedOrderTotal = this.calculatedTotal;
                this.placedOrderSubtotal = Alpine.store('cart').subtotal || 0;
                this.placedOrderDiscount = this.discountAmount || 0;
                this.placedOrderDate = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                this.orderPlaced = true;
                Alpine.store('cart').clear();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    };
}
</script>

<style>
@media print {
    header, footer, nav, .no-print, [x-show="!orderPlaced"], #cart-slideover-backdrop, #cart-drawer, .whatsapp-float, button.fixed, a.fixed, a[href*="wa.me"], a[href*="whatsapp"], div.fixed {
        display: none !important;
        visibility: hidden !important;
    }
    body, html, main, .min-h-screen {
        background: #ffffff !important;
        color: #000000 !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .print-invoice {
        max-width: 100% !important;
        border: 1px solid #e5e5e5 !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 24px !important;
    }
}
</style>
@endpush
@endsection
