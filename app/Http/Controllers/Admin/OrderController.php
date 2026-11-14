<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display orders table with search and filtering.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('payment') && $request->input('payment') !== 'all') {
            $pay = $request->input('payment');
            $query->where(function($q) use ($pay) {
                $q->where('payment_method', $pay)
                  ->orWhere('payment_method', strtoupper($pay));
            });
        }

        if ($request->filled('unread')) {
            $query->where('is_read', false);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $totalOrders = Order::count();
        $deliveredOrders = Order::whereIn('order_status', ['completed', 'delivered'])->count();
        $dispatchedOrders = Order::where('order_status', 'dispatched')->count();
        $returnedOrders = Order::where('order_status', 'returned')->count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();
        $unreadOrders = Order::where('is_read', false)->count();
        $totalRevenue = (float) Order::whereIn('order_status', ['completed', 'delivered'])->sum('total');
        $deliveryRate = $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100, 1) : 0;
        $returnRate = $totalOrders > 0 ? round(($returnedOrders / $totalOrders) * 100, 1) : 0;
        $totalReturnLoss = \Illuminate\Support\Facades\Schema::hasColumn('orders', 'return_courier_charge')
            ? (float) Order::where('order_status', 'returned')->sum('return_courier_charge')
            : 0;

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'deliveredOrders',
            'dispatchedOrders',
            'returnedOrders',
            'pendingOrders',
            'cancelledOrders',
            'unreadOrders',
            'totalRevenue',
            'deliveryRate',
            'returnRate',
            'totalReturnLoss'
        ));
    }

    /**
     * Show single order details.
     */
    public function show(Order $order)
    {
        if (!$order->is_read) {
            $order->update(['is_read' => true]);
        }
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Live API poll for new orders, unread count & notification toasts.
     */
    public function liveCheck(Request $request)
    {
        $unreadCount = Order::where('is_read', false)->count();
        $lastSeenId = (int) $request->input('last_id', 0);

        $newOrdersQuery = Order::query();
        if ($lastSeenId > 0) {
            $newOrdersQuery->where('id', '>', $lastSeenId);
        }

        $latestNew = $lastSeenId > 0 ? $newOrdersQuery->latest('id')->first() : null;

        $recentUnread = Order::where('is_read', false)
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(function ($ord) {
                return [
                    'id' => $ord->id,
                    'order_number' => $ord->order_number,
                    'customer_name' => $ord->customer_name,
                    'city' => $ord->city,
                    'total' => number_format($ord->total),
                    'payment_method' => $ord->payment_method,
                    'time_ago' => $ord->created_at->diffForHumans(),
                    'url' => route('admin.orders.show', $ord),
                ];
            });

        $maxId = (int) (Order::max('id') ?? 0);

        return response()->json([
            'unread_count' => $unreadCount,
            'max_id' => $maxId,
            'new_order' => $latestNew ? [
                'id' => $latestNew->id,
                'order_number' => $latestNew->order_number,
                'customer_name' => $latestNew->customer_name,
                'city' => $latestNew->city,
                'total' => number_format($latestNew->total),
                'payment_method' => $latestNew->payment_method,
                'url' => route('admin.orders.show', $latestNew),
            ] : null,
            'recent_unread' => $recentUnread,
        ]);
    }

    /**
     * Mark all unread orders as read.
     */
    public function markAllRead(Request $request)
    {
        Order::where('is_read', false)->update(['is_read' => true]);
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }
        return back()->with('toast_success', 'All orders marked as read.');
    }

    /**
     * Toggle read/unread flag for a single order.
     */
    public function toggleRead(Order $order)
    {
        $order->update(['is_read' => !$order->is_read]);
        $status = $order->is_read ? 'read' : 'unread';
        return back()->with('toast_success', "Order #{$order->order_number} marked as {$status}.");
    }

    /**
     * Update order & payment status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,dispatched,completed,delivered,returned,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'return_reason' => 'nullable|string|max:255',
            'return_courier_charge' => 'nullable|numeric|min:0',
        ]);

        $data = $validated;
        if (in_array($validated['order_status'], ['completed', 'delivered'])) {
            $data['delivered_at'] = now();
            if ($validated['payment_status'] === 'pending') {
                $data['payment_status'] = 'paid';
            }
        } elseif ($validated['order_status'] === 'dispatched') {
            $data['dispatched_at'] = $order->dispatched_at ?: now();
        } elseif ($validated['order_status'] === 'returned') {
            $data['returned_at'] = now();
            $data['payment_status'] = 'failed';
            if (!isset($data['return_courier_charge']) || $data['return_courier_charge'] === null) {
                $data['return_courier_charge'] = 250.00;
            }
        }

        $order->update($data);

        return back()->with('toast_success', "Order #{$order->order_number} status updated to " . ucfirst($order->order_status));
    }

    /**
     * Update Courier & Tracking details with optional WhatsApp redirect.
     */
    public function updateCourier(Request $request, Order $order)
    {
        $validated = $request->validate([
            'courier_name' => 'required|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'tracking_url' => 'nullable|url|max:500',
            'mark_dispatched' => 'nullable|boolean',
        ]);

        $data = [
            'courier_name' => $validated['courier_name'],
            'tracking_number' => $validated['tracking_number'] ?? null,
            'tracking_url' => $validated['tracking_url'] ?? null,
        ];

        if ($request->boolean('mark_dispatched')) {
            $data['order_status'] = 'dispatched';
            $data['dispatched_at'] = now();
        }

        $order->update($data);

        if ($request->boolean('open_whatsapp')) {
            $phone = $order->whatsapp_phone;
            $msg = urlencode($order->whatsapp_dispatch_message);
            return redirect("https://wa.me/{$phone}?text={$msg}");
        }

        return back()->with('toast_success', "Courier & tracking updated for Order #{$order->order_number}.");
    }

    /**
     * Handle Bulk Actions (Bulk Dispatch, Bulk Print Slips, Bulk Export CSV, Bulk Delete).
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $orderIds = $request->input('order_ids', []);

        if (empty($orderIds) || !is_array($orderIds)) {
            return back()->with('toast_error', 'Please select at least one order to perform a bulk action.');
        }

        $orders = Order::whereIn('id', $orderIds)->latest()->get();

        if ($action === 'dispatch') {
            Order::whereIn('id', $orderIds)->update([
                'order_status' => 'completed',
                'dispatched_at' => now(),
            ]);
            return back()->with('toast_success', count($orderIds) . ' orders marked as Dispatched & Closed.');
        }

        if ($action === 'print_slips') {
            return view('admin.orders.bulk-packing-slips', compact('orders'));
        }

        if ($action === 'export_csv') {
            $filename = 'ByZunash_Orders_Courier_Export_' . now()->format('Y-m-d_Hi') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function () use ($orders) {
                $file = fopen('php://output', 'w');
                // UTF-8 BOM for Excel
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Order #',
                    'Date',
                    'Customer Name',
                    'Phone',
                    'City',
                    'Shipping Address',
                    'Postal Code',
                    'Payment Method',
                    'COD Collection Amount (PKR)',
                    'Order Status',
                    'Courier',
                    'Tracking ID',
                    'Items Summary',
                    'Client Delivery Notes'
                ]);

                foreach ($orders as $order) {
                    $codAmount = $order->payment_method === 'COD' ? $order->total : 0;
                    
                    $itemNames = [];
                    if (is_array($order->items)) {
                        foreach ($order->items as $it) {
                            $itemNames[] = ($it['name'] ?? 'Item') . ' (x' . ($it['quantity'] ?? 1) . ')';
                        }
                    }
                    $itemsSummary = implode(', ', $itemNames);

                    fputcsv($file, [
                        $order->order_number,
                        $order->created_at ? $order->created_at->format('Y-m-d H:i') : '',
                        $order->customer_name,
                        $order->customer_phone,
                        $order->city,
                        $order->shipping_address,
                        $order->postal_code,
                        $order->payment_method,
                        $codAmount,
                        $order->order_status,
                        $order->courier_name ?: 'TCS Express',
                        $order->tracking_number ?: '',
                        $itemsSummary,
                        $order->order_notes ?: ''
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($action === 'delete') {
            Order::whereIn('id', $orderIds)->delete();
            return back()->with('toast_success', count($orderIds) . ' orders permanently deleted.');
        }

        return back()->with('toast_error', 'Invalid bulk action.');
    }

    /**
     * Printable invoice view.
     */
    public function invoice(Order $order)
    {
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Printable delivery & packaging dispatch slip.
     */
    public function packingSlip(Order $order)
    {
        return view('admin.orders.packing-slip', compact('order'));
    }

    /**
     * Printable payment receipt & voucher.
     */
    public function receipt(Order $order)
    {
        return view('admin.orders.receipt', compact('order'));
    }

    /**
     * Printable orders report & manifest.
     */
    public function printReport(Request $request)
    {
        $query = Order::query();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('payment') && $request->input('payment') !== 'all') {
            $pay = $request->input('payment');
            $query->where(function($q) use ($pay) {
                $q->where('payment_method', $pay)
                  ->orWhere('payment_method', strtoupper($pay));
            });
        }

        $orders = $query->latest()->get();
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('order_status', 'completed')->count();
        $pendingOrders = $orders->where('order_status', 'pending')->count();
        $totalRevenue = $orders->sum('total');

        return view('admin.orders.report', compact(
            'orders',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalRevenue'
        ));
    }

    /**
     * Delete order record.
     */
    public function destroy(Order $order)
    {
        $orderNum = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('toast_success', "Order #{$orderNum} has been deleted.");
    }
}
