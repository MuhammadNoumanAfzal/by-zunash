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
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('payment') && $request->input('payment') !== 'all') {
            $query->where('payment_method', $request->input('payment'));
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $totalOrders = Order::count();
        $completedOrders = Order::where('order_status', 'completed')->count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalRevenue = Order::sum('total');

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalRevenue'
        ));
    }

    /**
     * Show single order details.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order & payment status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update($validated);

        return back()->with('toast_success', "Order #{$order->order_number} status updated.");
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
            $data['order_status'] = 'completed';
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
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('payment') && $request->input('payment') !== 'all') {
            $query->where('payment_method', $request->input('payment'));
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
