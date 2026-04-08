<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Apply — {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <style>
        /* ── Page wrapper ──────────────────────────────────── */
        .apply-wrapper {
            padding: 2.5rem 1rem;
            max-width: 56rem;
            margin: 0 auto;
        }

        /* ── Back link ─────────────────────────────────────── */
        .apply-back {
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

        .apply-back:hover {
            color: #a5b4fc;
            gap: 0.6rem;
        }

        /* ── Job mini-banner ───────────────────────────────── */
        .apply-job-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 70%, #1f1347 100%);
            border: 1px solid rgba(99, 102, 241, 0.25);
            border-radius: 1.1rem;
            padding: 1.35rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .apply-job-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 55% 90% at 95% 10%, rgba(99, 102, 241, .15), transparent);
            pointer-events: none;
        }

        .apply-job-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 0.2rem;
        }

        .apply-job-meta {
            font-size: 0.82rem;
            color: #818cf8;
            font-weight: 500;
        }

        /* ── Section heading ───────────────────────────────── */
        .apply-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0 1rem;
        }

        .apply-section-title .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            flex-shrink: 0;
        }

        /* ── Card base ─────────────────────────────────────── */
        .apply-card {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 1.1rem;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(6px);
        }

        /* ── Resume selection grid ─────────────────────────── */
        .resume-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 0.9rem;
        }

        /* ── Resume card (selectable) ──────────────────────── */
        .resume-card {
            position: relative;
            cursor: pointer;
        }

        .resume-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .resume-card-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.6rem;
            padding: 1.2rem 1rem;
            border-radius: 0.9rem;
            border: 2px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .03);
            transition: border-color 0.2s, background 0.2s, transform 0.15s, box-shadow 0.2s;
            text-align: center;
            user-select: none;
        }

        .resume-card:hover .resume-card-inner {
            border-color: rgba(99, 102, 241, .45);
            background: rgba(99, 102, 241, .07);
            transform: translateY(-2px);
        }

        .resume-card input[type="radio"]:checked~.resume-card-inner {
            border-color: #6366f1;
            background: rgba(99, 102, 241, .15);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .2);
        }

        /* check badge on selected resume */
        .resume-card input[type="radio"]:checked~.resume-card-inner .rcard-check {
            opacity: 1;
        }

        .rcard-icon {
            width: 44px;
            height: 44px;
            border-radius: 0.65rem;
            background: rgba(99, 102, 241, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .rcard-icon svg {
            width: 22px;
            height: 22px;
            color: #818cf8;
        }

        .rcard-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #e2e8f0;
            word-break: break-word;
        }

        .rcard-date {
            font-size: 0.72rem;
            color: #475569;
        }

        .rcard-check {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 20px;
            height: 20px;
            background: #6366f1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .rcard-check svg {
            width: 11px;
            height: 11px;
            color: #fff;
        }

        /* ── Empty state ───────────────────────────────────── */
        .resume-empty {
            text-align: center;
            padding: 2rem;
            color: #475569;
            font-size: 0.9rem;
        }

        .resume-empty svg {
            width: 36px;
            height: 36px;
            margin: 0 auto 0.75rem;
            opacity: .4;
        }

        /* ── Divider ───────────────────────────────────────── */
        .apply-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0.25rem 0 1.5rem;
        }

        .apply-divider hr {
            flex: 1;
            border-color: rgba(255, 255, 255, .07);
        }

        .apply-divider span {
            font-size: 0.75rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 600;
            white-space: nowrap;
        }

        /* ── Upload drop zone ──────────────────────────────── */
        .upload-zone {
            border: 2px dashed rgba(99, 102, 241, .3);
            border-radius: 0.9rem;
            padding: 2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            position: relative;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, .06);
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 0.85rem;
            background: rgba(99, 102, 241, .12);
            border-radius: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-icon svg {
            width: 24px;
            height: 24px;
            color: #818cf8;
        }

        .upload-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-bottom: 0.3rem;
        }

        .upload-hint {
            font-size: 0.78rem;
            color: #475569;
        }

        .upload-hint span {
            color: #818cf8;
        }

        /* ── File preview (after selection) ────────────────── */
        .file-preview {
            display: none;
            align-items: center;
            gap: 0.85rem;
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            background: rgba(99, 102, 241, .1);
            border: 1px solid rgba(99, 102, 241, .3);
            border-radius: 0.75rem;
        }

        .file-preview.visible {
            display: flex;
        }

        .file-preview svg {
            width: 20px;
            height: 20px;
            color: #818cf8;
            flex-shrink: 0;
        }

        .fp-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #e2e8f0;
            flex: 1;
            word-break: break-all;
        }

        .fp-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: #ef4444;
            padding: 0.2rem;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .fp-remove:hover {
            color: #fca5a5;
        }

        .fp-remove svg {
            width: 16px;
            height: 16px;
        }

        /* ── Cover letter ──────────────────────────────────── */
        .apply-textarea {
            width: 100%;
            min-height: 130px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            color: #e2e8f0;
            font-size: 0.9rem;
            line-height: 1.7;
            resize: vertical;
            transition: border-color 0.2s, background 0.2s;
            font-family: inherit;
            outline: none;
        }

        .apply-textarea:focus {
            border-color: rgba(99, 102, 241, .6);
            background: rgba(99, 102, 241, .05);
        }

        .apply-textarea::placeholder {
            color: #475569;
        }

        /* ── Submit button ─────────────────────────────────── */
        .apply-submit {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            border-radius: 0.9rem;
            cursor: pointer;
            box-shadow: 0 4px 24px rgba(99, 102, 241, .4);
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
            width: 100%;
            justify-content: center;
        }

        .apply-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(99, 102, 241, .55);
            filter: brightness(1.08);
        }

        .apply-submit svg {
            width: 18px;
            height: 18px;
        }

        /* ── Form label ────────────────────────────────────── */
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.6rem;
        }

        /* ── Error message ─────────────────────────────────── */
        .field-error {
            font-size: 0.8rem;
            color: #f87171;
            margin-top: 0.4rem;
        }
    </style>

    <div class="apply-wrapper">

        {{-- ← Back --}}
        <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" class="apply-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" style="width:16px;height:16px;">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Back to Job
        </a>

        {{-- ── Job mini-banner ───────────────────── --}}
        <div class="apply-job-banner">
            <div>
                <p class="apply-job-title">{{ $jobVacancy->title }}</p>
                <p class="apply-job-meta">
                    {{ $jobVacancy->company->name }} &nbsp;·&nbsp; {{ $jobVacancy->location }} &nbsp;·&nbsp;
                    ${{ number_format($jobVacancy->salary) }}/yr
                </p>
            </div>
            <span
                style="font-size:.78rem;font-weight:600;padding:.3rem .85rem;border-radius:9999px;background:rgba(99,102,241,.15);color:#a5b4fc;border:1px solid rgba(99,102,241,.3);">
                {{ Str::ucfirst(str_replace('_', '-', $jobVacancy->type)) }}
            </span>
        </div>

        {{-- ── Application form ──────────────────── --}}
        <form action="{{ route('applications.store', $jobVacancy->id) }}" method="POST" enctype="multipart/form-data"
            id="apply-form">
            @csrf

            {{-- Hidden: job id --}}
            <input type="hidden" name="job_vacancy_id" value="{{ $jobVacancy->id }}">

            {{-- ── 1. Select existing resume ──────── --}}
            <div class="apply-card">
                <h2 class="apply-section-title">
                    <span class="dot"></span>
                    Choose an Existing Resume
                </h2>

                @if (isset($resumes) && $resumes->count() > 0)
                    <div class="resume-grid">
                        @foreach ($resumes as $resume)
                            <label class="resume-card">
                                <input type="radio" name="resume_id" value="{{ $resume->id }}"
                                    {{ $loop->first ? 'checked' : '' }} id="resume-{{ $resume->id }}">
                                <div class="resume-card-inner">
                                    {{-- Check badge --}}
                                    <span class="rcard-check">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </span>

                                    {{-- Icon --}}
                                    <div class="rcard-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                            <line x1="16" y1="13" x2="8" y2="13" />
                                            <line x1="16" y1="17" x2="8" y2="17" />
                                            <polyline points="10 9 9 9 8 9" />
                                        </svg>
                                    </div>

                                    <p class="rcard-name">{{ $resume->file_name ?? 'Resume #' . $loop->iteration }}</p>
                                    <p class="rcard-date">
                                        Uploaded
                                        {{ isset($resume->created_at) ? $resume->created_at->diffForHumans() : '—' }}
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    {{-- Empty state — no resumes yet --}}
                    <div class="resume-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" style="display:block;">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        You don't have any saved resumes yet.<br>
                        Upload one below to get started.
                    </div>
                @endif

                {{-- Validation error --}}
                @error('resume_id')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Divider ─────────────────────────── --}}
            <div class="apply-divider">
                <hr>
                <span>or upload a new resume</span>
                <hr>
            </div>

            {{-- ── 2. Upload new resume ────────────── --}}
            <div class="apply-card">
                <h2 class="apply-section-title">
                    <span class="dot" style="background:linear-gradient(135deg,#34d399,#6ee7b7);"></span>
                    Upload a New Resume
                </h2>

                <label class="form-label" for="new_resume">PDF, DOC, or DOCX — Max 5 MB</label>

                <div class="upload-zone" id="upload-zone" x-data="{ fileName: 'No file chosen' }">
                    <input type="file" name="new_resume" id="new_resume" accept=".pdf,.doc,.docx"
                        onchange="handleFileSelect(this)">
                    <div class="upload-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 16 12 12 8 16" />
                            <line x1="12" y1="12" x2="12" y2="21" />
                            <path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3" />
                        </svg>
                    </div>
                    <p class="upload-label">Drop your resume here</p>
                    <p class="upload-hint">or <span>browse files</span></p>
                </div>

                {{-- File preview --}}
                <div class="file-preview" id="file-preview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <span class="fp-name" id="fp-name"></span>
                    <button type="button" class="fp-remove" onclick="clearFile()" title="Remove">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                @error('new_resume')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Validation error banner ─────────── --}}
            <div id="resume-error-banner"
                style="display:none;align-items:center;gap:.75rem;padding:.85rem 1.1rem;margin-bottom:1.25rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.35);border-radius:.85rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" style="width:18px;height:18px;flex-shrink:0;">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span style="font-size:.85rem;font-weight:600;color:#f87171;">Please select a saved resume or upload a
                    new one before submitting.</span>
            </div>

            {{-- ── Submit ───────────────────────────── --}}
            <button type="button" class="apply-submit" onclick="handleSubmit()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13" />
                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                </svg>
                Submit Application
            </button>

        </form>
    </div>

    <script>
        // ── Drag-and-drop styling ──────────────────────────
        const zone = document.getElementById('upload-zone');
        const errorBanner = document.getElementById('resume-error-banner');

        zone.addEventListener('dragover', e => {
            e.preventDefault();
            zone.classList.add('dragover');
        });
        zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) showPreview(file);
        });

        // ── Show file name after selection ────────────────
        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                showPreview(input.files[0]);
                hideError();
            }
        }

        function showPreview(file) {
            document.getElementById('fp-name').textContent = file.name;
            document.getElementById('file-preview').classList.add('visible');
            zone.style.borderColor = 'rgba(99,102,241,.6)';
            zone.style.background = 'rgba(99,102,241,.06)';
        }

        function clearFile() {
            document.getElementById('new_resume').value = '';
            document.getElementById('fp-name').textContent = '';
            document.getElementById('file-preview').classList.remove('visible');
            zone.style.borderColor = '';
            zone.style.background = '';
        }

        // ── Hide error banner ─────────────────────────────
        function hideError() {
            errorBanner.style.display = 'none';
        }

        // ── Deselect radio when uploading new file ────────
        document.getElementById('new_resume').addEventListener('change', function() {
            document.querySelectorAll('input[name="resume_id"]').forEach(r => r.checked = false);
        });

        // ── Deselect file when choosing saved resume ──────
        document.querySelectorAll('input[name="resume_id"]').forEach(radio => {
            radio.addEventListener('change', () => {
                clearFile();
                hideError();
            });
        });

        // ── Gate: exactly one selection required ──────────
        function hasSelectedResume() {
            return document.querySelector('input[name="resume_id"]:checked') !== null;
        }

        function hasUploadedFile() {
            const fileInput = document.getElementById('new_resume');
            return fileInput.files && fileInput.files.length > 0;
        }

        function handleSubmit() {
            if (!hasSelectedResume() && !hasUploadedFile()) {
                // Show error and scroll to it
                errorBanner.style.display = 'flex';
                errorBanner.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Shake animation
                errorBanner.style.animation = 'none';
                errorBanner.offsetHeight; // reflow
                errorBanner.style.animation = 'shake .35s ease';
                return;
            }

            // All good — submit
            document.getElementById('apply-form').submit();
        }
    </script>

    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-6px);
            }

            40% {
                transform: translateX(6px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }
        }
    </style>
</x-app-layout>
