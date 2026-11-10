<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();
        $modules = Admin::availableModules();
        return view('admin.staff.index', compact('admins', 'modules'));
    }

    public function store(Request $request)
    {
        $allModules = array_keys(Admin::availableModules());

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email',
            'role' => 'required|in:super_admin,manager,editor,custom',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', $allModules),
            'password' => 'required|string|min:6',
        ]);

        $permissions = $validated['role'] === 'super_admin'
            ? $allModules
            : ($validated['permissions'] ?? []);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'permissions' => $permissions,
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('toast_success', "Staff member {$validated['name']} registered with module permissions.");
    }

    public function update(Request $request, Admin $staff)
    {
        $allModules = array_keys(Admin::availableModules());

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email,' . $staff->id,
            'role' => 'required|in:super_admin,manager,editor,custom',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', $allModules),
            'password' => 'nullable|string|min:6',
        ]);

        $permissions = $validated['role'] === 'super_admin'
            ? $allModules
            : ($validated['permissions'] ?? []);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'permissions' => $permissions,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $staff->update($data);

        return back()->with('toast_success', "Staff account {$staff->name} and module access updated.");
    }

    public function destroy(Admin $staff)
    {
        if (auth('admin')->id() === $staff->id) {
            return back()->with('toast_error', "You cannot terminate your own active administrator account.");
        }

        $name = $staff->name;
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('toast_success', "Staff account for {$name} has been removed.");
    }
}
