<x-app-layout>
    <x-slot name="header">
        <h2>Job Board</h2>
    </x-slot>

    <style>
        /* ── Page wrapper ── */
        .db-wrap {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* ── Welcome greeting ── */
        .db-greeting {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .db-greeting-left h1 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800;
            letter-spacing: -.03em;
            color: #fff;
            line-height: 1.2;
        }

        .db-greeting-left h1 span {
            background: linear-gradient(135deg, #818cf8, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .db-greeting-left p {
            margin-top: .3rem;
            font-size: .9rem;
            color: rgba(255, 255, 255, .4);
        }

        /* ── Search + Filter bar ── */
        .db-toolbar {
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .db-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 400px;
        }

        .db-search-wrap svg {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            color: rgba(255, 255, 255, .3);
            pointer-events: none;
        }

        .db-search-input {
            width: 100%;
            padding: .6rem .9rem .6rem 2.5rem;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: .7rem;
            color: #fff;
            font-size: .875rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s, background .2s;
        }

        .db-search-input::placeholder {
            color: rgba(255, 255, 255, .25);
        }

        .db-search-input:focus {
            border-color: rgba(99, 102, 241, .5);
            background: rgba(99, 102, 241, .05);
        }

        .db-search-btn {
            padding: .6rem 1.2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .82rem;
            font-weight: 600;
            border: none;
            border-radius: .7rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .2s;
            box-shadow: 0 0 16px rgba(99, 102, 241, .3);
        }

        .db-search-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 24px rgba(99, 102, 241, .45);
        }

        .db-clear-link {
            font-size: .8rem;
            color: rgba(255, 255, 255, .35);
            text-decoration: none;
            padding: .3rem .5rem;
            border-radius: .4rem;
            transition: color .2s;
        }

        .db-clear-link:hover {
            color: rgba(255, 255, 255, .7);
        }

        /* Filter chips */
        .db-filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
        }

        .db-chip {
            display: inline-flex;
            align-items: center;
            padding: .35rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .04em;
            border-radius: 9999px;
            text-decoration: none;
            white-space: nowrap;
            transition: all .2s ease;
            border: 1px solid rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .45);
            background: rgba(255, 255, 255, .04);
        }

        .db-chip:hover {
            background: rgba(99, 102, 241, .15);
            border-color: rgba(99, 102, 241, .4);
            color: #a5b4fc;
        }

        .db-chip.active {
            background: rgba(99, 102, 241, .2);
            border-color: rgba(99, 102, 241, .5);
            color: #c7d2fe;
        }

        .db-chip-clear {
            color: rgba(255, 255, 255, .3);
            border-color: transparent;
        }

        .db-chip-clear:hover {
            color: rgba(255, 255, 255, .6);
            background: rgba(255, 255, 255, .05);
        }

        /* ── Section heading ── */
        .db-section-h {
            display: flex;
            align-items: center;
            gap: .55rem;
            margin-bottom: 1.25rem;
        }

        .db-section-h h2 {
            font-size: .9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .55);
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .db-section-h-line {
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, .06);
        }

        /* ── Job cards grid ── */
        .db-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.1rem;
        }

        /* ── Job card ── */
        .db-job-card {
            background: rgba(15, 23, 42, .55);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 1.1rem;
            padding: 1.4rem 1.5rem;
            backdrop-filter: blur(10px);
            transition: all .25s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        .db-job-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 80% 0%, rgba(99, 102, 241, .07), transparent);
            pointer-events: none;
            opacity: 0;
            transition: opacity .35s;
        }

        .db-job-card:hover {
            border-color: rgba(99, 102, 241, .3);
            background: rgba(15, 23, 42, .75);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, .4), 0 0 0 1px rgba(99, 102, 241, .15);
        }

        .db-job-card:hover::before {
            opacity: 1;
        }

        .db-job-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .75rem;
        }

        .db-job-title {
            font-size: 1rem;
            font-weight: 700;
            color: #e2e8f0;
            letter-spacing: -.015em;
            line-height: 1.3;
            transition: color .2s;
        }

        .db-job-card:hover .db-job-title {
            color: #a5b4fc;
        }

        .db-job-company {
            font-size: .82rem;
            color: rgba(255, 255, 255, .4);
            margin-top: .2rem;
        }

        /* Type badge */
        .db-type-badge {
            display: inline-flex;
            align-items: center;
            padding: .22rem .65rem;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .05em;
            border-radius: 9999px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .type-full-time {
            background: rgba(99, 102, 241, .15);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, .3);
        }

        .type-part-time {
            background: rgba(245, 158, 11, .12);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, .25);
        }

        .type-remote {
            background: rgba(52, 211, 153, .12);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, .25);
        }

        .type-hybrid {
            background: rgba(139, 92, 246, .15);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, .3);
        }

        .type-contract {
            background: rgba(236, 72, 153, .12);
            color: #f9a8d4;
            border: 1px solid rgba(236, 72, 153, .25);
        }

        /* Meta row */
        .db-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .db-meta-item {
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .78rem;
            color: rgba(255, 255, 255, .35);
        }

        .db-meta-item svg {
            width: 12px;
            height: 12px;
            opacity: .6;
        }

        .db-meta-salary {
            font-size: .82rem;
            font-weight: 700;
            color: #6ee7b7;
        }

        /* Arrow icon */
        .db-arrow {
            width: 32px;
            height: 32px;
            border-radius: .65rem;
            background: rgba(99, 102, 241, .1);
            border: 1px solid rgba(99, 102, 241, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateX(-6px);
            transition: all .25s;
            flex-shrink: 0;
        }

        .db-arrow svg {
            width: 14px;
            height: 14px;
            color: #818cf8;
        }

        .db-job-card:hover .db-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        /* ── Empty state ── */
        .db-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 5rem 2rem;
        }

        .db-empty-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 1.5rem;
            background: rgba(99, 102, 241, .08);
            border: 1px solid rgba(99, 102, 241, .15);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .db-empty-icon svg {
            width: 32px;
            height: 32px;
            color: rgba(99, 102, 241, .5);
        }

        .db-empty h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .4);
            margin-bottom: .5rem;
        }

        .db-empty p {
            font-size: .875rem;
            color: rgba(255, 255, 255, .2);
        }

        /* ── Pagination ── */
        .db-pagination {
            margin-top: 2.5rem;
        }
    </style>

    <div class="db-wrap">

        <!-- Greeting -->
        <div class="db-greeting">
            <div class="db-greeting-left">
                <h1>Good to see you, <span>{{ explode(' ', Auth::user()->name)[0] }}</span> 👋</h1>
                <p>Browse and apply to the latest opportunities below.</p>
            </div>
        </div>

        <!-- Toolbar: Search + Filters -->
        <form action="{{ route('dashboard') }}" method="GET">
            @if (request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif
            <div class="db-toolbar">
                <div class="db-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" id="search-input" name="search" class="db-search-input"
                        value="{{ request('search') }}" placeholder="Search jobs, companies…">
                </div>
                <button type="submit" class="db-search-btn">Search</button>
                @if (request('search'))
                    <a href="{{ route('dashboard', ['filter' => request('filter')]) }}" class="db-clear-link">Clear</a>
                @endif
            </div>
        </form>

        <!-- Filter chips -->
        <div class="db-filter-chips" style="margin-bottom:2rem;">
            @php
                $filters = [
                    'full_time' => 'Full-Time',
                    'part_time' => 'Part-Time',
                    'remote' => 'Remote',
                    'hybrid' => 'Hybrid',
                    'contract' => 'Contract',
                ];
                $active = request('filter');
            @endphp

            @foreach ($filters as $val => $label)
                <a href="{{ route('dashboard', array_merge(request()->only('search'), ['filter' => $val])) }}"
                    class="db-chip {{ $active === $val ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach

            @if ($active)
                <a href="{{ route('dashboard', request()->only('search')) }}" class="db-chip db-chip-clear">✕ Clear
                    filter</a>
            @endif
        </div>

        <!-- Section heading -->
        <div class="db-section-h">
            <h2>{{ $jobVacancies->total() }} {{ $active ? Str::ucfirst(str_replace('_', ' ', $active)) : 'Available' }}
                Jobs</h2>
            <div class="db-section-h-line"></div>
        </div>

        <!-- Job cards -->
        <div class="db-grid">
            @forelse ($jobVacancies as $job)
                @php
                    $typeClass = match ($job->type) {
                        'full_time' => 'type-full-time',
                        'part_time' => 'type-part-time',
                        'remote' => 'type-remote',
                        'hybrid' => 'type-hybrid',
                        'contract' => 'type-contract',
                        default => 'type-full-time',
                    };
                @endphp
                <a href="{{ route('job-vacancies.show', $job->id) }}" class="db-job-card">
                    <div class="db-job-header">
                        <div>
                            <div class="db-job-title">{{ $job->title }}</div>
                            <div class="db-job-company">🏢 {{ $job->company->name }}</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <span class="db-type-badge {{ $typeClass }}">
                                {{ Str::ucfirst(str_replace('_', '-', $job->type)) }}
                            </span>
                            <div class="db-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="db-meta">
                        <span class="db-meta-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 21s-8-7.5-8-13a8 8 0 0116 0c0 5.5-8 13-8 13z" />
                                <circle cx="12" cy="8" r="3" />
                            </svg>
                            {{ $job->location }}
                        </span>
                        <span class="db-meta-salary">
                            ${{ number_format($job->salary) }}/yr
                        </span>
                        @if ($job->application_deadline)
                            <span class="db-meta-item" style="color:rgba(251,191,36,.6);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                {{ $job->application_deadline }}
                            </span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="db-empty">
                    <div class="db-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                            <line x1="9" y1="9" x2="9.01" y2="9" />
                            <line x1="15" y1="9" x2="15.01" y2="9" />
                        </svg>
                    </div>
                    <h3>No jobs found</h3>
                    <p>Try adjusting your search or clearing the filter.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="db-pagination">
            {{ $jobVacancies->appends(request()->query())->links() }}
        </div>

    </div>
</x-app-layout>
