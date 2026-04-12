<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('dashboard.setting', compact('setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'pwa_name' => 'nullable|string|max:255',
            'check_in_time' => 'nullable',
            'check_out_time' => 'nullable',
            'address' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'radius' => 'nullable|integer',
            'app_logo' => 'nullable|image|max:2048',
            'app_favicon' => 'nullable|image|max:1024',
            'pwa_logo' => 'nullable|image|max:2048',
        ]);

        $setting = Setting::first() ?? new Setting();
        
        // Handle Logo Uploads
        if ($request->hasFile('app_logo')) {
            $validated['app_logo'] = $request->file('app_logo')->store('branding', 'public');
        }
        if ($request->hasFile('app_favicon')) {
            $validated['app_favicon'] = $request->file('app_favicon')->store('branding', 'public');
        }
        if ($request->hasFile('pwa_logo')) {
            $validated['pwa_logo'] = $request->file('pwa_logo')->store('branding', 'public');
        }

        Setting::updateOrCreate(['id' => 1], $validated);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
