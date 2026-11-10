@extends('admin.layouts.app')

@section('title', 'Store Orders & Dispatch | By Zunash Atelier')

@section('content')

<div class="space-y-6" x-data="{
    selectedOrders: [],
    selectAll: false,
    toggleAll(checked) {
        if (checked) {
            this.selectedOrders = Array.from(document.querySelectorAll('.order-chk')).map(el => el.value);
        } else {
            this.selectedOrders = [];
        }
    },
    submitBulk(action) {
        if (this.selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }
        if (action === 'delete' && !confirm('Permanently delete ' + this.selectedOrders.length + ' selected order(s)?')) {
            return;
        }
        const form = document.getElementById('bulkActionForm');
        document.getElementById('bulkActionInput').value = action;
        if (action === 'print_slips') {
            form.target = '_blank';
        } else {
            form.target = '_self';
        }
        form.submit();
    }
}">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Store Orders & Dispatch
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Manage luxury orders, track courier consignments (TCS, Trax, Leopards, PostEx), send 1-click WhatsApp dispatch alerts, and process bulk fulfillment.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a 
                href="{{ route('admin.orders.print-report', request()->query()) }}" 
                target="_blank"
                class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] text-xs font-semibold text-espresso-950 dark:text-white hover:border-tan-500 shadow-2xs transition-colors flex items-center gap-1.5"
                title="Print Orders Summary Report & Dispatch Manifest"
            >
                <i data-lucide="printer" class="w-3.5 h-3.5 text-tan-600"></i>
                <span>Print Report</span>
            </a>

            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] text-xs font-bold text-tan-600 dark:text-gold-400 shadow-2xs font-mono">
                Total Revenue: Rs. {{ number_format($totalRevenue) }}
            </span>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.orders.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-tan-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">TOTAL ORDERS</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">{{ $totalOrders }}</div>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-emerald-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">DELIVERED & CLOSED</div>
            <div class="font-cinzel text-2xl font-bold text-emerald-600 mt-1">{{ $completedOrders }}</div>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-amber-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">PENDING DISPATCH</div>
            <div class="font-cinzel text-2xl font-bold text-amber-600 mt-1">{{ $pendingOrders }}</div>
        </a>
        <a href="{{ route('admin.orders.index', ['payment' => 'COD']) }}" class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs hover:border-tan-500 transition-colors">
            <div class="text-[10px] font-bold uppercase tracking-wider text-tan-600">CASH ON DELIVERY (COD)</div>
            <div class="font-cinzel text-2xl font-bold text-tan-600 mt-1">{{ \App\Models\Order::where('payment_method', 'COD')->count() }}</div>
        </a>
    </div>

    <!-- Filter Bar Card -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
            
            <div class="lg:col-span-5 relative">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Search by order #, client name, email, city..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
            </div>

            <div class="lg:col-span-3">
                <select name="status" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    <option value="all">Order Status: All</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed / Delivered</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="lg:col-span-3">
                <select name="payment" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    <option value="all">Payment Method: All</option>
                    <option value="COD" {{ request('payment') === 'COD' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                    <option value="BANK_TRANSFER" {{ request('payment') === 'BANK_TRANSFER' ? 'selected' : '' }}>Bank Transfer (IBFT)</option>
                    <option value="CREDIT_CARD" {{ request('payment') === 'CREDIT_CARD' ? 'selected' : '' }}>Card Online</option>
                    <option value="VIP_CONCIERGE" {{ request('payment') === 'VIP_CONCIERGE' ? 'selected' : '' }}>VIP Concierge Invoice</option>
                </select>
            </div>

            <div class="sm:col-span-2 lg:col-span-1">
                <button type="submit" class="w-full py-2 px-3 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-colors">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span class="sm:hidden lg:hidden">Filter</span>
                </button>
            </div>

        </form>
    </div>

    <!-- Bulk Action Toolbar (Active when 1 or more orders checked) -->
    <div 
        x-show="selectedOrders.length > 0" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="p-3.5 sm:p-4 rounded-2xl bg-espresso-950 text-white shadow-xl border border-tan-600/30 flex flex-wrap items-center justify-between gap-3 sticky top-4 z-20"
        style="display: none;"
    >
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-tan-600 text-white font-bold text-xs shadow-inner" x-text="selectedOrders.length"></span>
            <div>
                <div class="text-xs font-bold text-white tracking-wide">
                    <span x-text="selectedOrders.length"></span> Orders Selected for Bulk Dispatch
                </div>
                <div class="text-[10px] text-[#C5B8AC]">
                    Print bulk packing slips, mark dispatched, or download courier manifest
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <!-- Bulk Mark Dispatched -->
            <button 
                type="button" 
                @click="submitBulk('dispatch')" 
                class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                title="Mark all selected orders as Dispatched"
            >
                <i data-lucide="truck" class="w-3.5 h-3.5"></i>
                <span>Mark Dispatched</span>
            </button>

            <!-- Bulk Print Packing Slips -->
            <button 
                type="button" 
                @click="submitBulk('print_slips')" 
                class="px-3.5 py-1.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-2xs"
                title="Open unified multi-page printable packing slips in a new tab"
            >
                <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                <span>Print Packing Slips</span>
            </button>

            <!-- Bulk Export CSV -->
            <button 
                type="button" 
                @click="submitBulk('export_csv')" 
                class="px-3.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold flex items-center gap-1.5 transition-colors border border-white/20"
                title="Export CSV formatted for TCS / Trax / PostEx Booking Sheet"
            >
                <i data-lucide="download" class="w-3.5 h-3.5 text-gold-400"></i>
                <span>Export Courier CSV</span>
            </button>

            <!-- Clear Selection -->
            <button 
                type="button" 
                @click="selectedOrders = []; selectAll = false" 
                class="px-2.5 py-1.5 text-xs text-gray-400 hover:text-white transition-colors"
            >
                Deselect
            </button>
        </div>
    </div>

    <!-- Hidden Form for Bulk Action Submissions -->
    <form id="bulkActionForm" action="{{ route('admin.orders.bulk-action') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="action" id="bulkActionInput" value="">
        <template x-for="id in selectedOrders" :key="id">
            <input type="hidden" name="order_ids[]" :value="id">
        </template>
    </form>

    <!-- Orders Table & Mobile Cards -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        
        <!-- Mobile Card List (Visible on < 640px) -->
        <div class="block sm:hidden divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
            @forelse($orders as $order)
                <div class="p-4 hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors space-y-2.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <input 
                                type="checkbox" 
                                value="{{ $order->id }}" 
                                x-model="selectedOrders" 
                                class="order-chk rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500"
                            >
                            <span class="font-mono font-bold text-xs text-tan-600 dark:text-gold-400 truncate">
                                {{ $order->order_number }}
                            </span>
                            @if($order->order_status === 'completed')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Delivered
                                </span>
                            @elseif($order->order_status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @elseif($order->order_status === 'processing')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    In Crafting
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 shrink-0">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            @endif
                        </div>

                        <div class="font-cinzel font-bold text-sm text-espresso-950 dark:text-white shrink-0">
                            Rs. {{ number_format($order->total) }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-[#6E6359] dark:text-[#C5B8AC]">
                        <div class="min-w-0 flex-1 pr-2">
                            <div class="font-bold text-espresso-950 dark:text-white truncate">
                                {{ $order->customer_name }}
                            </div>
                            <div class="text-[11px] text-gray-400 truncate">
                                {{ $order->city }} • {{ $order->created_at ? $order->created_at->format('M d, Y') : '—' }}
                            </div>
                            @if($order->courier_name)
                                <div class="text-[10px] text-emerald-600 font-semibold mt-0.5">
                                    {{ $order->courier_name }} @if($order->tracking_number) (#{{ $order->tracking_number }}) @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            <!-- Direct WhatsApp Concierge Button -->
                            @if($order->whatsapp_phone)
                                <a 
                                    href="https://wa.me/{{ $order->whatsapp_phone }}?text={{ urlencode($order->whatsapp_dispatch_message) }}" 
                                    target="_blank" 
                                    class="w-7 h-7 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white inline-flex items-center justify-center shadow-2xs transition-colors"
                                    title="WhatsApp: Send Dispatched Notification"
                                >
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                </a>
                            @endif

                            <button 
                                type="button" 
                                onclick="openQuickCourierModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->courier_name ?: 'TCS Express' }}', '{{ $order->tracking_number }}', '{{ $order->whatsapp_phone }}', '{{ addslashes($order->whatsapp_dispatch_message) }}')"
                                class="w-7 h-7 rounded-full border border-emerald-300 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 inline-flex items-center justify-center transition-colors"
                                title="Quick Courier Dispatch"
                            >
                                <i data-lucide="truck" class="w-3.5 h-3.5"></i>
                            </button>

                            <a 
                                href="{{ route('admin.orders.show', $order) }}" 
                                class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-espresso-900 hover:bg-tan-600 text-white transition-colors"
                            >
                                Details →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-xs text-gray-400">
                    No orders match the selected criteria.
                </div>
            @endforelse
        </div>

        <!-- Desktop / Tablet Table (Visible on >= 640px) -->
        <div class="hidden sm:block overflow-x-auto w-full max-w-full">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-3 w-8 text-center">
                            <input 
                                type="checkbox" 
                                x-model="selectAll" 
                                @change="toggleAll($event.target.checked)" 
                                class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500 cursor-pointer"
                                title="Select All Orders on Page"
                            >
                        </th>
                        <th class="py-3 px-3 whitespace-nowrap">ORDER #</th>
                        <th class="py-3 px-3">CUSTOMER</th>
                        <th class="py-3 px-3">CITY</th>
                        <th class="py-3 px-3 whitespace-nowrap">AMOUNT</th>
                        <th class="py-3 px-3">PAYMENT</th>
                        <th class="py-3 px-3">COURIER & STATUS</th>
                        <th class="py-3 px-3 whitespace-nowrap">DATE</th>
                        <th class="py-3 px-4 text-right">DISPATCH & ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors" :class="selectedOrders.includes('{{ $order->id }}') ? 'bg-tan-50/50 dark:bg-[#2A201C]/50' : ''">
                            <td class="py-3.5 px-3 text-center">
                                <input 
                                    type="checkbox" 
                                    value="{{ $order->id }}" 
                                    x-model="selectedOrders" 
                                    class="order-chk rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500 cursor-pointer"
                                >
                            </td>

                            <td class="py-3.5 px-3 font-mono font-bold text-tan-600 dark:text-gold-400 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </td>

                            <td class="py-3.5 px-3">
                                <div class="font-bold text-espresso-950 dark:text-white">
                                    {{ $order->customer_name }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-mono">
                                    {{ $order->customer_phone ?: $order->customer_email }}
                                </div>
                            </td>

                            <td class="py-3.5 px-3 text-gray-600 dark:text-gray-300">
                                {{ $order->city }}
                            </td>

                            <td class="py-3.5 px-3 font-cinzel font-bold text-sm text-espresso-950 dark:text-white whitespace-nowrap">
                                Rs. {{ number_format($order->total) }}
                            </td>

                            <td class="py-3.5 px-3">
                                @if($order->payment_method === 'COD')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#FFF7E8] text-tan-700 border border-[#FDE68A]">
                                        COD
                                    </span>
                                @elseif($order->payment_method === 'BANK_TRANSFER')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE]">
                                        MEEZAN IBFT
                                    </span>
                                @elseif($order->payment_method === 'CREDIT_CARD')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#F3F4F6] text-[#4B5563] border border-[#E5E7EB]">
                                        CARD
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#FDF9F5] text-tan-700 border border-tan-200">
                                        {{ $order->payment_method }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-3">
                                <div>
                                    @if($order->order_status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Delivered
                                        </span>
                                    @elseif($order->order_status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif($order->order_status === 'processing')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            In Crafting
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    @endif
                                </div>

                                @if($order->courier_name)
                                    <div class="mt-1">
                                        <a 
                                            href="{{ $order->tracking_link }}" 
                                            target="_blank" 
                                            class="inline-flex items-center gap-1 text-[10px] font-mono text-[#8F8379] hover:text-emerald-600 transition-colors"
                                            title="Track consignment on courier portal"
                                        >
                                            <i data-lucide="external-link" class="w-2.5 h-2.5 text-emerald-600"></i>
                                            <span>{{ $order->courier_name }}: {{ $order->tracking_number ?: 'View' }}</span>
                                        </a>
                                    </div>
                                @endif
                            </td>

                            <td class="py-3.5 px-3 text-[11px] text-gray-400 whitespace-nowrap">
                                {{ $order->created_at ? $order->created_at->format('M d, Y') : '—' }}
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    
                                    <!-- 1-Click WhatsApp Concierge Dispatch Button -->
                                    @if($order->whatsapp_phone)
                                        <a 
                                            href="https://wa.me/{{ $order->whatsapp_phone }}?text={{ urlencode($order->whatsapp_dispatch_message) }}" 
                                            target="_blank"
                                            class="w-7 h-7 rounded-full bg-emerald-600 hover:bg-emerald-700 inline-flex items-center justify-center text-white shadow-2xs transition-colors"
                                            title="Direct WhatsApp: Send Dispatched Notification"
                                        >
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        </a>
                                    @endif

                                    <!-- Quick Courier / Dispatch Modal Trigger -->
                                    <button 
                                        type="button" 
                                        onclick="openQuickCourierModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->courier_name ?: 'TCS Express' }}', '{{ $order->tracking_number }}', '{{ $order->whatsapp_phone }}', '{{ addslashes($order->whatsapp_dispatch_message) }}')"
                                        class="w-7 h-7 rounded-full border border-emerald-300 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 inline-flex items-center justify-center transition-colors"
                                        title="Quick Courier & Tracking Setup"
                                    >
                                        <i data-lucide="truck" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Packaging Slip -->
                                    <a 
                                        href="{{ route('admin.orders.packing-slip', $order) }}" 
                                        target="_blank"
                                        class="w-7 h-7 rounded-full border border-[#DFD6CB] dark:border-[#3A2F29] inline-flex items-center justify-center text-gray-500 hover:text-tan-600 hover:border-tan-500 transition-colors"
                                        title="Print Packaging Slip"
                                    >
                                        <i data-lucide="package-check" class="w-3 h-3"></i>
                                    </a>

                                    <!-- Invoice -->
                                    <a 
                                        href="{{ route('admin.orders.invoice', $order) }}" 
                                        target="_blank"
                                        class="w-7 h-7 rounded-full border border-[#DFD6CB] dark:border-[#3A2F29] inline-flex items-center justify-center text-gray-500 hover:text-tan-600 hover:border-tan-500 transition-colors"
                                        title="Print Invoice"
                                    >
                                        <i data-lucide="file-text" class="w-3 h-3"></i>
                                    </a>

                                    <!-- Details -->
                                    <a 
                                        href="{{ route('admin.orders.show', $order) }}" 
                                        class="w-7 h-7 rounded-full border border-[#DFD6CB] dark:border-[#3A2F29] inline-flex items-center justify-center text-gray-500 hover:text-tan-600 hover:border-tan-500 transition-colors"
                                        title="View Full Details"
                                    >
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Permanently remove this order record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="w-7 h-7 rounded-full border border-[#DFD6CB] dark:border-[#3A2F29] inline-flex items-center justify-center text-gray-400 hover:text-rose-600 hover:border-rose-300 transition-colors"
                                            title="Delete Order"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-gray-400">
                                No store orders recorded.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $orders->links() }}
        </div>
    </div>

</div>

<!-- Quick Courier & Tracking Dialog (Luxury Modal) -->
<dialog id="quickCourierModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950/50 flex items-center justify-center">
                    <i data-lucide="truck" class="w-4 h-4 text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white" id="modalOrderTitle">Dispatch Order</h3>
                    <p class="text-[11px] text-[#8F8379]">Courier tracking & WhatsApp concierge alert</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('quickCourierModal').close()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="quickCourierForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold mb-1">Courier Partner <span class="text-rose-500">*</span></label>
                <select name="courier_name" id="modalCourierName" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold">
                    <option value="TCS Express">TCS Express</option>
                    <option value="Trax Logistics">Trax Logistics</option>
                    <option value="Leopards Courier">Leopards Courier</option>
                    <option value="PostEx">PostEx</option>
                    <option value="Call Courier">Call Courier</option>
                    <option value="M&P Express">M&P Express</option>
                    <option value="Rider PK">Rider PK</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tracking ID / Consignment Number (CN #)</label>
                <input 
                    type="text" 
                    name="tracking_number" 
                    id="modalTrackingNumber" 
                    placeholder="e.g. 192837465" 
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#DFD6CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                >
            </div>

            <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-900 dark:text-emerald-200">
                <div class="font-bold flex items-center gap-1.5 mb-1 text-[11px]">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Personalized WhatsApp Alert:</span>
                </div>
                <p class="text-[11px] italic" id="modalWaPreview">
                    "Dear [Customer], your By Zunash order #[OrderNumber] has been dispatched via TCS Express. Tracking ID: [12345]. Track here: [Link]"
                </p>
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">
                <input type="checkbox" name="mark_dispatched" value="1" checked class="rounded border-[#DFD6CB] text-emerald-600">
                <span>Mark Order Fulfillment Status as Dispatched</span>
            </label>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('quickCourierModal').close()" class="px-3.5 py-2 rounded-xl text-xs font-medium text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-xs font-semibold text-espresso-900 dark:text-white hover:bg-gray-100 dark:hover:bg-[#201A18]">
                    Save Only
                </button>
                <button type="submit" name="open_whatsapp" value="1" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-md flex items-center gap-1.5">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                    <span>Save & Send WhatsApp</span>
                </button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
function openQuickCourierModal(orderId, orderNum, courier, tracking, waPhone, waMsg) {
    const modal = document.getElementById('quickCourierModal');
    const form = document.getElementById('quickCourierForm');
    const title = document.getElementById('modalOrderTitle');
    const courierSelect = document.getElementById('modalCourierName');
    const trackingInput = document.getElementById('modalTrackingNumber');
    const preview = document.getElementById('modalWaPreview');

    form.action = '/admin/orders/' + orderId + '/courier';
    title.textContent = 'Dispatch Order ' + orderNum;
    courierSelect.value = courier || 'TCS Express';
    trackingInput.value = tracking || '';
    if (waMsg) {
        preview.textContent = '"' + waMsg + '"';
    }

    modal.showModal();
}
</script>
@endpush

@endsection
