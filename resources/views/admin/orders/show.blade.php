@extends('admin.layouts.app')

@section('title', 'Order #' . $order->order_number . ' | By Zunash Atelier Control Center')

@section('content')

<div class="max-w-6xl mx-auto space-y-6" x-data="{ 
    showReceiptModal: false,
    copyText(text, label) {
        if (!text) return;
        navigator.clipboard.writeText(text);
        if (window.Swal) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: label + ' copied to clipboard!',
                showConfirmButton: false,
                timer: 2000
            });
        }
    }
}">

    <!-- Top Breadcrumb & Responsive Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white dark:bg-[#1A1513] p-5 sm:p-6 rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs text-[#8F8379] flex-wrap">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-tan-600 transition-colors font-medium flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Store Orders</span>
                </a>
                <span>/</span>
                <span class="text-espresso-950 dark:text-white font-mono font-bold">{{ $order->order_number }}</span>
                @if(!$order->is_read)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white shadow-xs animate-pulse">
                        ● New Unread Order
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="font-cinzel text-2xl sm:text-3xl font-extrabold text-espresso-950 dark:text-white tracking-tight">
                    Order {{ $order->order_number }}
                </h1>

                <!-- Order Status Badge -->
                @php
                    $statusStyles = [
                        'pending' => 'bg-amber-50 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300 border-amber-200 dark:border-amber-800/60',
                        'processing' => 'bg-blue-50 text-blue-800 dark:bg-blue-950/50 dark:text-blue-300 border-blue-200 dark:border-blue-800/60',
                        'completed' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60',
                        'cancelled' => 'bg-rose-50 text-rose-800 dark:bg-rose-950/50 dark:text-rose-300 border-rose-200 dark:border-rose-800/60',
                    ];
                    $payStyles = [
                        'paid' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300 border-emerald-200',
                        'pending' => 'bg-amber-50 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300 border-amber-200',
                        'failed' => 'bg-rose-50 text-rose-800 dark:bg-rose-950/50 dark:text-rose-300 border-rose-200',
                    ];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusStyles[$order->order_status] ?? 'bg-gray-100 text-gray-800' }}">
                    <span class="w-2 h-2 rounded-full {{ $order->order_status === 'completed' ? 'bg-emerald-500' : ($order->order_status === 'pending' ? 'bg-amber-500' : ($order->order_status === 'processing' ? 'bg-blue-500' : 'bg-rose-500')) }}"></span>
                    <span class="capitalize">{{ $order->order_status === 'completed' ? 'Delivered' : $order->order_status }}</span>
                </span>

                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $payStyles[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                    <span>Payment:</span>
                    <strong class="uppercase text-[11px]">{{ $order->payment_status }}</strong>
                </span>
            </div>

            <p class="text-xs text-[#8F8379] flex items-center gap-2">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                <span>Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }} ({{ $order->created_at->diffForHumans() }})</span>
            </p>
        </div>

        <!-- Action Button Group -->
        <div class="flex items-center flex-wrap gap-2 pt-2 lg:pt-0">
            <!-- Mark Read / Unread Toggle -->
            <form action="{{ route('admin.orders.toggle-read', $order) }}" method="POST">
                @csrf
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold border {{ $order->is_read ? 'border-[#DFD6CB] dark:border-[#3A2F29] text-gray-600 dark:text-gray-300 hover:bg-[#FAF8F5] dark:hover:bg-[#251D1A]' : 'border-amber-300 bg-amber-50 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300' }} transition-colors"
                    title="{{ $order->is_read ? 'Mark this order as unread' : 'Mark this order as read' }}"
                >
                    <i data-lucide="{{ $order->is_read ? 'mail' : 'mail-open' }}" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span>{{ $order->is_read ? 'Mark Unread' : 'Mark Read' }}</span>
                </button>
            </form>

            <!-- Print Actions Cluster -->
            <div class="inline-flex items-center rounded-xl bg-[#FAF8F5] dark:bg-[#251D1A] border border-[#DFD6CB] dark:border-[#3A2F29] p-1 shadow-2xs">
                <a 
                    href="{{ route('admin.orders.invoice', $order) }}" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-white dark:hover:bg-[#1A1513] transition-colors"
                    title="Print Tax / Commercial Invoice"
                >
                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span class="hidden sm:inline">Invoice</span>
                </a>
                <span class="w-px h-4 bg-[#DFD6CB] dark:bg-[#3A2F29]"></span>
                <a 
                    href="{{ route('admin.orders.packing-slip', $order) }}" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-white dark:hover:bg-[#1A1513] transition-colors"
                    title="Print Courier Packaging & Dispatch Slip"
                >
                    <i data-lucide="package-check" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span class="hidden sm:inline">Packing Slip</span>
                </a>
                <span class="w-px h-4 bg-[#DFD6CB] dark:bg-[#3A2F29]"></span>
                <a 
                    href="{{ route('admin.orders.receipt', $order) }}" 
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-white dark:hover:bg-[#1A1513] transition-colors"
                    title="Print Official Payment Voucher / Settlement Receipt"
                >
                    <i data-lucide="receipt" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span class="hidden sm:inline">Receipt</span>
                </a>
                <span class="w-px h-4 bg-[#DFD6CB] dark:bg-[#3A2F29]"></span>
                <button 
                    type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg text-xs font-semibold text-espresso-900 dark:text-white hover:bg-white dark:hover:bg-[#1A1513] transition-colors"
                    title="Print Entire Order Dossier"
                >
                    <i data-lucide="printer" class="w-3.5 h-3.5 text-tan-600"></i>
                    <span class="hidden sm:inline">Print</span>
                </button>
            </div>

            <!-- Delete Order Button -->
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Permanently delete this order record? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-rose-200 dark:border-rose-900/40 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors"
                    title="Delete Order Record"
                >
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Delete</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Status & Courier Dispatch Grid (2 Responsive Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- Card 1: Fulfillment & Payment Status Card -->
        <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card flex flex-col justify-between">
            <div>
                <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420] mb-4">
                    <span class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-tan-600"></i>
                        <span>Fulfillment & Payment Status</span>
                    </span>
                    <span class="text-[10px] text-muted uppercase font-sans font-normal">Workflow Step</span>
                </h2>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4" x-data="{ currentStatus: '{{ $order->order_status }}' }">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1.5">Order Status</label>
                            <select name="order_status" x-model="currentStatus" class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold focus:outline-hidden focus:border-gold">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>● Pending Order</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>● In Crafting / Processing</option>
                                <option value="dispatched" {{ $order->order_status === 'dispatched' ? 'selected' : '' }}>● In Transit / Dispatched</option>
                                <option value="completed" {{ in_array($order->order_status, ['completed', 'delivered']) ? 'selected' : '' }}>● Delivered & Paid</option>
                                <option value="returned" {{ $order->order_status === 'returned' ? 'selected' : '' }}>● COD Return / Failed Delivery</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>● Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1.5">Payment Clearance</label>
                            <select name="payment_status" class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold focus:outline-hidden focus:border-gold">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending Clearance</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid / Cleared</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Payment Failed</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                    </div>

                    <!-- COD Return / Failed Delivery Details (Shown when Returned is selected) -->
                    <div x-show="currentStatus === 'returned'" x-cloak class="p-3.5 rounded-2xl bg-rose-50/70 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/50 space-y-3">
                        <div class="flex items-center gap-2 text-rose-800 dark:text-rose-300 font-bold text-xs">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                            <span>COD Return & Failed Delivery Reconciliation</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-rose-900 dark:text-rose-300 mb-1">
                                    Return Reason
                                </label>
                                <select name="return_reason" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#1D1412] border border-rose-300 dark:border-rose-800 text-espresso-900 dark:text-white focus:outline-hidden">
                                    <option value="Customer Refused at Doorstep" {{ $order->return_reason === 'Customer Refused at Doorstep' ? 'selected' : '' }}>Customer Refused at Doorstep</option>
                                    <option value="Phone Switched Off / Unreachable" {{ $order->return_reason === 'Phone Switched Off / Unreachable' ? 'selected' : '' }}>Phone Switched Off / Unreachable</option>
                                    <option value="Fake / Prank Order" {{ $order->return_reason === 'Fake / Prank Order' ? 'selected' : '' }}>Fake / Prank Order</option>
                                    <option value="Address Incomplete / Untraceable" {{ $order->return_reason === 'Address Incomplete / Untraceable' ? 'selected' : '' }}>Address Incomplete / Untraceable</option>
                                    <option value="Delayed Delivery by Courier" {{ $order->return_reason === 'Delayed Delivery by Courier' ? 'selected' : '' }}>Delayed Delivery by Courier</option>
                                    <option value="Customer Cancelled via Phone" {{ $order->return_reason === 'Customer Cancelled via Phone' ? 'selected' : '' }}>Customer Cancelled via Phone</option>
                                    <option value="Damaged in Transit" {{ $order->return_reason === 'Damaged in Transit' ? 'selected' : '' }}>Damaged in Transit</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-rose-900 dark:text-rose-300 mb-1">
                                    Courier Return Charge / Freight Loss (PKR)
                                </label>
                                <input 
                                    type="number" 
                                    step="1" 
                                    name="return_courier_charge" 
                                    value="{{ old('return_courier_charge', $order->return_courier_charge ?: 250) }}"
                                    placeholder="e.g. 250"
                                    class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-[#1D1412] border border-rose-300 dark:border-rose-800 text-espresso-900 dark:text-white font-mono font-bold focus:outline-hidden"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-700 text-white font-semibold text-xs shadow-md transition-colors text-center flex items-center justify-center gap-1.5">
                            <i data-lucide="save" class="w-3.5 h-3.5 text-gold"></i>
                            <span>Update Status</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card 2: Courier & One-Click WhatsApp Dispatch Card -->
        <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420] mb-4">
                    <h2 class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="truck" class="w-4 h-4 text-emerald-600"></i>
                        <span>Courier & WhatsApp Dispatch</span>
                    </h2>
                    @if($order->dispatched_at)
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 dark:bg-emerald-950/40 dark:text-emerald-300 px-2.5 py-0.5 rounded-full border border-emerald-200">
                            Dispatched {{ $order->dispatched_at->diffForHumans() }}
                        </span>
                    @endif
                </div>

                <form action="{{ route('admin.orders.courier', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1.5">Courier Service</label>
                            <select name="courier_name" class="w-full px-3 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold focus:outline-hidden focus:border-gold">
                                @foreach(['TCS Express', 'Trax Logistics', 'Leopards Courier', 'PostEx', 'Call Courier', 'M&P Express', 'Rider PK'] as $c)
                                    <option value="{{ $c }}" {{ ($order->courier_name ?: 'TCS Express') === $c ? 'selected' : '' }}>
                                        {{ $c }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1.5">Tracking ID / CN #</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="tracking_number" 
                                    value="{{ old('tracking_number', $order->tracking_number) }}" 
                                    placeholder="e.g. 129384920"
                                    class="w-full pl-3 pr-8 py-2.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono focus:outline-hidden focus:border-gold"
                                >
                                @if($order->tracking_number)
                                    <button 
                                        type="button" 
                                        @click="copyText('{{ $order->tracking_number }}', 'Tracking ID')"
                                        title="Copy Tracking ID"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-tan-600 p-1"
                                    >
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="mark_dispatched" value="1" {{ $order->order_status === 'completed' ? '' : 'checked' }} class="rounded border-[#DFD6CB] text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <span>Mark as Dispatched</span>
                        </label>

                        <div class="flex items-center gap-2">
                            <button type="submit" name="open_whatsapp" value="1" class="px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-md transition-colors flex items-center justify-center gap-1.5 flex-1 sm:flex-initial" title="Save details and immediately launch WhatsApp Web">
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                <span>Save & WhatsApp</span>
                            </button>
                            <button type="submit" class="px-3.5 py-2.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] hover:bg-gray-100 dark:hover:bg-[#241D1A] text-xs font-semibold text-espresso-900 dark:text-white transition-colors">
                                Save Only
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main 2-Column Responsive Layout: Line Items (8 Cols) & Client Dossier (4 Cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Column: Ordered Line Items & Pricing (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-5 sm:p-7">
                <div class="flex items-center justify-between pb-4 border-b border-[#F0EAE1] dark:border-[#2C2420] mb-5">
                    <div>
                        <h2 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">
                            Handcrafted Creations
                        </h2>
                        <span class="text-xs text-[#8F8379]">
                            {{ is_array($order->items) ? count($order->items) : 1 }} distinct article line item(s)
                        </span>
                    </div>
                    <span class="text-[11px] font-mono font-bold text-tan-700 dark:text-gold uppercase tracking-wider bg-[#FAF6F2] dark:bg-[#2A1E18] px-2.5 py-1 rounded-lg border border-tan-200 dark:border-[#3E2A24]">
                        Atelier Catalog
                    </span>
                </div>

                <!-- Products Table / List -->
                <div class="divide-y divide-[#F0EAE1] dark:divide-[#2C2420]">
                    @if(is_array($order->items) && count($order->items) > 0)
                        @foreach($order->items as $item)
                            <div class="py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="relative shrink-0">
                                        <img 
                                            src="{{ $item['image'] ?? '/images/products/prod-reversible-belt.jpg' }}" 
                                            alt="{{ $item['name'] ?? 'By Zunash Article' }}"
                                            class="w-16 h-16 rounded-2xl object-cover border border-[#ECE6DE] dark:border-[#2C2420] bg-[#FAF8F5] dark:bg-[#201A18] shadow-2xs"
                                        >
                                        <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-espresso-900 text-gold text-[10px] font-bold flex items-center justify-center font-mono border border-gold/40">
                                            {{ $item['qty'] ?? ($item['quantity'] ?? 1) }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <div class="font-bold text-sm text-espresso-950 dark:text-white truncate">
                                            {{ $item['name'] ?? 'By Zunash Leather Article' }}
                                        </div>

                                        <!-- Item Variant Badges (Color / Size / Tone) -->
                                        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                            @if(!empty($item['variant']))
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#FAF6F2] dark:bg-[#2A1E18] text-tan-700 dark:text-gold border border-tan-200 dark:border-[#3E2A24]">
                                                    {{ $item['variant'] }}
                                                </span>
                                            @endif

                                            @if(!empty($item['color']) && empty($item['variant']))
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-ivory-100 dark:bg-[#2A201C] text-espresso-900 dark:text-[#E8D0BE] border border-[#E0D7CB]">
                                                    Color: {{ $item['color'] }}
                                                </span>
                                            @endif

                                            @if(!empty($item['size']))
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-ivory-100 dark:bg-[#2A201C] text-espresso-900 dark:text-[#E8D0BE] border border-[#E0D7CB]">
                                                    Size: {{ $item['size'] }}″
                                                </span>
                                            @endif

                                            <span class="text-xs text-[#8F8379]">
                                                Qty: <strong class="text-espresso-950 dark:text-white font-mono">{{ $item['qty'] ?? ($item['quantity'] ?? 1) }}</strong>
                                            </span>

                                            @if(isset($item['sku']))
                                                <span class="text-[10px] font-mono text-gray-400">SKU: {{ $item['sku'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-left sm:text-right shrink-0 pt-1 sm:pt-0 border-t sm:border-t-0 border-gray-100 dark:border-white/5 flex sm:block items-center justify-between">
                                    <div class="font-cinzel font-bold text-sm text-espresso-950 dark:text-white">
                                        Rs. {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? ($item['quantity'] ?? 1))) }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-mono">
                                        @ Rs. {{ number_format($item['price'] ?? 0) }} each
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="py-6 text-center text-xs text-gray-400">
                            Custom bespoke atelier commission items recorded.
                        </div>
                    @endif
                </div>

                <!-- Financial Calculation Summary Breakdown -->
                <div class="pt-5 mt-5 border-t border-[#F0EAE1] dark:border-[#2C2420] space-y-2 text-xs text-[#7A6E64] dark:text-[#A89C91]">
                    <div class="flex justify-between items-center">
                        <span>Items Subtotal:</span>
                        <span class="font-bold text-espresso-950 dark:text-white font-mono">Rs. {{ number_format($order->subtotal) }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="truck" class="w-3.5 h-3.5 text-tan-600"></i>
                            <span>Priority Tracked Shipping (Pakistan):</span>
                        </span>
                        @if(($order->shipping_fee ?? 0) > 0)
                            <span class="font-bold text-espresso-950 dark:text-white font-mono">Rs. {{ number_format($order->shipping_fee) }}</span>
                        @else
                            <span class="font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded-full border border-emerald-200">
                                Complimentary (Zero Fee)
                            </span>
                        @endif
                    </div>

                    @if(($order->discount ?? 0) > 0)
                        <div class="flex justify-between items-center text-amber-700 dark:text-amber-400">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="ticket" class="w-3.5 h-3.5"></i>
                                <span>Voucher / Promotional Discount:</span>
                            </span>
                            <span class="font-bold font-mono">- Rs. {{ number_format($order->discount) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center text-base font-bold text-espresso-950 dark:text-white pt-3 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                        <span>Grand Total Due:</span>
                        <span class="font-cinzel text-xl sm:text-2xl text-tan-700 dark:text-gold-400 font-extrabold tracking-tight">
                            Rs. {{ number_format($order->total) }}
                        </span>
                    </div>

                    <!-- Atelier Unit Profit & Margin Analysis (Admin Secret Accounting) -->
                    <div class="mt-4 p-3.5 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-[#FAF8F5] to-gold/15 dark:from-emerald-950/20 dark:via-[#1D1714] dark:to-gold-950/20 border border-emerald-500/30 space-y-1.5">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="calculator" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Profit & Accounting Breakdown</span>
                            </span>
                            @if($order->order_status === 'returned')
                                <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-700 text-[9px] font-bold">COD Return Loss</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 text-[9px] font-bold">Net Profit</span>
                            @endif
                        </div>

                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                            <span>Estimated Product Purchase Cost (COGS):</span>
                            <span class="font-mono font-bold text-espresso-900 dark:text-white">Rs. {{ number_format($order->total_cost) }}</span>
                        </div>

                        @if($order->order_status === 'returned')
                            <div class="flex justify-between text-xs text-rose-600 font-medium">
                                <span>Return Courier Loss:</span>
                                <span class="font-mono font-bold">- Rs. {{ number_format($order->return_courier_charge ?: 250) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-xs font-bold pt-1.5 border-t border-emerald-500/20 {{ $order->net_profit >= 0 ? 'text-emerald-700 dark:text-emerald-300' : 'text-rose-600' }}">
                            <span>Real Net Cash Profit:</span>
                            <span class="font-mono text-sm">
                                {{ $order->net_profit >= 0 ? '+' : '' }} Rs. {{ number_format($order->net_profit) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Special Delivery Instructions / Bespoke Notes -->
            @if($order->order_notes)
                <div class="p-5 sm:p-6 rounded-3xl bg-[#FAF8F5] dark:bg-[#1F1916] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-tan-700 dark:text-gold mb-2">
                        <i data-lucide="message-square" class="w-4 h-4"></i>
                        <span>Client Delivery Instructions & Bespoke Notes</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#2C2420] text-xs text-[#5E544A] dark:text-[#D5C8BC] italic leading-relaxed">
                        “{{ $order->order_notes }}”
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Client Dossier & Payment Verification (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-5 sm:p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#2C2420]">
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-tan-600"></i>
                        <span>Client Dossier</span>
                    </h2>
                    <span class="text-[10px] font-mono uppercase bg-gold/15 text-gold-700 dark:text-gold px-2 py-0.5 rounded font-bold">
                        Patron
                    </span>
                </div>

                <div class="space-y-4 text-xs">
                    <!-- Client Name & Quick Avatar -->
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-espresso-900 to-tan-700 text-gold font-cinzel font-bold text-sm flex items-center justify-center shrink-0 shadow-xs border border-gold/40">
                            {{ strtoupper(substr($order->customer_name, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Client Name</div>
                            <div class="font-bold text-espresso-950 dark:text-white text-base truncate">{{ $order->customer_name }}</div>
                        </div>
                    </div>

                    <!-- Contact Details with Quick Copy -->
                    <div class="p-3.5 rounded-2xl bg-[#FAF8F5] dark:bg-[#201A18] border border-[#ECE6DE] dark:border-[#2C2420] space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Email</span>
                            <button 
                                type="button" 
                                @click="copyText('{{ $order->customer_email }}', 'Email')"
                                class="text-[10px] text-tan-600 dark:text-gold hover:underline font-semibold flex items-center gap-0.5"
                            >
                                <i data-lucide="copy" class="w-3 h-3"></i>
                                <span>Copy</span>
                            </button>
                        </div>
                        <div class="text-espresso-950 dark:text-white font-medium select-all truncate">{{ $order->customer_email }}</div>

                        <div class="flex items-center justify-between pt-1 border-t border-[#F0EAE1] dark:border-[#2C2420]">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Phone Number</span>
                            @if($order->customer_phone)
                                <button 
                                    type="button" 
                                    @click="copyText('{{ $order->customer_phone }}', 'Phone')"
                                    class="text-[10px] text-tan-600 dark:text-gold hover:underline font-semibold flex items-center gap-0.5"
                                >
                                    <i data-lucide="copy" class="w-3 h-3"></i>
                                    <span>Copy</span>
                                </button>
                            @endif
                        </div>
                        <div class="font-mono font-bold text-espresso-950 dark:text-white text-sm select-all">
                            {{ $order->customer_phone ?: 'No phone provided' }}
                        </div>

                        <!-- 1-Click VIP Communication Buttons -->
                        <div class="flex items-center gap-2 pt-2">
                            @if($order->whatsapp_phone)
                                <a 
                                    href="https://wa.me/{{ $order->whatsapp_phone }}?text={{ urlencode($order->whatsapp_dispatch_message) }}" 
                                    target="_blank" 
                                    class="flex-1 px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-semibold flex items-center justify-center gap-1.5 transition-colors shadow-2xs"
                                    title="Send Personalized Dispatch Message on WhatsApp"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>WhatsApp</span>
                                </a>
                            @endif

                            @if($order->customer_email)
                                <a 
                                    href="mailto:{{ $order->customer_email }}?subject={{ urlencode('Regarding your By Zunash Order #' . $order->order_number) }}" 
                                    class="flex-1 px-3 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-[#201A18] text-[11px] font-semibold flex items-center justify-center gap-1.5 transition-colors"
                                >
                                    <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                                    <span>Email Client</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Destination Address -->
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Shipping Destination</div>
                        <div class="text-espresso-950 dark:text-white leading-relaxed bg-[#FAF8F5] dark:bg-[#201A18] p-3.5 rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420]">
                            <div class="flex items-start gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-tan-600 shrink-0 mt-0.5"></i>
                                <div>
                                    <div class="font-semibold">{{ $order->shipping_address }}</div>
                                    <div class="text-xs text-[#8F8379] mt-0.5">
                                        <strong class="text-espresso-950 dark:text-white">{{ $order->city }}</strong>{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Mode & Verification -->
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Payment Method & Settlement</div>
                        <div class="p-3.5 rounded-2xl bg-[#FAF8F5] dark:bg-[#201A18] border border-[#ECE6DE] dark:border-[#2C2420] space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-tan-600"></span>
                                    @switch($order->payment_method)
                                        @case('BANK_TRANSFER')
                                            Direct Bank Transfer (Instant IBFT)
                                            @break
                                        @case('JAZZCASH')
                                            JazzCash Mobile Wallet
                                            @break
                                        @case('EASYPAISA')
                                            EasyPaisa Mobile Wallet
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
                                <div class="p-2.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#2C2420] flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-[9px] text-[#8F8379] uppercase font-bold block">Transaction Reference / TID</span>
                                        <span class="font-mono font-bold text-espresso-950 dark:text-white select-all">{{ $order->transaction_id }}</span>
                                    </div>
                                    <button 
                                        type="button" 
                                        @click="copyText('{{ $order->transaction_id }}', 'TID')"
                                        class="px-2 py-1 text-[10px] font-bold rounded-lg bg-tan-100 hover:bg-tan-200 text-espresso-900 border border-tan-300 transition-colors"
                                    >
                                        Copy
                                    </button>
                                </div>
                            @endif

                            <!-- Payment Proof Screenshot / Receipt -->
                            @if($order->payment_receipt)
                                <div class="mt-3 p-3 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-emerald-800 dark:text-emerald-300 flex items-center gap-1.5">
                                            <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                            Payment Proof Attached
                                        </span>
                                        <a 
                                            href="{{ $order->payment_receipt }}" 
                                            target="_blank" 
                                            download 
                                            class="text-[11px] font-bold text-emerald-700 hover:underline flex items-center gap-1"
                                        >
                                            <i data-lucide="download" class="w-3 h-3"></i>
                                            <span>Download</span>
                                        </a>
                                    </div>

                                    @if(str_ends_with(strtolower($order->payment_receipt), '.pdf'))
                                        <a href="{{ $order->payment_receipt }}" target="_blank" class="block p-4 rounded-xl bg-white dark:bg-[#161210] text-center hover:bg-emerald-50 transition-colors border border-emerald-300">
                                            <i data-lucide="file-text" class="w-8 h-8 text-rose-600 mx-auto mb-1"></i>
                                            <span class="text-xs font-bold text-espresso-950 dark:text-white">View Attached PDF Voucher</span>
                                        </a>
                                    @else
                                        <!-- Thumbnail with click-to-enlarge modal -->
                                        <div class="relative group rounded-xl overflow-hidden border border-emerald-300/80 dark:border-emerald-700/50 bg-white dark:bg-black/30">
                                            <img 
                                                src="{{ $order->payment_receipt }}" 
                                                alt="Payment Proof" 
                                                class="w-full max-h-48 object-contain cursor-pointer transition-transform duration-200 group-hover:scale-102"
                                                @click="showReceiptModal = true"
                                            >
                                            <div 
                                                @click="showReceiptModal = true"
                                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer text-white text-xs font-bold gap-1.5"
                                            >
                                                <i data-lucide="zoom-in" class="w-4 h-4"></i>
                                                <span>Click to Enlarge</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- High-Resolution Payment Receipt Lightbox Modal -->
    @if($order->payment_receipt && !str_ends_with(strtolower($order->payment_receipt), '.pdf'))
        <div 
            x-show="showReceiptModal" 
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
            @click.self="showReceiptModal = false"
            @keydown.escape.window="showReceiptModal = false"
        >
            <div class="relative bg-white dark:bg-[#1A1412] rounded-3xl max-w-2xl w-full p-4 sm:p-6 shadow-2xl border border-gold/40 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2D231E]">
                    <div class="flex items-center gap-2">
                        <i data-lucide="receipt" class="w-4 h-4 text-tan-600"></i>
                        <span class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white">Payment Proof Screenshot</span>
                        <span class="text-xs font-mono text-muted">({{ $order->order_number }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a 
                            href="{{ $order->payment_receipt }}" 
                            download 
                            class="px-2.5 py-1 text-xs font-bold rounded-lg bg-tan-100 text-espresso-900 hover:bg-tan-200 transition-colors flex items-center gap-1"
                        >
                            <i data-lucide="download" class="w-3 h-3"></i>
                            <span>Save Image</span>
                        </a>
                        <button 
                            type="button" 
                            @click="showReceiptModal = false" 
                            class="w-8 h-8 rounded-full border border-gray-300 dark:border-gray-700 flex items-center justify-center text-gray-500 hover:text-black dark:hover:text-white"
                        >
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-2 my-2 flex items-center justify-center bg-[#FAF8F5] dark:bg-black/50 rounded-2xl">
                    <img 
                        src="{{ $order->payment_receipt }}" 
                        alt="Full Resolution Payment Proof" 
                        class="max-h-[70vh] object-contain rounded-xl shadow-md"
                    >
                </div>
            </div>
        </div>
    @endif

</div>

@push('styles')
<style>
@media print {
    aside, header, nav, .no-print, form[action*="status"], form[action*="destroy"], form[action*="toggle-read"], a[href*="orders.index"], button[onclick*="print"] {
        display: none !important;
    }
    body {
        background: #fff !important;
        color: #000 !important;
    }
    .max-w-6xl {
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
