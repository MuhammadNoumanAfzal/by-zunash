@extends('admin.layouts.app')

@section('title', 'Store Orders & Dispatch | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Store Orders & Invoices
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Process verified orders, track bank transfers (IBFT) and Cash on Delivery, and dispatch fine leather shipments nationwide.
            </p>
        </div>

        <div class="flex items-center gap-2">
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

            <div class="lg:col-span-1">
                <button type="submit" class="w-full py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs flex items-center justify-center transition-colors">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                </button>
            </div>

        </form>
    </div>

    <!-- Orders Table -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">ORDER #</th>
                        <th class="py-3 px-3">CUSTOMER</th>
                        <th class="py-3 px-3">CITY</th>
                        <th class="py-3 px-3">AMOUNT</th>
                        <th class="py-3 px-3">PAYMENT</th>
                        <th class="py-3 px-3">STATUS</th>
                        <th class="py-3 px-3">DATE</th>
                        <th class="py-3 px-4 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-tan-600 dark:text-gold-400">
                                {{ $order->order_number }}
                            </td>

                            <td class="py-3.5 px-3">
                                <div class="font-bold text-espresso-950 dark:text-white">
                                    {{ $order->customer_name }}
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $order->customer_email }}
                                </div>
                            </td>

                            <td class="py-3.5 px-3 text-gray-600 dark:text-gray-300">
                                {{ $order->city }}
                            </td>

                            <td class="py-3.5 px-3 font-cinzel font-bold text-sm text-espresso-950 dark:text-white">
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
                            </td>

                            <td class="py-3.5 px-3 text-[11px] text-gray-400">
                                {{ $order->created_at ? $order->created_at->format('M d, Y') : '—' }}
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <a 
                                    href="{{ route('admin.orders.show', $order) }}" 
                                    class="w-7 h-7 rounded-full border border-[#DFD6CB] dark:border-[#3A2F29] inline-flex items-center justify-center text-gray-500 hover:text-tan-600 hover:border-tan-500 transition-colors"
                                    title="View Details"
                                >
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400">
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

@endsection
