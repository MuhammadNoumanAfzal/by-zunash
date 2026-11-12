@extends('admin.layouts.app')

@section('title', 'Coupons & Promotional Rules | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <!-- Header & Create Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-[#8F8379] mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-tan-600 transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-espresso-950 dark:text-white font-medium">Promotions</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Coupon & Promo Code Engine
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Generate flexible courtesy discounts, minimum cart spend conditions, usage redemption limits, and automatic campaign expiration countdowns.
            </p>
        </div>

        <button 
            type="button" 
            onclick="document.getElementById('addCouponModal').showModal()"
            class="px-4 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-2 shadow-md border border-gold-400/20"
        >
            <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
            <span>Create New Promo Code</span>
        </button>
    </div>

    <!-- 4 Key Analytics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Active Coupons</div>
            <div class="font-cinzel text-2xl font-bold text-emerald-600 mt-1">{{ $totalActive }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">Live on storefront</div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-tan-600">Total Redemptions</div>
            <div class="font-cinzel text-2xl font-bold text-tan-600 mt-1">{{ number_format($totalRedemptions) }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">Used by shoppers</div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Expiring in 7 Days</div>
            <div class="font-cinzel text-2xl font-bold text-amber-600 mt-1">{{ $expiringSoon }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">Ending this week</div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Total Rules</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">{{ $totalCoupons }}</div>
            <div class="text-[10px] text-gray-400 mt-0.5">All created promos</div>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
        <form action="{{ route('admin.coupons.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
            <div class="lg:col-span-8 relative">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Search by promo code or description (e.g. ZUNASH15)..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono"
                >
            </div>

            <div class="lg:col-span-3">
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 cursor-pointer">
                    <option value="all">Status: All Codes</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active & Usable</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive / Paused</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired Campaigns</option>
                </select>
            </div>

            <div class="sm:col-span-2 lg:col-span-1 flex items-center gap-1.5">
                <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-colors" title="Apply Filter">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span class="sm:hidden lg:hidden">Filter</span>
                </button>
                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.coupons.index') }}" class="w-9 h-9 shrink-0 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-500 hover:bg-gray-100 dark:hover:bg-[#241D1A] flex items-center justify-center transition-colors" title="Reset Filters">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Coupons Table Card -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        
        <div class="overflow-x-auto w-full max-w-full">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3.5 px-4">PROMO CODE</th>
                        <th class="py-3.5 px-3">DISCOUNT VALUE</th>
                        <th class="py-3.5 px-3">MINIMUM SPEND</th>
                        <th class="py-3.5 px-3">REDEMPTIONS / LIMIT</th>
                        <th class="py-3.5 px-3">VALIDITY & COUNTDOWN</th>
                        <th class="py-3.5 px-3 text-center">STATUS</th>
                        <th class="py-3.5 px-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            
                            <!-- Promo Code -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-sm tracking-wide px-2.5 py-1 rounded-lg bg-tan-50 dark:bg-tan-950/40 text-tan-800 dark:text-gold-300 border border-tan-300 dark:border-gold-500/30">
                                        {{ $coupon->code }}
                                    </span>
                                    <button 
                                        type="button" 
                                        onclick="navigator.clipboard.writeText('{{ $coupon->code }}'); if(window.ZunashAlert) window.ZunashAlert.toast('Code copied: {{ $coupon->code }}', 'success');"
                                        class="text-gray-400 hover:text-tan-600 p-1 rounded-md transition-colors"
                                        title="Copy code to clipboard"
                                    >
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                                @if($coupon->description)
                                    <div class="text-[11px] text-[#8F8379] mt-1 max-w-xs truncate">
                                        {{ $coupon->description }}
                                    </div>
                                @endif
                            </td>

                            <!-- Discount Rule -->
                            <td class="py-3.5 px-3 font-semibold text-espresso-950 dark:text-white whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#FAF4ED] text-tan-700 dark:bg-[#251A14] dark:text-gold border border-tan-200 dark:border-gold-500/20">
                                    {{ $coupon->badge_text }}
                                </div>
                                @if($coupon->max_discount)
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-mono">
                                        Max: Rs. {{ number_format($coupon->max_discount) }}
                                    </div>
                                @endif
                            </td>

                            <!-- Minimum Spend -->
                            <td class="py-3.5 px-3 font-mono text-espresso-900 dark:text-white whitespace-nowrap">
                                @if($coupon->min_spend > 0)
                                    <span class="font-bold">Rs. {{ number_format($coupon->min_spend) }}</span>
                                    <div class="text-[9px] text-gray-400">Cart minimum</div>
                                @else
                                    <span class="text-gray-400 text-[11px]">No minimum</span>
                                @endif
                            </td>

                            <!-- Usage Redemptions & Limits -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <div class="flex items-center gap-1.5 font-mono text-xs">
                                    <span class="font-bold text-espresso-950 dark:text-white">{{ $coupon->used_count }}</span>
                                    <span class="text-gray-400">/</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $coupon->usage_limit ?: '∞ Unlimited' }}</span>
                                </div>
                                @if($coupon->usage_limit)
                                    @php
                                        $percent = min(100, round(($coupon->used_count / $coupon->usage_limit) * 100));
                                    @endphp
                                    <div class="w-24 h-1.5 bg-gray-200 dark:bg-gray-800 rounded-full mt-1 overflow-hidden">
                                        <div class="h-full bg-tan-600 rounded-full" style="width: {{ $percent }}%"></div>
                                    </div>
                                @endif
                            </td>

                            <!-- Expiry Countdown -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                @if(!$coupon->expires_at)
                                    <span class="text-gray-400 text-[11px] flex items-center gap-1">
                                        <i data-lucide="infinity" class="w-3.5 h-3.5"></i>
                                        <span>Never expires</span>
                                    </span>
                                @elseif($coupon->is_expired)
                                    <span class="text-rose-600 font-semibold text-[11px] flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        <span>Expired {{ $coupon->expires_at->diffForHumans() }}</span>
                                    </span>
                                    <div class="text-[9px] text-gray-400">{{ $coupon->expires_at->format('M d, Y') }}</div>
                                @else
                                    <span class="text-amber-600 dark:text-amber-400 font-semibold text-[11px] flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        <span>{{ $coupon->expiry_text }}</span>
                                    </span>
                                    <div class="text-[9px] text-gray-400">{{ $coupon->expires_at->format('M d, Y h:i A') }}</div>
                                @endif
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-3.5 px-3 text-center">
                                <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST">
                                    @csrf
                                    @if($coupon->is_active && !$coupon->is_expired && !$coupon->is_limit_reached)
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 hover:bg-emerald-100 transition-colors" title="Click to Deactivate">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </button>
                                    @elseif($coupon->is_expired)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200">
                                            Expired
                                        </span>
                                    @elseif($coupon->is_limit_reached)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 dark:bg-purple-950/40 dark:text-purple-300 border border-purple-200">
                                            Limit Reached
                                        </span>
                                    @else
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 hover:bg-gray-200 transition-colors" title="Click to Activate">
                                            Paused
                                        </button>
                                    @endif
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    
                                    <!-- Edit Button -->
                                    <button 
                                        type="button" 
                                        onclick="openEditCouponModal({{ json_encode($coupon) }})"
                                        class="w-7 h-7 rounded-full border border-[#DFD6CB] dark:border-[#3A2F29] inline-flex items-center justify-center text-gray-500 hover:text-tan-600 hover:border-tan-500 transition-colors"
                                        title="Edit Coupon Rules"
                                    >
                                        <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Permanently remove promotional code {{ $coupon->code }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="w-7 h-7 rounded-full border border-gray-200 text-gray-400 hover:text-rose-600 hover:border-rose-300 transition-colors inline-flex items-center justify-center"
                                            title="Delete Coupon"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-xs text-gray-400">
                                No promotional codes configured. Click "Create New Promo Code" above to launch a campaign!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $coupons->links() }}
        </div>
    </div>

</div>

<!-- Modal: Create New Coupon (Card-shaped Dialog) -->
<dialog id="addCouponModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-tan-100 dark:bg-tan-950/50 flex items-center justify-center">
                    <i data-lucide="tag" class="w-4 h-4 text-tan-600 dark:text-gold-400"></i>
                </div>
                <div>
                    <h3 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">Create Promo Code</h3>
                    <p class="text-[11px] text-[#8F8379]">Define discount, spending rules & limits</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('addCouponModal').close()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Promo Code & Description -->
            <div>
                <label class="block text-xs font-semibold mb-1">Coupon Code <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="code" 
                    required 
                    placeholder="e.g. ZUNASH15 or EID2026" 
                    style="text-transform: uppercase;"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold tracking-wider"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Campaign Narrative / Description</label>
                <input 
                    type="text" 
                    name="description" 
                    placeholder="e.g. 15% VIP Courtesy Discount on Bespoke Handcrafted Leather" 
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white"
                >
            </div>

            <!-- Discount Type & Value -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Discount Type <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold">
                        <option value="percentage">Percentage (%) Off</option>
                        <option value="fixed">Fixed Amount (PKR) Off</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Discount Value <span class="text-rose-500">*</span></label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="value" 
                        required 
                        placeholder="e.g. 15 or 1000" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold"
                    >
                </div>
            </div>

            <!-- Minimum Spend & Max Cap -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Min. Cart Value (PKR)</label>
                    <input 
                        type="number" 
                        step="1" 
                        name="min_spend" 
                        placeholder="e.g. 10000 (0 = None)" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Max Cap (Optional PKR)</label>
                    <input 
                        type="number" 
                        step="1" 
                        name="max_discount" 
                        placeholder="e.g. 3000" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                    >
                </div>
            </div>

            <!-- Usage Limit & Expiry Date -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Redemption Limit</label>
                    <input 
                        type="number" 
                        name="usage_limit" 
                        placeholder="e.g. 50 (Blank = ∞)" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Expiration Date & Time</label>
                    <input 
                        type="datetime-local" 
                        name="expires_at" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white"
                    >
                </div>
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300 pt-1">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#DFD6CB] text-tan-600">
                <span>Activate immediately upon creation</span>
            </label>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('addCouponModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Save Promo Code
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal: Edit Coupon (Card-shaped Dialog) -->
<dialog id="editCouponModal" class="rounded-3xl p-0 shadow-2xl">
    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-tan-100 dark:bg-tan-950/50 flex items-center justify-center">
                    <i data-lucide="edit" class="w-4 h-4 text-tan-600 dark:text-gold-400"></i>
                </div>
                <div>
                    <h3 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white" id="editModalTitle">Edit Coupon Rules</h3>
                    <p class="text-[11px] text-[#8F8379]">Update rules, expiration & limits</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('editCouponModal').close()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editCouponForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1">Coupon Code <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    id="edit_coupon_code"
                    name="code" 
                    required 
                    style="text-transform: uppercase;"
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold tracking-wider"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Campaign Narrative / Description</label>
                <input 
                    type="text" 
                    id="edit_coupon_description"
                    name="description" 
                    class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Discount Type <span class="text-rose-500">*</span></label>
                    <select id="edit_coupon_type" name="type" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-semibold">
                        <option value="percentage">Percentage (%) Off</option>
                        <option value="fixed">Fixed Amount (PKR) Off</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Discount Value <span class="text-rose-500">*</span></label>
                    <input 
                        type="number" 
                        step="0.01" 
                        id="edit_coupon_value"
                        name="value" 
                        required 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono font-bold"
                    >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Min. Cart Value (PKR)</label>
                    <input 
                        type="number" 
                        step="1" 
                        id="edit_coupon_min_spend"
                        name="min_spend" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Max Cap (Optional PKR)</label>
                    <input 
                        type="number" 
                        step="1" 
                        id="edit_coupon_max_discount"
                        name="max_discount" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                    >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Redemption Limit</label>
                    <input 
                        type="number" 
                        id="edit_coupon_usage_limit"
                        name="usage_limit" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white font-mono"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Expiration Date & Time</label>
                    <input 
                        type="datetime-local" 
                        id="edit_coupon_expires_at"
                        name="expires_at" 
                        class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#382D27] text-espresso-900 dark:text-white"
                    >
                </div>
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300 pt-1">
                <input type="checkbox" id="edit_coupon_is_active" name="is_active" value="1" class="rounded border-[#DFD6CB] text-tan-600">
                <span>Coupon is active</span>
            </label>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('editCouponModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-espresso-900 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
function openEditCouponModal(coupon) {
    const form = document.getElementById('editCouponForm');
    form.action = '/admin/coupons/' + coupon.id;

    document.getElementById('editModalTitle').textContent = 'Edit ' + coupon.code;
    document.getElementById('edit_coupon_code').value = coupon.code;
    document.getElementById('edit_coupon_description').value = coupon.description || '';
    document.getElementById('edit_coupon_type').value = coupon.type;
    document.getElementById('edit_coupon_value').value = coupon.value;
    document.getElementById('edit_coupon_min_spend').value = coupon.min_spend || 0;
    document.getElementById('edit_coupon_max_discount').value = coupon.max_discount || '';
    document.getElementById('edit_coupon_usage_limit').value = coupon.usage_limit || '';
    
    if (coupon.expires_at) {
        // Format ISO string to datetime-local (YYYY-MM-DDTHH:mm)
        const d = new Date(coupon.expires_at);
        const formatted = d.toISOString().slice(0, 16);
        document.getElementById('edit_coupon_expires_at').value = formatted;
    } else {
        document.getElementById('edit_coupon_expires_at').value = '';
    }

    document.getElementById('edit_coupon_is_active').checked = Boolean(coupon.is_active);

    document.getElementById('editCouponModal').showModal();
}
</script>
@endpush

@endsection

