<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — Shaghalni' : config('app.name', 'Shaghalni') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@1,700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg:        #06060f;
            --surface:   rgba(255,255,255,.03);
            --border:    rgba(255,255,255,.07);
            --indigo:    #6366f1;
            --violet:    #8b5cf6;
            --pink:      #ec4899;
            --text:      #e2e8f0;
            --muted:     #64748b;
            --subtle:    rgba(255,255,255,.45);
            --nav-h:     64px;
        }

        html, body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,.3); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(99,102,241,.55); }

        /* ── Ambient orbs (fixed, behind everything) ── */
        .ambient-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            animation: orbDrift linear infinite alternate;
        }
        .orb-1 {
            width: 900px; height: 900px;
            background: radial-gradient(circle, rgba(99,102,241,.18) 0%, transparent 65%);
            top: -350px; left: -250px;
            animation-duration: 18s;
        }
        .orb-2 {
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(236,72,153,.14) 0%, transparent 65%);
            bottom: -200px; right: -150px;
            animation-duration: 24s;
            animation-direction: alternate-reverse;
        }
        .orb-3 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(139,92,246,.18) 0%, transparent 65%);
            top: 40%; left: 50%;
            transform: translate(-50%,-50%);
            animation-duration: 30s;
        }

        @keyframes orbDrift {
            0%   { transform: translate(0px, 0px) scale(1); }
            33%  { transform: translate(30px, -40px) scale(1.04); }
            66%  { transform: translate(-20px, 25px) scale(0.97); }
            100% { transform: translate(15px, -15px) scale(1.02); }
        }

        /* ── Noise texture overlay ── */
        .noise-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            opacity: .025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }

        /* ── Navigation ── */
        .sg-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--nav-h);
            z-index: 100;
            display: flex;
            align-items: center;
            background: rgba(6,6,15,.7);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            gap: 2rem;
        }

        /* Logo */
        .sg-logo {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .sg-logo-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--indigo), var(--pink));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 18px rgba(99,102,241,.4);
        }

        .sg-logo-icon svg { width: 16px; height: 16px; }

        .sg-logo-text {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -.02em;
            color: #fff;
        }

        .sg-logo-text span {
            background: linear-gradient(135deg, #818cf8, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Nav links */
        .sg-nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            flex: 1;
        }

        .sg-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.8rem;
            font-size: 0.83rem;
            font-weight: 500;
            color: var(--subtle);
            text-decoration: none;
            border-radius: 0.55rem;
            transition: all .2s ease;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .sg-nav-link svg { width: 14px; height: 14px; opacity: .7; }

        .sg-nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.06);
            border-color: var(--border);
        }

        .sg-nav-link.active {
            color: #fff;
            background: rgba(99,102,241,.15);
            border-color: rgba(99,102,241,.3);
        }

        .sg-nav-link.active svg { opacity: 1; }

        /* Right side */
        .sg-nav-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-left: auto;
        }

        /* User pill (dropdown trigger) */
        .sg-user-pill {
            display: flex; align-items: center; gap: 0.55rem;
            padding: 0.3rem 0.8rem 0.3rem 0.3rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 9999px;
            cursor: pointer;
            transition: all .2s ease;
            position: relative;
        }

        .sg-user-pill:hover {
            background: rgba(255,255,255,.06);
            border-color: rgba(255,255,255,.14);
        }

        .sg-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--indigo), var(--pink));
            display: flex; align-items: center; justify-content: center;
            font-size: .72rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }

        .sg-user-name {
            font-size: .8rem; font-weight: 500; color: rgba(255,255,255,.75);
        }

        .sg-user-caret {
            width: 14px; height: 14px;
            color: var(--muted);
            transition: transform .2s;
        }

        /* Dropdown */
        .sg-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 190px;
            background: rgba(12,12,24,.95);
            backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            border-radius: 0.9rem;
            padding: 0.4rem;
            opacity: 0;
            pointer-events: none;
            transform: translateY(-8px) scale(.97);
            transition: all .2s cubic-bezier(.22,1,.36,1);
            z-index: 200;
        }

        .sg-user-pill.open .sg-dropdown {
            opacity: 1;
            pointer-events: all;
            transform: translateY(0) scale(1);
        }

        .sg-user-pill.open .sg-user-caret { transform: rotate(180deg); }

        .sg-drop-item {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 0.7rem;
            font-size: 0.82rem; font-weight: 500;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            border-radius: 0.55rem;
            transition: all .15s ease;
            cursor: pointer;
            background: none; border: none; width: 100%; text-align: left;
        }

        .sg-drop-item svg { width: 14px; height: 14px; opacity: .6; }

        .sg-drop-item:hover {
            color: #fff;
            background: rgba(255,255,255,.07);
        }

        .sg-drop-item:hover svg { opacity: 1; }

        .sg-drop-divider {
            height: 1px;
            background: var(--border);
            margin: 0.3rem 0.4rem;
        }

        .sg-drop-item.danger:hover { color: #f87171; background: rgba(248,113,113,.08); }

        /* Mobile hamburger */
        .sg-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            padding: 0.5rem;
            background: none; border: none; cursor: pointer;
            margin-left: auto;
        }

        .sg-hamburger span {
            display: block; width: 20px; height: 2px;
            background: rgba(255,255,255,.6);
            border-radius: 2px;
            transition: all .25s ease;
        }

        /* Mobile menu overlay */
        .sg-mobile-menu {
            display: none;
            position: fixed;
            top: var(--nav-h); left: 0; right: 0;
            background: rgba(6,6,15,.97);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.5rem 1.5rem;
            z-index: 99;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sg-mobile-menu.open { display: flex; }

        .sg-mob-link {
            display: flex; align-items: center; gap: 0.55rem;
            padding: 0.65rem 0.85rem;
            font-size: .9rem; font-weight: 500;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            border-radius: 0.65rem;
            transition: all .2s;
        }

        .sg-mob-link svg { width: 16px; height: 16px; }
        .sg-mob-link:hover { color: #fff; background: rgba(255,255,255,.07); }
        .sg-mob-link.active { color: #fff; background: rgba(99,102,241,.15); }

        .sg-mob-divider { height: 1px; background: var(--border); margin: 0.6rem 0; }

        @media (max-width: 640px) {
            .sg-nav-links, .sg-nav-right { display: none !important; }
            .sg-hamburger { display: flex; }
        }

        /* ── Page shell ── */
        .sg-shell {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            padding-top: var(--nav-h);
        }

        /* Header slot */
        .sg-page-header {
            border-bottom: 1px solid var(--border);
            background: rgba(6,6,15,.5);
            backdrop-filter: blur(12px);
        }

        .sg-page-header-inner {
            max-width: 80rem;
            margin: 0 auto;
            padding: 1.25rem 1.5rem;
        }

        .sg-page-header-inner h2 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.02em;
        }

        /* Main content */
        .sg-main { position: relative; z-index: 10; }

        /* ── Flash messages ── */
        .sg-flash {
            max-width: 80rem; margin: 1.25rem auto 0;
            padding: 0 1.5rem;
        }

        /* ── Global card helper ── */
        .sg-card {
            background: rgba(15,23,42,.7);
            border: 1px solid var(--border);
            border-radius: 1.1rem;
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body>
    <!-- Ambient background -->
    <div class="ambient-layer" aria-hidden="true">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="noise-layer" aria-hidden="true"></div>

    <!-- ── Navigation ── -->
    <nav class="sg-nav" id="sg-nav">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="sg-logo">
            <span class="sg-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/>
                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                    <line x1="12" y1="12" x2="12" y2="16"/>
                    <line x1="10" y1="14" x2="14" y2="14"/>
                </svg>
            </span>
            <span class="sg-logo-text">Shaghalni<span>.</span></span>
        </a>

        <!-- Desktop nav links -->
        <div class="sg-nav-links">
            <a href="{{ route('dashboard') }}"
               class="sg-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('job-applications.index') }}"
               class="sg-nav-link {{ request()->routeIs('job-applications.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
                My Applications
            </a>
            <a href="{{ route('resumes.index') }}"
               class="sg-nav-link {{ request()->routeIs('resumes.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Resumes
            </a>
        </div>

        <!-- Desktop right -->
        <div class="sg-nav-right" id="sg-user-menu">
            <div class="sg-user-pill" id="sg-user-pill" onclick="this.classList.toggle('open')">
                <span class="sg-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                <span class="sg-user-name">{{ Auth::user()->name }}</span>
                <svg class="sg-user-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>

                <div class="sg-dropdown">
                    <a href="{{ route('profile.edit') }}" class="sg-drop-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        Profile
                    </a>
                    <div class="sg-drop-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sg-drop-item danger">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile hamburger -->
        <button class="sg-hamburger" id="sg-hamburger" onclick="toggleMobileMenu()" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <!-- Mobile menu -->
    <div class="sg-mobile-menu" id="sg-mobile-menu">
        <a href="{{ route('dashboard') }}" class="sg-mob-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('job-applications.index') }}" class="sg-mob-link {{ request()->routeIs('job-applications.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            My Applications
        </a>
        <a href="{{ route('resumes.index') }}" class="sg-mob-link {{ request()->routeIs('resumes.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Resumes
        </a>
        <div class="sg-mob-divider"></div>
        <a href="{{ route('profile.edit') }}" class="sg-mob-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profile
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sg-mob-link" style="width:100%;color:#f87171;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Log Out
            </button>
        </form>
    </div>

    <!-- Shell -->
    <div class="sg-shell">

        @isset($header)
        <div class="sg-page-header">
            <div class="sg-page-header-inner">
                {{ $header }}
            </div>
        </div>
        @endisset

        <main class="sg-main">
            {{ $slot }}
        </main>
    </div>

    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const pill = document.getElementById('sg-user-pill');
            if (pill && !pill.contains(e.target)) {
                pill.classList.remove('open');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('sg-mobile-menu');
            const btn = document.getElementById('sg-hamburger');
            const isOpen = menu.classList.toggle('open');
            btn.style.opacity = isOpen ? '1' : '';
        }
    </script>
</body>

</html>