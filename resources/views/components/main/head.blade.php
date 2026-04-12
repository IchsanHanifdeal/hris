@php $setting = \App\Models\Setting::first(); @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @laravelPWA

    <title>
        @if(trim($__env->yieldContent('title')))
            @yield('title') | {{ $setting->app_name ?? config('app.name', 'HRIS PRO') }}
        @else
            {{ $setting->app_name ?? config('app.name', 'HRIS PRO') }}
        @endif
    </title>

    <meta name="description" content="@yield('description', __('seo.description'))">
    <meta name="keywords" content="{{ __('seo.keywords') }}">
    <meta name="author" content="{{ __('seo.author') }}">

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta property="og:title" content="@yield('title', __('seo.og_title'))">
    <meta property="og:description" content="@yield('description', __('seo.og_description'))">

    <meta property="og:image" content="@yield('image', asset('images/og-preview.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', __('seo.twitter_title'))">
    <meta name="twitter:description" content="@yield('description', __('seo.twitter_description'))">
    <meta name="twitter:image" content="@yield('image', asset('images/og-preview.jpg'))">

    @if($setting && $setting->app_favicon)
        <link rel="icon" href="{{ asset('storage/' . $setting->app_favicon) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
