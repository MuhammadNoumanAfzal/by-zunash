@extends('admin.layouts.app')

@section('title', 'Staff & Roles (RBAC) | By Zunash Atelier')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                Staff & Access Roles (RBAC)
            </h1>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">
                Executive team accounts, privileges, and By Zunash Atelier Control Center access.
            </p>
        </div>

        <button 
            type="button" 
            onclick="document.getElementById('addStaffModal').showModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="user-plus" class="w-4 h-4 text-gold-400"></i>
            <span>Add Staff Member</span>
        </button>
    </div>

    <!-- Staff Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($admins as $admin)
            <div class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-espresso-900 text-gold-400 border border-gold-400/30 font-bold text-sm flex items-center justify-center shadow-md">
                            {{ substr($admin->name, 0, 2) }}
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#FAF6F2] text-tan-700 border border-tan-200">
                            {{ str_replace('_', ' ', $admin->role) }}
                        </span>
                    </div>

                    <h2 class="font-bold text-base text-espresso-950 dark:text-white">
                        {{ $admin->name }}
                    </h2>
                    <div class="text-xs text-[#8F8379] mt-0.5">
                        {{ $admin->email }}
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-[#F0EAE1] dark:border-[#2C2420] text-[11px] text-gray-400 flex items-center justify-between">
                    <span>Added {{ $admin->created_at->format('M Y') }}</span>
                    <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Active
                    </span>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Add Staff Modal -->
<dialog id="addStaffModal" class="rounded-3xl p-0 backdrop:bg-black/50 border border-[#ECE6DE] shadow-2xl max-w-md w-full bg-white dark:bg-[#1A1513] text-espresso-900 dark:text-white">
    <div class="p-6">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-4">
            <h3 class="font-cinzel text-xl font-bold text-tan-600">Add Staff Account</h3>
            <button onclick="document.getElementById('addStaffModal').close()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold mb-1">Full Name</label>
                <input type="text" name="name" required placeholder="e.g. Fatima Tariq" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Staff Email</label>
                <input type="email" name="email" required placeholder="fatima@byzunash.com" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] focus:outline-hidden focus:border-tan-500">
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Role & Permission Level</label>
                <select name="role" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] focus:outline-hidden focus:border-tan-500">
                    <option value="super_admin">Super Admin (Unrestricted)</option>
                    <option value="manager">Atelier Manager (Catalogue & Orders)</option>
                    <option value="editor">Catalogue Editor</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Password</label>
                <input type="password" name="password" required placeholder="Minimum 6 characters" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] focus:outline-hidden focus:border-tan-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('addStaffModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</dialog>

@endsection
