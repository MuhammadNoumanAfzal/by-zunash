@extends('admin.layouts.app')

@section('title', 'Abandoned Cart Recovery & Drop-offs | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-[#8F8379] mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-tan-600 transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-espresso-950 dark:text-white font-medium">Drop-off Recovery</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Abandoned Carts & Drop-offs
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Shoppers who entered their name and mobile number on checkout without hitting "Complete Order". Re-engage them via 1-click WhatsApp concierge.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] text-xs font-bold text-emerald-600 dark:text-emerald-400 shadow-2xs font-mono">
                Recovered: Rs. {{ number_format($recoveredRevenue) }}
            </span>
        </div>
    </div>

    <!-- 4 Analytics Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Pending Recovery</div>
            <div class="font-cinzel text-2xl font-bold text-amber-600 mt-1">{{ $totalAbandonedCount }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">Uncontacted shoppers</div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Revenue at Risk</div>
            <div class="font-cinzel text-xl sm:text-2xl font-bold text-rose-600 mt-1">Rs. {{ number_format($potentialRevenueLost) }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">Incomplete bags</div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Concierge Contacted</div>
            <div class="font-cinzel text-2xl font-bold text-blue-600 mt-1">{{ $contactedCount }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">WhatsApp alerts sent</div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Sales Recovered</div>
            <div class="font-cinzel text-xl sm:text-2xl font-bold text-emerald-600 mt-1">Rs. {{ number_format($recoveredRevenue) }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">Resumed & completed</div>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
        <form action="{{ route('admin.abandoned-carts.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
            <div class="lg:col-span-8 relative">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Search by shopper name, phone number, city, email..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500"
                >
            </div>

            <div class="lg:col-span-3">
                <select name="status" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                    <option value="all">Recovery Status: All</option>
                    <option value="abandoned" {{ request('status') === 'abandoned' ? 'selected' : '' }}>Pending / Uncontacted</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted via WhatsApp</option>
                    <option value="recovered" {{ request('status') === 'recovered' ? 'selected' : '' }}>Recovered Sale</option>
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

    <!-- Abandoned Carts Table Card -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        
        <div class="overflow-x-auto w-full max-w-full">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3.5 px-4">SHOPPER & CONTACT</th>
                        <th class="py-3.5 px-3">ABANDONED BAG ARTICLES</th>
                        <th class="py-3.5 px-3 whitespace-nowrap">VALUE</th>
                        <th class="py-3.5 px-3 whitespace-nowrap">DROPPED OFF</th>
                        <th class="py-3.5 px-3">STATUS</th>
                        <th class="py-3.5 px-4 text-right">ONE-CLICK WHATSAPP RECOVERY</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($carts as $cart)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            
                            <!-- Shopper Info -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-espresso-950 dark:text-white text-xs">
                                    {{ $cart->customer_name ?: 'Guest Shopper' }}
                                </div>
                                <div class="font-mono text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                                    <i data-lucide="phone" class="w-3 h-3"></i>
                                    <span>{{ $cart->customer_phone ?: 'No phone' }}</span>
                                </div>
                                <div class="text-[10px] text-gray-400 mt-0.5">
                                    {{ $cart->city ?: 'Pakistan' }} @if($cart->customer_email) • {{ $cart->customer_email }} @endif
                                </div>
                            </td>

                            <!-- Cart Articles -->
                            <td class="py-3.5 px-3 max-w-xs">
                                @if(is_array($cart->items) && count($cart->items) > 0)
                                    <div class="space-y-1">
                                        @foreach(array_slice($cart->items, 0, 2) as $item)
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-tan-500 shrink-0"></span>
                                                <span class="truncate font-medium text-espresso-900 dark:text-white text-[11px]">
                                                    {{ $item['name'] ?? 'Leather Article' }}
                                                </span>
                                                <span class="text-gray-400 text-[10px] shrink-0 font-mono">
                                                    (x{{ $item['quantity'] ?? $item['qty'] ?? 1 }})
                                                </span>
                                            </div>
                                        @endforeach
                                        @if(count($cart->items) > 2)
                                            <div class="text-[10px] text-tan-600 italic">
                                                +{{ count($cart->items) - 2 }} more piece(s)
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 italic text-[11px]">Handcrafted Selection</span>
                                @endif
                            </td>

                            <!-- Cart Total Value -->
                            <td class="py-3.5 px-3 font-cinzel font-bold text-sm text-espresso-950 dark:text-white whitespace-nowrap">
                                Rs. {{ number_format($cart->total ?: $cart->subtotal) }}
                            </td>

                            <!-- Drop-off Time -->
                            <td class="py-3.5 px-3 text-[11px] text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                <div>{{ $cart->created_at ? $cart->created_at->diffForHumans() : 'Recently' }}</div>
                                <div class="text-[9px] text-gray-400">{{ $cart->created_at ? $cart->created_at->format('M d, h:i A') : '' }}</div>
                            </td>

                            <!-- Recovery Status Badge -->
                            <td class="py-3.5 px-3">
                                @if($cart->status === 'recovered')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200">
                                        <i data-lucide="check-check" class="w-3 h-3 text-emerald-500"></i>
                                        <span>Recovered</span>
                                    </span>
                                @elseif($cart->status === 'contacted')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200">
                                        <i data-lucide="message-circle" class="w-3 h-3 text-blue-500"></i>
                                        <span>Contacted</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Incomplete</span>
                                    </span>
                                @endif
                            </td>

                            <!-- One-Click WhatsApp Recovery Actions -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    
                                    @if($cart->whatsapp_phone)
                                        <!-- Template 1: Gentle Bag Reminder -->
                                        <form action="{{ route('admin.abandoned-carts.whatsapp', $cart) }}" method="POST" target="_blank">
                                            @csrf
                                            <input type="hidden" name="template" value="gentle">
                                            <button 
                                                type="submit" 
                                                class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[11px] shadow-2xs transition-colors flex items-center gap-1"
                                                title="Send Gentle WhatsApp Bag Reminder"
                                            >
                                                <i data-lucide="message-circle" class="w-3 h-3"></i>
                                                <span>Remind</span>
                                            </button>
                                        </form>

                                        <!-- Template 2: 5% Courtesy Voucher -->
                                        <form action="{{ route('admin.abandoned-carts.whatsapp', $cart) }}" method="POST" target="_blank">
                                            @csrf
                                            <input type="hidden" name="template" value="discount">
                                            <button 
                                                type="submit" 
                                                class="px-2.5 py-1.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white font-semibold text-[11px] shadow-2xs transition-colors flex items-center gap-1"
                                                title="Send 5% Courtesy Discount Code [ATELIER5] via WhatsApp"
                                            >
                                                <i data-lucide="tag" class="w-3 h-3 text-gold-300"></i>
                                                <span>5% Perk</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Mark Recovered -->
                                    @if($cart->status !== 'recovered')
                                        <form action="{{ route('admin.abandoned-carts.recover', $cart) }}" method="POST">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="w-7 h-7 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 inline-flex items-center justify-center transition-colors"
                                                title="Mark as Recovered / Placed"
                                            >
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete -->
                                    <form action="{{ route('admin.abandoned-carts.destroy', $cart) }}" method="POST" onsubmit="return confirm('Remove this abandoned cart record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="w-7 h-7 rounded-full border border-gray-200 text-gray-400 hover:text-rose-600 hover:border-rose-300 transition-colors inline-flex items-center justify-center"
                                            title="Delete Record"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-xs text-gray-400">
                                No abandoned drop-offs recorded. Shoppers are smoothly completing checkout!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $carts->links() }}
        </div>
    </div>

</div>

@endsection

