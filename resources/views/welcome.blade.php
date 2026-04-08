<x-main-layout title="Shaghalni - Find Your Dream Job">

    <style>
        /* ── Animations ── */
        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleFade {
            from {
                opacity: 0;
                transform: scale(.94);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hero-badge {
            animation: fadeDown .6s cubic-bezier(.22, 1, .36, 1) .15s both;
        }

        .hero-heading {
            animation: scaleFade .8s cubic-bezier(.22, 1, .36, 1) .3s both;
        }

        .hero-desc {
            animation: fadeUp .7s cubic-bezier(.22, 1, .36, 1) .5s both;
        }

        .hero-buttons {
            animation: fadeUp .7s cubic-bezier(.22, 1, .36, 1) .65s both;
        }

        /* ── Badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .28rem 1rem;
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .55);
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 9999px;
            backdrop-filter: blur(6px);
            margin-bottom: 2rem;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #818cf8;
            box-shadow: 0 0 6px #818cf8;
        }

        /* ── Heading ── */
        .hero-title {
            font-size: clamp(2.8rem, 8vw, 6.5rem);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -.03em;
            margin-bottom: 1.5rem;
        }

        .hero-title .line-1 {
            display: block;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .hero-title .line-2 {
            display: block;
            font-family: 'Playfair Display', Georgia, serif;
            font-style: italic;
            font-weight: 700;
            padding: 0.1em 0.05em;
            margin: -0.1em -0.05em;
            background: linear-gradient(130deg,
                    rgba(255, 255, 255, .85) 0%,
                    rgba(167, 139, 250, .8) 50%,
                    rgba(255, 255, 255, .4) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Description ── */
        .hero-description {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, .45);
            line-height: 1.7;
            max-width: 440px;
            margin: 0 auto 2.5rem;
        }

        /* ── Buttons ── */
        .btn-group {
            display: flex;
            gap: .85rem;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: .65rem 1.6rem;
            font-size: .88rem;
            font-weight: 500;
            border-radius: .6rem;
            text-decoration: none;
            transition: all .2s ease;
            cursor: pointer;
        }

        .btn-ghost {
            color: rgba(255, 255, 255, .8);
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, .12);
            border-color: rgba(255, 255, 255, .25);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: 1px solid rgba(99, 102, 241, .3);
            box-shadow: 0 0 24px rgba(99, 102, 241, .35), inset 0 1px 0 rgba(255, 255, 255, .15);
        }

        .btn-primary:hover {
            box-shadow: 0 0 36px rgba(99, 102, 241, .55), inset 0 1px 0 rgba(255, 255, 255, .2);
            transform: translateY(-2px);
        }
    </style>

    <!-- Badge -->
    <div class="hero-badge">
        <span class="badge">
            <span class="badge-dot"></span>
            Shaghalni
        </span>
    </div>

    <!-- Heading -->
    <div class="hero-heading">
        <h1 class="hero-title">
            <span class="line-1">Find your</span>
            <span class="line-2">Dream Job</span>
        </h1>
    </div>

    <!-- Description -->
    <div class="hero-desc">
        <p class="hero-description">
            connect with top employers, and find exciting opportunities
        </p>
    </div>

    <!-- Buttons -->
    <div class="hero-buttons">
        <div class="btn-group">
            <a href="{{ route('register') }}" class="btn btn-ghost">Create an Account</a>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    </div>

</x-main-layout>
