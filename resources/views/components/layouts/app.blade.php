<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $pageTitle = isset($title) ? $title.' — '.config('app.name') : config('app.name').' — épülethangosítás, konferenciarendszerek, tourguide-rendszerek';
        $pageDescription = $metaDescription ?? 'Épülethangosítás, konferenciarendszerek, tourguide-rendszerek és mobil hangosítás megoldások.';
        $canonicalUrl = $canonical ?? url()->current();
        $ogImageUrl = isset($ogImage) ? Illuminate\Support\Facades\Storage::url($ogImage) : asset('images/og-default.jpg');
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta property="og:locale" content="hu_HU">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <x-schema.local-business />
    {!! $schema ?? '' !!}
</head>
<body class="bg-cream text-ink font-sans antialiased">
    <div id="page-transition-overlay" class="fixed inset-0 z-[10000] flex items-center justify-center bg-petrol-950 motion-reduce:hidden">
        <img src="{{ asset('images/logo-icon.webp') }}" alt="" id="page-transition-mark" class="h-14 w-auto opacity-0 scale-90" width="82" height="56">
    </div>

    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 focus:bg-petrol-900 focus:text-cream focus:px-4 focus:py-2 focus:rounded">
        Ugrás a tartalomra
    </a>

    <x-site-header />

    <main id="main">
        {{ $slot }}
    </main>

    <x-site-footer />

    @livewireScripts
</body>
</html>
