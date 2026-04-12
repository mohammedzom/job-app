<x-app-layout>
    <x-slot name="header">
        <h2>Resume Details</h2>
    </x-slot>

    <style>
        .rs-show-wrap {
            max-width: 56rem;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 5rem;
        }

        /* Back link */
        .rs-back {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: .82rem; font-weight: 500;
            color: #818cf8; text-decoration: none;
            margin-bottom: 2rem; transition: gap .2s, color .2s;
        }
        .rs-back svg { width: 14px; height: 14px; }
        .rs-back:hover { gap: .65rem; color: #a5b4fc; }

        /* Hero card */
        .rs-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #1f1347 100%);
            border: 1px solid rgba(99,102,241,.25);
            border-radius: 1.25rem;
            padding: 2rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .rs-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 90% 20%, rgba(99,102,241,.15), transparent);
            pointer-events: none;
        }

        .rs-hero-left {
            display: flex; align-items: center; gap: 1rem;
        }

        .rs-hero-icon {
            width: 52px; height: 52px;
            background: rgba(99,102,241,.2);
            border: 1px solid rgba(99,102,241,.35);
            border-radius: .9rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .rs-hero-icon svg { width: 22px; height: 22px; color: #a5b4fc; }

        .rs-hero-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.02em;
        }

        .rs-hero-date {
            font-size: .78rem;
            color: rgba(255,255,255,.35);
            margin-top: .2rem;
        }

        .rs-hero-actions {
            display: flex; gap: .6rem; flex-wrap: wrap;
        }

        .rs-dl-btn {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .5rem 1.1rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .8rem; font-weight: 600;
            border-radius: .65rem;
            text-decoration: none;
            box-shadow: 0 0 16px rgba(99,102,241,.3);
            transition: all .2s;
        }

        .rs-dl-btn svg { width: 13px; height: 13px; }
        .rs-dl-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(99,102,241,.45); }

        .rs-del-btn {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .5rem 1.1rem;
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.2);
            color: rgba(239,68,68,.8);
            font-size: .8rem; font-weight: 600;
            border-radius: .65rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .2s;
        }

        .rs-del-btn svg { width: 13px; height: 13px; }
        .rs-del-btn:hover { background: rgba(239,68,68,.18); color: #f87171; }

        /* AI status banner */
        .rs-ai-banner {
            background: rgba(52,211,153,.06);
            border: 1px solid rgba(52,211,153,.2);
            border-radius: .9rem;
            padding: .85rem 1.2rem;
            display: flex; align-items: center; gap: .65rem;
            margin-bottom: 1.5rem;
            font-size: .82rem;
            color: #6ee7b7;
            font-weight: 500;
        }

        .rs-ai-banner svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* Section title */
        .rs-section-title {
            display: flex; align-items: center; gap: .45rem;
            font-size: .72rem; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase;
            color: rgba(255,255,255,.3);
            margin-bottom: .85rem;
        }

        .rs-section-title .marker {
            width: 3px; height: 14px;
            border-radius: 2px;
            background: linear-gradient(180deg, #6366f1, #ec4899);
        }

        /* Content grid */
        .rs-content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 640px) { .rs-content-grid { grid-template-columns: 1fr; } }

        .rs-info-card {
            background: rgba(15,23,42,.55);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 1rem;
            padding: 1.4rem;
            backdrop-filter: blur(8px);
            transition: border-color .2s;
        }

        .rs-info-card:hover { border-color: rgba(99,102,241,.2); }

        /* Colspan full */
        .rs-info-card.full { grid-column: 1 / -1; }

        .rs-info-body {
            font-size: .87rem;
            color: rgba(255,255,255,.65);
            line-height: 1.75;
        }

        .rs-info-body.na { color: rgba(255,255,255,.2); font-style: italic; }

        /* Skills tags */
        .rs-skills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }

        .rs-skill-tag {
            display: inline-flex; align-items: center;
            padding: .25rem .7rem;
            font-size: .75rem; font-weight: 600;
            background: rgba(99,102,241,.1);
            border: 1px solid rgba(99,102,241,.25);
            color: #a5b4fc;
            border-radius: 9999px;
        }

        /* Education entries */
        .rs-edu-item { margin-bottom: .65rem; }
        .rs-edu-item:last-child { margin-bottom: 0; }
        .rs-edu-degree { font-weight: 600; color: rgba(255,255,255,.6); font-size: .82rem; }
        .rs-edu-institution { color: #818cf8; font-size: .75rem; font-weight: 600; margin-top: .1rem; }
        .rs-edu-dates { color: rgba(255,255,255,.2); font-size: .7rem; margin-top: .1rem; }

        /* Experience entries */
        .rs-exp-item {
            padding: .9rem 0;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .rs-exp-item:first-child { padding-top: 0; }
        .rs-exp-item:last-child { border-bottom: none; padding-bottom: 0; }

        .rs-exp-role { font-size: .88rem; font-weight: 700; color: #e2e8f0; margin-bottom: .1rem; }
        .rs-exp-company { font-size: .78rem; color: #818cf8; font-weight: 600; margin-bottom: .2rem; }
        .rs-exp-dates { font-size: .72rem; color: rgba(255,255,255,.25); margin-bottom: .5rem; }

        .rs-exp-achievements {
            list-style: none; padding: 0; display: flex; flex-direction: column; gap: .3rem;
        }
        .rs-exp-achievements li {
            display: flex; gap: .5rem; font-size: .78rem; color: rgba(255,255,255,.45); line-height: 1.6;
        }
        .rs-exp-achievements li::before {
            content: '›'; color: #6366f1; font-weight: 700; flex-shrink: 0;
        }

        /* Project entries */
        .rs-proj-item {
            padding: .9rem 0;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .rs-proj-item:first-child { padding-top: 0; }
        .rs-proj-item:last-child { border-bottom: none; padding-bottom: 0; }

        .rs-proj-name { font-size: .88rem; font-weight: 700; color: #e2e8f0; margin-bottom: .25rem; }
        .rs-proj-desc { font-size: .78rem; color: rgba(255,255,255,.45); line-height: 1.65; margin-bottom: .3rem; }
        .rs-proj-url {
            display: inline-flex; align-items: center; gap: .3rem;
            font-size: .72rem; color: #818cf8; font-weight: 600;
            text-decoration: none; transition: color .2s;
        }
        .rs-proj-url svg { width: 11px; height: 11px; }
        .rs-proj-url:hover { color: #a5b4fc; }

        /* Other section entries */
        .rs-other-section { margin-bottom: 1rem; }
        .rs-other-section:last-child { margin-bottom: 0; }

        .rs-other-section-title {
            font-size: .75rem; font-weight: 700;
            color: rgba(255,255,255,.35);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: .45rem;
        }

        .rs-other-tags {
            display: flex; flex-wrap: wrap; gap: .35rem;
        }

        .rs-other-tag {
            display: inline-flex; align-items: center;
            padding: .2rem .6rem;
            font-size: .73rem; font-weight: 500;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            color: rgba(255,255,255,.5);
            border-radius: 9999px;
        }
    </style>

    <div class="rs-show-wrap">

        <a href="{{ route('resumes.index') }}" class="rs-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Resumes
        </a>

        <!-- Hero -->
        <div class="rs-hero">
            <div class="rs-hero-left">
                <div class="rs-hero-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div>
                    <div class="rs-hero-name">{{ $resume->file_name }}</div>
                    <div class="rs-hero-date">Uploaded {{ $resume->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
            <div class="rs-hero-actions">
                <a href="{{ asset('storage/' . $resume->file_url) }}" target="_blank" class="rs-dl-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Download
                </a>
                <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST"
                      onsubmit="return confirm('Delete this resume permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="rs-del-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if($resume->is_analyzed)
            <div class="rs-ai-banner">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                AI analysis complete — your resume has been parsed and is ready for job matching.
            </div>
        @endif

        <!-- Content grid -->
        <div class="rs-content-grid">

            <!-- Summary (full width) -->
            <div class="rs-info-card full">
                <div class="rs-section-title">
                    <span class="marker"></span>
                    Professional Summary
                </div>
                @if($resume->summary)
                    <p class="rs-info-body">{{ $resume->summary }}</p>
                @else
                    <p class="rs-info-body na">No summary extracted yet.</p>
                @endif
            </div>

            <!-- Experience (full width) -->
            <div class="rs-info-card full">
                <div class="rs-section-title">
                    <span class="marker" style="background:linear-gradient(180deg,#ec4899,#f9a8d4);"></span>
                    Experience
                </div>
                @php
                    $expItems = is_array($resume->experience) ? $resume->experience : [];
                @endphp
                @if(count($expItems) > 0)
                    <div>
                        @foreach($expItems as $exp)
                            <div class="rs-exp-item">
                                @if(isset($exp['position']))
                                    <div class="rs-exp-role">{{ $exp['position'] }}</div>
                                @endif
                                @if(isset($exp['company']))
                                    <div class="rs-exp-company">{{ $exp['company'] }}</div>
                                @endif
                                @if(isset($exp['start_date']) || isset($exp['end_date']))
                                    <div class="rs-exp-dates">
                                        {{ $exp['start_date'] ?? '' }}
                                        @if(isset($exp['start_date']) && isset($exp['end_date'])) – @endif
                                        {{ $exp['end_date'] ?? '' }}
                                    </div>
                                @endif
                                @if(isset($exp['responsibilities']) && $exp['responsibilities'])
                                    <ul class="rs-exp-achievements">
                                        <li>{{ $exp['responsibilities'] }}</li>
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="rs-info-body na">Not extracted.</p>
                @endif
            </div>

            <!-- Skills + Education side by side -->
            <!-- Skills -->
            <div class="rs-info-card">
                <div class="rs-section-title">
                    <span class="marker" style="background:linear-gradient(180deg,#34d399,#6ee7b7);"></span>
                    Key Skills
                </div>
                @php
                    $skills = is_array($resume->skills) ? $resume->skills : [];
                @endphp
                @if(count($skills) > 0)
                    <div class="rs-skills-wrap">
                        @foreach($skills as $skill)
                            @if(is_string($skill) && trim($skill))
                                <span class="rs-skill-tag">{{ trim($skill) }}</span>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="rs-info-body na">No skills extracted yet.</p>
                @endif
            </div>

            <!-- Education -->
            <div class="rs-info-card">
                <div class="rs-section-title">
                    <span class="marker" style="background:linear-gradient(180deg,#f59e0b,#fbbf24);"></span>
                    Education
                </div>
                @php
                    $eduItems = is_array($resume->education) ? $resume->education : [];
                @endphp
                @if(count($eduItems) > 0)
                    <div>
                        @foreach($eduItems as $edu)
                            <div class="rs-edu-item">
                                @if(isset($edu['degree']))
                                    <div class="rs-edu-degree">{{ $edu['degree'] }}</div>
                                @endif
                                @if(isset($edu['field_of_study']))
                                    <div class="rs-edu-degree" style="color:rgba(255,255,255,.45);font-weight:500;">{{ $edu['field_of_study'] }}</div>
                                @endif
                                @if(isset($edu['university']))
                                    <div class="rs-edu-institution">{{ $edu['university'] }}</div>
                                @endif
                                @if(isset($edu['graduation_year']))
                                    <div class="rs-edu-dates">{{ $edu['graduation_year'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="rs-info-body na">Not extracted.</p>
                @endif
            </div>

            <!-- Projects (full width) -->
            @php
                $projItems = is_array($resume->projects) ? $resume->projects : [];
            @endphp
            <div class="rs-info-card full">
                <div class="rs-section-title">
                    <span class="marker" style="background:linear-gradient(180deg,#8b5cf6,#c4b5fd);"></span>
                    Projects
                </div>
                @if(count($projItems) > 0)
                <div>
                    @foreach($projItems as $proj)
                        <div class="rs-proj-item">
                            @if(isset($proj['name']))
                                <div class="rs-proj-name">{{ $proj['name'] }}</div>
                            @endif
                            @if(isset($proj['description']) && $proj['description'])
                                <div class="rs-proj-desc">{{ $proj['description'] }}</div>
                            @endif
                            @if(isset($proj['url']) && $proj['url'])
                                <a href="{{ $proj['url'] }}" target="_blank" class="rs-proj-url">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                                        <polyline points="15 3 21 3 21 9"/>
                                        <line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                    {{ $proj['url'] }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
                @else
                    <p class="rs-info-body na">Not extracted yet. Re-analyze to populate.</p>
                @endif
            </div>

            <!-- Other sections (full width) -->
            @php
                $otherSections = is_array($resume->other) ? $resume->other : [];
            @endphp
            <div class="rs-info-card full">
                <div class="rs-section-title">
                    <span class="marker" style="background:linear-gradient(180deg,#0ea5e9,#7dd3fc);"></span>
                    Additional Information
                </div>
                @if(count($otherSections) > 0)
                <div>
                    @foreach($otherSections as $sectionName => $items)
                        @if(is_array($items) && count($items) > 0)
                            <div class="rs-other-section">
                                <div class="rs-other-section-title">{{ $sectionName }}</div>
                                <div class="rs-other-tags">
                                    @foreach($items as $item)
                                        @if(is_string($item) && trim($item))
                                            <span class="rs-other-tag">{{ trim($item) }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @else
                    <p class="rs-info-body na">Not extracted yet. Re-analyze to populate.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
