{{--
    Tisztán vektoros (SVG) hero-illusztráció: izometrikus épület-kocka + hangenergia-áramlás.
    Semmilyen felbontáson nem pixelesedik. A #hero-diagram-flows alatti path-eket
    a resources/js/hero-diagram.js animálja folyamatos "energia-áramlás" hatással.
--}}
<svg
    id="hero-diagram"
    viewBox="0 0 640 480"
    class="w-full h-auto max-h-[560px]"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
>
    <defs>
        <linearGradient id="flow-teal" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#6bacac" stop-opacity="0" />
            <stop offset="50%" stop-color="#a8dede" stop-opacity="1" />
            <stop offset="100%" stop-color="#6bacac" stop-opacity="0.15" />
        </linearGradient>
        <linearGradient id="flow-gold" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#d99a5c" stop-opacity="0" />
            <stop offset="50%" stop-color="#f3cf94" stop-opacity="1" />
            <stop offset="100%" stop-color="#d99a5c" stop-opacity="0.15" />
        </linearGradient>
        <filter id="glow" x="-80%" y="-80%" width="260%" height="260%">
            <feGaussianBlur stdDeviation="5" />
        </filter>
    </defs>

    {{-- Háttér "network" pontok --}}
    <g fill="#6bacac" opacity="0.35">
        <circle cx="70" cy="60" r="2.5" />
        <circle cx="120" cy="40" r="1.8" />
        <circle cx="560" cy="70" r="2.5" />
        <circle cx="600" cy="120" r="1.8" />
        <circle cx="590" cy="420" r="2.5" />
        <circle cx="540" cy="450" r="1.8" />
        <circle cx="60" cy="420" r="2" />
        <circle cx="30" cy="380" r="1.5" />
    </g>
    <g stroke="#6bacac" stroke-width="1" opacity="0.25">
        <path d="M70,60 L120,40" />
        <path d="M560,70 L600,120" />
        <path d="M590,420 L540,450" />
    </g>

    {{-- Izometrikus épület-kocka --}}
    <g>
        {{-- Fő tetőlap (rombusz) --}}
        <polygon points="320,80 440,140 320,200 200,140" fill="#0a5e5e" fill-opacity="0.55" stroke="#6bacac" stroke-width="1.5" />
        {{-- Bal homlokzat (Aula és Recepció) --}}
        <polygon points="200,140 320,200 320,420 200,360" fill="#042f2f" stroke="#0f7a7a" stroke-width="1.5" />
        {{-- Jobb homlokzat (Open Office / Folyosó) --}}
        <polygon points="440,140 320,200 320,420 440,360" fill="#075252" stroke="#0f7a7a" stroke-width="1.5" />

        {{-- Szintosztó vonalak a jobb homlokzaton --}}
        <path d="M320,270 L440,230" stroke="#0a5e5e" stroke-width="1" opacity="0.7" />
        {{-- Ablak-rács motívum a homlokzatokon --}}
        <g stroke="#0f7a7a" stroke-width="1" opacity="0.5">
            <path d="M230,320 L230,395" />
            <path d="M260,335 L260,405" />
            <path d="M290,350 L290,415" />
            <path d="M360,300 L360,220" />
            <path d="M390,285 L390,205" />
            <path d="M410,275 L410,197" />
        </g>

        {{-- Kis "konferenciaterem" kocka a tetőn --}}
        <polygon points="320,10 390,45 320,80 250,45" fill="#0f7a7a" fill-opacity="0.85" stroke="#a8dede" stroke-width="1.5" />
        <polygon points="250,45 320,80 320,130 250,95" fill="#053838" stroke="#0f7a7a" stroke-width="1.5" />
        <polygon points="390,45 320,80 320,130 390,95" fill="#0a5e5e" stroke="#0f7a7a" stroke-width="1.5" />
    </g>

    {{-- Forrás node: 100V transzformátor --}}
    <g transform="translate(50,110)">
        <circle cx="35" cy="35" r="35" fill="#042f2f" stroke="#d99a5c" stroke-width="1.5" />
        <path d="M20 28h30M20 35h30M20 42h30" stroke="#d99a5c" stroke-width="2.5" stroke-linecap="round" />
        <text x="35" y="-12" text-anchor="middle" fill="#d4e8e8" font-size="12" letter-spacing="0.5" font-family="var(--font-sans)">100V transformer</text>
    </g>

    {{-- Zóna vezérlő központ (hub) --}}
    <g transform="translate(40,250)" filter="url(#glow)">
        <circle cx="50" cy="50" r="46" fill="#042f2f" stroke="#c9793a" stroke-width="2" />
    </g>
    <g transform="translate(40,250)">
        <circle cx="50" cy="50" r="46" fill="#042f2f" stroke="#c9793a" stroke-width="2" />
        <circle cx="50" cy="50" r="30" fill="none" stroke="#6bacac" stroke-width="1.2" stroke-dasharray="2 5" />
        <rect x="36" y="36" width="28" height="28" rx="6" fill="#0f7a7a" />
        <path d="M43 50h14M50 43v14" stroke="#faf7f2" stroke-width="2.5" stroke-linecap="round" />
    </g>
    <text x="90" y="375" text-anchor="middle" fill="#d4e8e8" font-size="12" letter-spacing="0.5" font-family="var(--font-sans)">Zóna Vezérlő</text>
    <text x="90" y="391" text-anchor="middle" fill="#d4e8e8" font-size="12" letter-spacing="0.5" font-family="var(--font-sans)">Központ</text>

    {{-- Forrás -> hub összekötő --}}
    <path d="M85,180 C85,210 85,250 90,268" stroke="#0f7a7a" stroke-width="2" stroke-linecap="round" stroke-dasharray="3 4" />

    {{-- Jobb oldali zóna-badge-ek, pontozott vezetővel --}}
    <g font-family="var(--font-sans)" font-size="12" fill="#d4e8e8">
        <path d="M395,55 L455,42" stroke="#6bacac" stroke-width="1" stroke-dasharray="2 4" />
        <circle cx="465" cy="40" r="18" fill="#042f2f" stroke="#a8dede" stroke-width="1.5" />
        <path d="M459 40h12M465 34v12" stroke="#a8dede" stroke-width="1.8" stroke-linecap="round" />
        <text x="490" y="44">Konferenciaterem 1</text>

        <path d="M420,190 L490,175" stroke="#d99a5c" stroke-width="1" stroke-dasharray="2 4" />
        <circle cx="500" cy="172" r="18" fill="#042f2f" stroke="#f3cf94" stroke-width="1.5" />
        <g stroke="#f3cf94" stroke-width="1.4">
            <rect x="493" y="165" width="6" height="6" />
            <rect x="501" y="165" width="6" height="6" />
            <rect x="493" y="174" width="6" height="6" />
            <rect x="501" y="174" width="6" height="6" />
        </g>
        <text x="525" y="176">Open Office Zóna</text>

        <path d="M420,300 L490,290" stroke="#d99a5c" stroke-width="1" stroke-dasharray="2 4" />
        <circle cx="500" cy="288" r="18" fill="#042f2f" stroke="#f3cf94" stroke-width="1.5" />
        <circle cx="500" cy="284" r="7" fill="none" stroke="#f3cf94" stroke-width="1.4" />
        <path d="M493 288a7 7 0 0014 0M500 295v5" stroke="#f3cf94" stroke-width="1.4" stroke-linecap="round" />
        <text x="525" y="292">Folyosó hangosítás</text>

        <path d="M330,405 L400,415" stroke="#6bacac" stroke-width="1" stroke-dasharray="2 4" />
        <circle cx="410" cy="418" r="18" fill="#042f2f" stroke="#a8dede" stroke-width="1.5" />
        <path d="M403 418h14M403 423h14" stroke="#a8dede" stroke-width="1.6" stroke-linecap="round" />
        <text x="270" y="452" text-anchor="middle">Aula és Recepció</text>
    </g>

    {{-- Hangenergia-áramlás a hubtól a zónákig --}}
    <g id="hero-diagram-flows" fill="none" stroke-linecap="round">
        <path data-flow d="M90,270 C150,230 220,120 320,95" stroke="url(#flow-gold)" stroke-width="4" opacity="0.9" />
        <path data-flow d="M90,280 C200,270 300,220 385,205" stroke="url(#flow-teal)" stroke-width="4" opacity="0.9" />
        <path data-flow d="M90,300 C200,320 300,300 385,290" stroke="url(#flow-gold)" stroke-width="4" opacity="0.9" />
        <path data-flow d="M90,320 C160,350 240,390 320,405" stroke="url(#flow-teal)" stroke-width="4" opacity="0.9" />
    </g>
</svg>
