<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('q')) {
            $search = trim($request->input('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('vip') && $request->input('vip') !== 'all') {
            $query->where('is_vip', $request->input('vip') === '1');
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        $totalCustomers = Customer::count();
        $vipCount = Customer::where('is_vip', true)->count();
        $totalCustomerSpend = Customer::sum('total_spent');

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'vipCount',
            'totalCustomerSpend'
        ));
    }

    public function toggleVip(Customer $customer)
    {
        $customer->is_vip = !$customer->is_vip;
        $customer->save();

        $status = $customer->is_vip ? 'granted VIP Atelier privilege' : 'reverted to regular client';
        return back()->with('toast_success', "Customer {$customer->name} {$status}.");
    }
}
