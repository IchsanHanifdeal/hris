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
            'address' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'radius' => 'nullable|integer',
        ]);

        // If GPS validation toggle is off or not present, set radius to 0 (which means disabled)
        if (!$request->has('gps_validation') || $request->input('gps_validation') == '0') {
            $validated['radius'] = 0;
        } else {
            // If GPS validation is on, ensure radius is at least 1, default to 100 if empty
            $radius = $request->input('radius');
            $validated['radius'] = ($radius && $radius > 0) ? (int)$radius : 100;
        }

        $setting = Setting::first() ?? new Setting();
        $setting->fill($validated);
        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
