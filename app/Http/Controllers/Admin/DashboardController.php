<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Executive Atelier Control Center Dashboard
     */
    public function index()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('in_stock', true)->count();
        $lowStockCount = Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();

        $totalOrders = Order::count();
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();
        $totalRevenue = Order::sum('total');
        $averageOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        $activeInquiries = Inquiry::where('status', 'unread')->count();
        $totalClients = Customer::count();
        $vipClients = $totalClients; // backward compat

        // Recent Store Orders
        $recentOrders = Order::latest()->take(5)->get();

        // Unread or recent concierge inquiries
        $conciergeInquiries = Inquiry::latest()->take(5)->get();

        // Category Portfolio Share (for the Donut Chart)
        $categories = Category::withCount('products')->get();
        $categoryShare = $categories->map(function ($cat) use ($totalProducts) {
            $percentage = $totalProducts > 0 ? round(($cat->products_count / $totalProducts) * 100) : 0;
            return [
                'name' => $cat->name,
                'slug' => $cat->slug,
                'count' => $cat->products_count,
                'percentage' => $percentage,
            ];
        });

        // 1. 12-Month Revenue & Sales Trajectory Curve (Dynamic Trailing 12 Months)
        $monthlyTrajectory = [];
        for ($i = 11; $i >= 0; $i--) {
            $targetDate = now()->subMonths($i);
            $year = $targetDate->year;
            $month = $targetDate->month;
            $monthLabel = $targetDate->format('M');

            $rev = (int) Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('order_status', '!=', 'cancelled')
                ->sum('total');

            $vol = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('order_status', '!=', 'cancelled')
                ->count();

            $monthlyTrajectory[] = [
                'month' => $monthLabel,
                'revenue' => $rev,
                'volume' => $vol,
            ];
        }

        // 2. 7-Day Velocity (Dynamic Trailing 7 Days)
        $weeklyTrajectory = [];
        for ($i = 6; $i >= 0; $i--) {
            $targetDay = now()->subDays($i);
            $dayLabel = $targetDay->format('D');

            $rev = (int) Order::whereDate('created_at', $targetDay->toDateString())
                ->where('order_status', '!=', 'cancelled')
                ->sum('total');

            $ord = Order::whereDate('created_at', $targetDay->toDateString())
                ->where('order_status', '!=', 'cancelled')
                ->count();

            $weeklyTrajectory[] = [
                'day' => $dayLabel,
                'revenue' => $rev,
                'orders' => $ord,
            ];
        }

        // 3. Orders Fulfillment Status Breakdown
        $orderStatusBreakdown = [
            'Delivered' => Order::where('order_status', 'completed')->count(),
            'In Crafting' => Order::where('order_status', 'processing')->count(),
            'Pending Dispatch' => Order::where('order_status', 'pending')->count(),
            'Cancelled' => Order::where('order_status', 'cancelled')->count(),
        ];

        // 4. Payment Methods Breakdown
        $paymentMethodsBreakdown = [
            'Cash on Delivery' => [
                'count' => Order::where('payment_method', 'COD')->count(),
                'amount' => (int) Order::where('payment_method', 'COD')->sum('total'),
            ],
            'Meezan Bank IBFT' => [
                'count' => Order::where('payment_method', 'BANK_TRANSFER')->count(),
                'amount' => (int) Order::where('payment_method', 'BANK_TRANSFER')->sum('total'),
            ],
            'Online Card' => [
                'count' => Order::where('payment_method', 'CREDIT_CARD')->count(),
                'amount' => (int) Order::where('payment_method', 'CREDIT_CARD')->sum('total'),
            ],
            'VIP Concierge' => [
                'count' => Order::where('payment_method', 'VIP_CONCIERGE')->count(),
                'amount' => (int) Order::where('payment_method', 'VIP_CONCIERGE')->sum('total'),
            ],
        ];

        // 5. Regional Pakistani City Distribution
        $cities = Order::whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city')
            ->selectRaw('count(*) as count, sum(total) as revenue')
            ->groupBy('city')
            ->orderByDesc('revenue')
            ->get();

        if ($cities->isEmpty()) {
            $regionalDistribution = collect([]);
        } else {
            $regionalDistribution = $cities->map(function ($c) use ($totalRevenue) {
                $pct = $totalRevenue > 0 ? round(($c->revenue / $totalRevenue) * 100) : 0;
                return [
                    'city' => $c->city,
                    'orders' => $c->count,
                    'revenue' => (int) $c->revenue,
                    'share' => $pct,
                ];
            });
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'lowStockCount',
            'outOfStockCount',
            'totalOrders',
            'ordersThisMonth',
            'totalRevenue',
            'averageOrderValue',
            'activeInquiries',
            'vipClients',
            'totalClients',
            'recentOrders',
            'conciergeInquiries',
            'categoryShare',
            'monthlyTrajectory',
            'weeklyTrajectory',
            'orderStatusBreakdown',
            'paymentMethodsBreakdown',
            'regionalDistribution'
        ));
    }
}
