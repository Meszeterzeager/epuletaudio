<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Templomi hangosítás — hero előnézet</title>
    <link rel="stylesheet" href="{{ asset('css/templomos-preview.css') }}?v={{ filemtime(public_path('css/templomos-preview.css')) }}">
</head>
<body>
    <main>
        <section id="church-hero">
            <img
                src="{{ asset('images/hero-templomos-v3.png') }}"
                alt="Templomi hangosítás: szószék, hangsugárzók és a sekrestyében elhelyezett erősítő"
                class="hero-image"
            >
            <div class="hero-overlay hero-overlay-side"></div>
            <div class="hero-overlay hero-overlay-bottom"></div>

            {{-- Egyértelmű jelút: középen a mikrofon, onnan két oldali oszlophangszóró. --}}
            <svg class="signal-overlay" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                <defs>
                    <linearGradient id="church-signal" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#d99a5c" stop-opacity=".18" />
                        <stop offset="48%" stop-color="#f3cf94" stop-opacity=".95" />
                        <stop offset="100%" stop-color="#d99a5c" stop-opacity=".18" />
                    </linearGradient>
                    <filter id="church-glow" x="-40%" y="-40%" width="180%" height="180%"><feGaussianBlur stdDeviation="4" /></filter>
                </defs>
                <g fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M965 608 C965 638 965 662 965 684" class="church-signal-glow" />
                    <path d="M965 684 C825 652 638 560 475 495" class="church-signal-glow" />
                    <path d="M965 684 C1105 652 1282 560 1445 495" class="church-signal-glow" />
                    <path d="M965 608 C965 638 965 662 965 684" class="church-signal-path" data-church-path="source" />
                    <path d="M965 684 C825 652 638 560 475 495" class="church-signal-path" data-church-path="left" />
                    <path d="M965 684 C1105 652 1282 560 1445 495" class="church-signal-path" data-church-path="right" />
                </g>
            </svg>

            <div class="hero-content-wrap">
                <div class="hero-content">
                    <p class="eyebrow">Épülethangosítás</p>
                    <h1>
                        Minden szó eljut<br>oda, ahová kell.
                    </h1>
                    <p class="intro">
                        A mikrofontól az oszlopokon elhelyezett hangsugárzókig olyan rendszert tervezünk, amely a templomtérben tisztán és természetesen szól.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('quote.create') }}" class="button button-primary">Ajánlatot kérek</a>
                        <a href="{{ route('solutions.index') }}" class="button button-secondary">Megnézem a megoldásokat</a>
                    </div>
                    <p class="microcopy">Fotók és rövid videó alapján is elkészítjük az első ajánlatot.</p>
                </div>
            </div>

        </section>
    </main>
    <script src="{{ asset('js/templomos-preview.js') }}?v={{ filemtime(public_path('js/templomos-preview.js')) }}" defer></script>
</body>
</html>
