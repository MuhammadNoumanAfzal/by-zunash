@extends('admin.layouts.app')

@section('title', 'Order #' . $order->order_number . ' | By Zunash Atelier')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-[#8F8379] mb-1">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-tan-600 transition-colors">Orders</a>
                <span>/</span>
                <span class="text-espresso-950 dark:text-white font-mono font-bold">{{ $order->order_number }}</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Order {{ $order->order_number }}
            </h1>
            <p class="text-xs text-[#8F8379] mt-0.5">
                Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
            </p>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Print Actions Group -->
            <div class="inline-flex items-center rounded-xl bg-white dark:bg-[#1A1513] border border-[#DFD6CB] dark:border-[#3A2F29] p-0.5 shadow-2xs">
                <a 
                    href="{{ route('admin.orders.invoice', $order) }}" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#251D1A] transition-colors"
                    title="Print Tax / Commercial Invoice"
                >
                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span>Invoice</span>
                </a>
                <span class="w-px h-4 bg-[#DFD6CB] dark:bg-[#3A2F29]"></span>
                <a 
                    href="{{ route('admin.orders.packing-slip', $order) }}" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#251D1A] transition-colors"
                    title="Print Courier Packaging & Dispatch Slip"
                >
                    <i data-lucide="package-check" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span>Packing Slip</span>
                </a>
                <span class="w-px h-4 bg-[#DFD6CB] dark:bg-[#3A2F29]"></span>
                <a 
                    href="{{ route('admin.orders.receipt', $order) }}" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#251D1A] transition-colors"
                    title="Print Official Payment Voucher / Settlement Receipt"
                >
                    <i data-lucide="receipt" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span>Receipt</span>
                </a>
                <span class="w-px h-4 bg-[#DFD6CB] dark:bg-[#3A2F29]"></span>
                <button 
                    type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-[#FAF8F5] dark:hover:bg-[#251D1A] transition-colors"
                    title="Print Order Summary Page"
                >
                    <i data-lucide="printer" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span>Print Order</span>
                </button>
            </div>

            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Permanently delete this order record?')">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-rose-200 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors"
                    title="Delete Order"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span>Delete</span>
                </button>
            </form>

            <a 
                href="{{ route('admin.orders.index') }}" 
                class="px-3.5 py-2 rounded-xl border border-[#DFD6CB] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 transition-colors"
            >
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Status & Courier Dispatch Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Fulfillment & Payment Status Card -->
        <div class="p-5 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
            <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2 mb-3 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <i data-lucide="check-circle" class="w-4 h-4 text-tan-600"></i>
                <span>Fulfillment & Payment Status</span>
            </h2>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Order Status</label>
                        <select name="order_status" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold">
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>● Pending</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>● In Crafting / Processing</option>
                            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>● Delivered & Closed</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>● Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Payment Status</label>
                        <select name="payment_status" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending Clearance</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid / Cleared</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Payment Failed</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end pt-1">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors text-center">
                        Update Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Courier & One-Click WhatsApp Dispatch Card -->
        <div class="p-5 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                    <i data-lucide="truck" class="w-4 h-4 text-emerald-600"></i>
                    <span>Courier & WhatsApp Dispatch</span>
                </h2>
                @if($order->dispatched_at)
                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full border border-emerald-200">
                        Dispatched {{ $order->dispatched_at->diffForHumans() }}
                    </span>
                @endif
            </div>

            <form action="{{ route('admin.orders.courier', $order) }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Courier Service</label>
                        <select name="courier_name" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold">
                            @foreach(['TCS Express', 'Trax Logistics', 'Leopards Courier', 'PostEx', 'Call Courier', 'M&P Express', 'Rider PK'] as $c)
                                <option value="{{ $c }}" {{ ($order->courier_name ?: 'TCS Express') === $c ? 'selected' : '' }}>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Tracking ID / CN #</label>
                        <input 
                            type="text" 
                            name="tracking_number" 
                            value="{{ old('tracking_number', $order->tracking_number) }}" 
                            placeholder="e.g. 129384920"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                        >
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-1">
                    <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="mark_dispatched" value="1" {{ $order->order_status === 'completed' ? '' : 'checked' }} class="rounded border-[#DFD6CB] text-emerald-600 focus:ring-emerald-500">
                        <span>Mark Dispatched</span>
                    </label>

                    <div class="flex items-center gap-2">
                        <button type="submit" name="open_whatsapp" value="1" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-md transition-colors flex items-center gap-1.5" title="Save details and immediately launch WhatsApp Web">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                            <span>Save & Open WhatsApp</span>
                        </button>
                        <button type="submit" class="px-3 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] hover:bg-gray-100 dark:hover:bg-[#241D1A] text-xs font-semibold text-espresso-900 dark:text-white transition-colors">
                            Save Only
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 2 Column Layout: Order Items & Customer Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Line Items (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-6">
                <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420] mb-4">
                    Handcrafted Creations
                </h2>

                <div class="divide-y divide-[#F0EAE1] dark:divide-[#2C2420]">
                    @if(is_array($order->items) && count($order->items) > 0)
                        @foreach($order->items as $item)
                            <div class="py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <img 
                                        src="{{ $item['image'] ?? '/images/products/prod-reversible-belt.jpg' }}" 
                                        alt="{{ $item['name'] ?? 'By Zunash Article' }}"
                                        class="w-14 h-14 rounded-xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] shrink-0 bg-[#FAF8F5] dark:bg-[#201A18]"
                                    >
                                    <div class="min-w-0">
                                        <div class="font-bold text-sm text-espresso-950 dark:text-white truncate">
                                            {{ $item['name'] ?? 'By Zunash Leather Article' }}
                                        </div>

                                        <!-- Item Variant Badges (Color / Size) -->
                                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                                            @if(!empty($item['variant']))
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#FAF6F2] dark:bg-[#2A1E18] text-tan-700 dark:text-gold-300 border border-tan-200 dark:border-[#3E2A24]">
                                                    {{ $item['variant'] }}
                                                </span>
                                            @endif

                                            @if(!empty($item['color']) && empty($item['variant']))
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-ivory-100 dark:bg-[#2A201C] text-espresso-900 dark:text-[#E8D0BE] border border-[#E0D7CB]">
                                                    Color: {{ $item['color'] }}
                                                </span>
                                            @endif

                                            @if(!empty($item['size']))
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-ivory-100 dark:bg-[#2A201C] text-espresso-900 dark:text-[#E8D0BE] border border-[#E0D7CB]">
                                                    Size: {{ $item['size'] }}″
                                                </span>
                                            @endif

                                            <span class="text-xs text-[#8F8379]">
                                                Qty: <strong class="text-espresso-900 dark:text-white font-mono">{{ $item['qty'] ?? ($item['quantity'] ?? 1) }}</strong>
                                            </span>

                                            @if(isset($item['sku']))
                                                <span class="text-[10px] font-mono text-gray-400">SKU: {{ $item['sku'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <div class="font-cinzel font-bold text-sm text-espresso-950 dark:text-white">
                                        Rs. {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? ($item['quantity'] ?? 1))) }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-mono">
                                        @ Rs. {{ number_format($item['price'] ?? 0) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="py-4 text-xs text-gray-400">
                            Custom bespoke atelier commission items recorded.
                        </div>
                    @endif
                </div>

                <!-- Financial Summary -->
                <div class="pt-4 mt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-1.5 text-xs text-[#7A6E64] dark:text-[#A89C91]">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span class="font-bold text-espresso-950 dark:text-white">Rs. {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>White-Glove Express Shipping:</span>
                        <span class="font-bold text-emerald-600">Complimentary (Pakistan)</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-espresso-950 dark:text-white pt-2 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                        <span>Grand Total:</span>
                        <span class="font-cinzel text-lg text-tan-600 dark:text-gold-400">Rs. {{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Client Order Notes -->
            @if($order->order_notes)
                <div class="p-5 rounded-2xl bg-[#FAF8F5] dark:bg-[#1F1916] border border-[#ECE6DE] dark:border-[#2C2420]">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-tan-600 mb-1">
                        Client Special Delivery Instructions / Bespoke Notes
                    </div>
                    <p class="text-xs text-[#6E6359] dark:text-[#C5B8AC] italic">
                        "{{ $order->order_notes }}"
                    </p>
                </div>
            @endif
        </div>

        <!-- Right: Client & Shipping Details (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-6 space-y-4">
                <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                    Client Dossier
                </h2>

                <div class="space-y-4 text-xs">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Client Name</div>
                        <div class="font-bold text-espresso-950 dark:text-white text-base mt-0.5">{{ $order->customer_name }}</div>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Contact Details</div>
                        <div class="text-espresso-950 dark:text-white mt-0.5">{{ $order->customer_email }}</div>
                        <div class="text-gray-600 dark:text-gray-300 font-mono mt-0.5 font-semibold">{{ $order->customer_phone ?: 'No phone provided' }}</div>

                        <!-- Direct VIP Contact Buttons -->
                        <div class="flex items-center gap-2 mt-2.5">
                            @if($order->whatsapp_phone)
                                <a 
                                    href="https://wa.me/{{ $order->whatsapp_phone }}?text={{ urlencode($order->whatsapp_dispatch_message) }}" 
                                    target="_blank" 
                                    class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                                    title="Send Personalized Dispatch Message on WhatsApp"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>WhatsApp Dispatch</span>
                                </a>
                            @endif

                            @if($order->customer_email)
                                <a 
                                    href="mailto:{{ $order->customer_email }}?subject={{ urlencode('Regarding your By Zunash Order #' . $order->order_number) }}" 
                                    class="px-3 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#201A18] text-[11px] font-semibold flex items-center gap-1.5 transition-colors"
                                >
                                    <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                                    <span>Email Client</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Shipping Destination</div>
                        <div class="text-espresso-950 dark:text-white mt-0.5 leading-relaxed bg-[#FAF8F5] dark:bg-[#201A18] p-3 rounded-xl border border-[#ECE6DE] dark:border-[#2C2420]">
                            {{ $order->shipping_address }}<br>
                            <strong>{{ $order->city }}</strong> {{ $order->postal_code }}
                        </div>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Payment Method & Details</div>
                        <div class="mt-1 font-bold text-tan-600 dark:text-gold-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-tan-600 dark:bg-gold-400"></span>
                            <span>
                                @switch($order->payment_method)
                                    @case('BANK_TRANSFER')
                                        Direct Bank Transfer (Instant IBFT)
                                        @break
                                    @case('JAZZCASH')
                                        JazzCash Mobile Account
                                        @break
                                    @case('EASYPAISA')
                                        EasyPaisa Mobile Account
                                        @break
                                    @case('COD')
                                        Cash on Delivery (Nationwide COD)
                                        @break
                                    @default
                                        {{ $order->payment_method }}
                                @endswitch
                            </span>
                        </div>

                        @if($order->transaction_id)
                            <div class="mt-2 p-2.5 rounded-xl bg-[#FAF8F5] dark:bg-[#201A18] border border-[#ECE6DE] dark:border-[#2C2420] flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-[10px] text-[#8F8379] block">Transaction Reference / TID</span>
                                    <span class="font-mono font-bold text-espresso-950 dark:text-white select-all">{{ $order->transaction_id }}</span>
                                </div>
                                <button 
                                    type="button" 
                                    onclick="navigator.clipboard.writeText('{{ $order->transaction_id }}'); alert('TID copied: {{ $order->transaction_id }}')" 
                                    class="px-2 py-1 text-[10px] font-bold rounded-md bg-tan-100 hover:bg-tan-200 text-espresso-900 border border-tan-300 transition-colors"
                                >
                                    Copy
                                </button>
                            </div>
                        @endif

                        @if($order->payment_receipt)
                            <div class="mt-3 p-3 rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-emerald-800 dark:text-emerald-300 flex items-center gap-1.5">
                                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        Payment Proof Screenshot Attached
                                    </span>
                                    <a 
                                        href="{{ $order->payment_receipt }}" 
                                        target="_blank" 
                                        download 
                                        class="text-[11px] font-bold text-emerald-700 hover:underline flex items-center gap-1"
                                    >
                                        <i data-lucide="download" class="w-3 h-3"></i>
                                        Download
                                    </a>
                                </div>

                                <div class="rounded-lg overflow-hidden border border-emerald-300/60 dark:border-emerald-700/50 max-w-xs">
                                    @if(str_ends_with(strtolower($order->payment_receipt), '.pdf'))
                                        <a href="{{ $order->payment_receipt }}" target="_blank" class="block p-4 bg-white dark:bg-[#161210] text-center hover:bg-emerald-50 transition-colors">
                                            <i data-lucide="file-text" class="w-8 h-8 text-rose-600 mx-auto mb-1"></i>
                                            <span class="text-xs font-bold text-espresso-950 dark:text-white">View Attached PDF Receipt</span>
                                        </a>
                                    @else
                                        <a href="{{ $order->payment_receipt }}" target="_blank" title="Click to view full image in high resolution">
                                            <img 
                                                src="{{ $order->payment_receipt }}" 
                                                alt="Payment Proof" 
                                                class="w-full max-h-56 object-contain bg-white dark:bg-black/40 hover:scale-102 transition-transform cursor-zoom-in"
                                            >
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('styles')
<style>
@media print {
    aside, header, nav, .no-print, form[action*="status"], form[action*="destroy"], a[href*="orders.index"] {
        display: none !important;
    }
    body {
        background: #fff !important;
        color: #000 !important;
    }
    .max-w-4xl {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .shadow-card, .shadow-2xs {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
}
</style>
@endpush

@endsection
