{{-- ============================================================
     FILE: resources/views/layouts/app.blade.php
     This is the master template. Every page extends this.
     ============================================================ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF token needed by ALL AJAX requests (search, reviews, library) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WatchList+ | @yield('title', 'Discover Movies & Series')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

    {{-- Vite compiles Tailwind + your JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== GLOBAL CSS VARIABLES ===== */
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

        /* Subtle film-grain texture overlay on whole app */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.35;
        }

        /* Page fade-in on every load */
        .page-wrapper {
            animation: fadeUp 0.45s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--color-bg); }
        ::-webkit-scrollbar-thumb { background: var(--color-border); border-radius: 3px; }

        /* ===== GLOBAL BUTTONS ===== */
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

        /* ===== SECTION HEADER (reused across pages) ===== */
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

        /* ===== FLASH MESSAGES ===== */
        .flash { padding: 0.8rem 2.5rem; font-size: 0.9rem; }
        .flash--success { background: #1a3a1a; color: #6fcf6f; border-bottom: 1px solid #2d5a2d; }
        .flash--error   { background: #3a1a1a; color: #e07070; border-bottom: 1px solid #5a2d2d; }
    </style>

    {{-- Each page can inject extra <style> blocks here --}}
    @stack('styles')
</head>
<body>

    {{-- ===== NAVBAR — always visible ===== --}}
    @include('partials.navbar')

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success'))
        <div class="flash flash--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash--error">{{ session('error') }}</div>
    @endif

    {{-- ===== MAIN CONTENT — each page fills this via @section('content') ===== --}}
    <main class="page-wrapper">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer style="text-align:center; padding:2rem; color:var(--color-muted); font-size:0.8rem; border-top:1px solid var(--color-border); margin-top:4rem;">
        WatchList+ &copy; {{ date('Y') }} &mdash; Track what you love.
    </footer>

    {{-- ===== PAGE-SPECIFIC SCRIPTS injected here by each page ===== --}}
    @stack('scripts')

</body>
</html>
