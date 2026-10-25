<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::query();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $inquiries = $query->latest()->paginate(10)->withQueryString();

        $totalInquiries = Inquiry::count();
        $unreadCount = Inquiry::where('status', 'unread')->count();
        $resolvedCount = Inquiry::where('status', 'resolved')->count();

        return view('admin.messages.index', compact(
            'inquiries',
            'totalInquiries',
            'unreadCount',
            'resolvedCount'
        ));
    }

    public function markResolved(Inquiry $inquiry)
    {
        $inquiry->update([
            'status' => 'resolved',
            'is_read' => true,
        ]);

        return back()->with('toast_success', 'Concierge ticket marked as resolved.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return back()->with('toast_success', 'Inquiry deleted.');
    }
}
