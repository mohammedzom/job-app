<x-app-layout>
    <x-slot name="header">
        <h2>Application Details</h2>
    </x-slot>

    <style>
        /* ── Page wrapper ── */
        .jas-wrap {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 5rem;
        }

        /* ── Back link ── */
        .jas-back {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: .82rem; font-weight: 500;
            color: #818cf8; text-decoration: none;
            margin-bottom: 2rem; transition: gap .2s, color .2s;
        }
        .jas-back svg { width: 14px; height: 14px; }
        .jas-back:hover { gap: .65rem; color: #a5b4fc; }

        /* ── Two-col layout ── */
        .jas-layout {
            display: grid;
            grid-template-columns: 1fr 22rem;
            gap: 1.5rem;
            align-items: start;
        }

        @media (max-width: 900px) { .jas-layout { grid-template-columns: 1fr; } }

        /* ── Common card ── */
        .jas-card {
            background: rgba(15,23,42,.6);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 1.15rem;
            padding: 1.75rem;
            backdrop-filter: blur(10px);
        }

        /* ── Hero (job header) ── */
        .jas-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #160d35 100%);
            border: 1px solid rgba(99,102,241,.22);
            border-radius: 1.15rem;
            padding: 2rem 2rem;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        .jas-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 80% at 95% 10%, rgba(99,102,241,.18), transparent);
            pointer-events: none;
        }

        .jas-hero-inner { position: relative; z-index: 1; }

        .jas-status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
            margin-bottom: 1.1rem;
        }

        .jas-status-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .25rem .8rem;
            font-size: .72rem; font-weight: 700;
            letter-spacing: .07em; text-transform: uppercase;
            border-radius: 9999px; border: 1px solid;
        }

        .jas-status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .status-pending  { background: rgba(245,158,11,.1); color: #fbbf24; border-color: rgba(245,158,11,.3); }
        .status-accepted { background: rgba(52,211,153,.1); color: #34d399; border-color: rgba(52,211,153,.3); }
        .status-rejected { background: rgba(239,68,68,.1);  color: #f87171; border-color: rgba(239,68,68,.3); }

        .jas-time-pill {
            font-size: .75rem; color: rgba(255,255,255,.3); display: flex; align-items: center; gap: .35rem;
        }
        .jas-time-pill svg { width: 12px; height: 12px; }

        .jas-hero-title {
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 800;
            letter-spacing: -.03em;
            color: #fff;
            margin-bottom: .65rem;
            line-height: 1.15;
        }

        .jas-hero-meta {
            display: flex; flex-wrap: wrap; align-items: center; gap: .55rem;
        }

        .jas-hero-chip {
            display: inline-flex; align-items: center; gap: .3rem;
            font-size: .78rem; font-weight: 500;
            padding: .28rem .75rem;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .jas-hero-chip svg { width: 12px; height: 12px; opacity: .7; }
        .jas-hero-chip-company { background: rgba(99,102,241,.15); border: 1px solid rgba(99,102,241,.25); color: #a5b4fc; }
        .jas-hero-chip-loc     { background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1); color: rgba(255,255,255,.55); }
        .jas-hero-chip-type    { background: rgba(52,211,153,.08); border: 1px solid rgba(52,211,153,.2); color: #6ee7b7; }
        .jas-hero-chip-salary  { background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.2); color: #fbbf24; font-weight: 700; }

        /* ── Section title ── */
        .jas-section-title {
            display: flex; align-items: center; gap: .45rem;
            font-size: .82rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: rgba(255,255,255,.35);
            margin-bottom: 1.1rem;
        }

        .jas-section-title .marker {
            width: 3px; height: 14px;
            border-radius: 2px;
            background: linear-gradient(180deg, #6366f1, #ec4899);
        }

        /* ── AI Analysis card ── */
        .jas-ai-card {
            background: rgba(99,102,241,.05);
            border: 1px solid rgba(99,102,241,.15);
            border-radius: 1.15rem;
            padding: 1.75rem;
            margin-bottom: 1.25rem;
        }

        .jas-ai-header {
            display: flex; align-items: center; gap: .75rem;
            margin-bottom: 1.35rem;
        }

        .jas-ai-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 16px rgba(99,102,241,.3);
            flex-shrink: 0;
        }

        .jas-ai-icon svg { width: 18px; height: 18px; color: #fff; }

        .jas-ai-header-text h3 {
            font-size: 1rem; font-weight: 700; color: #e2e8f0; letter-spacing: -.01em;
        }

        .jas-ai-header-text p {
            font-size: .75rem; color: rgba(255,255,255,.3); margin-top: .1rem;
        }

        .jas-ai-body {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        /* Score circle */
        .jas-score-circle {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            width: 90px; height: 90px;
            border-radius: 50%;
            border: 2px solid rgba(99,102,241,.25);
            background: rgba(99,102,241,.08);
            flex-shrink: 0;
        }

        .jas-score-num {
            font-size: 1.75rem; font-weight: 900; letter-spacing: -.04em; line-height: 1;
        }

        .jas-score-pct { font-size: .65rem; font-weight: 600; color: rgba(255,255,255,.3); margin-top: .1rem; }

        .score-hi { background: linear-gradient(135deg, #34d399, #6ee7b7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .score-md { background: linear-gradient(135deg, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .score-lo { background: linear-gradient(135deg, #f59e0b, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Feedback */
        .jas-feedback-text {
            font-size: .875rem;
            color: rgba(255,255,255,.55);
            line-height: 1.8;
            font-style: italic;
        }

        /* ── Resume profile card ── */
        .jas-profile-card {
            background: rgba(15,23,42,.6);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 1.15rem;
            padding: 1.75rem;
            backdrop-filter: blur(10px);
        }

        /* Profile file badge */
        .jas-file-pill {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .3rem .85rem;
            background: rgba(99,102,241,.1);
            border: 1px solid rgba(99,102,241,.2);
            border-radius: 9999px;
            font-size: .75rem; font-weight: 600; color: #a5b4fc;
            text-decoration: none;
            transition: all .2s;
            margin-bottom: 1.35rem;
        }
        .jas-file-pill svg { width: 12px; height: 12px; }
        .jas-file-pill:hover { background: rgba(99,102,241,.2); color: #c7d2fe; }

        /* Summary block */
        .jas-summary {
            font-size: .875rem;
            color: rgba(255,255,255,.6);
            line-height: 1.8;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        /* Two-col sub-grid */
        .jas-sub-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        @media (max-width: 640px) { .jas-sub-grid { grid-template-columns: 1fr; } }

        /* Skills tags */
        .jas-skills-wrap {
            display: flex; flex-wrap: wrap; gap: .35rem; margin-top: .55rem;
        }

        .jas-skill-tag {
            display: inline-flex; align-items: center;
            padding: .22rem .65rem;
            font-size: .72rem; font-weight: 600;
            background: rgba(99,102,241,.1);
            border: 1px solid rgba(99,102,241,.22);
            color: #a5b4fc;
            border-radius: 9999px;
        }

        /* Education text */
        .jas-edu-text {
            font-size: .825rem;
            color: rgba(255,255,255,.5);
            line-height: 1.7;
            margin-top: .55rem;
        }

        /* Experience block */
        .jas-exp-block {
            font-size: .825rem;
            color: rgba(255,255,255,.5);
            line-height: 1.75;
        }

        /* Experience item */
        .jas-exp-item {
            padding: .9rem 0;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }

        .jas-exp-item:first-child { padding-top: 0; }
        .jas-exp-item:last-child { border-bottom: none; padding-bottom: 0; }

        .jas-exp-role {
            font-size: .88rem; font-weight: 700; color: #e2e8f0; margin-bottom: .1rem;
        }

        .jas-exp-company {
            font-size: .78rem; color: #818cf8; font-weight: 600; margin-bottom: .2rem;
        }

        .jas-exp-dates {
            font-size: .72rem; color: rgba(255,255,255,.25); margin-bottom: .5rem;
        }

        .jas-exp-achievements {
            list-style: none; padding: 0; display: flex; flex-direction: column; gap: .3rem;
        }

        .jas-exp-achievements li {
            display: flex; gap: .5rem; font-size: .78rem; color: rgba(255,255,255,.45); line-height: 1.6;
        }

        .jas-exp-achievements li::before {
            content: '›';
            color: #6366f1;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* No resume placeholder */
        .jas-no-resume {
            text-align: center; padding: 2rem;
        }

        .jas-no-resume svg { width: 32px; height: 32px; color: rgba(255,255,255,.15); margin: 0 auto .75rem; display: block; }
        .jas-no-resume p { font-size: .85rem; color: rgba(255,255,255,.25); font-style: italic; }

        /* ── RIGHT SIDEBAR ── */
        .jas-sidebar { display: flex; flex-direction: column; gap: 1.1rem; }

        /* Job snapshot */
        .jas-snapshot-item {
            display: flex; align-items: center; gap: .9rem;
            padding: .85rem 0;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .jas-snapshot-item:first-child { padding-top: 0; }
        .jas-snapshot-item:last-child { border-bottom: none; padding-bottom: 0; }

        .jas-snap-icon {
            width: 36px; height: 36px;
            border-radius: .65rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .jas-snap-icon svg { width: 16px; height: 16px; }

        .jas-snap-label {
            font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
            color: rgba(255,255,255,.25); margin-bottom: .2rem;
        }

        .jas-snap-value {
            font-size: .95rem; font-weight: 700; color: #e2e8f0;
        }

        .jas-snap-value .small { font-size: .72rem; font-weight: 400; color: rgba(255,255,255,.3); margin-left: .2rem; }

        /* Actions */
        .jas-action-dl {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .7rem 1.2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff; font-size: .82rem; font-weight: 700;
            border-radius: .75rem; text-decoration: none;
            box-shadow: 0 0 18px rgba(99,102,241,.3);
            transition: all .2s; width: 100%;
        }

        .jas-action-dl svg { width: 14px; height: 14px; }
        .jas-action-dl:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(99,102,241,.45); }

        .jas-action-archive {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .65rem 1.2rem;
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.08);
            color: rgba(255,255,255,.35);
            font-size: .82rem; font-weight: 600;
            border-radius: .75rem; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .2s; width: 100%;
        }

        .jas-action-archive svg { width: 14px; height: 14px; }
        .jas-action-archive:hover { background: rgba(239,68,68,.08); border-color: rgba(239,68,68,.2); color: #f87171; }
    </style>

    <div class="jas-wrap">

        <!-- Back -->
        <a href="{{ route('job-applications.index') }}" class="jas-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Applications
        </a>

        @php
            $score = $jobApplication->ai_generated_score;
            $scoreClass = $score >= 70 ? 'score-hi' : ($score >= 40 ? 'score-md' : 'score-lo');
            $status = $jobApplication->status;
        @endphp

        <div class="jas-layout">

            <!-- ── LEFT COLUMN ── -->
            <div>

                <!-- Hero -->
                <div class="jas-hero">
                    <div class="jas-hero-inner">
                        <div class="jas-status-row">
                            <span class="jas-status-badge status-{{ $status }}">
                                <span class="dot"></span>
                                {{ Str::ucfirst($status) }}
                            </span>
                            <span class="jas-time-pill">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Applied {{ $jobApplication->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h1 class="jas-hero-title">{{ $jobApplication->job->title }}</h1>

                        <div class="jas-hero-meta">
                            <span class="jas-hero-chip jas-hero-chip-company">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                                {{ $jobApplication->job->company->name }}
                            </span>
                            <span class="jas-hero-chip jas-hero-chip-loc">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-8-7.5-8-13a8 8 0 0116 0c0 5.5-8 13-8 13z"/><circle cx="12" cy="8" r="3"/></svg>
                                {{ $jobApplication->job->location }}
                            </span>
                            <span class="jas-hero-chip jas-hero-chip-type">
                                {{ Str::ucfirst(str_replace('_', '-', $jobApplication->job->type)) }}
                            </span>
                            <span class="jas-hero-chip jas-hero-chip-salary">
                                ${{ number_format($jobApplication->job->salary) }}/yr
                            </span>
                        </div>
                    </div>
                </div>

                <!-- AI Analysis -->
                <div class="jas-ai-card">
                    <div class="jas-ai-header">
                        <div class="jas-ai-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div class="jas-ai-header-text">
                            <h3>Intelligence Analysis</h3>
                            <p>AI-Driven Resume Matching Insights</p>
                        </div>
                    </div>

                    <div class="jas-ai-body">
                        <!-- Score circle -->
                        <div class="jas-score-circle">
                            <span class="jas-score-num {{ $scoreClass }}">{{ $score }}</span>
                            <span class="jas-score-pct">MATCH %</span>
                        </div>

                        <!-- Feedback -->
                        @if($jobApplication->ai_generated_feedback && $jobApplication->ai_generated_feedback !== 'Analyzing...')
                            <p class="jas-feedback-text">"{{ $jobApplication->ai_generated_feedback }}"</p>
                        @else
                            <p class="jas-feedback-text" style="color:rgba(255,255,255,.2);">Analysis is still processing. Check back in a moment.</p>
                        @endif
                    </div>
                </div>

                <!-- Resume Profile -->
                <div class="jas-profile-card">
                    <div class="jas-section-title">
                        <span class="marker"></span>
                        Extracted Resume Profile
                    </div>

                    @if($jobApplication->resume)
                        <!-- File link -->
                        <a href="{{ asset('storage/' . $jobApplication->resume->file_url) }}" target="_blank" class="jas-file-pill">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            {{ $jobApplication->resume->file_name }}
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>

                        <!-- Professional Summary -->
                        @if($jobApplication->resume->summary)
                            <div class="jas-section-title" style="margin-bottom:.6rem;">
                                <span class="marker" style="background:linear-gradient(180deg,#818cf8,#c084fc);"></span>
                                Professional Summary
                            </div>
                            <p class="jas-summary">{{ $jobApplication->resume->summary }}</p>
                        @endif

                        <!-- Skills + Education -->
                        <div class="jas-sub-grid">
                            <!-- Skills -->
                            <div>
                                <div class="jas-section-title" style="margin-bottom:.4rem;">
                                    <span class="marker" style="background:linear-gradient(180deg,#34d399,#6ee7b7);"></span>
                                    Key Skills
                                </div>
                                @php
                                    $skills = is_array($jobApplication->resume->skills) ? $jobApplication->resume->skills : [];
                                @endphp
                                @if(count($skills) > 0)
                                    <div class="jas-skills-wrap">
                                        @foreach($skills as $skill)
                                            @if(is_string($skill) && trim($skill))
                                                <span class="jas-skill-tag">{{ trim($skill) }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="jas-edu-text" style="font-style:italic;color:rgba(255,255,255,.2);">No skills extracted.</p>
                                @endif
                            </div>

                            <!-- Education -->
                            <div>
                                <div class="jas-section-title" style="margin-bottom:.4rem;">
                                    <span class="marker" style="background:linear-gradient(180deg,#f59e0b,#fbbf24);"></span>
                                    Education
                                </div>
                                @php
                                    $eduItems = is_array($jobApplication->resume->education) ? $jobApplication->resume->education : [];
                                @endphp
                                @if(count($eduItems) > 0)
                                    <div class="jas-edu-text">
                                        @foreach($eduItems as $edu)
                                            <div style="margin-bottom:.65rem;">
                                                @if(isset($edu['degree']))
                                                    <div style="font-weight:600;color:rgba(255,255,255,.6);font-size:.82rem;">{{ $edu['degree'] }}</div>
                                                @endif
                                                @if(isset($edu['field_of_study']))
                                                    <div style="color:rgba(255,255,255,.45);font-size:.75rem;font-weight:500;">{{ $edu['field_of_study'] }}</div>
                                                @endif
                                                @if(isset($edu['university']))
                                                    <div style="color:#818cf8;font-size:.75rem;font-weight:600;">{{ $edu['university'] }}</div>
                                                @endif
                                                @if(isset($edu['graduation_year']))
                                                    <div style="color:rgba(255,255,255,.2);font-size:.7rem;">{{ $edu['graduation_year'] }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="jas-edu-text" style="font-style:italic;color:rgba(255,255,255,.2);">No education info extracted.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Experience -->
                        @if($jobApplication->resume->experience)
                            <div>
                                <div class="jas-section-title" style="margin-bottom:.6rem;">
                                    <span class="marker" style="background:linear-gradient(180deg,#ec4899,#f9a8d4);"></span>
                                    Experience
                                </div>
                                @php
                                    $expItems = is_array($jobApplication->resume->experience) ? $jobApplication->resume->experience : [];
                                @endphp
                                @if(count($expItems) > 0)
                                    <div>
                                        @foreach($expItems as $exp)
                                            <div class="jas-exp-item">
                                                @if(isset($exp['position']))
                                                    <div class="jas-exp-role">{{ $exp['position'] }}</div>
                                                @endif
                                                @if(isset($exp['company']))
                                                    <div class="jas-exp-company">{{ $exp['company'] }}</div>
                                                @endif
                                                @if(isset($exp['start_date']) || isset($exp['end_date']))
                                                    <div class="jas-exp-dates">
                                                        {{ $exp['start_date'] ?? '' }}
                                                        @if(isset($exp['start_date']) && isset($exp['end_date'])) &ndash; @endif
                                                        {{ $exp['end_date'] ?? '' }}
                                                    </div>
                                                @endif
                                                @if(isset($exp['responsibilities']) && $exp['responsibilities'])
                                                    <ul class="jas-exp-achievements">
                                                        <li>{{ $exp['responsibilities'] }}</li>
                                                    </ul>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                    @else
                        <!-- No resume -->
                        <div class="jas-no-resume">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <p>Resume was deleted or not attached to this application.</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- ── RIGHT SIDEBAR ── -->
            <div class="jas-sidebar">

                <!-- Job Snapshot -->
                <div class="jas-card">
                    <div class="jas-section-title">
                        <span class="marker"></span>
                        Job Snapshot
                    </div>
                    <div>
                        <div class="jas-snapshot-item">
                            <div class="jas-snap-icon" style="background:rgba(52,211,153,.1);color:#34d399;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                            </div>
                            <div>
                                <div class="jas-snap-label">Base Salary</div>
                                <div class="jas-snap-value">
                                    ${{ number_format($jobApplication->job->salary) }}
                                    <span class="small">/ year</span>
                                </div>
                            </div>
                        </div>
                        <div class="jas-snapshot-item">
                            <div class="jas-snap-icon" style="background:rgba(99,102,241,.1);color:#818cf8;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                            </div>
                            <div>
                                <div class="jas-snap-label">Employment Type</div>
                                <div class="jas-snap-value">{{ Str::ucfirst(str_replace('_', '-', $jobApplication->job->type)) }}</div>
                            </div>
                        </div>
                        @if($jobApplication->job->application_deadline)
                            <div class="jas-snapshot-item">
                                <div class="jas-snap-icon" style="background:rgba(245,158,11,.1);color:#fbbf24;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div>
                                    <div class="jas-snap-label">Deadline</div>
                                    <div class="jas-snap-value">{{ \Carbon\Carbon::parse($jobApplication->job->application_deadline)->format('d M, Y') }}</div>
                                </div>
                            </div>
                        @endif
                        <div class="jas-snapshot-item">
                            <div class="jas-snap-icon" style="background:rgba(139,92,246,.1);color:#a78bfa;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <div class="jas-snap-label">Applied</div>
                                <div class="jas-snap-value" style="font-size:.85rem;">{{ $jobApplication->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="jas-card">
                    <div class="jas-section-title" style="margin-bottom:1rem;">
                        <span class="marker"></span>
                        Manage Application
                    </div>
                    <div style="display:flex;flex-direction:column;gap:.65rem;">
                        @if($jobApplication->resume)
                            <a href="{{ asset('storage/' . $jobApplication->resume->file_url) }}" target="_blank" class="jas-action-dl">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                View Full Resume
                            </a>
                        @endif
                        <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="jas-action-archive">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V8"/><path d="M23 3H1v5h22V3z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                                Archive Application
                            </button>
                        </form>
                    </div>
                </div>

                <!-- View vacancy -->
                <a href="{{ route('job-vacancies.show', $jobApplication->job->id) }}"
                   style="display:flex;align-items:center;justify-content:center;gap:.45rem;padding:.65rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:.9rem;font-size:.78rem;font-weight:600;color:rgba(255,255,255,.35);text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.color='rgba(255,255,255,.7)';this.style.background='rgba(255,255,255,.06)'"
                   onmouseout="this.style.color='rgba(255,255,255,.35)';this.style.background='rgba(255,255,255,.03)'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Job Vacancy
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
