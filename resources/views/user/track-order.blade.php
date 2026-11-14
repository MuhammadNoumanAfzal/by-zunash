@extends('user.layouts.app')

@section('title', 'Track Your Order & Consignment | By Zunash Luxury Leather Pakistan')
@section('meta_description', 'Track your By Zunash leather order real-time. View atelier crafting status, courier consignment tracking number, and expected doorstep delivery date.')
@section('canonical', route('track-order'))

@section('content')
<div class="bg-[#FAF8F5] min-h-screen py-10 sm:py-16 selection:bg-gold/30 selection:text-espresso-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-8 sm:mb-10">
            <span class="text-xs uppercase tracking-[0.25em] text-tan-700 font-bold block mb-2">CONCIERGE DISPATCH DISPATCH</span>
            <h1 class="font-cinzel text-2xl sm:text-4xl font-bold text-espresso-950 mb-3">
                Track Your Consignment
            </h1>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                Enter your Order Number (e.g., <span class="font-mono font-semibold text-espresso-900">BZ-202611-1234</span>) or your Phone Number to view live dispatch milestones.
            </p>
        </div>

        <!-- Search Bar Box -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-luxury border border-[#ECE6DE] mb-8">
            <form action="{{ route('track-order') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i data-lucide="search" class="w-5 h-5 text-tan-600 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $search }}" 
                        placeholder="Enter Order # or 11-digit Phone (03001234567)" 
                        required
                        class="w-full pl-12 pr-4 py-3.5 text-xs sm:text-sm rounded-2xl bg-[#FAF8F5] border border-[#DFD6CB] text-espresso-950 font-medium focus:outline-none focus:border-tan-600 focus:ring-2 focus:ring-tan-600/20 transition-all placeholder:text-gray-400"
                    >
                </div>
                <button 
                    type="submit" 
                    class="px-7 py-3.5 rounded-2xl bg-espresso-950 hover:bg-chocolate-800 text-gold font-serif text-xs uppercase tracking-widest font-bold shadow-md hover:shadow-lg transition-all active:scale-98 flex items-center justify-center gap-2"
                >
                    <i data-lucide="compass" class="w-4 h-4"></i>
                    <span>Track Order</span>
                </button>
            </form>

            <div class="flex items-center justify-center gap-4 mt-4 pt-3 border-t border-[#F2ECE4] text-[11px] text-gray-500">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Doorstep Inspection Allowed</span>
                </span>
                <span class="text-gray-300">•</span>
                <span class="flex items-center gap-1.5">
                    <i data-lucide="truck" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span>Express Air Courier</span>
                </span>
            </div>
        </div>

        <!-- Result Container -->
        @if($searched && $order)
            @php
                $status = $order->order_status;
                $isConfirmed = $order->confirmed_at || in_array($status, ['confirmed', 'processing', 'dispatched', 'delivered', 'completed']);
                $isProcessing = in_array($status, ['processing', 'dispatched', 'delivered', 'completed']);
                $isDispatched = in_array($status, ['dispatched', 'delivered', 'completed']);
                $isDelivered = in_array($status, ['delivered', 'completed']);
            @endphp

            <div class="space-y-6">
                <!-- Order Status Banner -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-luxury border border-[#ECE6DE]">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#F0EAE1]">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-mono font-bold text-sm sm:text-base text-tan-700">
                                    {{ $order->order_number }}
                                </span>
                                @if($isDelivered)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        DELIVERED & PAID
                                    </span>
                                @elseif($isDispatched)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800 border border-sky-300">
                                        IN TRANSIT WITH COURIER
                                    </span>
                                @elseif($isProcessing)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                        ATELIER PACKING & QC
                                    </span>
                                @elseif($isConfirmed)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-300">
                                        ORDER CONFIRMED
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                        PENDING VERIFICATION
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500">
                                Consignee: <strong class="text-espresso-950">{{ $order->customer_name }}</strong> • {{ $order->city }}
                            </div>
                        </div>

                        <div class="sm:text-right">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400">TOTAL DUE ({{ $order->payment_method }})</div>
                            <div class="font-cinzel text-xl sm:text-2xl font-bold text-espresso-950">
                                Rs. {{ number_format($order->total) }}
                            </div>
                            @if($order->payment_method === 'COD')
                                <div class="text-[10px] text-emerald-700 font-semibold">Pay cash upon inspection at your doorstep</div>
                            @else
                                <div class="text-[10px] text-emerald-700 font-semibold">Prepaid order — Zero cash collection</div>
                            @endif
                        </div>
                    </div>

                    <!-- 5-Stage Visual Progress Timeline -->
                    <div class="py-8">
                        <div class="relative">
                            <!-- Background line -->
                            <div class="hidden md:block absolute top-1/2 left-6 right-6 -translate-y-1/2 h-1 bg-[#ECE6DE] -z-0"></div>

                            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 md:gap-2 relative z-10">
                                
                                <!-- Stage 1: Order Placed -->
                                <div class="flex md:flex-col items-center gap-3.5 text-left md:text-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-md shrink-0">
                                        <i data-lucide="file-check" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-espresso-950">Order Placed</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">
                                            {{ $order->created_at ? $order->created_at->format('M d, h:i A') : 'Recorded' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Stage 2: WhatsApp Confirmed -->
                                <div class="flex md:flex-col items-center gap-3.5 text-left md:text-center">
                                    <div class="w-10 h-10 rounded-full {{ $isConfirmed ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-300' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold {{ $isConfirmed ? 'text-espresso-950' : 'text-gray-400' }}">Confirmed</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">
                                            {{ $order->confirmed_at ? $order->confirmed_at->format('M d, h:i A') : ($isConfirmed ? 'Verified via WA' : 'Pending verification') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Stage 3: Atelier QC & Boxing -->
                                <div class="flex md:flex-col items-center gap-3.5 text-left md:text-center">
                                    <div class="w-10 h-10 rounded-full {{ $isProcessing ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-300' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="package" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold {{ $isProcessing ? 'text-espresso-950' : 'text-gray-400' }}">Crafting & QC</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">
                                            {{ $isProcessing ? 'Inspected & Sealed' : 'Queued in Atelier' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Stage 4: Dispatched & In Transit -->
                                <div class="flex md:flex-col items-center gap-3.5 text-left md:text-center">
                                    <div class="w-10 h-10 rounded-full {{ $isDispatched ? 'bg-sky-600 text-white shadow-md animate-bounce' : 'bg-gray-100 text-gray-400 border border-gray-300' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="truck" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold {{ $isDispatched ? 'text-sky-700' : 'text-gray-400' }}">In Transit</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">
                                            @if($order->courier_name)
                                                {{ $order->courier_name }}
                                            @else
                                                {{ $isDispatched ? 'Handed to Courier' : 'Awaiting Courier' }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Stage 5: Delivered -->
                                <div class="flex md:flex-col items-center gap-3.5 text-left md:text-center">
                                    <div class="w-10 h-10 rounded-full {{ $isDelivered ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-300' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold {{ $isDelivered ? 'text-emerald-700' : 'text-gray-400' }}">Delivered</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">
                                            {{ $isDelivered ? ($order->delivered_at ? $order->delivered_at->format('M d') : 'Completed') : 'Estimated 2-3 days' }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Courier Live Tracking Info (If Dispatched) -->
                    @if($order->courier_name || $order->tracking_number)
                        <div class="p-4 sm:p-5 rounded-2xl bg-[#FAF8F5] border border-[#ECE6DE] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white border border-[#DFD6CB] flex items-center justify-center text-tan-700 shrink-0">
                                    <i data-lucide="navigation" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-espresso-950">
                                        Consignment Handed to {{ $order->courier_name ?: 'Courier Express' }}
                                    </div>
                                    <div class="text-[11px] text-gray-600 mt-0.5 font-mono">
                                        Tracking CN: <strong>{{ $order->tracking_number ?: 'Assigned upon departure' }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if($order->tracking_link)
                                <a 
                                    href="{{ $order->tracking_link }}" 
                                    target="_blank" 
                                    class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors shadow-2xs"
                                >
                                    <span>Track on {{ $order->courier_name ?: 'Courier' }} Portal</span>
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                </a>
                            @endif
                        </div>
                    @endif

                </div>

                <!-- Parcel Contents & Shipping Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Items -->
                    <div class="bg-white rounded-3xl p-6 shadow-luxury border border-[#ECE6DE]">
                        <h2 class="font-cinzel text-xs font-bold uppercase tracking-wider text-espresso-950 mb-4 pb-2 border-b border-[#F0EAE1]">
                            Enclosed Luxury Items ({{ count($order->items ?? []) }})
                        </h2>
                        <div class="space-y-3.5">
                            @if(is_array($order->items))
                                @foreach($order->items as $it)
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-[#FAF8F5] border border-[#ECE6DE] overflow-hidden shrink-0 flex items-center justify-center">
                                            @if(!empty($it['image']))
                                                <img src="{{ $it['image'] }}" alt="{{ $it['name'] ?? '' }}" class="w-full h-full object-cover">
                                            @else
                                                <i data-lucide="shopping-bag" class="w-5 h-5 text-tan-600"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs font-bold text-espresso-950 truncate">
                                                {{ $it['name'] ?? 'Leather Item' }}
                                            </div>
                                            <div class="text-[10px] text-gray-500 mt-0.5">
                                                Qty: {{ $it['quantity'] ?? 1 }}
                                                @if(!empty($it['size'])) • Size: {{ $it['size'] }} @endif
                                                @if(!empty($it['color'])) • {{ $it['color'] }} @endif
                                            </div>
                                        </div>
                                        <div class="font-mono text-xs font-bold text-espresso-950">
                                            Rs. {{ number_format(($it['price'] ?? 0) * ($it['quantity'] ?? 1)) }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Destination & Concierge Helpline -->
                    <div class="bg-white rounded-3xl p-6 shadow-luxury border border-[#ECE6DE] flex flex-col justify-between">
                        <div>
                            <h2 class="font-cinzel text-xs font-bold uppercase tracking-wider text-espresso-950 mb-4 pb-2 border-b border-[#F0EAE1]">
                                Shipping Destination
                            </h2>
                            <div class="text-xs text-gray-700 leading-relaxed space-y-1">
                                <div class="font-bold text-espresso-950 text-sm">{{ $order->customer_name }}</div>
                                <div>📞 {{ $order->customer_phone }}</div>
                                <div>📍 {{ $order->shipping_address }}</div>
                                <div class="font-bold uppercase tracking-wider text-tan-700 pt-1">{{ $order->city }}</div>
                            </div>
                        </div>

                        <!-- Direct WhatsApp Concierge Help -->
                        <div class="pt-6 border-t border-[#F0EAE1] mt-4">
                            <div class="text-[11px] text-gray-500 mb-2">Have a question regarding delivery time or need address revision?</div>
                            <a 
                                href="https://wa.me/{{ $order->whatsapp_phone }}?text={{ urlencode('Salam By Zunash team, I would like to inquire about my order #' . $order->order_number) }}" 
                                target="_blank"
                                class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs flex items-center justify-center gap-2 shadow-2xs transition-colors"
                            >
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Message Concierge on WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        @elseif($searched && !$order)
            <!-- Not Found State -->
            <div class="bg-white rounded-3xl p-8 sm:p-12 text-center shadow-luxury border border-[#ECE6DE] max-w-xl mx-auto">
                <div class="w-14 h-14 rounded-full bg-amber-50 border border-amber-200 text-amber-600 mx-auto flex items-center justify-center mb-4">
                    <i data-lucide="help-circle" class="w-7 h-7"></i>
                </div>
                <h2 class="font-cinzel text-xl font-bold text-espresso-950 mb-2">Order Not Found</h2>
                <p class="text-xs text-gray-600 mb-6 leading-relaxed">
                    We could not locate an order matching "<span class="font-mono font-semibold">{{ $search }}</span>". Please ensure you entered the complete Order Number (e.g., <span class="font-mono">BZ-202611-1234</span>) or the exact 11-digit phone number provided during checkout.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a 
                        href="{{ route('track-order') }}" 
                        class="px-5 py-2.5 rounded-xl border border-[#DFD6CB] text-xs font-semibold text-espresso-950 hover:bg-[#FAF8F5] transition-colors"
                    >
                        Try Another Search
                    </a>
                    <a 
                        href="https://wa.me/923000000000?text={{ urlencode('Salam By Zunash team, I need help locating my order: ' . $search) }}" 
                        target="_blank"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center justify-center gap-2 transition-colors shadow-2xs"
                    >
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Ask WhatsApp Concierge</span>
                    </a>
                </div>
            </div>

        @else
            <!-- Default Landing Highlights -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                <div class="bg-white rounded-3xl p-6 shadow-luxury border border-[#ECE6DE] text-center">
                    <div class="w-12 h-12 rounded-2xl bg-tan-50 text-tan-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="eye" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-cinzel text-sm font-bold text-espresso-950 mb-1.5">Doorstep Parcel Inspection</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Every patron across Pakistan is invited to open and inspect the leather grain, stitching, and hardware at their doorstep before paying Cash on Delivery.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-luxury border border-[#ECE6DE] text-center">
                    <div class="w-12 h-12 rounded-2xl bg-tan-50 text-tan-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="plane" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-cinzel text-sm font-bold text-espresso-950 mb-1.5">Air Express Consignment</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Dispatched via top courier partners (TCS, Trax, Leopards, PostEx) with real-time tracking SMS and overnight priority air routes.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-luxury border border-[#ECE6DE] text-center">
                    <div class="w-12 h-12 rounded-2xl bg-tan-50 text-tan-700 mx-auto flex items-center justify-center mb-3">
                        <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-cinzel text-sm font-bold text-espresso-950 mb-1.5">7-Day Fit Guarantee</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Need a different belt waist size or color? Our concierge arranges doorstep size replacement without unnecessary interrogations.
                    </p>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

