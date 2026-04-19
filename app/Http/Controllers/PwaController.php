<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PwaController extends Controller
{
    public function manifest()
    {
        $setting = Setting::first();
        $appName = $setting?->pwa_name ?? config('app.name', 'HRIS PRO');
        $shortName = $setting?->pwa_short_name ?? 'HRIS';
        $themeColor = $setting?->theme_color ?? '#6366f1';
        $logo = $setting?->pwa_logo ? asset('storage/' . $setting->pwa_logo) : asset('logo.png');

        $manifest = [
            "name" => $appName,
            "short_name" => $shortName,
            "start_url" => "/",
            "background_color" => "#ffffff",
            "description" => $setting?->app_description ?? "HRIS Management System",
            "display" => "standalone",
            "theme_color" => $themeColor,
            "icons" => [
                [
                    "src" => $logo,
                    "sizes" => "72x72",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "96x96",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "128x128",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "144x144",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "152x152",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "192x192",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "384x384",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => $logo,
                    "sizes" => "512x512",
                    "type" => "image/png",
                    "purpose" => "any"
                ]
            ]
        ];

        return response()->json($manifest);
    }

    public function serviceWorker()
    {
        $content = file_get_contents(base_path('vendor/ladumor/laravel-pwa/src/stubs/sw.stub'));
        $content = str_replace('{{VERSION}}', time(), $content);
        
        return response($content)->header('Content-Type', 'text/javascript');
    }
}
