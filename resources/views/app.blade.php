<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ \App\Models\Setting::where('key', 'web_description')->first()?->value ?? 'Website Resmi Kelurahan' }}">
    <meta name="keywords" content="{{ \App\Models\Setting::where('key', 'web_keywords')->first()?->value ?? 'kelurahan, desa, pelayanan' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url" content="{{ \App\Models\Setting::where('key', 'website_url')->first()?->value ?? url()->current() }}">
    <link rel="canonical" href="{{ \App\Models\Setting::where('key', 'website_url')->first()?->value ?? url()->current() }}">

    <title inertia>
        {{ \App\Models\Setting::where('key', 'web_name')->first()?->value ?? config('app.name', '[Nama Wilayah]') }}
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/png"
        href="{{ \App\Models\Setting::where('key', 'logo')->first()?->value ?? asset('assets/images/icons/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased overflow-x-hidden">
    @inertia
</body>

</html>