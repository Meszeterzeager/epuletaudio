<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ strip_tags($title) }} — hero előnézet</title>
    <link rel="stylesheet" href="{{ asset('css/templomos-preview.css') }}">
</head>
<body>
    <main>
        <section id="preview-hero" class="preview-{{ $signal }}">
            <img src="{{ asset($image) }}" alt="{{ $eyebrow }}" class="hero-image">
            <div class="hero-overlay hero-overlay-side"></div>
            <div class="hero-overlay hero-overlay-bottom"></div>

            @if ($signal === 'conference')
                <svg class="signal-overlay" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                    <defs>
                        <linearGradient id="conference-signal" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#d99a5c" stop-opacity=".16"/><stop offset="50%" stop-color="#f3cf94" stop-opacity=".9"/><stop offset="100%" stop-color="#d99a5c" stop-opacity=".16"/></linearGradient>
                        <filter id="conference-glow" x="-40%" y="-40%" width="180%" height="180%"><feGaussianBlur stdDeviation="4"/></filter>
                    </defs>
                    <g fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M650 700 C684 655 716 604 752 550" class="church-signal-glow"/>
                        <path d="M752 550 C760 480 770 410 780 350" class="church-signal-glow"/>
                        <path d="M752 550 C910 495 1125 410 1330 350" class="church-signal-glow"/>
                        <path d="M650 700 C684 655 716 604 752 550" class="church-signal-path" data-preview-path="source"/>
                        <path d="M752 550 C760 480 770 410 780 350" class="church-signal-path" data-preview-path="left"/>
                        <path d="M752 550 C910 495 1125 410 1330 350" class="church-signal-path" data-preview-path="right"/>
                    </g>
                </svg>
            @endif

            <div class="hero-content-wrap">
                <div class="hero-content">
                    <p class="eyebrow">{{ $eyebrow }}</p>
                    <h1>{!! $title !!}</h1>
                    <p class="intro">{{ $intro }}</p>
                    <div class="hero-actions">
                        <a href="{{ route('quote.create') }}" class="button button-primary">Ajánlatot kérek</a>
                        <a href="{{ route('solutions.index') }}" class="button button-secondary">Megnézem a megoldásokat</a>
                    </div>
                    <p class="microcopy">Fotók és rövid videó alapján is elkészítjük az első ajánlatot.</p>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('js/preview-hero.js') }}" defer></script>
</body>
</html>
