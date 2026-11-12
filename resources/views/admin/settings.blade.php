@extends('admin.layouts.app')

@section('title', 'Store Settings | By Zunash Atelier')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
            Atelier Store Settings
        </h1>
        <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
            Configure boutique identity, currency displays, concierge lines, and nationwide delivery policies.
        </p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] p-6 sm:p-8 shadow-card space-y-6">
        @csrf

        <!-- General Identity -->
        <div>
            <h2 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                Brand & Atelier Identity
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Store Brand Name</label>
                    <input type="text" name="store_name" value="{{ $settings['store_name'] ?? '' }}" placeholder="e.g., By Zunash Atelier" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Tagline</label>
                    <input type="text" name="store_tagline" value="{{ $settings['store_tagline'] ?? '' }}" placeholder="e.g., Luxury Pakistani Leather Goods — Heirloom Craftsmanship" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '' }}" placeholder="e.g., Rs." class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-bold font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Currency Code</label>
                    <input type="text" name="currency_code" value="{{ $settings['currency_code'] ?? '' }}" placeholder="e.g., PKR" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
                </div>
            </div>
        </div>

        <!-- Concierge Hotline & Email -->
        <div>
            <h2 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                Concierge Contact & Operations
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Concierge Email</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" placeholder="e.g., concierge@byzunash.com" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">WhatsApp / Phone Hotline</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="e.g., +92 321 4700545" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Workshop City / Location</label>
                    <input type="text" name="warehouse_city" value="{{ $settings['warehouse_city'] ?? '' }}" placeholder="e.g., Sargodha, Pakistan" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Concierge & Atelier Timing</label>
                    <input type="text" name="store_timing" value="{{ $settings['store_timing'] ?? 'Mon – Sat: 10:00 AM – 8:00 PM PKT' }}" placeholder="e.g., Mon – Sat: 10:00 AM – 8:00 PM PKT" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">Complimentary Shipping Threshold (PKR)</label>
                    <input type="number" name="free_shipping_threshold" value="{{ $settings['free_shipping_threshold'] ?? '' }}" placeholder="e.g., 0 for all free, or 5000" class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
                </div>
            </div>
        </div>

        <!-- Nationwide Delivery & Returns Policy Module -->
        <div>
            <div class="flex items-center justify-between pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <h2 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400">
                    Nationwide Delivery & Return Policies
                </h2>
                <span class="text-[11px] text-[#8F8379]">Auto-syncs with Product Detail Pages</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Major Metros Delivery Timeline
                    </label>
                    <input 
                        type="text" 
                        name="delivery_timeline_metro" 
                        value="{{ $settings['delivery_timeline_metro'] ?? '24–48 Hours (Lahore, Karachi, Islamabad, Rawalpindi)' }}" 
                        placeholder="e.g. 24–48 Hours (Major Cities)" 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Other Cities Delivery Timeline
                    </label>
                    <input 
                        type="text" 
                        name="delivery_timeline_other" 
                        value="{{ $settings['delivery_timeline_other'] ?? '2–3 Business Days (Faisalabad, Multan, Sialkot, Peshawar & nationwide)' }}" 
                        placeholder="e.g. 2–3 Business Days (All other cities)" 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Courier Tracking & Dispatch Note
                    </label>
                    <input 
                        type="text" 
                        name="delivery_courier_partners" 
                        value="{{ $settings['delivery_courier_partners'] ?? 'Dispatched via TCS, Leopards & Trax with real-time SMS tracking updates.' }}" 
                        placeholder="e.g. Dispatched via TCS / Leopards with SMS tracking." 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Cash on Delivery & Open Parcel Inspection Policy
                    </label>
                    <textarea 
                        name="cod_policy_note" 
                        rows="2" 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >{{ $settings['cod_policy_note'] ?? 'Cash on Delivery available nationwide. You can open and inspect the parcel at your doorstep before paying cash to the courier representative. Direct bank transfer is also accepted.' }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Exchange Window Header
                    </label>
                    <input 
                        type="text" 
                        name="exchange_policy_days" 
                        value="{{ $settings['exchange_policy_days'] ?? '7-Day Size & Model Exchange' }}" 
                        placeholder="e.g. 7-Day Size & Model Exchange" 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-espresso-900 dark:text-white mb-1.5">
                        Exchange & Returns Instructions
                    </label>
                    <textarea 
                        name="exchange_policy_note" 
                        rows="2" 
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                    >{{ $settings['exchange_policy_note'] ?? 'If your size or model needs an adjustment, simply WhatsApp our atelier concierge within 7 days of delivery. We will arrange a courier pickup and replacement promptly with zero hassle.' }}</textarea>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] flex justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                Save By Zunash Settings
            </button>
        </div>

    </form>

</div>

@endsection
