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
                        <th class="py-3 px-4 text-right">ACTIONS</th>
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
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $client->phone ?? '');
                                        if (str_starts_with($cleanPhone, '03')) {
                                            $cleanPhone = '92' . substr($cleanPhone, 1);
                                        }
                                    @endphp
                                    @if($cleanPhone)
                                        <a 
                                            href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Assalam o Alaikum ' . $client->name . ', from By Zunash Luxury Leather Atelier.') }}" 
                                            target="_blank"
                                            class="p-1.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 rounded-lg transition-colors"
                                            title="Chat with Patron on WhatsApp"
                                        >
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        </a>
                                    @endif

                                    <!-- Toggle VIP -->
                                    <form action="{{ route('admin.customers.vip', $client) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="px-2.5 py-1 rounded-lg text-[10px] font-semibold border transition-colors {{ $client->is_vip ? 'border-gray-200 text-gray-600 hover:bg-gray-100' : 'border-tan-300 bg-tan-50 text-tan-800 hover:bg-tan-100' }}"
                                            title="Toggle VIP Privilege"
                                        >
                                            {{ $client->is_vip ? 'Revoke' : 'Make VIP' }}
                                        </button>
                                    </form>

                                    <!-- Edit Patron Button -->
                                    <button 
                                        type="button" 
                                        onclick="openEditCustomerModal({{ json_encode($client) }})"
                                        class="p-1.5 text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] dark:hover:bg-[#2A1D1A] rounded-lg transition-colors"
                                        title="Edit Patron Dossier"
                                    >
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    </button>

                                    <!-- Delete Patron Button -->
                                    <form action="{{ route('admin.customers.destroy', $client) }}" method="POST" onsubmit="return confirm('Delete this patron profile?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition-colors" title="Delete Patron">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
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

<!-- Edit Customer Modal Dialog -->
<dialog id="editCustomerModal" class="rounded-3xl p-0 shadow-2xl max-w-md w-full bg-white dark:bg-[#1A1513] text-espresso-900 dark:text-white border border-[#ECE6DE] dark:border-[#2C2420]">
    <div class="p-6">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Edit Patron Dossier</h3>
            <button type="button" onclick="document.getElementById('editCustomerModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editCustomerForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1">Patron Full Name <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_cust_name" name="name" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Email Address <span class="text-rose-500">*</span></label>
                <input type="email" id="edit_cust_email" name="email" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Phone Number</label>
                <input type="text" id="edit_cust_phone" name="phone" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500 font-mono">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Primary City</label>
                <input type="text" id="edit_cust_city" name="city" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
            </div>

            <div class="pt-1">
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-medium text-espresso-900 dark:text-white">
                    <input type="checkbox" id="edit_cust_vip" name="is_vip" value="1" class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                    <span>VIP Atelier Patron Member</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('editCustomerModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-tan-600 hover:bg-espresso-900 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
function openEditCustomerModal(client) {
    document.getElementById('editCustomerForm').action = '/admin/customers/' + client.id;
    document.getElementById('edit_cust_name').value = client.name || '';
    document.getElementById('edit_cust_email').value = client.email || '';
    document.getElementById('edit_cust_phone').value = client.phone || '';
    document.getElementById('edit_cust_city').value = client.city || '';
    document.getElementById('edit_cust_vip').checked = !!client.is_vip;
    document.getElementById('editCustomerModal').showModal();
}
</script>
@endpush

@endsection
