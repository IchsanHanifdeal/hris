@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
@php $setting = \App\Models\Setting::first(); @endphp
<head>
    @include('components.main.head')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#4f46e5">

    <title>{{ $title ?? ($setting->pwa_name ?? ($setting->app_name ?? config('app.name'))) }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        body::-webkit-scrollbar { display: none; }
        body { -ms-overflow-style: none; scrollbar-width: none; }

        .mobile-container::-webkit-scrollbar { width: 4px; }
        .mobile-container::-webkit-scrollbar-track { background: transparent; }
        .mobile-container::-webkit-scrollbar-thumb {
            background: oklch(var(--p) / 0.5);
            border-radius: 4px;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
        
        .safe-area-bottom { padding-bottom: env(safe-area-inset-bottom); }
    </style>
</head>

<body class="h-[100dvh] font-sans antialiased bg-base-200 text-base-content selection:bg-primary selection:text-white overflow-hidden flex justify-center">
    
    <div class="mobile-container w-full max-w-md bg-base-100 h-full relative overflow-hidden flex flex-col shadow-2xl sm:border-x border-base-300">

        <x-pwa.top-bar />

        <main class="flex-1 h-full w-full overflow-y-auto animate-fade-in relative z-10 pb-24 pt-4 px-4 safe-area-bottom">
            {{ $slot }}
        </main>

        <x-pwa.bottom-nav />

        <div id="toast-container" class="toast toast-top toast-center z-[10000] absolute w-full max-w-sm mx-auto mt-4 px-4 pointer-events-none">
            @if (session('success'))
                <div class="alert alert-success shadow-lg border-none text-success-content rounded-2xl pointer-events-auto"
                     x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif
        </div>

    </div>

    @stack('scripts')
</body>
</html>