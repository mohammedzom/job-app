<x-app-layout>
    <x-slot name="header">
        <h2>My Applications</h2>
    </x-slot>

    <style>
        /* ── Page wrapper ── */
        .ja-wrap {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 5rem;
        }

        /* ── Tabs ── */
        .ja-tabs {
            display: flex;
            align-items: flex-end;
            gap: 0;
            border-bottom: 1px solid rgba(255,255,255,.07);
            margin-bottom: 2rem;
        }

        .ja-tab {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .65rem 1.1rem;
            font-size: .83rem;
            font-weight: 600;
            color: rgba(255,255,255,.3);
            text-decoration: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            transition: all .2s;
            white-space: nowrap;
        }

        .ja-tab:hover { color: rgba(255,255,255,.65); }

        .ja-tab.active {
            color: #a5b4fc;
            border-bottom-color: #6366f1;
        }

        .ja-tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            font-size: .65rem;
            font-weight: 700;
            background: rgba(99,102,241,.2);
            border: 1px solid rgba(99,102,241,.3);
            color: #818cf8;
            border-radius: 9999px;
        }

        /* ── Flash ── */
        .ja-flash {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .85rem 1.1rem;
            background: rgba(52,211,153,.07);
            border: 1px solid rgba(52,211,153,.22);
            border-radius: .8rem;
            font-size: .85rem;
            font-weight: 500;
            color: #6ee7b7;
            margin-bottom: 1.75rem;
        }

        .ja-flash svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Grid ── */
        .ja-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 1.1rem;
        }

        /* ── Application Card ── */
        .ja-card {
            background: rgba(15,23,42,.55);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 1.15rem;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            transition: all .25s ease;
            display: flex;
            flex-direction: column;
            gap: .95rem;
            position: relative;
            overflow: hidden;
        }

        .ja-card:hover {
            border-color: rgba(99,102,241,.25);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0,0,0,.35), 0 0 0 1px rgba(99,102,241,.12);
        }

        /* Shimmer line at top */
        .ja-card::before {
            content: '';
            position: absolute;
            top: 0; left: 1.5rem; right: 1.5rem;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99,102,241,.35), transparent);
            opacity: 0;
            transition: opacity .3s;
        }

        .ja-card:hover::before { opacity: 1; }

        /* ── Card top row: badges + action ── */
        .ja-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .6rem;
        }

        .ja-badges {
            display: flex;
            flex-wrap: wrap;
            gap: .35rem;
        }

        .ja-badge {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            padding: .2rem .6rem;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            border-radius: 9999px;
            border: 1px solid;
        }

        .ja-badge-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Status colors */
        .status-pending  { background: rgba(245,158,11,.1); color: #fbbf24; border-color: rgba(245,158,11,.25); }
        .status-accepted { background: rgba(52,211,153,.1); color: #34d399; border-color: rgba(52,211,153,.25); }
        .status-rejected { background: rgba(239,68,68,.1);  color: #f87171; border-color: rgba(239,68,68,.25); }

        /* Type colors */
        .type-badge { background: rgba(255,255,255,.05); color: rgba(255,255,255,.4); border-color: rgba(255,255,255,.1); }

        /* ── Action button (archive/restore) ── */
        .ja-action-btn {
            display: flex; align-items: center; justify-content: center;
            width: 30px; height: 30px;
            border-radius: .55rem;
            border: 1px solid rgba(255,255,255,.08);
            background: rgba(255,255,255,.03);
            color: rgba(255,255,255,.25);
            cursor: pointer;
            transition: all .2s;
            flex-shrink: 0;
        }

        .ja-action-btn svg { width: 13px; height: 13px; }

        .ja-action-btn:hover {
            background: rgba(239,68,68,.1);
            border-color: rgba(239,68,68,.25);
            color: #f87171;
        }

        .ja-action-btn.restore:hover {
            background: rgba(52,211,153,.1);
            border-color: rgba(52,211,153,.25);
            color: #34d399;
        }

        /* ── Job info ── */
        .ja-job-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #e2e8f0;
            letter-spacing: -.015em;
            line-height: 1.3;
            text-decoration: none;
            transition: color .2s;
            display: block;
        }

        .ja-job-title:hover { color: #a5b4fc; }

        .ja-job-title.archived { color: rgba(255,255,255,.3); pointer-events: none; }

        .ja-job-meta {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .8rem;
            color: rgba(255,255,255,.35);
            margin-top: .2rem;
        }

        .ja-job-meta-sep { color: rgba(255,255,255,.12); }

        /* ── AI Score block ── */
        .ja-score-block {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .9rem 1rem;
            background: rgba(99,102,241,.05);
            border: 1px solid rgba(99,102,241,.12);
            border-radius: .8rem;
        }

        .ja-score-left {
            display: flex;
            flex-direction: column;
            gap: .1rem;
        }

        .ja-score-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
        }

        .ja-score-value {
            font-size: 1.8rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -.04em;
        }

        .ja-score-value .pct {
            font-size: .85rem;
            font-weight: 600;
            margin-left: 1px;
        }

        /* Score color by value */
        .score-high   { background: linear-gradient(135deg, #34d399, #6ee7b7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .score-mid    { background: linear-gradient(135deg, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .score-low    { background: linear-gradient(135deg, #f59e0b, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .score-none   { color: rgba(255,255,255,.2); }

        .ja-score-ring {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(99,102,241,.2);
            display: flex; align-items: center; justify-content: center;
            background: rgba(99,102,241,.08);
        }

        .ja-score-ring svg { width: 16px; height: 16px; color: #818cf8; }

        /* ── Meta row (date + resume) ── */
        .ja-meta-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
        }

        .ja-meta-item { display: flex; flex-direction: column; gap: .2rem; }

        .ja-meta-key {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255,255,255,.2);
        }

        .ja-meta-val {
            font-size: .78rem;
            color: rgba(255,255,255,.55);
            font-weight: 500;
        }

        .ja-resume-link {
            font-size: .78rem;
            font-weight: 600;
            color: #818cf8;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .3rem;
            transition: color .2s;
        }

        .ja-resume-link svg { width: 11px; height: 11px; }
        .ja-resume-link:hover { color: #a5b4fc; }

        /* ── AI Feedback snippet ── */
        .ja-feedback {
            background: rgba(255,255,255,.02);
            border: 1px solid rgba(255,255,255,.05);
            border-radius: .7rem;
            padding: .85rem 1rem;
        }

        .ja-feedback-label {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: rgba(255,255,255,.2);
            margin-bottom: .5rem;
        }

        .ja-feedback-label-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #6366f1;
        }

        .ja-feedback-text {
            font-size: .78rem;
            color: rgba(255,255,255,.4);
            line-height: 1.65;
            font-style: italic;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ── View details link ── */
        .ja-view-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .55rem .85rem;
            background: rgba(99,102,241,.08);
            border: 1px solid rgba(99,102,241,.18);
            border-radius: .65rem;
            font-size: .8rem;
            font-weight: 600;
            color: #a5b4fc;
            text-decoration: none;
            transition: all .2s;
        }

        .ja-view-btn svg { width: 14px; height: 14px; transition: transform .2s; }
        .ja-view-btn:hover { background: rgba(99,102,241,.18); border-color: rgba(99,102,241,.35); }
        .ja-view-btn:hover svg { transform: translateX(3px); }

        /* ── Empty state ── */
        .ja-empty {
            grid-column: 1/-1;
            text-align: center;
            padding: 5rem 2rem;
        }

        .ja-empty-icon {
            width: 72px; height: 72px;
            margin: 0 auto 1.5rem;
            background: rgba(99,102,241,.07);
            border: 1px solid rgba(99,102,241,.15);
            border-radius: 1.25rem;
            display: flex; align-items: center; justify-content: center;
        }

        .ja-empty-icon svg { width: 30px; height: 30px; color: rgba(99,102,241,.5); }

        .ja-empty h3 { font-size: 1.15rem; font-weight: 700; color: rgba(255,255,255,.35); margin-bottom: .4rem; }
        .ja-empty p  { font-size: .875rem; color: rgba(255,255,255,.2); margin-bottom: 1.5rem; }

        .ja-empty-browse {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .55rem 1.2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .82rem;
            font-weight: 600;
            border-radius: .65rem;
            text-decoration: none;
            box-shadow: 0 0 18px rgba(99,102,241,.3);
            transition: all .2s;
        }

        .ja-empty-browse:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(99,102,241,.45); }

        /* ── Pagination ── */
        .ja-pagination { margin-top: 2.5rem; }
    </style>

    <div class="ja-wrap">

        <!-- Tabs -->
        <div class="ja-tabs">
            <a href="{{ route('job-applications.index', ['archived' => 'false']) }}"
               class="ja-tab {{ !request('archived') || request('archived') === 'false' ? 'active' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                Active
            </a>
            <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
               class="ja-tab {{ request('archived') === 'true' ? 'active' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V8"/><path d="M23 3H1v5h22V3z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                Archived
            </a>
        </div>

        @if(session('success'))
            <div class="ja-flash">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Cards grid -->
        <div class="ja-grid">
            @forelse ($jobApplications as $app)
                @php
                    $score = $app->ai_generated_score;
                    $scoreClass = $score >= 70 ? 'score-high' : ($score >= 40 ? 'score-mid' : ($score > 0 ? 'score-low' : 'score-none'));
                    $statusClass = 'status-' . $app->status;
                    $typeLabel = Str::ucfirst(str_replace('_', '-', $app->job->type));
                @endphp
                <div class="ja-card">

                    <!-- Top: badges + action -->
                    <div class="ja-card-top">
                        <div class="ja-badges">
                            <span class="ja-badge {{ $statusClass }}">
                                <span class="ja-badge-dot"></span>
                                {{ Str::ucfirst($app->status) }}
                            </span>
                            <span class="ja-badge type-badge">{{ $typeLabel }}</span>
                        </div>

                        @if(request('archived') === 'true')
                            <form action="{{ route('job-applications.restore', $app->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="ja-action-btn restore" title="Restore">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10h10a8 8 0 018 8v2M3 10l5 5m-5-5l5-5"/></svg>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('job-applications.destroy', $app->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="ja-action-btn" title="Archive">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Job info -->
                    <div>
                        @if($app->trashed())
                            <span class="ja-job-title archived">{{ $app->job->title }}</span>
                        @else
                            <a href="{{ route('job-applications.show', $app->id) }}" class="ja-job-title">
                                {{ $app->job->title }}
                            </a>
                        @endif
                        <div class="ja-job-meta">
                            <span>{{ $app->job->company->name }}</span>
                            <span class="ja-job-meta-sep">•</span>
                            <span>{{ $app->job->location }}</span>
                        </div>
                    </div>

                    <!-- AI Score -->
                    <div class="ja-score-block">
                        <div class="ja-score-left">
                            <span class="ja-score-label">AI Match Score</span>
                            <span class="ja-score-value {{ $scoreClass }}">
                                {{ $score > 0 ? $score : '—' }}<span class="pct">{{ $score > 0 ? '%' : '' }}</span>
                            </span>
                        </div>
                        <div class="ja-score-ring">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Meta row -->
                    <div class="ja-meta-row">
                        <div class="ja-meta-item">
                            <span class="ja-meta-key">Applied On</span>
                            <span class="ja-meta-val">{{ $app->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="ja-meta-item">
                            <span class="ja-meta-key">Resume</span>
                            @if($app->resume)
                                <a href="{{ asset('storage/' . $app->resume->file_url) }}" target="_blank" class="ja-resume-link">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    {{ Str::limit($app->resume->file_name, 18) }}
                                </a>
                            @else
                                <span class="ja-meta-val" style="color:rgba(255,255,255,.2);font-style:italic;">No file</span>
                            @endif
                        </div>
                    </div>

                    <!-- AI Feedback -->
                    @if($app->ai_generated_feedback)
                        <div class="ja-feedback">
                            <div class="ja-feedback-label">
                                <span class="ja-feedback-label-dot"></span>
                                AI Insight
                            </div>
                            <p class="ja-feedback-text">"{{ $app->ai_generated_feedback }}"</p>
                        </div>
                    @endif

                    <!-- View details -->
                    @unless($app->trashed())
                        <a href="{{ route('job-applications.show', $app->id) }}" class="ja-view-btn">
                            View Full Analysis
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @endunless

                </div>
            @empty
                <div class="ja-empty">
                    <div class="ja-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    @if(request('archived') === 'true')
                        <h3>No archived applications</h3>
                        <p>Applications you archive will appear here.</p>
                        <a href="{{ route('job-applications.index') }}" class="ja-empty-browse">← View active applications</a>
                    @else
                        <h3>No applications yet</h3>
                        <p>Browse jobs and apply with your resume to get AI-powered matching.</p>
                        <a href="{{ route('dashboard') }}" class="ja-empty-browse">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Browse Jobs
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($jobApplications->hasPages())
            <div class="ja-pagination">
                {{ $jobApplications->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
