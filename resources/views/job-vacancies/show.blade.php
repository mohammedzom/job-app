<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __($jobVacancy->title) }}
        </h2>
    </x-slot>

    {{-- Inline styles scoped to this page --}}
    <style>
        /* ── Page wrapper ──────────────────────────────── */
        .jv-show-wrapper {
            padding: 2.5rem 1rem;
            max-width: 80rem;
            margin: 0 auto;
        }

        /* ── Back link ─────────────────────────────────── */
        .jv-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #818cf8;
            text-decoration: none;
            margin-bottom: 1.75rem;
            transition: color 0.2s, gap 0.2s;
        }

        .jv-back-link:hover {
            color: #a5b4fc;
            gap: 0.6rem;
        }

        .jv-back-link svg {
            width: 16px;
            height: 16px;
        }

        /* ── Hero header card ──────────────────────────── */
        .jv-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #1f1347 100%);
            border: 1px solid rgba(99, 102, 241, 0.25);
            border-radius: 1.25rem;
            padding: 2.25rem 2.5rem;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.75rem;
        }

        .jv-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 90% 20%, rgba(99, 102, 241, .18), transparent);
            pointer-events: none;
        }

        .jv-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .jv-hero-title {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin: 0 0 0.35rem;
        }

        .jv-hero-company {
            font-size: 1rem;
            color: #a5b4fc;
            font-weight: 600;
            margin-bottom: 0.9rem;
        }

        .jv-meta-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.6rem;
        }

        .jv-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .jv-chip-location {
            background: rgba(255, 255, 255, .07);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, .1);
        }

        .jv-chip-salary {
            background: rgba(52, 211, 153, .12);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, .25);
        }

        .jv-chip-type {
            background: rgba(99, 102, 241, .18);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, .35);
        }

        .jv-chip-status-active {
            background: rgba(34, 197, 94, .12);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, .3);
        }

        /* ── Apply button ──────────────────────────────── */
        .jv-apply-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.75rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 0.9rem;
            text-decoration: none;
            white-space: nowrap;
            box-shadow: 0 4px 24px rgba(99, 102, 241, .4);
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
        }

        .jv-apply-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(99, 102, 241, .55);
            filter: brightness(1.08);
        }

        .jv-apply-btn svg {
            width: 18px;
            height: 18px;
        }

        /* ── Two-column layout ─────────────────────────── */
        .jv-body {
            display: grid;
            grid-template-columns: 1fr 21rem;
            gap: 1.75rem;
            align-items: start;
        }

        @media (max-width: 900px) {
            .jv-body {
                grid-template-columns: 1fr;
            }
        }

        /* ── Section card ──────────────────────────────── */
        .jv-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 1.1rem;
            padding: 1.75rem;
            backdrop-filter: blur(6px);
        }

        /* ── Section heading ───────────────────────────── */
        .jv-section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #e2e8f0;
            margin: 0 0 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .jv-section-title .icon-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            flex-shrink: 0;
        }

        /* ── Description ───────────────────────────────── */
        .jv-description {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.85;
            white-space: pre-wrap;
        }

        /* ── Overview grid ─────────────────────────────── */
        .overview-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .overview-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
        }

        .overview-item:last-child {
            border-bottom: none;
        }

        .overview-item .label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .overview-item .label svg {
            width: 14px;
            height: 14px;
            opacity: .75;
        }

        .overview-item .value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #e2e8f0;
            text-align: right;
        }

        /* ── Stat cards ────────────────────────────────── */
        .jv-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .stat-card {
            background: rgba(99, 102, 241, 0.08);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 0.85rem;
            padding: 1rem 1.1rem;
            text-align: center;
        }

        .stat-card .stat-num {
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card .stat-label {
            font-size: 0.72rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-weight: 500;
            margin-top: 0.15rem;
        }

        /* ── Tag pills ─────────────────────────────────── */
        .tag-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
            margin-top: 0.5rem;
        }

        .tag-pill {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            border: 1px solid rgba(99, 102, 241, .3);
            background: rgba(99, 102, 241, .1);
            color: #a5b4fc;
        }

        .tag-pill-tech {
            border-color: rgba(52, 211, 153, .3);
            background: rgba(52, 211, 153, .08);
            color: #6ee7b7;
        }

        /* ── Deadline warning ──────────────────────────── */
        .deadline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #fbbf24;
        }

        .deadline-badge svg {
            width: 14px;
            height: 14px;
        }
    </style>

    <div class="jv-show-wrapper">

        {{-- ← Back link --}}
        <a href="{{ route('dashboard') }}" class="jv-back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Back to Dashboard
        </a>

        {{-- ── Hero header ───────────────────────────────────── --}}
        <div class="jv-hero">
            <div class="jv-hero-top">
                <div>
                    <h1 class="jv-hero-title">{{ $jobVacancy->title }}</h1>
                    <p class="jv-hero-company">
                        🏢 {{ $jobVacancy->company->name }}
                    </p>
                    <div class="jv-meta-row">
                        <span class="jv-chip jv-chip-location">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                width="13" height="13">
                                <path d="M12 21s-8-7.5-8-13a8 8 0 0116 0c0 5.5-8 13-8 13z" />
                                <circle cx="12" cy="8" r="3" />
                            </svg>
                            {{ $jobVacancy->location }}
                        </span>
                        <span class="jv-chip jv-chip-salary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                width="13" height="13">
                                <rect x="2" y="7" width="20" height="14" rx="2" />
                                <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                                <line x1="12" y1="12" x2="12" y2="16" />
                                <line x1="10" y1="14" x2="14" y2="14" />
                            </svg>
                            ${{ number_format($jobVacancy->salary) }} / Year
                        </span>
                        <span class="jv-chip jv-chip-type">
                            {{ Str::ucfirst(str_replace('_', '-', $jobVacancy->type)) }}
                        </span>
                        @if ($jobVacancy->status === 'active')
                            <span class="jv-chip jv-chip-status-active">
                                <svg viewBox="0 0 10 10" width="7" height="7" fill="currentColor">
                                    <circle cx="5" cy="5" r="5" />
                                </svg>
                                Active
                            </span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}" class="jv-apply-btn">
                    Apply Now
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- ── Two-column body ──────────────────────────────── --}}
        <div class="jv-body">

            {{-- LEFT — Description --}}
            <div class="jv-card">
                <h2 class="jv-section-title">
                    <span class="icon-dot"></span> Job Description
                </h2>
                <p class="jv-description">{{ $jobVacancy->description }}</p>

                @if (count($jobVacancy->technologies) > 0)
                    <div style="margin-top:1.75rem;">
                        <h3 class="jv-section-title" style="font-size:.9rem;">
                            <span class="icon-dot" style="background:linear-gradient(135deg,#34d399,#6ee7b7);"></span>
                            Required Technologies
                        </h3>
                        <div class="tag-group">
                            @foreach ($jobVacancy->technologies as $technology)
                                <span class="tag-pill tag-pill-tech">{{ $technology }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($jobVacancy->categories->count() > 0)
                    <div style="margin-top:1.5rem;">
                        <h3 class="jv-section-title" style="font-size:.9rem;">
                            <span class="icon-dot"></span> Categories
                        </h3>
                        <div class="tag-group">
                            @foreach ($jobVacancy->categories as $category)
                                <span class="tag-pill">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- RIGHT — Sidebar --}}
            <div style="display:flex; flex-direction:column; gap:1.25rem;">

                {{-- Stats --}}
                <div class="jv-card" style="padding:1.4rem;">
                    <h2 class="jv-section-title">
                        <span class="icon-dot"></span> Job Stats
                    </h2>
                    <div class="jv-stats">
                        <div class="stat-card">
                            <div class="stat-num">{{ number_format($jobVacancy->view_count) }}</div>
                            <div class="stat-label">Views</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-num">{{ number_format($jobVacancy->apply_count) }}</div>
                            <div class="stat-label">Applications</div>
                        </div>
                    </div>

                    @if ($jobVacancy->view_count > 0)
                        @php
                            $convRate = round(($jobVacancy->apply_count / $jobVacancy->view_count) * 100, 1);
                        @endphp
                        <div
                            style="background:rgba(99,102,241,.07);border-radius:.7rem;padding:.7rem 1rem;text-align:center;">
                            <div
                                style="font-size:.7rem;color:#64748b;text-transform:uppercase;letter-spacing:.06em;font-weight:500;margin-bottom:.2rem;">
                                Conversion Rate</div>
                            <div style="font-size:1.1rem;font-weight:800;color:#818cf8;">{{ $convRate }}%</div>
                        </div>
                    @endif
                </div>

                {{-- Overview --}}
                <div class="jv-card" style="padding:1.4rem;">
                    <h2 class="jv-section-title">
                        <span class="icon-dot"></span> Overview
                    </h2>
                    <div class="overview-list">
                        <div class="overview-item">
                            <span class="label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="3" width="20" height="14" rx="2" />
                                    <path d="M8 21h8M12 17v4" />
                                </svg>
                                Company
                            </span>
                            <span class="value">{{ $jobVacancy->company->name }}</span>
                        </div>
                        <div class="overview-item">
                            <span class="label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 21s-8-7.5-8-13a8 8 0 0116 0c0 5.5-8 13-8 13z" />
                                    <circle cx="12" cy="8" r="3" />
                                </svg>
                                Location
                            </span>
                            <span class="value">{{ $jobVacancy->location }}</span>
                        </div>
                        <div class="overview-item">
                            <span class="label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" />
                                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                                </svg>
                                Salary
                            </span>
                            <span class="value">${{ number_format($jobVacancy->salary) }}/yr</span>
                        </div>
                        <div class="overview-item">
                            <span class="label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Type
                            </span>
                            <span class="value">{{ Str::ucfirst(str_replace('_', '-', $jobVacancy->type)) }}</span>
                        </div>
                        <div class="overview-item">
                            <span class="label">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                Published
                            </span>
                            <span class="value">{{ $jobVacancy->created_at->format('M d, Y') }}</span>
                        </div>
                        @if ($jobVacancy->application_deadline)
                            <div class="overview-item">
                                <span class="label">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                        <line x1="12" y1="9" x2="12" y2="13" />
                                        <line x1="12" y1="17" x2="12.01" y2="17" />
                                    </svg>
                                    Deadline
                                </span>
                                <span class="deadline-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    {{ $jobVacancy->application_deadline }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CTA bottom --}}
                <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}" class="jv-apply-btn"
                    style="justify-content:center; border-radius:0.85rem; text-align:center;">
                    Apply for This Position
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
