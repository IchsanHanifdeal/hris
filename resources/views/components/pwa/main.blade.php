@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#4f46e5"> <title>{{ $title ?? config('app.name') }}</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/apple-icon-180.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        /* Hilangkan scrollbar tapi tetep bisa scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Safe area untuk iPhone berponi */
        .safe-area-bottom { padding-bottom: env(safe-area-inset-bottom); }
    </style>
</head>
<body class="antialiased text-base-content selection:bg-primary selection:text-white overflow-x-hidden no-scrollbar">
    
    <x-pwa.top-bar />

    <main class="min-h-screen pb-24 pt-4 px-4 safe-area-bottom animate-fade-in">
        {{ $slot }}
    </main>

    <x-pwa.bottom-nav />

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>