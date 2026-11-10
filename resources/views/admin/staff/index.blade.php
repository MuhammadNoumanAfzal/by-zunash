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
                Executive team accounts, privileges, and granular module access control for By Zunash Atelier.
            </p>
        </div>

        <button 
            type="button" 
            onclick="openAddStaffModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="user-plus" class="w-4 h-4 text-gold-400"></i>
            <span>Add Staff Member</span>
        </button>
    </div>

    <!-- Staff Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($admins as $admin)
            @php
                $isSuper = $admin->role === 'super_admin';
                $staffPerms = $admin->permissions ?? [];
                $available = \App\Models\Admin::availableModules();
            @endphp
            <div class="bg-white dark:bg-[#1A1513] rounded-3xl border border-[#ECE6DE] dark:border-[#2C2420] shadow-card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-espresso-900 text-gold-400 border border-gold-400/30 font-bold text-sm flex items-center justify-center shadow-md">
                            {{ substr($admin->name, 0, 2) }}
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $isSuper ? 'bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300' : 'bg-[#FAF6F2] text-tan-700 border border-tan-200 dark:bg-[#281E19] dark:text-gold-300' }}">
                                {{ str_replace('_', ' ', $admin->role) }}
                            </span>
                            <button 
                                type="button"
                                onclick="openEditStaff({{ json_encode($admin) }})"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-tan-600 hover:bg-[#FAF8F5] transition-colors"
                                title="Edit Staff & Permissions"
                            >
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            @if(auth('admin')->id() !== $admin->id)
                                <form action="{{ route('admin.staff.destroy', $admin) }}" method="POST" onsubmit="return confirm('Remove staff member {{ addslashes($admin->name) }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors" title="Delete Staff">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <h2 class="font-bold text-base text-espresso-950 dark:text-white">
                        {{ $admin->name }}
                    </h2>
                    <div class="text-xs text-[#8F8379] mt-0.5">
                        {{ $admin->email }}
                    </div>

                    <!-- Assigned Modules Breakdown -->
                    <div class="mt-4 pt-3 border-t border-[#F0EAE1] dark:border-[#28201C]">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379] mb-2 flex items-center justify-between">
                            <span>Module Access</span>
                            @if($isSuper)
                                <span class="text-amber-600 font-mono">12/12</span>
                            @else
                                <span class="font-mono text-tan-700 dark:text-gold-400">{{ count($staffPerms) }}/12</span>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-1.5">
                            @if($isSuper)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-amber-500/10 text-amber-800 dark:text-amber-300 border border-amber-500/20">
                                    <i data-lucide="shield-check" class="w-3 h-3 text-amber-600"></i>
                                    <span>All Modules (Full Administrative Control)</span>
                                </span>
                            @elseif(empty($staffPerms))
                                <span class="text-[11px] text-gray-400 italic">No modules assigned</span>
                            @else
                                @foreach($staffPerms as $p)
                                    @if(isset($available[$p]))
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-[#FAF8F5] dark:bg-[#221A16] text-espresso-800 dark:text-ivory-200 border border-[#EAE3DA] dark:border-[#382B24]">
                                            <i data-lucide="{{ $available[$p]['icon'] ?? 'check' }}" class="w-2.5 h-2.5 text-tan-600"></i>
                                            <span>{{ $available[$p]['name'] }}</span>
                                        </span>
                                    @endif
                                @endforeach
                            @endif
                        </div>
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
<dialog id="addStaffModal" class="rounded-3xl p-0 shadow-2xl modal-wide">
    <div class="p-6 sm:p-7 max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-5">
            <div>
                <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Add Staff Account</h3>
                <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">Define login credentials and grant access to any or every module.</p>
            </div>
            <button type="button" onclick="document.getElementById('addStaffModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Fatima Tariq" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Staff Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" required placeholder="fatima@byzunash.com" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1">Account Role</label>
                    <select id="add_staff_role" name="role" onchange="onRoleChangeAdd(this.value)" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        <option value="custom">Custom Permissions (Choose Below)</option>
                        <option value="super_admin">Super Admin (All 12 Modules)</option>
                        <option value="manager">Atelier Manager (Orders, Catalogue & Support)</option>
                        <option value="editor">Catalogue Editor (Products & Deals)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required placeholder="Minimum 6 characters" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>
            </div>

            <!-- Granular Module Permissions Selector -->
            <div class="pt-2">
                <div class="flex items-center justify-between pb-2 mb-3 border-b border-[#ECE6DE] dark:border-[#2C2420]">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-espresso-950 dark:text-white">
                            Assigned Module Access
                        </label>
                        <p class="text-[11px] text-[#8F8379]">Select which administrative modules this staff member can access.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="toggleAllAddPermissions(true)" class="text-[11px] font-semibold text-tan-600 hover:text-espresso-900 dark:hover:text-gold underline">
                            Select All
                        </button>
                        <span class="text-gray-300">|</span>
                        <button type="button" onclick="toggleAllAddPermissions(false)" class="text-[11px] font-semibold text-gray-500 hover:text-rose-600 underline">
                            Clear All
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    @foreach($modules as $key => $mod)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-[#ECE6DE] dark:border-[#2C2420] hover:bg-[#FAF8F5] dark:hover:bg-[#201815] transition-colors cursor-pointer group">
                            <input 
                                type="checkbox" 
                                name="permissions[]" 
                                value="{{ $key }}"
                                class="add-permission-checkbox mt-0.5 rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500"
                            >
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="{{ $mod['icon'] }}" class="w-3.5 h-3.5 text-tan-600 dark:text-gold-400 shrink-0"></i>
                                    <span class="text-xs font-bold text-espresso-950 dark:text-white group-hover:text-tan-600 transition-colors truncate">
                                        {{ $mod['name'] }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-[#8F8379] mt-0.5 leading-snug">
                                    {{ $mod['desc'] }}
                                </p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('addStaffModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- Edit Staff Modal -->
<dialog id="editStaffModal" class="rounded-3xl p-0 shadow-2xl modal-wide">
    <div class="p-6 sm:p-7 max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#ECE6DE] dark:border-[#2C2420] mb-5">
            <div>
                <h3 class="font-cinzel text-xl font-bold text-tan-600 dark:text-gold-400">Edit Staff Account & Permissions</h3>
                <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-0.5">Modify role, credentials, and granular module access.</p>
            </div>
            <button type="button" onclick="document.getElementById('editStaffModal').close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="editStaffForm" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="edit_staff_name" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Staff Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="edit_staff_email" required class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1">Account Role</label>
                    <select name="role" id="edit_staff_role" onchange="onRoleChangeEdit(this.value)" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                        <option value="custom">Custom Permissions (Choose Below)</option>
                        <option value="super_admin">Super Admin (All 12 Modules)</option>
                        <option value="manager">Atelier Manager (Orders, Catalogue & Support)</option>
                        <option value="editor">Catalogue Editor (Products & Deals)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" placeholder="Leave blank to preserve current" class="w-full px-3 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#241D1A] border border-[#E0D7CB] dark:border-[#3A2F29] text-espresso-900 dark:text-white focus:outline-hidden focus:border-tan-500">
                </div>
            </div>

            <!-- Granular Module Permissions Selector -->
            <div class="pt-2">
                <div class="flex items-center justify-between pb-2 mb-3 border-b border-[#ECE6DE] dark:border-[#2C2420]">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-espresso-950 dark:text-white">
                            Assigned Module Access
                        </label>
                        <p class="text-[11px] text-[#8F8379]">Toggle any specific module or grant complete suite access.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="toggleAllEditPermissions(true)" class="text-[11px] font-semibold text-tan-600 hover:text-espresso-900 dark:hover:text-gold underline">
                            Select All
                        </button>
                        <span class="text-gray-300">|</span>
                        <button type="button" onclick="toggleAllEditPermissions(false)" class="text-[11px] font-semibold text-gray-500 hover:text-rose-600 underline">
                            Clear All
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    @foreach($modules as $key => $mod)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-[#ECE6DE] dark:border-[#2C2420] hover:bg-[#FAF8F5] dark:hover:bg-[#201815] transition-colors cursor-pointer group">
                            <input 
                                type="checkbox" 
                                name="permissions[]" 
                                value="{{ $key }}"
                                id="edit_perm_{{ $key }}"
                                class="edit-permission-checkbox mt-0.5 rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500"
                            >
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="{{ $mod['icon'] }}" class="w-3.5 h-3.5 text-tan-600 dark:text-gold-400 shrink-0"></i>
                                    <span class="text-xs font-bold text-espresso-950 dark:text-white group-hover:text-tan-600 transition-colors truncate">
                                        {{ $mod['name'] }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-[#8F8379] mt-0.5 leading-snug">
                                    {{ $mod['desc'] }}
                                </p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                <button type="button" onclick="document.getElementById('editStaffModal').close()" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 dark:text-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-tan-600 hover:bg-espresso-900 text-white font-semibold text-xs shadow-md transition-colors border border-gold-400/20">
                    Update Staff & Permissions
                </button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
    const managerPresets = ['dashboard', 'products', 'inventory', 'orders', 'customers', 'messages', 'reviews'];
    const editorPresets = ['categories', 'subcategories', 'products', 'deals', 'reviews'];

    function openAddStaffModal() {
        toggleAllAddPermissions(true);
        document.getElementById('add_staff_role').value = 'super_admin';
        document.getElementById('addStaffModal').showModal();
        if (window.lucide) lucide.createIcons();
    }

    function toggleAllAddPermissions(check) {
        document.querySelectorAll('.add-permission-checkbox').forEach(cb => cb.checked = check);
    }

    function toggleAllEditPermissions(check) {
        document.querySelectorAll('.edit-permission-checkbox').forEach(cb => cb.checked = check);
    }

    function onRoleChangeAdd(role) {
        if (role === 'super_admin') {
            toggleAllAddPermissions(true);
        } else if (role === 'manager') {
            toggleAllAddPermissions(false);
            managerPresets.forEach(mod => {
                const el = document.querySelector(`.add-permission-checkbox[value="${mod}"]`);
                if (el) el.checked = true;
            });
        } else if (role === 'editor') {
            toggleAllAddPermissions(false);
            editorPresets.forEach(mod => {
                const el = document.querySelector(`.add-permission-checkbox[value="${mod}"]`);
                if (el) el.checked = true;
            });
        }
    }

    function onRoleChangeEdit(role) {
        if (role === 'super_admin') {
            toggleAllEditPermissions(true);
        } else if (role === 'manager') {
            toggleAllEditPermissions(false);
            managerPresets.forEach(mod => {
                const el = document.getElementById('edit_perm_' + mod);
                if (el) el.checked = true;
            });
        } else if (role === 'editor') {
            toggleAllEditPermissions(false);
            editorPresets.forEach(mod => {
                const el = document.getElementById('edit_perm_' + mod);
                if (el) el.checked = true;
            });
        }
    }

    function openEditStaff(staff) {
        document.getElementById('editStaffForm').action = '/admin/staff/' + staff.id;
        document.getElementById('edit_staff_name').value = staff.name || '';
        document.getElementById('edit_staff_email').value = staff.email || '';
        document.getElementById('edit_staff_role').value = staff.role || 'custom';

        // Clear all checkboxes
        toggleAllEditPermissions(false);

        if (staff.role === 'super_admin') {
            toggleAllEditPermissions(true);
        } else {
            let perms = staff.permissions;
            if (typeof perms === 'string') {
                try { perms = JSON.parse(perms); } catch (e) { perms = []; }
            }
            if (Array.isArray(perms) && perms.length > 0) {
                perms.forEach(key => {
                    const cb = document.getElementById('edit_perm_' + key);
                    if (cb) cb.checked = true;
                });
            } else {
                // If legacy manager or editor without explicit permissions array
                if (staff.role === 'manager') {
                    managerPresets.forEach(mod => {
                        const el = document.getElementById('edit_perm_' + mod);
                        if (el) el.checked = true;
                    });
                } else if (staff.role === 'editor') {
                    editorPresets.forEach(mod => {
                        const el = document.getElementById('edit_perm_' + mod);
                        if (el) el.checked = true;
                    });
                }
            }
        }

        document.getElementById('editStaffModal').showModal();
        if (window.lucide) lucide.createIcons();
    }
</script>
@endpush

@endsection
