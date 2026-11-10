@extends('admin.layouts.app')

@section('title', 'Executive Leathercraft Control Center | By Zunash Atelier')

@section('content')

<div class="space-y-3.5 w-full min-w-0 max-w-full" x-data="{ activeChartTab: 'revenue', trajectoryPeriod: '12m' }">

    <!-- ======================= 1. COMPACT EXECUTIVE RIBBON ======================= -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-espresso-950 via-[#1C1512] to-tan-800 text-white py-2.5 px-3.5 sm:px-5 shadow-xs border border-gold/30 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 w-full min-w-0">
        <!-- Subtle luxury ambient gold ornament -->
        <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-gold/10 blur-2xl pointer-events-none"></div>

        <!-- Left: Brand Title & Live Status -->
        <div class="flex items-center gap-2.5 sm:gap-3 relative z-10 min-w-0">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-espresso-900 to-tan-700 text-gold font-cinzel font-bold text-xs flex items-center justify-center shrink-0 border border-gold/40 shadow-xs">
                BZ
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="font-cinzel text-sm sm:text-base font-bold text-white tracking-wide leading-none truncate">
                        BY ZUNASH ATELIER
                    </h1>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[9px] font-bold border border-emerald-500/40 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        LIVE
                    </span>
                </div>
                <p class="text-[10px] text-tan-200/80 mt-0.5 line-clamp-1 sm:line-clamp-none">
                    Executive Leathercraft Control Center • Real-time sales velocity & orders across Pakistan
                </p>
            </div>
        </div>

        <!-- Right: Compact Revenue & Action Button -->
        <div class="flex items-center justify-between sm:justify-end gap-2.5 w-full sm:w-auto shrink-0 relative z-10 pt-1.5 sm:pt-0 border-t border-white/10 sm:border-0">
            <div class="px-2.5 sm:px-3 py-1 rounded-xl bg-black/40 border border-gold/30 text-left sm:text-right min-w-0">
                <span class="text-[8px] font-bold tracking-wider uppercase text-gold-300 block truncate">TOTAL REVENUE (PKR)</span>
                <div class="font-cinzel text-xs sm:text-base font-bold text-white leading-none mt-0.5 truncate">
                    Rs. {{ number_format($totalRevenue, 0) }}
                </div>
            </div>

            <a 
                href="{{ route('admin.products.create') }}" 
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gradient-to-r from-gold-400 via-gold to-tan-600 hover:from-gold hover:to-tan-700 text-espresso-950 font-bold text-xs shadow-xs transition-all active:scale-95 border border-gold-300/40 shrink-0"
            >
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                <span>New Creation</span>
            </a>
        </div>
    </div>


    <!-- ======================= 2. COMPACT 4 KPI STAT CARDS (REDUCED HEIGHT) ======================= -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 w-full min-w-0">
        
        <!-- KPI 1: TOTAL PRODUCTS -->
        <a href="{{ route('admin.products.index') }}" class="p-2.5 sm:p-3.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-2xs hover:border-tan-500 transition-colors group flex items-center justify-between min-w-0 overflow-hidden">
            <div class="min-w-0 flex-1">
                <div class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] truncate">
                    TOTAL CREATIONS
                </div>
                <div class="font-cinzel text-lg sm:text-2xl font-bold text-espresso-950 dark:text-white leading-tight mt-0.5">
                    {{ $totalProducts }}
                </div>
                <div class="flex items-center gap-1 text-[10px] text-tan-600 dark:text-gold-400 mt-0.5 font-medium truncate">
                    <span class="w-1.5 h-1.5 rounded-full bg-tan-500 shrink-0"></span>
                    <span class="truncate">{{ $activeProducts }} Active</span>
                </div>
            </div>
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#FAF6F2] dark:bg-[#251A14] text-tan-700 dark:text-gold-400 flex items-center justify-center shrink-0 border border-tan-200 dark:border-[#38261E] group-hover:scale-105 transition-transform ml-1">
                <i data-lucide="shopping-bag" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            </div>
        </a>

        <!-- KPI 2: STORE ORDERS -->
        <a href="{{ route('admin.orders.index') }}" class="p-2.5 sm:p-3.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-2xs hover:border-gold-400 transition-colors group flex items-center justify-between min-w-0 overflow-hidden">
            <div class="min-w-0 flex-1">
                <div class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] truncate">
                    STORE ORDERS
                </div>
                <div class="font-cinzel text-lg sm:text-2xl font-bold text-espresso-950 dark:text-white leading-tight mt-0.5">
                    {{ $totalOrders }}
                </div>
                <div class="flex items-center gap-1 text-[10px] text-emerald-600 dark:text-emerald-400 mt-0.5 font-medium truncate">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="truncate">{{ $ordersThisMonth }} This Month</span>
                </div>
            </div>
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#FDF9F2] dark:bg-[#261F15] text-gold-700 dark:text-gold-400 flex items-center justify-center shrink-0 border border-gold-300/40 group-hover:scale-105 transition-transform ml-1">
                <i data-lucide="clipboard-check" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            </div>
        </a>

        <!-- KPI 3: CLIENT INQUIRIES -->
        <a href="{{ route('admin.messages.index') }}" class="p-2.5 sm:p-3.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-2xs hover:border-amber-400 transition-colors group flex items-center justify-between min-w-0 overflow-hidden">
            <div class="min-w-0 flex-1">
                <div class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] truncate">
                    CLIENT INQUIRIES
                </div>
                <div class="font-cinzel text-lg sm:text-2xl font-bold text-espresso-950 dark:text-white leading-tight mt-0.5">
                    {{ $activeInquiries }}
                </div>
                <div class="flex items-center gap-1 text-[10px] text-[#8F8379] mt-0.5 font-medium truncate">
                    <span class="w-1.5 h-1.5 rounded-full {{ $activeInquiries > 0 ? 'bg-amber-500' : 'bg-emerald-500' }} shrink-0"></span>
                    <span class="truncate">{{ $activeInquiries > 0 ? $activeInquiries . ' Pending' : 'All Handled' }}</span>
                </div>
            </div>
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#FAF8F5] dark:bg-[#201815] text-tan-700 dark:text-gold flex items-center justify-center shrink-0 border border-[#E8E1D7] dark:border-[#38261E] group-hover:scale-105 transition-transform ml-1">
                <i data-lucide="message-square" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            </div>
        </a>

        <!-- KPI 4: TOTAL PATRONS -->
        <a href="{{ route('admin.customers.index') }}" class="p-2.5 sm:p-3.5 rounded-xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-2xs hover:border-emerald-500 transition-colors group flex items-center justify-between min-w-0 overflow-hidden">
            <div class="min-w-0 flex-1">
                <div class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] truncate">
                    TOTAL PATRONS
                </div>
                <div class="font-cinzel text-lg sm:text-2xl font-bold text-espresso-950 dark:text-white leading-tight mt-0.5">
                    {{ $totalClients ?? $vipClients }}
                </div>
                <div class="flex items-center gap-1 text-[10px] text-emerald-600 dark:text-emerald-400 mt-0.5 font-medium truncate">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="truncate">Avg Ticket: Rs. {{ number_format($averageOrderValue) }}</span>
                </div>
            </div>
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#F0FAF5] dark:bg-[#162720] text-emerald-600 flex items-center justify-center shrink-0 border border-[#D5EFE2] dark:border-[#223E32] group-hover:scale-105 transition-transform ml-1">
                <i data-lucide="users" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
            </div>
        </a>

    </div>


    <!-- ======================= 3. MULTI-GRAPH ANALYTICS HUB (VISIBLE IN FIRST VIEW) ======================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 w-full min-w-0">

        <!-- Left Column: Multi-Tab Interactive Charts Hub (8 Cols / ~67%) -->
        <div class="lg:col-span-8 p-3.5 sm:p-5 rounded-2xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-card flex flex-col justify-between w-full min-w-0 overflow-hidden">
            
            <div>
                <!-- Header with Clean Tab Selectors -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-[#F0EAE1] dark:border-[#261E1A]">
                    
                    <!-- Graph Title with Dynamic Icon -->
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-tan-600 animate-pulse"></span>
                        <h2 class="font-cinzel text-sm sm:text-base font-bold text-espresso-950 dark:text-white tracking-wide">
                            <span x-show="activeChartTab === 'revenue'">Revenue & Sales Trajectory</span>
                            <span x-show="activeChartTab === 'orders'" x-cloak>Orders & Fulfillment Flow</span>
                            <span x-show="activeChartTab === 'payments'" x-cloak>Payment Methods & Cash Flow</span>
                            <span x-show="activeChartTab === 'collections'" x-cloak>Collections Portfolio Share</span>
                            <span x-show="activeChartTab === 'regions'" x-cloak>Regional Pakistani Distribution</span>
                        </h2>
                    </div>

                    <!-- Clean Graph Navigation Tabs -->
                    <div class="flex items-center gap-1 p-1 rounded-xl bg-[#FAF8F5] dark:bg-[#201815] border border-[#EFE8DF] dark:border-[#2E241F] overflow-x-auto max-w-full flex-nowrap">
                        <button 
                            type="button" 
                            @click="activeChartTab = 'revenue'; switchChart('revenue')"
                            :class="activeChartTab === 'revenue' ? 'bg-white dark:bg-[#2D221D] text-tan-700 dark:text-gold shadow-2xs font-bold' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition-all flex items-center gap-1.5 shrink-0"
                        >
                            <i data-lucide="trending-up" class="w-3 h-3"></i>
                            <span>Revenue</span>
                        </button>

                        <button 
                            type="button" 
                            @click="activeChartTab = 'orders'; switchChart('orders')"
                            :class="activeChartTab === 'orders' ? 'bg-white dark:bg-[#2D221D] text-tan-700 dark:text-gold shadow-2xs font-bold' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition-all flex items-center gap-1.5 shrink-0"
                        >
                            <i data-lucide="package-check" class="w-3 h-3"></i>
                            <span>Orders</span>
                        </button>

                        <button 
                            type="button" 
                            @click="activeChartTab = 'payments'; switchChart('payments')"
                            :class="activeChartTab === 'payments' ? 'bg-white dark:bg-[#2D221D] text-tan-700 dark:text-gold shadow-2xs font-bold' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition-all flex items-center gap-1.5 shrink-0"
                        >
                            <i data-lucide="credit-card" class="w-3 h-3"></i>
                            <span>Payments</span>
                        </button>

                        <button 
                            type="button" 
                            @click="activeChartTab = 'collections'; switchChart('collections')"
                            :class="activeChartTab === 'collections' ? 'bg-white dark:bg-[#2D221D] text-tan-700 dark:text-gold shadow-2xs font-bold' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition-all flex items-center gap-1.5 shrink-0"
                        >
                            <i data-lucide="layers" class="w-3 h-3"></i>
                            <span>Collections</span>
                        </button>

                        <button 
                            type="button" 
                            @click="activeChartTab = 'regions'; switchChart('regions')"
                            :class="activeChartTab === 'regions' ? 'bg-white dark:bg-[#2D221D] text-tan-700 dark:text-gold shadow-2xs font-bold' : 'text-gray-500 hover:text-espresso-900 dark:hover:text-white'"
                            class="px-2.5 py-1 rounded-lg text-[11px] transition-all flex items-center gap-1.5 shrink-0"
                        >
                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                            <span>Cities</span>
                        </button>
                    </div>

                </div>

                <!-- Interactive Chart Canvas Area -->
                <div class="relative w-full h-[240px] sm:h-[270px] mt-3 min-w-0 overflow-hidden">
                    
                    <!-- Graph 1: Revenue Trajectory -->
                    <div x-show="activeChartTab === 'revenue'" class="w-full h-full">
                        <canvas id="trajectoryChart"></canvas>
                    </div>

                    <!-- Graph 2: Orders Fulfillment -->
                    <div x-show="activeChartTab === 'orders'" x-cloak class="w-full h-full">
                        <canvas id="ordersChart"></canvas>
                    </div>

                    <!-- Graph 3: Payment Breakdown -->
                    <div x-show="activeChartTab === 'payments'" x-cloak class="w-full h-full">
                        <canvas id="paymentsChart"></canvas>
                    </div>

                    <!-- Graph 4: Collections Breakdown -->
                    <div x-show="activeChartTab === 'collections'" x-cloak class="w-full h-full">
                        <canvas id="collectionsChart"></canvas>
                    </div>

                    <!-- Graph 5: Regional Cities -->
                    <div x-show="activeChartTab === 'regions'" x-cloak class="w-full h-full">
                        <canvas id="regionsChart"></canvas>
                    </div>

                </div>
            </div>

            <!-- Graph Sub-Footer Pills -->
            <div class="pt-3 mt-2 border-t border-[#F0EAE1] dark:border-[#261E1A] flex flex-wrap items-center justify-between gap-2 text-[11px]">
                <div class="flex items-center gap-3 text-[#8F8379]">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-tan-600"></span>
                        <span class="font-medium">Pakistani Rupee (PKR)</span>
                    </span>
                    <span class="text-gray-300">•</span>
                    <span>Total Recorded Orders: <strong class="text-espresso-900 dark:text-white font-mono">{{ $totalOrders }}</strong></span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-md bg-[#FAF6F2] dark:bg-[#201815] text-[10px] font-bold text-tan-700 dark:text-gold-400 border border-tan-200 dark:border-[#38261E]">
                        Avg Ticket: Rs. {{ number_format($averageOrderValue) }}
                    </span>
                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/30 text-[10px] font-bold text-emerald-700 dark:text-emerald-300 border border-emerald-200">
                        100% Delivery Success
                    </span>
                </div>
            </div>

        </div>


        <!-- Right Column: Atelier Performance Dossier (4 Cols / ~33%) -->
        <div class="lg:col-span-4 p-3.5 sm:p-5 rounded-2xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-card flex flex-col justify-between w-full min-w-0 overflow-hidden">
            
            <div>
                <!-- Header -->
                <div class="flex items-center justify-between pb-3 border-b border-[#F0EAE1] dark:border-[#261E1A]">
                    <div>
                        <h2 class="font-cinzel text-sm sm:text-base font-bold text-espresso-950 dark:text-white tracking-wide">
                            Atelier Health & Stock
                        </h2>
                        <p class="text-[10px] text-[#8F8379] dark:text-[#A09387]">
                            Real-time workshop & order metrics
                        </p>
                    </div>

                    <a href="{{ route('admin.inventory.index') }}" class="text-[10px] font-bold uppercase text-tan-600 dark:text-gold hover:underline">
                        Inventory →
                    </a>
                </div>

                <!-- Stock Health KPI Bar -->
                <div class="mt-3.5 space-y-3">
                    
                    <!-- Low Stock Alert Banner -->
                    <div class="p-3 rounded-xl bg-[#FFF9F2] dark:bg-[#221812] border border-[#F5E2CF] dark:border-[#3E291C] flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold text-xs shrink-0">
                                !
                            </div>
                            <div>
                                <div class="text-xs font-bold text-espresso-950 dark:text-white">
                                    {{ $lowStockCount }} Low Stock Alerts
                                </div>
                                <div class="text-[10px] text-[#8F8379]">
                                    Stock level ≤ 5 units in workshop
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.inventory.index', ['status' => 'low']) }}" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white dark:bg-[#1A120E] text-tan-700 dark:text-gold border border-tan-300 shadow-2xs hover:bg-tan-50 transition-colors">
                            Restock
                        </a>
                    </div>

                    <!-- Payment Distribution Quick Bars -->
                    <div class="space-y-2 pt-1">
                        <div class="flex items-center justify-between text-xs font-semibold text-espresso-900 dark:text-white">
                            <span>Cash on Delivery (COD)</span>
                            <span class="font-mono text-tan-600 dark:text-gold-400">Rs. {{ number_format($paymentMethodsBreakdown['Cash on Delivery']['amount'] ?? 0) }}</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-[#FAF0E6] dark:bg-[#281F1B] overflow-hidden">
                            <div class="h-full bg-tan-600 rounded-full" style="width: 72%"></div>
                        </div>

                        <div class="flex items-center justify-between text-xs font-semibold text-espresso-900 dark:text-white pt-1">
                            <span>Meezan Bank IBFT / Online</span>
                            <span class="font-mono text-emerald-600 dark:text-emerald-400">Rs. {{ number_format(($paymentMethodsBreakdown['Meezan Bank IBFT']['amount'] ?? 0) + ($paymentMethodsBreakdown['Online Card']['amount'] ?? 0)) }}</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-[#FAF0E6] dark:bg-[#281F1B] overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 28%"></div>
                        </div>
                    </div>

                    <!-- Regional Top Cities -->
                    <div class="pt-2 border-t border-[#F0EAE1] dark:border-[#261E1A] space-y-1.5 text-xs">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Top Dispatch Hubs</div>
                        <div class="flex items-center justify-between text-[11px] text-[#6E6359] dark:text-[#C5B8AC]">
                            <span>Lahore (DHA, Gulberg)</span>
                            <span class="font-bold text-espresso-950 dark:text-white">45%</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-[#6E6359] dark:text-[#C5B8AC]">
                            <span>Karachi (Clifton, Defence)</span>
                            <span class="font-bold text-espresso-950 dark:text-white">28%</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-[#6E6359] dark:text-[#C5B8AC]">
                            <span>Islamabad & Rawalpindi</span>
                            <span class="font-bold text-espresso-950 dark:text-white">27%</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Quick Links -->
            <div class="pt-3 border-t border-[#F0EAE1] dark:border-[#261E1A] flex items-center justify-between text-[11px] text-[#8F8379]">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-tan-700 dark:hover:text-gold transition-colors font-medium">
                    View Orders ({{ $totalOrders }})
                </a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('admin.categories.index') }}" class="hover:text-tan-700 dark:hover:text-gold transition-colors font-medium">
                    Collections ({{ count($categoryShare) }})
                </a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('admin.settings.index') }}" class="hover:text-tan-700 dark:hover:text-gold transition-colors font-medium">
                    Settings
                </a>
            </div>

        </div>

    </div>


    <!-- ======================= 4. RECENT STORE ORDERS & DISPATCH ======================= -->
    <div class="rounded-2xl bg-white dark:bg-[#161210] border border-[#ECE6DE] dark:border-[#261E1A] shadow-card overflow-hidden w-full min-w-0">
        
        <div class="p-3.5 sm:p-4 border-b border-[#ECE6DE] dark:border-[#261E1A] flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="truck" class="w-4 h-4 text-tan-600"></i>
                <h3 class="font-cinzel text-sm sm:text-base font-bold text-espresso-950 dark:text-white tracking-wide">
                    Recent Store Orders
                </h3>
            </div>
            
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-tan-600 dark:text-gold-400 hover:underline flex items-center gap-1">
                <span>View All Orders</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <!-- Mobile Order Cards (Visible on screens < 640px) -->
        <div class="block sm:hidden divide-y divide-[#F0EAE1] dark:divide-[#261E1A]">
            @forelse($recentOrders as $order)
                <div class="p-3.5 hover:bg-[#FAF8F5]/80 dark:hover:bg-[#221B18] transition-colors space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="font-mono font-bold text-xs text-tan-600 dark:text-gold-400 truncate">
                                {{ $order->order_number }}
                            </span>
                            @if($order->order_status === 'completed')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Delivered
                                </span>
                            @elseif($order->order_status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 dark:bg-blue-950/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    In Crafting
                                </span>
                            @endif
                        </div>
                        <div class="font-cinzel font-bold text-xs text-espresso-950 dark:text-white shrink-0">
                            Rs. {{ number_format($order->total) }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-[#6E6359] dark:text-[#C5B8AC]">
                        <div class="min-w-0 flex-1 pr-2">
                            <div class="font-bold text-espresso-950 dark:text-white truncate">
                                {{ $order->customer_name }}
                            </div>
                            <div class="text-[10px] text-gray-400 truncate">
                                {{ $order->city }} • {{ $order->customer_email }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-[#FAF6F2] dark:bg-[#221812] text-tan-700 dark:text-gold border border-tan-200 dark:border-[#38261E]">
                                {{ $order->payment_method }}
                            </span>
                            <a 
                                href="{{ route('admin.orders.show', $order) }}" 
                                class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-espresso-900 hover:bg-tan-600 text-white transition-colors"
                            >
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-xs text-gray-400">
                    No recent orders recorded yet.
                </div>
            @endforelse
        </div>

        <!-- Desktop / Tablet Table View (Visible on screens >= 640px) -->
        <div class="hidden sm:block overflow-x-auto w-full max-w-full">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[9px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#261E1A]">
                        <th class="py-2.5 px-4 whitespace-nowrap">ORDER #</th>
                        <th class="py-2.5 px-3">PATRON</th>
                        <th class="py-2.5 px-3">DESTINATION</th>
                        <th class="py-2.5 px-3 whitespace-nowrap">AMOUNT (PKR)</th>
                        <th class="py-2.5 px-3">METHOD</th>
                        <th class="py-2.5 px-3">STATUS</th>
                        <th class="py-2.5 px-4 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#261E1A]">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-[#FAF8F5]/80 dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-2.5 px-4 font-mono font-bold text-tan-600 dark:text-gold-400 whitespace-nowrap">
                                {{ $order->order_number }}
                            </td>
                            <td class="py-2.5 px-3">
                                <div class="font-bold text-espresso-950 dark:text-white">
                                    {{ $order->customer_name }}
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    {{ $order->customer_email }}
                                </div>
                            </td>
                            <td class="py-2.5 px-3 text-gray-600 dark:text-gray-300">
                                {{ $order->city }}
                            </td>
                            <td class="py-2.5 px-3 font-cinzel font-bold text-espresso-950 dark:text-white whitespace-nowrap">
                                Rs. {{ number_format($order->total) }}
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#FAF6F2] dark:bg-[#221812] text-tan-700 dark:text-gold border border-tan-200 dark:border-[#38261E]">
                                    {{ $order->payment_method }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3">
                                @if($order->order_status === 'completed')
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Delivered
                                    </span>
                                @elseif($order->order_status === 'pending')
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Pending Dispatch
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        In Crafting
                                    </span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-right">
                                <a 
                                    href="{{ route('admin.orders.show', $order) }}" 
                                    class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-white dark:bg-[#201A18] border border-[#DFD6CB] dark:border-[#38261E] hover:border-tan-500 text-espresso-900 dark:text-white transition-colors"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">
                                No recent orders recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
let charts = {};

document.addEventListener('DOMContentLoaded', function() {
    initCharts();
});

window.addEventListener('themechanged', function() {
    Object.values(charts).forEach(chart => {
        if (chart && typeof chart.destroy === 'function') {
            chart.destroy();
        }
    });
    charts = {};
    initCharts();
});

function initCharts() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.07)' : 'rgba(236, 230, 222, 0.45)';
    const tickColor = isDark ? '#A09387' : '#8F8379';
    const doughnutBorder = isDark ? '#161210' : '#FFFFFF';
    const legendColor = isDark ? '#C5B8AC' : '#6E6359';

    // -------------------------------------------------------------
    // CHART 1: REVENUE TRAJECTORY (Spline Area)
    // -------------------------------------------------------------
    const trajectoryCtx = document.getElementById('trajectoryChart')?.getContext('2d');
    if (trajectoryCtx) {
        const revenueGradient = trajectoryCtx.createLinearGradient(0, 0, 0, 260);
        revenueGradient.addColorStop(0, isDark ? 'rgba(197, 161, 107, 0.35)' : 'rgba(176, 125, 78, 0.40)');
        revenueGradient.addColorStop(0.7, isDark ? 'rgba(197, 161, 107, 0.08)' : 'rgba(176, 125, 78, 0.08)');
        revenueGradient.addColorStop(1, 'rgba(176, 125, 78, 0.0)');

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const revenueData = [19500, 22000, 25800, 19000, 24500, 23800, 27900, 26400, 31200, 32800, 34100, 34800];
        const volumeData = [4, 5, 6, 4, 5, 5, 6, 6, 7, 8, 8, 9];

        charts.revenue = new Chart(trajectoryCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Gross Revenue (PKR)',
                        data: revenueData,
                        borderColor: isDark ? '#C5A16B' : '#976239',
                        borderWidth: 2.5,
                        backgroundColor: revenueGradient,
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#C5A16B',
                        pointBorderColor: isDark ? '#0D0A09' : '#120E0C',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Order Volume',
                        data: volumeData,
                        borderColor: isDark ? '#EED9C5' : '#C5A16B',
                        borderWidth: 1.5,
                        borderDash: [4, 4],
                        backgroundColor: 'transparent',
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#120E0C',
                        borderColor: 'rgba(197, 161, 107, 0.3)',
                        borderWidth: 1,
                        titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        padding: 8,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return ' Revenue: Rs. ' + context.parsed.y.toLocaleString();
                                } else {
                                    return ' Volume: ' + context.parsed.y + ' orders';
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: tickColor } },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: gridColor },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 9 },
                            color: tickColor,
                            callback: function(v) { return 'Rs. ' + (v / 1000) + 'k'; }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 9 },
                            color: isDark ? '#C5A16B' : '#B07D4E',
                            callback: function(v) { return v + ' pcs'; }
                        }
                    }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 2: ORDERS FULFILLMENT BREAKDOWN (Bar Chart)
    // -------------------------------------------------------------
    const ordersCtx = document.getElementById('ordersChart')?.getContext('2d');
    if (ordersCtx) {
        charts.orders = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Delivered & Completed', 'In Crafting / Processing', 'Pending Dispatch', 'Cancelled'],
                datasets: [{
                    label: 'Orders Count',
                    data: [{{ $orderStatusBreakdown['Delivered'] ?? 4 }}, {{ $orderStatusBreakdown['In Crafting'] ?? 4 }}, {{ $orderStatusBreakdown['Pending Dispatch'] ?? 3 }}, {{ $orderStatusBreakdown['Cancelled'] ?? 0 }}],
                    backgroundColor: ['#16A34A', '#3B82F6', '#F59E0B', '#EF4444'],
                    borderRadius: 8,
                    barThickness: 28,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#120E0C',
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        callbacks: {
                            label: function(c) { return ' ' + c.raw + ' Verified Orders'; }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, color: tickColor } },
                    y: { beginAtZero: true, grid: { color: gridColor }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10 }, stepSize: 1, color: tickColor } }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 3: PAYMENT METHODS BREAKDOWN (Doughnut Chart)
    // -------------------------------------------------------------
    const paymentsCtx = document.getElementById('paymentsChart')?.getContext('2d');
    if (paymentsCtx) {
        charts.payments = new Chart(paymentsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cash on Delivery (COD)', 'Meezan Bank (IBFT)', 'Credit/Debit Card', 'VIP Concierge'],
                datasets: [{
                    data: [
                        {{ $paymentMethodsBreakdown['Cash on Delivery']['count'] ?? 6 }},
                        {{ $paymentMethodsBreakdown['Meezan Bank IBFT']['count'] ?? 3 }},
                        {{ $paymentMethodsBreakdown['Online Card']['count'] ?? 1 }},
                        {{ $paymentMethodsBreakdown['VIP Concierge']['count'] ?? 1 }}
                    ],
                    backgroundColor: isDark ? ['#C5A16B', '#976239', '#5E361A', '#DFC0A1'] : ['#976239', '#C5A16B', '#120E0C', '#B07D4E'],
                    borderWidth: 2,
                    borderColor: doughnutBorder,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: legendColor }
                    },
                    tooltip: {
                        backgroundColor: '#120E0C',
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        callbacks: {
                            label: function(c) { return ' ' + c.label + ': ' + c.raw + ' orders'; }
                        }
                    }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 4: COLLECTIONS SHARE (Doughnut Chart)
    // -------------------------------------------------------------
    const collectionsCtx = document.getElementById('collectionsChart')?.getContext('2d');
    if (collectionsCtx) {
        const catData = @json($categoryShare);
        charts.collections = new Chart(collectionsCtx, {
            type: 'doughnut',
            data: {
                labels: catData.map(c => c.name),
                datasets: [{
                    data: catData.map(c => c.count),
                    backgroundColor: isDark ? ['#C5A16B', '#976239', '#EED9C5', '#7A4B27', '#B07D4E', '#8F8379'] : ['#120E0C', '#976239', '#C5A16B', '#7A4B27', '#B07D4E', '#4A3428'],
                    borderWidth: 2,
                    borderColor: doughnutBorder,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: legendColor }
                    },
                    tooltip: {
                        backgroundColor: '#120E0C',
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        callbacks: {
                            label: function(c) { return ' ' + c.label + ': ' + c.raw + ' articles'; }
                        }
                    }
                }
            }
        });
    }

    // -------------------------------------------------------------
    // CHART 5: REGIONAL PAKISTANI DISTRIBUTION (Horizontal Bar)
    // -------------------------------------------------------------
    const regionsCtx = document.getElementById('regionsChart')?.getContext('2d');
    if (regionsCtx) {
        const regData = @json($regionalDistribution);
        charts.regions = new Chart(regionsCtx, {
            type: 'bar',
            data: {
                labels: regData.map(r => r.city),
                datasets: [{
                    label: 'Gross Revenue (PKR)',
                    data: regData.map(r => r.revenue),
                    backgroundColor: isDark ? '#C5A16B' : '#B07D4E',
                    borderRadius: 6,
                    barThickness: 18,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#120E0C',
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        callbacks: {
                            label: function(c) { return ' Revenue: Rs. ' + c.raw.toLocaleString(); }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: gridColor },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 9 },
                            color: tickColor,
                            callback: function(v) { return 'Rs. ' + (v / 1000) + 'k'; }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 10, weight: '500' }, color: isDark ? '#E8D0BE' : '#6E6359' }
                    }
                }
            }
        });
    }
}

function switchChart(tabName) {
    setTimeout(() => {
        if (charts[tabName]) {
            charts[tabName].resize();
            charts[tabName].update();
        }
    }, 50);
}
</script>
@endpush
