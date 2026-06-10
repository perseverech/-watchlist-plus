<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WatchList+ | @yield('title', 'Discover Movies & Series')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-bg:      #0a0a0f;
            --color-surface: #13131a;
            --color-border:  #1e1e2e;
            --color-accent:  #e8462a;
            --color-accent2: #f5a623;
            --color-text:    #e8e8f0;
            --color-muted:   #6b6b80;
            --font-display:  'Bebas Neue', sans-serif;
            --font-body:     'DM Sans', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--color-bg);
            color: var(--color-text);
            font-family: var(--font-body);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.35;
        }

        .page-wrapper {
            animation: fadeUp 0.45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--color-bg); }
        ::-webkit-scrollbar-thumb { background: var(--color-border); border-radius: 3px; }

        .btn {
            padding: 0.45rem 1.1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            font-family: var(--font-body);
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn--ghost {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text);
        }

        .btn--ghost:hover { border-color: var(--color-muted); }
        .btn--accent { background: var(--color-accent); color: #fff; }
        .btn--accent:hover { background: #c73820; }
        .btn--full { width: 100%; padding: 0.8rem; font-size: 0.95rem; text-align: center; }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 1.8rem;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .section-line {
            flex: 1;
            height: 1px;
            background: var(--color-border);
        }

        .flash { padding: 0.8rem 2.5rem; font-size: 0.9rem; }
        .flash--success { background: #1a3a1a; color: #6fcf6f; border-bottom: 1px solid #2d5a2d; }
        .flash--error   { background: #3a1a1a; color: #e07070; border-bottom: 1px solid #5a2d2d; }

        .media-card {
            display: block;
            text-decoration: none;
            color: var(--color-text);
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .media-card:hover {
            transform: translateY(-6px);
            border-color: var(--color-accent);
            box-shadow: 0 16px 40px rgba(232,70,42,0.15);
        }

        .media-card__poster {
            position: relative;
            aspect-ratio: 2/3;
            overflow: hidden;
            background: var(--color-bg);
        }

        .media-card__poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .media-card__no-poster {
            width: 100%;
            height: 100%;
            min-height: 230px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-muted);
            font-size: 0.78rem;
            background: repeating-linear-gradient(
                45deg,
                var(--color-bg), var(--color-bg) 10px,
                var(--color-border) 10px, var(--color-border) 11px
            );
        }

        .media-card__badge {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: rgba(10,10,15,0.85);
            color: var(--color-accent);
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
        }

        .media-card__overlay {
            position: absolute;
            inset: 0;
            background: rgba(10,10,15,0.72);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s;
        }

        .media-card:hover .media-card__overlay {
            opacity: 1;
        }

        .media-card__view-btn {
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 0.45rem 0.9rem;
            border-radius: 6px;
        }

        .media-card__info {
            padding: 0.8rem;
        }

        .media-card__title {
            font-size: 0.88rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.35rem;
        }

        .media-card__meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .media-card__rating {
            font-size: 0.78rem;
            color: var(--color-accent2);
        }

        .media-card__year {
            font-size: 0.72rem;
            color: var(--color-muted);
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    @if(session('success'))
        <div class="flash flash--success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="flash flash--error">{{ session('error') }}</div>
    @endif

    <main class="page-wrapper">
        @yield('content')
    </main>

    <footer style="text-align:center; padding:2rem; color:var(--color-muted); font-size:0.8rem; border-top:1px solid var(--color-border); margin-top:4rem;">
        WatchList+ &copy; {{ date('Y') }} &mdash; Track what you love.
    </footer>

    @stack('scripts')

</body>
</html>