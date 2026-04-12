<x-app-layout>
    <x-slot name="header">
        <h2>Resumes</h2>
    </x-slot>

    <style>
        .rs-wrap {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* Page title row */
        .rs-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .rs-title-row h1 {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -.03em;
            color: #fff;
        }

        /* Upload button */
        .rs-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .55rem 1.2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .85rem;
            font-weight: 600;
            border-radius: .7rem;
            text-decoration: none;
            box-shadow: 0 0 18px rgba(99,102,241,.35);
            transition: all .2s;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .rs-upload-btn svg { width: 15px; height: 15px; }
        .rs-upload-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 28px rgba(99,102,241,.5); }

        /* Flash */
        .rs-flash {
            padding: .85rem 1.2rem;
            border-radius: .75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .875rem;
            font-weight: 500;
        }

        .rs-flash.success {
            background: rgba(52,211,153,.08);
            border: 1px solid rgba(52,211,153,.25);
            color: #6ee7b7;
        }

        .rs-flash svg { width: 16px; height: 16px; }

        /* Grid */
        .rs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }

        /* Resume card */
        .rs-card {
            background: rgba(15,23,42,.55);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 1.1rem;
            padding: 1.4rem;
            backdrop-filter: blur(10px);
            transition: all .25s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .rs-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            background: radial-gradient(circle, rgba(99,102,241,.15), transparent);
            pointer-events: none;
        }

        .rs-card:hover {
            border-color: rgba(99,102,241,.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0,0,0,.3);
        }

        .rs-card-icon {
            width: 44px; height: 44px;
            background: rgba(99,102,241,.12);
            border: 1px solid rgba(99,102,241,.2);
            border-radius: .75rem;
            display: flex; align-items: center; justify-content: center;
        }

        .rs-card-icon svg { width: 20px; height: 20px; color: #818cf8; }

        .rs-card-name {
            font-size: .95rem;
            font-weight: 700;
            color: #e2e8f0;
            letter-spacing: -.01em;
            text-decoration: none;
        }

        .rs-card-name:hover { color: #a5b4fc; }

        .rs-card-date {
            font-size: .75rem;
            color: rgba(255,255,255,.25);
            margin-top: .2rem;
        }

        /* AI status */
        .rs-ai-status {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .72rem;
            font-weight: 600;
            padding: .2rem .65rem;
            border-radius: 9999px;
        }

        .rs-ai-ready {
            background: rgba(52,211,153,.1);
            border: 1px solid rgba(52,211,153,.25);
            color: #6ee7b7;
        }

        .rs-ai-pending {
            background: rgba(245,158,11,.1);
            border: 1px solid rgba(245,158,11,.2);
            color: #fcd34d;
        }

        .rs-ai-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Card actions */
        .rs-card-actions {
            display: flex;
            gap: .5rem;
            margin-top: auto;
        }

        .rs-btn-view {
            flex: 1;
            display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
            padding: .45rem .8rem;
            font-size: .78rem; font-weight: 600;
            background: rgba(99,102,241,.12);
            border: 1px solid rgba(99,102,241,.22);
            color: #a5b4fc;
            border-radius: .6rem;
            text-decoration: none;
            transition: all .2s;
        }

        .rs-btn-view svg { width: 13px; height: 13px; }
        .rs-btn-view:hover { background: rgba(99,102,241,.25); color: #c7d2fe; }

        .rs-btn-delete {
            display: inline-flex; align-items: center; justify-content: center;
            padding: .45rem .65rem;
            font-size: .78rem; font-weight: 600;
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.18);
            color: rgba(239,68,68,.7);
            border-radius: .6rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .2s;
        }

        .rs-btn-delete svg { width: 13px; height: 13px; }
        .rs-btn-delete:hover { background: rgba(239,68,68,.18); color: #f87171; }

        /* Empty state */
        .rs-empty {
            grid-column: 1/-1;
            text-align: center;
            padding: 5rem 2rem;
        }

        .rs-empty-icon {
            width: 72px; height: 72px;
            margin: 0 auto 1.5rem;
            background: rgba(99,102,241,.07);
            border: 1px solid rgba(99,102,241,.15);
            border-radius: 1.25rem;
            display: flex; align-items: center; justify-content: center;
        }

        .rs-empty-icon svg { width: 32px; height: 32px; color: rgba(99,102,241,.45); }

        .rs-empty h3 { font-size: 1.1rem; font-weight: 600; color: rgba(255,255,255,.35); margin-bottom: .5rem; }
        .rs-empty p { font-size: .875rem; color: rgba(255,255,255,.2); margin-bottom: 1.5rem; }
    </style>

    <div class="rs-wrap">

        <!-- Title row -->
        <div class="rs-title-row">
            <h1>Your Resumes</h1>
            <a href="{{ route('resumes.create') }}" class="rs-upload-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Upload Resume
            </a>
        </div>

        @if(session('success'))
            <div class="rs-flash success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Resume grid -->
        <div class="rs-grid">
            @forelse ($resumes as $resume)
                <div class="rs-card">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.75rem;">
                        <div class="rs-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                            </svg>
                        </div>
                        @if($resume->summary)
                            <span class="rs-ai-status rs-ai-ready">
                                <span class="rs-ai-dot"></span> AI Analyzed
                            </span>
                        @else
                            <span class="rs-ai-status rs-ai-pending">
                                <span class="rs-ai-dot"></span> Processing
                            </span>
                        @endif
                    </div>

                    <div>
                        <a href="{{ route('resumes.show', $resume->id) }}" class="rs-card-name">
                            {{ $resume->file_name }}
                        </a>
                        <div class="rs-card-date">Uploaded {{ $resume->created_at->format('d M Y') }}</div>
                    </div>

                    <div class="rs-card-actions">
                        <a href="{{ route('resumes.show', $resume->id) }}" class="rs-btn-view">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            View Details
                        </a>
                        <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST"
                              onsubmit="return confirm('Delete this resume?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="rs-btn-delete">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rs-empty">
                    <div class="rs-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <h3>No resumes yet</h3>
                    <p>Upload your resume to get AI-powered job matching.</p>
                    <a href="{{ route('resumes.create') }}" class="rs-upload-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Upload Resume
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
