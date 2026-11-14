<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    /**
     * Financial & Analytics Dashboard
     */
    public function index(Request $request)
    {
        $period = $request->input('period', '30_days');

        $query = Order::query();

        $startDate = match ($period) {
            'this_month' => Carbon::now()->startOfMonth(),
            'last_month' => Carbon::now()->subMonth()->startOfMonth(),
            '90_days' => Carbon::now()->subDays(90),
            'this_year' => Carbon::now()->startOfYear(),
            'all_time' => Carbon::create(2020, 1, 1),
            default => Carbon::now()->subDays(30),
        };

        if ($period === 'last_month') {
            $endDate = Carbon::now()->subMonth()->endOfMonth();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            $query->where('created_at', '>=', $startDate);
        }

        $allOrders = $query->orderBy('created_at', 'desc')->get();

        // Core Financial Metrics (Real Accounting)
        $totalOrdersCount = $allOrders->count();
        $deliveredOrders = $allOrders->whereIn('order_status', ['completed', 'delivered']);
        $returnedOrders = $allOrders->where('order_status', 'returned');
        $dispatchedOrders = $allOrders->where('order_status', 'dispatched');

        $grossRevenue = (float) $deliveredOrders->sum('total');
        $totalDiscount = (float) $allOrders->sum('discount');
        $netSales = $grossRevenue;

        // Real Cost of Goods Sold (Actual Product Purchase/Crafting Costs)
        $cogs = 0;
        foreach ($deliveredOrders as $ord) {
            $cogs += $ord->total_cost;
        }

        // Real Return Losses from failed courier deliveries
        $returnLosses = (float) $returnedOrders->sum('return_courier_charge');
        $grossProfit = max(0, $netSales - $cogs - $returnLosses);
        $profitMargin = $netSales > 0 ? round(($grossProfit / $netSales) * 100, 1) : 0;
        $averageOrderValue = $deliveredOrders->count() > 0 ? round($netSales / $deliveredOrders->count()) : ($totalOrdersCount > 0 ? round($allOrders->sum('total') / $totalOrdersCount) : 0);

        // Estimated Tax / PRA breakdown (Assuming 5% withholding / sales tax applicable)
        $taxCollected = round($netSales * 0.05, 2);

        // Category Profitability Analysis
        $categorySales = [];
        foreach ($allOrders as $order) {
            if (is_array($order->items)) {
                foreach ($order->items as $item) {
                    $cat = $item['category'] ?? $item['category_name'] ?? 'Bespoke Leather';
                    $lineTotal = (float)($item['price'] ?? 0) * (int)($item['quantity'] ?? $item['qty'] ?? 1);
                    if (!isset($categorySales[$cat])) {
                        $categorySales[$cat] = [
                            'name' => $cat,
                            'revenue' => 0,
                            'units' => 0,
                        ];
                    }
                    $categorySales[$cat]['revenue'] += $lineTotal;
                    $categorySales[$cat]['units'] += (int)($item['quantity'] ?? $item['qty'] ?? 1);
                }
            }
        }

        // If orders table is freshly seeded or items lack category keys, supplement with product relations
        if (empty($categorySales)) {
            $dbCategories = Category::all();
            foreach ($dbCategories as $c) {
                $categorySales[$c->name] = [
                    'name' => $c->name,
                    'revenue' => 0,
                    'units' => 0,
                ];
            }
        }

        // Compute profitability percentages
        $profitableCategories = collect($categorySales)->map(function ($c) use ($netSales) {
            $rev = $c['revenue'];
            $estCogs = $rev * 0.40;
            $margin = $rev - $estCogs;
            $share = $netSales > 0 ? round(($rev / $netSales) * 100, 1) : 0;
            return [
                'name' => $c['name'],
                'revenue' => $rev,
                'units' => $c['units'],
                'gross_margin' => $margin,
                'share' => $share,
            ];
        })->sortByDesc('revenue')->values();

        // Slow-Moving / Aging Inventory: Products in stock but not sold recently
        $products = Product::where('stock_quantity', '>', 0)->get();
        $agingInventory = $products->map(function ($p) {
            $capitalTiedUp = $p->stock_quantity * $p->price;
            $daysInAtelier = $p->created_at ? $p->created_at->diffInDays(now()) : 45;
            $isSlowMoving = $p->stock_quantity >= 5 && $daysInAtelier >= 20;

            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
                'category' => $p->category_name ?: 'Leather',
                'stock' => $p->stock_quantity,
                'price' => $p->price,
                'tied_up_pkr' => $capitalTiedUp,
                'days_active' => $daysInAtelier,
                'slow_moving' => $isSlowMoving,
            ];
        })->sortByDesc('tied_up_pkr')->values();

        $totalTiedUpCapital = $agingInventory->sum('tied_up_pkr');
        $slowMovingItemsCount = $agingInventory->where('slow_moving', true)->count();

        // Monthly Trajectory for Bar / Trend Visuals
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $monthStart = $m->copy()->startOfMonth();
            $monthEnd = $m->copy()->endOfMonth();
            $mRev = (float) Order::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total');
            $mOrders = Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $monthlyRevenue[] = [
                'month' => $m->format('M Y'),
                'revenue' => $mRev,
                'orders' => $mOrders,
            ];
        }

        // Payment Methods Breakdown
        $paymentBreakdown = [
            'COD' => Order::where('payment_method', 'COD')->count(),
            'BANK_TRANSFER' => Order::where('payment_method', 'BANK_TRANSFER')->count(),
            'CREDIT_CARD' => Order::where('payment_method', 'CREDIT_CARD')->count(),
            'VIP_CONCIERGE' => Order::where('payment_method', 'VIP_CONCIERGE')->count(),
        ];

        return view('admin.analytics.index', compact(
            'period',
            'totalOrdersCount',
            'grossRevenue',
            'totalDiscount',
            'netSales',
            'cogs',
            'grossProfit',
            'profitMargin',
            'averageOrderValue',
            'taxCollected',
            'profitableCategories',
            'agingInventory',
            'totalTiedUpCapital',
            'slowMovingItemsCount',
            'monthlyRevenue',
            'paymentBreakdown'
        ));
    }

    /**
     * Download Clean Monthly Orders CSV
     */
    public function exportOrders(Request $request)
    {
        $timeframe = $request->input('timeframe', 'this_month');
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $query = Order::query();
        $label = 'orders_report_' . date('Y-m-d');

        if ($timeframe === 'today') {
            $query->whereDate('created_at', now()->toDateString());
            $label = 'orders_daily_' . now()->format('Y-m-d');
        } elseif ($timeframe === 'yesterday') {
            $query->whereDate('created_at', now()->subDay()->toDateString());
            $label = 'orders_yesterday_' . now()->subDay()->format('Y-m-d');
        } elseif ($timeframe === 'this_week') {
            $query->where('created_at', '>=', now()->startOfWeek());
            $label = 'orders_weekly_' . now()->format('Y-W');
        } elseif ($timeframe === 'this_month') {
            $month = $request->input('month', date('Y-m'));
            $start = Carbon::parse($month)->startOfMonth();
            $end = Carbon::parse($month)->endOfMonth();
            $query->whereBetween('created_at', [$start, $end]);
            $label = 'orders_monthly_' . $start->format('Y-m');
        } elseif ($timeframe === 'this_year') {
            $query->where('created_at', '>=', now()->startOfYear());
            $label = 'orders_yearly_' . now()->format('Y');
        } elseif ($timeframe === 'custom' && $startDateInput && $endDateInput) {
            $start = Carbon::parse($startDateInput)->startOfDay();
            $end = Carbon::parse($endDateInput)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $label = 'orders_' . $start->format('Y-m-d') . '_to_' . $end->format('Y-m-d');
        } elseif ($request->filled('month')) {
            $month = $request->input('month');
            $start = Carbon::parse($month)->startOfMonth();
            $end = Carbon::parse($month)->endOfMonth();
            $query->whereBetween('created_at', [$start, $end]);
            $label = 'orders_' . $month;
        }

        $orders = $query->orderBy('created_at', 'asc')->get();
        $fileName = 'byzunash_' . $label . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');
            // BOM for UTF-8 Excel support
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Columns Header
            fputcsv($handle, [
                'Order Number',
                'Date',
                'Time',
                'Customer Name',
                'Phone',
                'Email',
                'City',
                'Order Status',
                'Courier Name',
                'Tracking Number',
                'Payment Method',
                'Payment Status',
                'Gross Revenue (PKR)',
                'Product Cost / COGS (PKR)',
                'Return Courier Loss (PKR)',
                'Net Profit / Loss (PKR)',
                'Return Reason',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d'),
                    $order->created_at->format('H:i:s'),
                    $order->customer_name,
                    $order->customer_phone,
                    $order->customer_email,
                    $order->city,
                    ucfirst($order->order_status),
                    $order->courier_name ?: 'None',
                    $order->tracking_number ?: 'N/A',
                    $order->payment_method,
                    $order->payment_status,
                    number_format($order->total, 2, '.', ''),
                    number_format($order->total_cost, 2, '.', ''),
                    number_format((float)($order->return_courier_charge ?? 0), 2, '.', ''),
                    number_format($order->net_profit, 2, '.', ''),
                    $order->return_reason ?: 'N/A',
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Download Clean Tax & Revenue Summary CSV
     */
    public function exportTaxSummary(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $fileName = 'byzunash_tax_revenue_' . $year . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($year) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Month',
                'Orders Count',
                'Gross Revenue (PKR)',
                'Discounts Given (PKR)',
                'Net Taxable Revenue (PKR)',
                'Estimated PRA / Sales Tax (5%)',
                'COGS Est. (42%)',
                'Gross Margin / Retained Atelier (PKR)',
            ]);

            for ($m = 1; $m <= 12; $m++) {
                $start = Carbon::create($year, $m, 1)->startOfMonth();
                $end = Carbon::create($year, $m, 1)->endOfMonth();

                $orders = Order::whereBetween('created_at', [$start, $end]);
                $count = $orders->count();
                $gross = (float) $orders->sum('total');
                $discount = (float) $orders->sum('discount');
                $net = $gross;
                $tax = round($net * 0.05, 2);
                $cogs = round($net * 0.42, 2);
                $retained = $net - $cogs - $tax;

                fputcsv($handle, [
                    $start->format('F Y'),
                    $count,
                    number_format($gross, 2, '.', ''),
                    number_format($discount, 2, '.', ''),
                    number_format($net, 2, '.', ''),
                    number_format($tax, 2, '.', ''),
                    number_format($cogs, 2, '.', ''),
                    number_format($retained, 2, '.', ''),
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Download Aging / Slow-Moving Inventory Valuation CSV
     */
    public function exportAgingInventory()
    {
        $fileName = 'byzunash_inventory_valuation_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $products = Product::orderBy('stock_quantity', 'desc')->get();

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBF) . chr(0xBD));

            fputcsv($handle, [
                'Product Name',
                'SKU',
                'Collection',
                'Availability Mode',
                'Units In Stock',
                'Unit Price (PKR)',
                'Capital Valuation (PKR)',
                'Stock Classification',
            ]);

            foreach ($products as $p) {
                $val = $p->stock_quantity * $p->price;
                $status = $p->stock_quantity <= 0 ? 'Sold Out' : ($p->stock_quantity <= 5 ? 'Low Stock' : ($p->stock_quantity > 20 ? 'Slow Moving / Overstock' : 'Healthy Buffer'));

                fputcsv($handle, [
                    $p->name,
                    $p->sku,
                    $p->category_name ?: ucfirst($p->category_slug),
                    $p->availability,
                    $p->stock_quantity,
                    number_format($p->price, 2, '.', ''),
                    number_format($val, 2, '.', ''),
                    $status,
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Printable & PDF Daily Closing Summary (Z-Report)
     */
    public function dailyClosing(Request $request)
    {
        $dateInput = $request->input('date', now()->toDateString());
        $closingDate = Carbon::parse($dateInput)->startOfDay();
        $closingDateEnd = Carbon::parse($dateInput)->endOfDay();

        $orders = Order::whereBetween('created_at', [$closingDate, $closingDateEnd])
            ->orderBy('created_at', 'asc')
            ->get();

        // Financial Totals
        $ordersCount = $orders->count();
        $grossSales = (float) $orders->sum('total');
        $totalDiscount = (float) $orders->sum('discount');
        $subtotal = (float) $orders->sum('subtotal');
        $shippingCollected = (float) $orders->sum('shipping_fee');

        $totalCogs = 0;
        $totalNetProfit = 0;
        foreach ($orders as $o) {
            $totalCogs += $o->total_cost;
            $totalNetProfit += $o->net_profit;
        }

        $grossMarginPercent = $grossSales > 0 ? round(($totalNetProfit / $grossSales) * 100, 1) : 0;
        $aov = $ordersCount > 0 ? round($grossSales / $ordersCount) : 0;

        // Payment Channel Breakdown
        $paymentMethods = [
            'cod' => ['label' => 'Cash on Delivery (Nationwide COD)', 'count' => 0, 'amount' => 0],
            'bank' => ['label' => 'Direct Bank Transfer (Instant IBFT)', 'count' => 0, 'amount' => 0],
            'jazzcash' => ['label' => 'JazzCash Mobile Account', 'count' => 0, 'amount' => 0],
            'easypaisa' => ['label' => 'EasyPaisa Mobile Account', 'count' => 0, 'amount' => 0],
        ];

        $paymentStatusSummary = [
            'paid' => ['count' => 0, 'amount' => 0],
            'pending' => ['count' => 0, 'amount' => 0],
        ];

        foreach ($orders as $o) {
            $method = strtolower($o->payment_method ?? 'cod');
            if (!isset($paymentMethods[$method])) {
                $paymentMethods[$method] = ['label' => ucfirst($method), 'count' => 0, 'amount' => 0];
            }
            $paymentMethods[$method]['count']++;
            $paymentMethods[$method]['amount'] += $o->total;

            $pStatus = strtolower($o->payment_status ?? 'pending');
            if ($pStatus === 'paid') {
                $paymentStatusSummary['paid']['count']++;
                $paymentStatusSummary['paid']['amount'] += $o->total;
            } else {
                $paymentStatusSummary['pending']['count']++;
                $paymentStatusSummary['pending']['amount'] += $o->total;
            }
        }

        // Fulfillment Breakdown
        $fulfillmentSummary = [
            'pending' => $orders->whereIn('order_status', ['pending', 'placed', 'processing', 'in_production'])->count(),
            'dispatched' => $orders->where('order_status', 'dispatched')->count(),
            'completed' => $orders->whereIn('order_status', ['completed', 'delivered'])->count(),
            'returned' => $orders->where('order_status', 'returned')->count(),
            'cancelled' => $orders->where('order_status', 'cancelled')->count(),
        ];

        // Itemized Articles / Creations Sold Today
        $itemsSold = [];
        $totalUnitsSold = 0;
        foreach ($orders as $o) {
            if (is_array($o->items)) {
                foreach ($o->items as $item) {
                    $itemKey = ($item['id'] ?? 'item') . '-' . ($item['variant'] ?? ($item['color'] ?? 'default'));
                    $qty = (int)($item['quantity'] ?? $item['qty'] ?? 1);
                    $price = (float)($item['price'] ?? 0);
                    $cost = (float)($item['cost_price'] ?? 0);
                    if ($cost <= 0 && !empty($item['id'])) {
                        $prod = Product::find($item['id']);
                        if ($prod && $prod->cost_price > 0) $cost = (float)$prod->cost_price;
                    }
                    if ($cost <= 0) $cost = round($price * 0.40, 2);

                    if (!isset($itemsSold[$itemKey])) {
                        $itemsSold[$itemKey] = [
                            'name' => $item['name'] ?? 'Bespoke Item',
                            'variant' => $item['variant'] ?? ($item['color'] ?? '-'),
                            'sku' => $item['sku'] ?? 'N/A',
                            'quantity' => 0,
                            'unit_price' => $price,
                            'unit_cost' => $cost,
                            'total_sales' => 0,
                            'total_profit' => 0,
                        ];
                    }

                    $itemsSold[$itemKey]['quantity'] += $qty;
                    $itemsSold[$itemKey]['total_sales'] += ($price * $qty);
                    $itemsSold[$itemKey]['total_profit'] += (($price - $cost) * $qty);
                    $totalUnitsSold += $qty;
                }
            }
        }

        $totalReturnLoss = (float) $orders->where('order_status', 'returned')->sum('return_courier_charge');

        return view('admin.analytics.daily-closing-pdf', compact(
            'closingDate',
            'orders',
            'ordersCount',
            'grossSales',
            'totalDiscount',
            'subtotal',
            'shippingCollected',
            'totalCogs',
            'totalNetProfit',
            'grossMarginPercent',
            'aov',
            'paymentMethods',
            'paymentStatusSummary',
            'fulfillmentSummary',
            'itemsSold',
            'totalUnitsSold',
            'totalReturnLoss'
        ));
    }

    /**
     * Download Clean Daily Closing Summary CSV
     */
    public function exportDailyClosingCsv(Request $request)
    {
        $dateInput = $request->input('date', now()->toDateString());
        $closingDate = Carbon::parse($dateInput)->startOfDay();
        $closingDateEnd = Carbon::parse($dateInput)->endOfDay();

        $orders = Order::whereBetween('created_at', [$closingDate, $closingDateEnd])
            ->orderBy('created_at', 'asc')
            ->get();

        $fileName = 'byzunash_daily_closing_' . $closingDate->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($orders, $closingDate) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Section 1: Closing Summary Meta
            fputcsv($handle, ['BY ZUNASH LEATHER ATELIER - DAILY SALES & CASHIER CLOSING REPORT']);
            fputcsv($handle, ['Closing Date', $closingDate->format('d F Y (l)')]);
            fputcsv($handle, ['Generated At', now()->format('Y-m-d H:i:s')]);
            fputcsv($handle, ['Total Orders Booked', $orders->count()]);
            fputcsv($handle, ['Gross Revenue (PKR)', number_format((float)$orders->sum('total'), 2, '.', '')]);
            fputcsv($handle, ['Discounts Given (PKR)', number_format((float)$orders->sum('discount'), 2, '.', '')]);
            fputcsv($handle, ['Total COGS / Product Cost (PKR)', number_format((float)$orders->sum(fn($o) => $o->total_cost), 2, '.', '')]);
            fputcsv($handle, ['Net Retained Profit (PKR)', number_format((float)$orders->sum(fn($o) => $o->net_profit), 2, '.', '')]);
            fputcsv($handle, []);

            // Section 2: Detailed Orders Table
            fputcsv($handle, [
                'Order #',
                'Time',
                'Customer Name',
                'Phone',
                'City',
                'Payment Mode',
                'Payment Status',
                'Order Status',
                'Courier / Tracking',
                'Subtotal (PKR)',
                'Discount (PKR)',
                'Total (PKR)',
                'Cost (PKR)',
                'Net Profit (PKR)',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->created_at->format('H:i:s'),
                    $order->customer_name,
                    $order->customer_phone,
                    $order->city,
                    strtoupper($order->payment_method),
                    strtoupper($order->payment_status),
                    strtoupper($order->order_status),
                    ($order->courier_name ? $order->courier_name . ': ' : '') . ($order->tracking_number ?: 'N/A'),
                    number_format($order->subtotal, 2, '.', ''),
                    number_format($order->discount, 2, '.', ''),
                    number_format($order->total, 2, '.', ''),
                    number_format($order->total_cost, 2, '.', ''),
                    number_format($order->net_profit, 2, '.', ''),
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Printable & PDF Comprehensive Sales & Profit Report
     */
    public function salesReportPdf(Request $request)
    {
        $timeframe = $request->input('timeframe', 'this_month');
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $query = Order::query();
        $reportTitle = 'Executive Sales & Profit Report';

        if ($timeframe === 'today') {
            $query->whereDate('created_at', now()->toDateString());
            $periodLabel = 'Today (' . now()->format('d M Y') . ')';
        } elseif ($timeframe === 'yesterday') {
            $query->whereDate('created_at', now()->subDay()->toDateString());
            $periodLabel = 'Yesterday (' . now()->subDay()->format('d M Y') . ')';
        } elseif ($timeframe === 'this_week') {
            $query->where('created_at', '>=', now()->startOfWeek());
            $periodLabel = 'This Week (' . now()->startOfWeek()->format('d M') . ' – ' . now()->format('d M Y') . ')';
        } elseif ($timeframe === 'this_month') {
            $month = $request->input('month', date('Y-m'));
            $start = Carbon::parse($month)->startOfMonth();
            $end = Carbon::parse($month)->endOfMonth();
            $query->whereBetween('created_at', [$start, $end]);
            $periodLabel = 'Month of ' . $start->format('F Y');
        } elseif ($timeframe === 'this_year') {
            $query->where('created_at', '>=', now()->startOfYear());
            $periodLabel = 'Year ' . now()->format('Y');
        } elseif ($timeframe === 'custom' && $startDateInput && $endDateInput) {
            $start = Carbon::parse($startDateInput)->startOfDay();
            $end = Carbon::parse($endDateInput)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $periodLabel = $start->format('d M Y') . ' to ' . $end->format('d M Y');
        } else {
            $query->where('created_at', '>=', now()->startOfMonth());
            $periodLabel = 'Month of ' . now()->format('F Y');
        }

        $orders = $query->orderBy('created_at', 'asc')->get();

        $ordersCount = $orders->count();
        $grossSales = (float) $orders->sum('total');
        $totalDiscount = (float) $orders->sum('discount');
        $totalCogs = 0;
        $totalNetProfit = 0;
        foreach ($orders as $o) {
            $totalCogs += $o->total_cost;
            $totalNetProfit += $o->net_profit;
        }
        $marginPercent = $grossSales > 0 ? round(($totalNetProfit / $grossSales) * 100, 1) : 0;
        $aov = $ordersCount > 0 ? round($grossSales / $ordersCount) : 0;

        return view('admin.analytics.sales-report-pdf', compact(
            'orders',
            'periodLabel',
            'reportTitle',
            'ordersCount',
            'grossSales',
            'totalDiscount',
            'totalCogs',
            'totalNetProfit',
            'marginPercent',
            'aov'
        ));
    }
}

