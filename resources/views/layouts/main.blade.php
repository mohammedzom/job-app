<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Shaghalni' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@1,700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #06060f;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* ── Glow Orbs ── */
        .orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(90px);
            animation: drift 12s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(99,102,241,.30) 0%, transparent 70%);
            top: -200px; left: -150px;
            animation-duration: 14s;
        }
        .orb-2 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(236,72,153,.22) 0%, transparent 70%);
            bottom: -150px; right: -100px;
            animation-duration: 18s;
            animation-direction: alternate-reverse;
        }
        .orb-3 {
            width: 450px; height: 450px;
            background: radial-gradient(circle, rgba(139,92,246,.25) 0%, transparent 70%);
            top: 40%; left: 35%;
            transform: translate(-50%, -50%);
            animation-duration: 22s;
        }
        .orb-4 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(245,158,11,.18) 0%, transparent 70%);
            top: 80px; right: 15%;
            animation-duration: 16s;
            animation-direction: alternate-reverse;
        }

        @keyframes drift {
            0%   { transform: translate(0, 0) scale(1); }
            33%  { transform: translate(25px, -30px) scale(1.05); }
            66%  { transform: translate(-15px, 20px) scale(0.97); }
            100% { transform: translate(10px, -10px) scale(1.02); }
        }

        /* ── Content wrapper ── */
        .page-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 2rem 1.5rem;
            width: 100%;
            max-width: 900px;
        }

        /* ── Vignette overlay ── */
        .vignette {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 120% 50% at 50% 50%, transparent 40%, #06060f 100%);
            pointer-events: none;
            z-index: 5;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Background Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>

    <!-- Radial vignette (edges only) -->
    <div class="vignette"></div>

    <!-- Page Content -->
    <main class="page-content">
        {{ $slot }}
    </main>
</body>
</html>