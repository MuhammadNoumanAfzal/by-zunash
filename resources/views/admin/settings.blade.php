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

        <!-- Section 3: Pakistani Payment Gateways & Accounts (COD, IBFT, JazzCash, EasyPaisa) -->
        <div class="p-6 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Checkout Payment Methods & Accounts
                    </h2>
                    <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                        Enable or disable payment options on the checkout page and configure your bank & mobile wallet credentials.
                    </p>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gold/15 text-gold-700 dark:text-gold border border-gold/30">
                        Pakistan Gateways
                    </span>
                </div>
            </div>

            <!-- Method 1: Cash on Delivery (COD) -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E8DFD5] dark:border-[#2E241F] space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-bold text-xs border border-emerald-500/30">
                            COD
                        </div>
                        <div>
                            <div class="font-bold text-xs text-espresso-950 dark:text-white">Cash on Delivery (Nationwide COD)</div>
                            <div class="text-[10px] text-gray-400">Collect cash upon doorstep delivery after parcel inspection</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_cod_enabled" value="1" class="sr-only peer" {{ ($settings['payment_cod_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ml-2 text-xs font-semibold text-espresso-900 dark:text-white">Active</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-[#E8DFD5] dark:border-white/5">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Method Display Title</label>
                        <input type="text" name="payment_cod_title" value="{{ $settings['payment_cod_title'] ?? 'Cash on Delivery (Nationwide COD)' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Instruction Subtitle</label>
                        <input type="text" name="payment_cod_desc" value="{{ $settings['payment_cod_desc'] ?? 'Pay in cash to the registered courier representative upon doorstep delivery after physical parcel inspection.' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Method 2: Direct Bank Transfer / IBFT -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E8DFD5] dark:border-[#2E241F] space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/15 text-blue-700 dark:text-blue-400 flex items-center justify-center font-bold text-xs border border-blue-500/30">
                            IBFT
                        </div>
                        <div>
                            <div class="font-bold text-xs text-espresso-950 dark:text-white">Direct Bank Transfer / Instant IBFT</div>
                            <div class="text-[10px] text-gray-400">Receive payment directly into your corporate bank account</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_bank_enabled" value="1" class="sr-only peer" {{ ($settings['payment_bank_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-2 text-xs font-semibold text-espresso-900 dark:text-white">Active</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-2 border-t border-[#E8DFD5] dark:border-white/5">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Bank Name</label>
                        <input type="text" name="payment_bank_name" value="{{ $settings['payment_bank_name'] ?? 'Meezan Bank Limited' }}" placeholder="e.g. Meezan Bank / HBL / Alfalah" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Account Title</label>
                        <input type="text" name="payment_bank_account_title" value="{{ $settings['payment_bank_account_title'] ?? 'BY ZUNASH LEATHER ATELIER' }}" placeholder="e.g. BY ZUNASH" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Account Number (Optional)</label>
                        <input type="text" name="payment_bank_account_number" value="{{ $settings['payment_bank_account_number'] ?? '' }}" placeholder="e.g. 02010108924519" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">IBAN Coordinates (Full 24-character IBAN)</label>
                        <input type="text" name="payment_bank_iban" value="{{ $settings['payment_bank_iban'] ?? '' }}" placeholder="e.g. PK64MEZN0002010108924519" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono uppercase">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Method Display Title</label>
                        <input type="text" name="payment_bank_title" value="{{ $settings['payment_bank_title'] ?? 'Direct Bank Transfer / Instant IBFT' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Client Transfer Instructions</label>
                        <input type="text" name="payment_bank_instructions" value="{{ $settings['payment_bank_instructions'] ?? 'Transfer directly from your banking app. Please attach the transaction receipt / screenshot below.' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Method 3: JazzCash Mobile Account -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E8DFD5] dark:border-[#2E241F] space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-700 dark:text-amber-400 flex items-center justify-center font-bold text-xs border border-amber-500/30">
                            JC
                        </div>
                        <div>
                            <div class="font-bold text-xs text-espresso-950 dark:text-white">JazzCash Mobile Account</div>
                            <div class="text-[10px] text-gray-400">Receive instant mobile payments via JazzCash App or USSD</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_jazzcash_enabled" value="1" class="sr-only peer" {{ ($settings['payment_jazzcash_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                        <span class="ml-2 text-xs font-semibold text-espresso-900 dark:text-white">Active</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-[#E8DFD5] dark:border-white/5">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">JazzCash Account Title</label>
                        <input type="text" name="payment_jazzcash_account_title" value="{{ $settings['payment_jazzcash_account_title'] ?? 'By Zunash Leather Atelier' }}" placeholder="e.g. By Zunash" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">JazzCash Mobile Number</label>
                        <input type="text" name="payment_jazzcash_number" value="{{ $settings['payment_jazzcash_number'] ?? '' }}" placeholder="e.g. 03001234567" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Method Display Title</label>
                        <input type="text" name="payment_jazzcash_title" value="{{ $settings['payment_jazzcash_title'] ?? 'JazzCash Mobile Account' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Client Instructions</label>
                        <input type="text" name="payment_jazzcash_instructions" value="{{ $settings['payment_jazzcash_instructions'] ?? 'Send payment to our JazzCash number and attach the transaction screenshot below.' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Method 4: EasyPaisa Mobile Account -->
            <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E8DFD5] dark:border-[#2E241F] space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/15 text-teal-700 dark:text-teal-400 flex items-center justify-center font-bold text-xs border border-teal-500/30">
                            EP
                        </div>
                        <div>
                            <div class="font-bold text-xs text-espresso-950 dark:text-white">EasyPaisa Mobile Account</div>
                            <div class="text-[10px] text-gray-400">Receive instant payments via EasyPaisa App or USSD</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_easypaisa_enabled" value="1" class="sr-only peer" {{ ($settings['payment_easypaisa_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                        <span class="ml-2 text-xs font-semibold text-espresso-900 dark:text-white">Active</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 border-t border-[#E8DFD5] dark:border-white/5">
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">EasyPaisa Account Title</label>
                        <input type="text" name="payment_easypaisa_account_title" value="{{ $settings['payment_easypaisa_account_title'] ?? 'By Zunash Leather Atelier' }}" placeholder="e.g. By Zunash" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">EasyPaisa Mobile Number</label>
                        <input type="text" name="payment_easypaisa_number" value="{{ $settings['payment_easypaisa_number'] ?? '' }}" placeholder="e.g. 03451234567" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Method Display Title</label>
                        <input type="text" name="payment_easypaisa_title" value="{{ $settings['payment_easypaisa_title'] ?? 'EasyPaisa Mobile Account' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-[11px] font-semibold text-[#6E645E] dark:text-[#C5B8AC] mb-1">Client Instructions</label>
                        <input type="text" name="payment_easypaisa_instructions" value="{{ $settings['payment_easypaisa_instructions'] ?? 'Send payment to our EasyPaisa number and attach the transaction screenshot below.' }}" class="w-full px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#16100E] border border-[#DCD3C7] dark:border-[#382D27] text-espresso-900 dark:text-white">
                    </div>
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
