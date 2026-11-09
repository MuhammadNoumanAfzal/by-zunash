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
     * Printable invoice view.
     */
    public function invoice(Order $order)
    {
        return view('admin.orders.invoice', compact('order'));
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
