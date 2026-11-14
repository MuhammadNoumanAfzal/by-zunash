@extends('admin.layouts.app')

@section('title', 'Financial Analytics & Capital Intelligence | By Zunash Atelier')

@section('content')

<div class="space-y-6" x-data="{ exportMonth: '{{ date('Y-m') }}' }">

    <!-- Header & Period Filter -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Financial Analytics & Atelier Intelligence
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Profit margin ROI, category performance, tax withholding estimates, aging inventory & clean CSV data exports.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Period Filter -->
            <form action="{{ route('admin.analytics.index') }}" method="GET" class="inline-flex items-center">
                <select 
                    name="period" 
                    onchange="this.form.submit()" 
                    class="px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] text-espresso-900 dark:text-white font-semibold shadow-2xs focus:outline-hidden"
                >
                    <option value="30_days" {{ $period === '30_days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="this_month" {{ $period === 'this_month' ? 'selected' : '' }}>This Month ({{ date('F') }})</option>
                    <option value="last_month" {{ $period === 'last_month' ? 'selected' : '' }}>Last Month</option>
                    <option value="90_days" {{ $period === '90_days' ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="this_year" {{ $period === 'this_year' ? 'selected' : '' }}>Fiscal Year {{ date('Y') }}</option>
                    <option value="all_time" {{ $period === 'all_time' ? 'selected' : '' }}>All-Time Performance</option>
                </select>
            </form>

            <!-- Daily Closing Summary PDF Quick Button -->
            <a 
                href="{{ route('admin.analytics.daily-closing') }}" 
                target="_blank"
                class="px-3.5 py-1.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white font-semibold text-xs flex items-center gap-1.5 transition-colors shadow-2xs"
                title="Open Day-End Sales & Cashier Closing Summary (PDF / Print Z-Report)"
            >
                <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                <span>Daily Closing (PDF)</span>
            </a>

            <!-- One-Click Export Trigger Button -->
            <button 
                type="button" 
                onclick="document.getElementById('exportModal').showModal()" 
                class="px-3.5 py-1.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs flex items-center gap-1.5 transition-colors shadow-2xs border border-gold-400/20"
            >
                <i data-lucide="download" class="w-3.5 h-3.5 text-gold-400"></i>
                <span>Export Reports (PDF / CSV)</span>
            </button>
        </div>
    </div>

    <!-- 5 Core Financial KPIs -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        
        <!-- Net Sales / Gross Revenue -->
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">NET REVENUE</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">
                PKR {{ number_format($netSales) }}
            </div>
            <div class="text-[10px] text-gray-400 mt-1">
                From {{ $totalOrdersCount }} completed orders
            </div>
        </div>

        <!-- Profit Margin ROI -->
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">GROSS PROFIT MARGIN</div>
            <div class="font-cinzel text-2xl font-bold text-emerald-600 mt-1">
                {{ $profitMargin }}%
            </div>
            <div class="text-[10px] text-emerald-700/80 mt-1">
                PKR {{ number_format($grossProfit) }} profit
            </div>
        </div>

        <!-- Cost of Goods Sold (COGS) -->
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-tan-600 dark:text-gold-400">ESTIMATED COGS</div>
            <div class="font-cinzel text-2xl font-bold text-tan-600 dark:text-gold-400 mt-1">
                PKR {{ number_format($cogs) }}
            </div>
            <div class="text-[10px] text-gray-400 mt-1">
                Raw calfskin & master craft (~42%)
            </div>
        </div>

        <!-- Average Order Value (AOV) -->
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">AVG BASKET (AOV)</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">
                PKR {{ number_format($averageOrderValue) }}
            </div>
            <div class="text-[10px] text-gray-400 mt-1">
                Per patron acquisition
            </div>
        </div>

        <!-- Sales Tax / PRA Provision -->
        <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">TAX / PRA PROVISION</div>
            <div class="font-cinzel text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">
                PKR {{ number_format($taxCollected) }}
            </div>
            <div class="text-[10px] text-purple-700/80 dark:text-purple-400/80 mt-1">
                5% Withholding standard
            </div>
        </div>

    </div>

    <!-- Monthly Trajectory Chart & Payment Channels -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Monthly Revenue Trajectory (7 cols) -->
        <div class="lg:col-span-8 p-6 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                        Monthly Revenue & Trajectory (Past 6 Months)
                    </h2>
                    <p class="text-xs text-[#8F8379] mt-0.5">
                        Atelier gross sales velocity in Pakistani Rupees (PKR)
                    </p>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-tan-500/10 text-tan-700 dark:text-tan-400 border border-tan-500/20">
                    Trailing 6 Months
                </span>
            </div>

            <div class="space-y-4">
                @php
                    $maxRev = collect($monthlyRevenue)->max('revenue') ?: 100000;
                @endphp
                @foreach($monthlyRevenue as $m)
                    @php
                        $pct = $maxRev > 0 ? min(100, max(5, round(($m['revenue'] / $maxRev) * 100))) : 5;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="font-bold text-espresso-950 dark:text-white">{{ $m['month'] }}</span>
                            <div class="flex items-center gap-3">
                                <span class="text-gray-400 text-[11px]">{{ $m['orders'] }} orders</span>
                                <span class="font-mono font-bold text-espresso-950 dark:text-gold-400">
                                    PKR {{ number_format($m['revenue']) }}
                                </span>
                            </div>
                        </div>
                        <div class="w-full h-3 rounded-full bg-[#FAF8F5] dark:bg-[#201A18] overflow-hidden p-0.5">
                            <div 
                                class="h-full rounded-full bg-gradient-to-r from-tan-600 to-gold-400 transition-all duration-500" 
                                style="width: {{ $pct }}%;"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Channel Distribution (4 cols) -->
        <div class="lg:col-span-4 p-6 rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card flex flex-col justify-between">
            <div>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white mb-1">
                    Payment Gateway Share
                </h2>
                <p class="text-xs text-[#8F8379] mb-4">
                    Pakistani settlement methods distribution
                </p>

                <div class="space-y-3">
                    @php
                        $totPayments = array_sum($paymentBreakdown) ?: 1;
                    @endphp
                    
                    <div class="p-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB]/60 dark:border-[#382D27]">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-espresso-950 dark:text-white">Cash on Delivery (COD)</span>
                            <span class="font-mono font-bold">{{ $paymentBreakdown['COD'] }} orders</span>
                        </div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ round(($paymentBreakdown['COD'] / $totPayments) * 100) }}% total checkout preference</div>
                    </div>

                    <div class="p-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB]/60 dark:border-[#382D27]">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-espresso-950 dark:text-white">Bank Transfer (IBFT)</span>
                            <span class="font-mono font-bold">{{ $paymentBreakdown['BANK_TRANSFER'] }} orders</span>
                        </div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ round(($paymentBreakdown['BANK_TRANSFER'] / $totPayments) * 100) }}% direct manual settlement</div>
                    </div>

                    <div class="p-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB]/60 dark:border-[#382D27]">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-espresso-950 dark:text-white">Credit / Debit Card</span>
                            <span class="font-mono font-bold">{{ $paymentBreakdown['CREDIT_CARD'] }} orders</span>
                        </div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ round(($paymentBreakdown['CREDIT_CARD'] / $totPayments) * 100) }}% online gateway</div>
                    </div>

                    <div class="p-3 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB]/60 dark:border-[#382D27]">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-espresso-950 dark:text-white">VIP Concierge Invoice</span>
                            <span class="font-mono font-bold">{{ $paymentBreakdown['VIP_CONCIERGE'] }} orders</span>
                        </div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ round(($paymentBreakdown['VIP_CONCIERGE'] / $totPayments) * 100) }}% bespoke client concierge</div>
                    </div>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-[#ECE6DE] dark:border-[#2C2420] text-center">
                <a href="{{ route('admin.analytics.export.tax') }}" class="text-xs text-tan-600 dark:text-gold-400 hover:underline font-semibold inline-flex items-center gap-1">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                    <span>Download Fiscal Tax Sheet (CSV)</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Category Profitability & Most Profitable Collections -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="p-5 border-b border-[#ECE6DE] dark:border-[#2C2420] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                    Category Profitability & Contribution Matrix
                </h2>
                <p class="text-xs text-[#8F8379] mt-0.5">
                    Which luxury collections generate the highest gross margins and revenue share.
                </p>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 px-3 py-1 rounded-full">
                ROI Optimized
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">COLLECTION / CATEGORY</th>
                        <th class="py-3 px-3 text-center">UNITS SOLD</th>
                        <th class="py-3 px-4 text-right">GROSS REVENUE</th>
                        <th class="py-3 px-4 text-right">EST. GROSS MARGIN (60%)</th>
                        <th class="py-3 px-4 text-center">STORE SHARE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($profitableCategories as $cat)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-3.5 px-4 font-bold text-espresso-950 dark:text-white">
                                {{ $cat['name'] }}
                            </td>
                            <td class="py-3.5 px-3 text-center font-mono font-bold text-gray-600 dark:text-gray-300">
                                {{ $cat['units'] }}
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-espresso-950 dark:text-white">
                                PKR {{ number_format($cat['revenue']) }}
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-emerald-600">
                                PKR {{ number_format($cat['gross_margin']) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF6F2] dark:bg-[#241D1A] text-tan-700 dark:text-tan-400 border border-tan-300/40">
                                    {{ $cat['share'] }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">
                                No sales recorded in this period.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aging & Slow-Moving Inventory (Capital Valuation) -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="p-5 border-b border-[#ECE6DE] dark:border-[#2C2420] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-cinzel text-base font-bold text-espresso-950 dark:text-white">
                    Aging Inventory & Capital Lock-up Analysis
                </h2>
                <p class="text-xs text-[#8F8379] mt-0.5">
                    Articles with ready finished units tying up atelier capital. Total capital in stock: <strong class="text-espresso-950 dark:text-white font-mono">PKR {{ number_format($totalTiedUpCapital) }}</strong>
                </p>
            </div>
            
            <a 
                href="{{ route('admin.analytics.export.inventory') }}" 
                class="px-3 py-1.5 rounded-xl border border-[#DFD6CB] dark:border-[#382D27] text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#201A18] text-xs font-semibold flex items-center gap-1.5 transition-colors self-start sm:self-center"
            >
                <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                <span>Export Valuation (CSV)</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">PRODUCT / SKU</th>
                        <th class="py-3 px-3">COLLECTION</th>
                        <th class="py-3 px-3 text-center">UNITS IN STOCK</th>
                        <th class="py-3 px-4 text-right">UNIT PRICE</th>
                        <th class="py-3 px-4 text-right">TIED-UP CAPITAL</th>
                        <th class="py-3 px-4">VELOCITY CLASSIFICATION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($agingInventory->take(10) as $item)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-espresso-950 dark:text-white">
                                    {{ $item['name'] }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-mono">
                                    {{ $item['sku'] }}
                                </div>
                            </td>
                            <td class="py-3.5 px-3 text-gray-500">
                                {{ $item['category'] }}
                            </td>
                            <td class="py-3.5 px-3 text-center font-mono font-bold text-xs text-espresso-950 dark:text-white">
                                {{ $item['stock'] }} units
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono text-gray-500">
                                PKR {{ number_format($item['price']) }}
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-amber-600 dark:text-gold-400">
                                PKR {{ number_format($item['tied_up_pkr']) }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($item['slow_moving'])
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-300">
                                        Slow Moving (Bundle / Perk Advised)
                                    </span>
                                @elseif($item['stock'] <= 5)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border border-rose-300">
                                        Low Buffer (Replenish)
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-300">
                                        Optimal Turnover
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400">
                                No inventory records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- One-Click Export Dialog Modal -->
    <dialog id="exportModal" class="rounded-3xl p-0 shadow-2xl">
        <div class="p-6 sm:p-7">
            <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="download" class="w-5 h-5 text-tan-600 dark:text-gold-400"></i>
                    <h3 class="font-cinzel text-lg font-bold text-tan-600 dark:text-gold-400">Export Atelier Reports</h3>
                </div>
                <button type="button" onclick="document.getElementById('exportModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-4">
                
                <!-- Option 1: Daily Closing Sales & Cashier Audit Summary (PDF & CSV) -->
                <div class="p-4 rounded-2xl bg-amber-50/50 dark:bg-[#2A1E14] border border-amber-300/60 dark:border-amber-700/40 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-bold text-xs text-espresso-950 dark:text-white flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span>1. Daily Sales & Cashier Closing (Z-Report)</span>
                            </div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">
                                Complete day-end reconciliation: Gross sales, COGS, Net profit, COD vs Bank breakdown, and itemized pieces sold.
                            </div>
                        </div>
                    </div>

                    <div 
                        class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2"
                        x-data="{ closingDate: '{{ date('Y-m-d') }}' }"
                    >
                        <input 
                            type="date" 
                            x-model="closingDate"
                            class="px-2.5 py-1.5 text-xs rounded-xl border border-amber-300 dark:border-amber-700 bg-white dark:bg-[#1E1612] text-espresso-900 dark:text-white font-mono"
                        >
                        <a 
                            :href="'{{ route('admin.analytics.daily-closing') }}?date=' + closingDate"
                            target="_blank"
                            class="py-1.5 px-3.5 rounded-xl bg-tan-600 hover:bg-tan-700 text-white font-bold text-xs transition-colors flex items-center justify-center gap-1.5 shadow-xs"
                        >
                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                            <span>Print / Save PDF</span>
                        </a>
                        <a 
                            :href="'{{ route('admin.analytics.daily-closing.csv') }}?date=' + closingDate"
                            class="py-1.5 px-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-1.5"
                        >
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            <span>Export CSV</span>
                        </a>
                    </div>
                </div>

                <!-- Option 2: Executive Period Sales Report (PDF) -->
                <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB] dark:border-[#382D27] space-y-2.5">
                    <div>
                        <div class="font-bold text-xs text-espresso-950 dark:text-white">2. Executive Sales & Margin Report (PDF)</div>
                        <div class="text-[10px] text-gray-400">High-resolution printable executive dossier with KPIs and order ledger</div>
                    </div>

                    <form action="{{ route('admin.analytics.sales-report.pdf') }}" method="GET" target="_blank" class="flex items-center gap-2">
                        <select 
                            name="timeframe" 
                            class="px-2.5 py-1.5 text-xs rounded-xl border border-[#DFD6CB] dark:border-[#382D27] bg-white dark:bg-[#28201C] text-espresso-900 dark:text-white focus:outline-hidden"
                        >
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month" selected>This Month ({{ date('F') }})</option>
                            <option value="this_year">Fiscal Year {{ date('Y') }}</option>
                        </select>
                        <button 
                            type="submit" 
                            class="flex-1 py-1.5 px-3 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-1.5"
                        >
                            <i data-lucide="file-text" class="w-3.5 h-3.5 text-gold-400"></i>
                            <span>Generate PDF Report</span>
                        </button>
                    </form>
                </div>

                <!-- Option 3: Monthly Orders CSV -->
                <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB] dark:border-[#382D27] space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-bold text-xs text-espresso-950 dark:text-white">3. Monthly Orders Ledger (CSV)</div>
                            <div class="text-[10px] text-gray-400">Clean order breakdown with clients, cities, courier tracking, and totals</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.analytics.export.orders') }}" method="GET" class="flex items-center gap-2">
                        <input 
                            type="month" 
                            name="month" 
                            value="{{ date('Y-m') }}" 
                            class="px-2.5 py-1.5 text-xs rounded-xl border border-[#DFD6CB] dark:border-[#382D27] bg-white dark:bg-[#28201C] text-espresso-900 dark:text-white focus:outline-hidden"
                        >
                        <button 
                            type="submit" 
                            class="flex-1 py-1.5 px-3 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-1.5"
                        >
                            <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                            <span>Download Month CSV</span>
                        </button>
                    </form>
                </div>

                <!-- Option 4: Tax & Fiscal Summary -->
                <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB] dark:border-[#382D27] space-y-2.5">
                    <div class="font-bold text-xs text-espresso-950 dark:text-white">4. Tax & PRA Fiscal Summary (CSV)</div>
                    <div class="text-[10px] text-gray-400">12-month taxable revenue, gross sales, and PRA 5% withholding schedule</div>

                    <form action="{{ route('admin.analytics.export.tax') }}" method="GET" class="flex items-center gap-2">
                        <select 
                            name="year" 
                            class="px-2.5 py-1.5 text-xs rounded-xl border border-[#DFD6CB] dark:border-[#382D27] bg-white dark:bg-[#28201C] text-espresso-900 dark:text-white focus:outline-hidden"
                        >
                            <option value="{{ date('Y') }}">Year {{ date('Y') }}</option>
                            <option value="{{ date('Y') - 1 }}">Year {{ date('Y') - 1 }}</option>
                        </select>
                        <button 
                            type="submit" 
                            class="flex-1 py-1.5 px-3 rounded-xl bg-purple-900 hover:bg-purple-800 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-1.5"
                        >
                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                            <span>Download Tax Report</span>
                        </button>
                    </form>
                </div>

                <!-- Option 5: Inventory Valuation -->
                <div class="p-4 rounded-2xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#E0D7CB] dark:border-[#382D27] flex items-center justify-between">
                    <div>
                        <div class="font-bold text-xs text-espresso-950 dark:text-white">5. Inventory Capital Valuation (CSV)</div>
                        <div class="text-[10px] text-gray-400">Live capital locked in stock per SKU and slow-moving warnings</div>
                    </div>
                    <a 
                        href="{{ route('admin.analytics.export.inventory') }}" 
                        class="py-1.5 px-3 rounded-xl bg-tan-600 hover:bg-espresso-900 text-white font-semibold text-xs transition-colors flex items-center gap-1.5 shrink-0"
                    >
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Download</span>
                    </a>
                </div>

            </div>

            <div class="flex items-center justify-end pt-4 mt-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('exportModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </dialog>

</div>

@endsection

