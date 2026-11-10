<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbandonedCart;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    /**
     * Display list of abandoned carts and drop-offs.
     */
    public function index(Request $request)
    {
        $query = AbandonedCart::query();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $carts = $query->latest()->paginate(12)->withQueryString();

        // 4 Key Analytics
        $totalAbandonedCount = AbandonedCart::where('status', 'abandoned')->count();
        $potentialRevenueLost = AbandonedCart::where('status', 'abandoned')->sum('total');
        $contactedCount = AbandonedCart::where('status', 'contacted')->count();
        $recoveredRevenue = AbandonedCart::where('status', 'recovered')->sum('total');

        return view('admin.abandoned-carts.index', compact(
            'carts',
            'totalAbandonedCount',
            'potentialRevenueLost',
            'contactedCount',
            'recoveredRevenue'
        ));
    }

    /**
     * Launch WhatsApp Recovery with pre-filled concierge message and mark as Contacted.
     */
    public function sendRecovery(Request $request, AbandonedCart $cart)
    {
        $template = $request->input('template', 'gentle');

        $message = $template === 'discount'
            ? $cart->special_discount_message
            : $cart->gentle_reminder_message;

        $cart->update([
            'status' => 'contacted',
            'contacted_at' => now(),
        ]);

        $phone = $cart->whatsapp_phone;
        $encodedMsg = urlencode($message);

        return redirect("https://wa.me/{$phone}?text={$encodedMsg}");
    }

    /**
     * Manually mark an abandoned cart as recovered.
     */
    public function markRecovered(AbandonedCart $cart)
    {
        $cart->update([
            'status' => 'recovered',
            'recovered_at' => now(),
        ]);

        return back()->with('toast_success', "Cart for {$cart->customer_name} marked as Recovered!");
    }

    /**
     * Delete an abandoned cart record.
     */
    public function destroy(AbandonedCart $cart)
    {
        $name = $cart->customer_name ?: 'Unknown shopper';
        $cart->delete();

        return back()->with('toast_success', "Abandoned record for {$name} removed.");
    }
}

