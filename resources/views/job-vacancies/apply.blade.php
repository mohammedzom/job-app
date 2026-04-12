<x-app-layout>
    <x-slot name="header">
        <h2>Apply — {{ $jobVacancy->title }}</h2>
    </x-slot>

    <style>
        /* ── Page wrapper ── */
        .apply-wrap {
            max-width: 52rem;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* ── Back link ── */
        .apply-back {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            font-weight: 500;
            color: rgba(255, 255, 255, .35);
            text-decoration: none;
            margin-bottom: 1.75rem;
            transition: color .2s;
        }

        .apply-back svg {
            width: 14px;
            height: 14px;
        }

        .apply-back:hover {
            color: #a5b4fc;
        }

        /* ── Job summary card ── */
        .apply-job-card {
            background: rgba(15, 23, 42, .55);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 1.1rem;
            padding: 1.4rem 1.5rem;
            backdrop-filter: blur(12px);
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
        }

        .apply-job-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 60% at 90% 0%, rgba(99, 102, 241, .08), transparent);
            pointer-events: none;
        }

        .apply-job-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #e2e8f0;
            letter-spacing: -.02em;
            line-height: 1.25;
        }

        .apply-job-company {
            font-size: .82rem;
            color: rgba(255, 255, 255, .4);
            margin-top: .2rem;
        }

        .apply-job-meta {
            display: flex;
            align-items: center;
            gap: .65rem;
            flex-wrap: wrap;
            margin-top: .75rem;
        }

        .apply-meta-item {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            font-size: .75rem;
            color: rgba(255, 255, 255, .32);
        }

        .apply-meta-item svg {
            width: 12px;
            height: 12px;
        }

        .apply-salary {
            font-size: .8rem;
            font-weight: 700;
            color: #6ee7b7;
        }

        .apply-type-badge {
            display: inline-flex;
            align-items: center;
            padding: .2rem .65rem;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .05em;
            border-radius: 9999px;
            white-space: nowrap;
            background: rgba(99, 102, 241, .15);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, .3);
        }

        /* ── Form card ── */
        .apply-form-card {
            background: rgba(15, 23, 42, .55);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 1.1rem;
            padding: 1.8rem 1.8rem 2.2rem;
            backdrop-filter: blur(12px);
        }

        /* ── Section label ── */
        .apply-section-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
            margin-bottom: 1rem;
        }

        /* ── Error alert ── */
        .apply-errors {
            background: rgba(239, 68, 68, .08);
            border: 1px solid rgba(239, 68, 68, .25);
            border-radius: .75rem;
            padding: .9rem 1.1rem;
            margin-bottom: 1.5rem;
        }

        .apply-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: .3rem;
        }

        .apply-errors li {
            font-size: .82rem;
            color: #fca5a5;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .apply-errors li::before {
            content: '!';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
            background: rgba(239, 68, 68, .3);
            border-radius: 50%;
            font-size: .62rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        /* ── Resume option row ── */
        .apply-resume-option {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .85rem 1rem;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: .75rem;
            background: rgba(255, 255, 255, .02);
            cursor: pointer;
            transition: all .2s ease;
            position: relative;
        }

        .apply-resume-option:has(input:checked) {
            border-color: rgba(99, 102, 241, .4);
            background: rgba(99, 102, 241, .07);
        }

        .apply-resume-option:hover {
            border-color: rgba(99, 102, 241, .25);
            background: rgba(99, 102, 241, .04);
        }

        /* Hide native radio */
        .apply-resume-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Custom radio dot */
        .apply-radio-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .2);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .apply-resume-option:has(input:checked) .apply-radio-dot {
            border-color: #818cf8;
            background: rgba(99, 102, 241, .2);
        }

        .apply-radio-dot::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #818cf8;
            opacity: 0;
            transition: opacity .2s;
        }

        .apply-resume-option:has(input:checked) .apply-radio-dot::after {
            opacity: 1;
        }

        /* File icon */
        .apply-file-icon {
            width: 36px;
            height: 36px;
            background: rgba(99, 102, 241, .1);
            border: 1px solid rgba(99, 102, 241, .2);
            border-radius: .6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .apply-file-icon svg {
            width: 16px;
            height: 16px;
            color: #818cf8;
        }

        .apply-resume-name {
            font-size: .875rem;
            font-weight: 600;
            color: #e2e8f0;
            line-height: 1.3;
        }

        .apply-resume-date {
            font-size: .72rem;
            color: rgba(255, 255, 255, .25);
            margin-top: .15rem;
        }

        /* ── Divider ── */
        .apply-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1rem 0;
        }

        .apply-divider-line {
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, .07);
        }

        .apply-divider-text {
            font-size: .72rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .2);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* ── Dropzone ── */
        .apply-dropzone {
            border: 2px dashed rgba(255, 255, 255, .1);
            border-radius: .85rem;
            padding: 1.75rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all .2s ease;
            background: rgba(255, 255, 255, .02);
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .apply-dropzone:hover,
        .apply-dropzone.active-file {
            border-color: rgba(99, 102, 241, .45);
            background: rgba(99, 102, 241, .05);
        }

        .apply-dropzone.has-error {
            border-color: rgba(239, 68, 68, .4);
        }

        .apply-dropzone-icon {
            width: 44px;
            height: 44px;
            margin: 0 auto .75rem;
            background: rgba(99, 102, 241, .1);
            border: 1px solid rgba(99, 102, 241, .2);
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .apply-dropzone-icon svg {
            width: 20px;
            height: 20px;
            color: #818cf8;
        }

        .apply-dropzone-hint {
            font-size: .8rem;
            color: rgba(255, 255, 255, .3);
        }

        .apply-dropzone-hint span {
            color: #a5b4fc;
            font-weight: 600;
        }

        .apply-dropzone-sub {
            font-size: .72rem;
            color: rgba(255, 255, 255, .2);
            margin-top: .3rem;
        }

        .apply-file-chosen {
            font-size: .85rem;
            font-weight: 600;
            color: #a5b4fc;
        }

        .apply-file-change {
            font-size: .72rem;
            color: rgba(255, 255, 255, .25);
            margin-top: .25rem;
        }

        /* ── Submit button ── */
        .apply-submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            width: 100%;
            margin-top: 2.5rem;
            padding: .85rem 1.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .92rem;
            font-weight: 700;
            border: none;
            border-radius: .85rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            letter-spacing: -.01em;
            box-shadow: 0 0 24px rgba(99, 102, 241, .35);
            transition: all .25s ease;
        }

        .apply-submit-btn svg {
            width: 16px;
            height: 16px;
        }

        .apply-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(99, 102, 241, .5);
        }

        .apply-submit-btn:active {
            transform: translateY(0);
        }

        /* ── Resume list spacing ── */
        .apply-resume-list {
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        /* Empty resumes notice */
        .apply-no-resumes {
            text-align: center;
            padding: 1.5rem;
            color: rgba(255, 255, 255, .25);
            font-size: .82rem;
            border: 1px dashed rgba(255, 255, 255, .07);
            border-radius: .75rem;
        }
    </style>

    <div class="apply-wrap">

        {{-- Back link --}}
        <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" class="apply-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Back to Job Details
        </a>

        {{-- Job summary --}}
        <div class="apply-job-card">
            <div>
                <div class="apply-job-title">{{ $jobVacancy->title }}</div>
                <div class="apply-job-company">🏢 {{ $jobVacancy->company->name }}</div>
                <div class="apply-job-meta">
                    <span class="apply-meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 21s-8-7.5-8-13a8 8 0 0116 0c0 5.5-8 13-8 13z" />
                            <circle cx="12" cy="8" r="3" />
                        </svg>
                        {{ $jobVacancy->location }}
                    </span>
                    <span class="apply-salary">${{ number_format($jobVacancy->salary) }}/yr</span>
                </div>
            </div>
            <span class="apply-type-badge">
                {{ Str::ucfirst(str_replace('_', '-', $jobVacancy->type)) }}
            </span>
        </div>

        {{-- Form card --}}
        <div class="apply-form-card">

            <form action="{{ route('job-applications.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-0">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job_id }}">

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="apply-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Section: choose resume --}}
                <p class="apply-section-label">Choose Your Resume</p>

                <div class="apply-resume-list">
                    @forelse ($resumes as $resume)
                        <label class="apply-resume-option">
                            <input type="radio" name="resume_option" id="resume_{{ $resume->id }}"
                                value="{{ $resume->id }}">
                            <div class="apply-radio-dot"></div>
                            <div class="apply-file-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                </svg>
                            </div>
                            <div>
                                <div class="apply-resume-name">{{ $resume->file_name }}</div>
                                <div class="apply-resume-date">Updated {{ $resume->updated_at->format('d M Y') }}</div>
                            </div>
                        </label>
                    @empty
                        <div class="apply-no-resumes">No saved resumes found. Upload a new one below.</div>
                    @endforelse
                </div>

                {{-- Divider --}}
                <div class="apply-divider" style="margin-top:1.25rem;">
                    <div class="apply-divider-line"></div>
                    <span class="apply-divider-text">or upload new</span>
                    <div class="apply-divider-line"></div>
                </div>

                {{-- New resume upload --}}
                <div x-data="{ fileName: '', hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }} }" style="margin-bottom: 2rem;">

                    {{-- Radio row for "new resume" --}}
                    <label class="apply-resume-option" style="margin-bottom:.75rem;">
                        <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume"
                            value="new_resume">
                        <div class="apply-radio-dot"></div>
                        <div class="apply-file-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </div>
                        <div>
                            <div class="apply-resume-name">Upload a new resume</div>
                            <div class="apply-resume-date">PDF only · Max 5 MB</div>
                        </div>
                    </label>

                    {{-- Dropzone --}}
                    <label for="new_resume_file" class="apply-dropzone py-5"
                        :class="{ 'active-file': fileName, 'has-error': hasError }">

                        <input type="file" name="resume_file" id="new_resume_file" class="hidden" accept=".pdf"
                            @change="fileName = $event.target.files[0].name; $refs.newResumeRadio.checked = true;">

                        <div x-show="!fileName">
                            <div class="apply-dropzone-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                            </div>
                            <p class="apply-dropzone-hint"><span>Click to browse</span> or drag & drop</p>
                            <p class="apply-dropzone-sub">PDF · Max 5 MB</p>
                        </div>

                        <div x-show="fileName">
                            <div class="apply-dropzone-icon"
                                style="background:rgba(52,211,153,.1);border-color:rgba(52,211,153,.25);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#6ee7b7" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </div>
                            <p class="apply-file-chosen" x-text="fileName"></p>
                            <p class="apply-file-change">Click to change file</p>
                        </div>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="apply-submit-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                    Submit Application
                </button>

            </form>
        </div>

    </div>
</x-app-layout>
