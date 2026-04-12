<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $setting = Setting::first();
                if ($setting) {
                    config([
                        'laravelpwa.manifest.name' => $setting->pwa_name ?? ($setting->app_name ?? config('app.name')),
                        'laravelpwa.manifest.short_name' => $setting->pwa_name ?? ($setting->app_name ?? config('app.name')),
                    ]);

                    if ($setting->pwa_logo) {
                        $pwaLogoPath = '/storage/' . $setting->pwa_logo;
                        config([
                            'laravelpwa.manifest.icons.72x72.path'   => $pwaLogoPath,
                            'laravelpwa.manifest.icons.96x96.path'   => $pwaLogoPath,
                            'laravelpwa.manifest.icons.128x128.path' => $pwaLogoPath,
                            'laravelpwa.manifest.icons.144x144.path' => $pwaLogoPath,
                            'laravelpwa.manifest.icons.152x152.path' => $pwaLogoPath,
                            'laravelpwa.manifest.icons.192x192.path' => $pwaLogoPath,
                            'laravelpwa.manifest.icons.384x384.path' => $pwaLogoPath,
                            'laravelpwa.manifest.icons.512x512.path' => $pwaLogoPath,
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            // Silence errors if database is not ready
        }
    }
}
