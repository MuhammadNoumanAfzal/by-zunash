@extends('admin.layouts.app')

@section('title', 'VIP Customers & Client Profiles | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                VIP Patrons & Client Dossiers
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Curate Pakistani luxury patrons across Lahore, Islamabad, Karachi, and nationwide with lifetime spend tracking.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] text-xs font-bold text-tan-600 dark:text-gold-400 shadow-2xs">
                {{ $vipCount }} Registered VIP Atelier Patrons
            </span>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="rounded-3xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] bg-[#FAF8F5] dark:bg-[#201A18] border-b border-[#ECE6DE] dark:border-[#2C2420]">
                        <th class="py-3 px-4">PATRON NAME</th>
                        <th class="py-3 px-3">EMAIL & PHONE</th>
                        <th class="py-3 px-3">PRIMARY CITY</th>
                        <th class="py-3 px-3">ORDERS</th>
                        <th class="py-3 px-3">LIFETIME SPEND</th>
                        <th class="py-3 px-3">VIP STATUS</th>
                        <th class="py-3 px-4 text-right">PRIVILEGE ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EAE1] dark:divide-[#28201C]">
                    @forelse($customers as $client)
                        <tr class="hover:bg-[#FAF8F5] dark:hover:bg-[#221B18] transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-espresso-950 dark:text-white text-sm">
                                    {{ $client->name }}
                                </div>
                                <div class="text-[10px] text-gray-400">
                                    Patron since {{ $client->created_at->format('M Y') }}
                                </div>
                            </td>

                            <td class="py-3.5 px-3">
                                <div class="text-espresso-900 dark:text-white">{{ $client->email }}</div>
                                <div class="font-mono text-[10px] text-gray-400">{{ $client->phone ?: '—' }}</div>
                            </td>

                            <td class="py-3.5 px-3 font-medium text-gray-600 dark:text-gray-300">
                                {{ $client->city ?: 'Lahore' }}
                            </td>

                            <td class="py-3.5 px-3 font-mono font-bold text-espresso-950 dark:text-white">
                                {{ $client->total_orders }} orders
                            </td>

                            <td class="py-3.5 px-3 font-cinzel font-bold text-sm text-tan-600 dark:text-gold-400">
                                Rs. {{ number_format($client->total_spent) }}
                            </td>

                            <td class="py-3.5 px-3">
                                @if($client->is_vip)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF6F2] text-tan-700 border border-tan-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tan-500"></span>
                                        VIP Atelier Member
                                    </span>
                                @else
                                    <span class="text-[11px] text-gray-400">
                                        Standard Patron
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('admin.customers.vip', $client) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-3 py-1 rounded-lg text-[10px] font-semibold border transition-colors {{ $client->is_vip ? 'border-gray-200 text-gray-600 hover:bg-gray-100' : 'border-tan-300 bg-tan-50 text-tan-800 hover:bg-tan-100' }}"
                                    >
                                        {{ $client->is_vip ? 'Revoke VIP' : 'Promote to VIP' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">
                                No patron records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
            {{ $customers->links() }}
        </div>
    </div>

</div>

@endsection
