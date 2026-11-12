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
        $checkboxKeys = [
            'payment_cod_enabled',
            'payment_bank_enabled',
            'payment_jazzcash_enabled',
            'payment_easypaisa_enabled',
        ];

        foreach ($checkboxKeys as $cb) {
            StoreSetting::set($cb, $request->has($cb) ? '1' : '0');
        }

        $data = $request->except(array_merge(['_token', '_method'], $checkboxKeys));

        foreach ($data as $key => $value) {
            StoreSetting::set($key, $value);
        }

        \Illuminate\Support\Facades\Cache::forget('store_settings_all');

        return back()->with('toast_success', 'Atelier store configuration saved.');
    }
}
