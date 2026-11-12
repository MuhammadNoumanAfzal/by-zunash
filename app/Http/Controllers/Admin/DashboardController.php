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

    /**
     * Unified Live Notifications Poll for Orders, Inquiries, and Customer Reviews
     */
    public function liveNotifications(Request $request)
    {
        $lastOrderId = (int) $request->input('last_order_id', 0);
        $lastInquiryId = (int) $request->input('last_inquiry_id', 0);
        $lastReviewId = (int) $request->input('last_review_id', 0);

        // Unread counts across all active modules
        $unreadOrders = Order::where('is_read', false)->count();
        $unreadInquiries = Inquiry::where('status', 'unread')->orWhere('is_read', false)->count();
        $pendingReviews = \App\Models\Review::where('status', 'pending')->count();
        $totalUnread = $unreadOrders + $unreadInquiries + $pendingReviews;

        // Detect newest item for instant toast alert
        $newOrder = null;
        if ($lastOrderId > 0) {
            $newOrder = Order::where('id', '>', $lastOrderId)->latest('id')->first();
        }
        $newInquiry = null;
        if ($lastInquiryId > 0) {
            $newInquiry = Inquiry::where('id', '>', $lastInquiryId)->latest('id')->first();
        }
        $newReview = null;
        if ($lastReviewId > 0) {
            $newReview = \App\Models\Review::where('id', '>', $lastReviewId)->latest('id')->first();
        }

        $toast = null;
        if ($newOrder) {
            $toast = [
                'type' => 'order',
                'title' => '🛍️ New Order Placed!',
                'headline' => $newOrder->order_number . ' • Rs. ' . number_format($newOrder->total),
                'subtext' => $newOrder->customer_name . ' (' . $newOrder->city . ')',
                'url' => route('admin.orders.show', $newOrder),
            ];
        } elseif ($newInquiry) {
            $toast = [
                'type' => 'inquiry',
                'title' => '💬 New Customer Message!',
                'headline' => $newInquiry->subject ?: 'General Atelier Inquiry',
                'subtext' => $newInquiry->name . ' (' . ($newInquiry->phone ?: $newInquiry->email) . ')',
                'url' => route('admin.messages.index'),
            ];
        } elseif ($newReview) {
            $toast = [
                'type' => 'review',
                'title' => '⭐ New Customer Review!',
                'headline' => $newReview->rating . '★ on ' . ($newReview->product_name ?: 'Leather Article'),
                'subtext' => 'by ' . $newReview->author . ' (' . $newReview->city . ')',
                'url' => route('admin.reviews.index'),
            ];
        }

        // Recent unread items for notification dropdown
        $recentOrders = Order::where('is_read', false)
            ->latest('id')
            ->limit(4)
            ->get()
            ->map(fn($o) => [
                'id' => $o->id,
                'type' => 'order',
                'title' => $o->order_number,
                'sub' => $o->customer_name . ' • ' . $o->city,
                'amount' => 'Rs. ' . number_format($o->total),
                'time' => $o->created_at->diffForHumans(),
                'url' => route('admin.orders.show', $o),
            ]);

        $recentInquiries = Inquiry::where(function($q) {
                $q->where('status', 'unread')->orWhere('is_read', false);
            })
            ->latest('id')
            ->limit(4)
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'type' => 'inquiry',
                'title' => $m->name,
                'sub' => $m->subject ?: \Illuminate\Support\Str::limit($m->message, 40),
                'amount' => null,
                'time' => $m->created_at->diffForHumans(),
                'url' => route('admin.messages.index'),
            ]);

        $recentReviews = \App\Models\Review::where('status', 'pending')
            ->latest('id')
            ->limit(4)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'type' => 'review',
                'title' => $r->author . ' (' . $r->rating . '★)',
                'sub' => $r->product_name ?: 'Atelier Creation',
                'amount' => null,
                'time' => $r->created_at->diffForHumans(),
                'url' => route('admin.reviews.index'),
            ]);

        return response()->json([
            'total_unread' => $totalUnread,
            'unread_orders' => $unreadOrders,
            'unread_inquiries' => $unreadInquiries,
            'pending_reviews' => $pendingReviews,
            'max_order_id' => (int) (Order::max('id') ?? 0),
            'max_inquiry_id' => (int) (Inquiry::max('id') ?? 0),
            'max_review_id' => (int) (\App\Models\Review::max('id') ?? 0),
            'toast' => $toast,
            'orders' => $recentOrders,
            'inquiries' => $recentInquiries,
            'reviews' => $recentReviews,
        ]);
    }

    /**
     * Mark all pending notifications across orders, inquiries, and reviews as read
     */
    public function markAllNotificationsRead(Request $request)
    {
        Order::where('is_read', false)->update(['is_read' => true]);
        Inquiry::where('status', 'unread')->orWhere('is_read', false)->update(['status' => 'resolved', 'is_read' => true]);
        \App\Models\Review::where('status', 'pending')->update(['status' => 'published']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }
        return back()->with('toast_success', 'All notifications marked as read.');
    }
}
