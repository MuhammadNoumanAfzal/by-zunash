<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            StoreSetting::set($key, $value);
        }

        \Illuminate\Support\Facades\Cache::forget('store_settings_all');

        return back()->with('toast_success', 'Atelier store configuration saved.');
    }
}
