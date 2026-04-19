<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider extends ServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        if (app()->runningInConsole() || ! env('NATIVEPHP_RUNNING')) {
            return;
        }

        $setting = \App\Models\Setting::first();
        $appName = $setting?->app_name ?? config('app.name', 'HRIS PRO');

        Window::open()
            ->title($appName)
            ->width(1280)
            ->height(800)
            ->minWidth(800)
            ->minHeight(600)
            ->showDevTools(false)
            ->rememberState();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
