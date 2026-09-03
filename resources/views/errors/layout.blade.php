<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $code }} — {{ $heading }} · {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <style>
        @font-face {
            font-family: 'Instrument Sans';
            font-style: normal;
            font-weight: 400 700;
            font-display: swap;
            src: url('/fonts/instrument-sans-latin-600-normal.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Fraunces';
            font-style: normal;
            font-weight: 500 700;
            font-display: swap;
            src: url('/fonts/fraunces-latin-600-normal.woff2') format('woff2');
        }
        * { box-sizing: border-box; }
        html, body {
            height: 100%;
            margin: 0;
            background: #faf7f2;
            color: #1c2321;
            font-family: 'Instrument Sans', Arial, sans-serif;
        }
        .wrap {
            min-height: 100svh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            text-align: center;
        }
        .logo { display: inline-flex; margin-bottom: 2.5rem; }
        .logo img { height: 40px; width: auto; }
        .code {
            font-family: 'Fraunces', Georgia, serif;
            font-weight: 600;
            font-size: clamp(4.5rem, 14vw, 8rem);
            line-height: 1;
            letter-spacing: -0.03em;
            color: #c9793a;
            margin: 0;
        }
        h1 {
            font-family: 'Fraunces', Georgia, serif;
            font-weight: 600;
            font-size: clamp(1.5rem, 3.2vw, 2.1rem);
            line-height: 1.25;
            letter-spacing: -0.02em;
            margin: .75rem 0 0;
            color: #075252;
        }
        p.message {
            max-width: 34rem;
            margin: 1.1rem auto 0;
            color: rgb(28 35 33 / .72);
            font-size: 1.05rem;
            line-height: 1.6;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            justify-content: center;
            margin-top: 2.25rem;
        }
        .button {
            display: inline-flex;
            min-height: 3.1rem;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: .8rem 1.8rem;
            font-weight: 700;
            font-size: .98rem;
            text-decoration: none;
            transition: transform .18s ease, background-color .18s ease, border-color .18s ease;
        }
        .button:hover { transform: translateY(-2px); }
        .button-primary { background: #c9793a; color: #faf7f2; }
        .button-primary:hover { background: #0a5e5e; }
        .button-secondary { border: 1px solid rgb(28 35 33 / .22); color: #1c2321; }
        .button-secondary:hover { background: rgb(28 35 33 / .06); }
        .status-dot {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            margin-top: 3rem;
            padding: .5rem 1rem;
            border-radius: 999px;
            background: #edf5f5;
            color: #0a5e5e;
            font-size: .85rem;
            font-weight: 600;
        }
        .status-dot span {
            width: .5rem;
            height: .5rem;
            border-radius: 999px;
            background: currentColor;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo-icon.webp') }}" alt="{{ config('app.name') }}" width="40" height="27">
        </a>

        <p class="code">{{ $code }}</p>
        <h1>{{ $heading }}</h1>
        <p class="message">{{ $message }}</p>

        <div class="actions">
            <a href="{{ route('home') }}" class="button button-primary">Vissza a főoldalra</a>
            <a href="{{ route('contact') }}" class="button button-secondary">Kapcsolatfelvétel</a>
        </div>

        @if($note ?? null)
            <div class="status-dot"><span></span>{{ $note }}</div>
        @endif
    </div>
</body>
</html>
