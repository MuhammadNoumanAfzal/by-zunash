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

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('admin.orders.invoice', $order) }}" 
                target="_blank"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white dark:bg-[#1A1513] border border-[#DFD6CB] dark:border-[#3A2F29] text-xs font-semibold text-espresso-900 dark:text-white hover:border-tan-500 shadow-2xs transition-colors"
            >
                <i data-lucide="printer" class="w-3.5 h-3.5 text-tan-600"></i>
                <span>Print Invoice</span>
            </a>

            <a 
                href="{{ route('admin.orders.index') }}" 
                class="px-4 py-2 rounded-xl border border-[#DFD6CB] text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 transition-colors"
            >
                Back to Orders
            </a>
        </div>
    </div>

    <!-- Status Update Banner Card -->
    <div class="p-5 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            @csrf
            
            <div class="flex items-center gap-4">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Order Fulfillment Status</label>
                    <select name="order_status" class="px-3 py-1.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] text-espresso-900 dark:text-white font-semibold">
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>● Pending</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>● In Crafting / Processing</option>
                        <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>● Delivered & Closed</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>● Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-1">Payment Status</label>
                    <select name="payment_status" class="px-3 py-1.5 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] text-espresso-900 dark:text-white font-semibold">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending Clearance</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid / Cleared</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Payment Failed</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="px-5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors self-start sm:self-end">
                Update Order Status
            </button>
        </form>
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
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-sm text-espresso-950 dark:text-white">
                                        {{ $item['name'] ?? 'By Zunash Leather Article' }}
                                    </div>
                                    <div class="text-xs text-[#8F8379] mt-0.5">
                                        Qty: <span class="font-bold text-espresso-900 dark:text-white">{{ $item['qty'] ?? 1 }}</span>
                                        @if(isset($item['sku'])) • SKU: {{ $item['sku'] }} @endif
                                        @if(isset($item['color'])) • Color: {{ $item['color'] }} @endif
                                    </div>
                                </div>
                                <div class="font-cinzel font-bold text-sm text-espresso-950 dark:text-white">
                                    Rs. {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1)) }}
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

                <div class="space-y-3 text-xs">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Client Name</div>
                        <div class="font-bold text-espresso-950 dark:text-white text-sm mt-0.5">{{ $order->customer_name }}</div>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Contact Details</div>
                        <div class="text-espresso-950 dark:text-white mt-0.5">{{ $order->customer_email }}</div>
                        <div class="text-gray-500 font-mono mt-0.5">{{ $order->customer_phone ?: 'No phone provided' }}</div>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Shipping Destination</div>
                        <div class="text-espresso-950 dark:text-white mt-0.5 leading-relaxed">
                            {{ $order->shipping_address }}<br>
                            {{ $order->city }} {{ $order->postal_code }}
                        </div>
                    </div>

                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Payment Method</div>
                        <div class="mt-1 font-bold text-tan-600">
                            {{ $order->payment_method }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
