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
}

