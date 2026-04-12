<x-app-layout>
    <x-slot name="header">
        <h2>Upload Resume</h2>
    </x-slot>

    <style>
        .rup-wrap {
            max-width: 42rem;
            margin: 0 auto;
            padding: 3rem 1.5rem 5rem;
        }

        /* Back link */
        .rup-back {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            font-weight: 500;
            color: #818cf8;
            text-decoration: none;
            margin-bottom: 2rem;
            transition: gap .2s, color .2s;
        }

        .rup-back svg {
            width: 14px;
            height: 14px;
        }

        .rup-back:hover {
            gap: .65rem;
            color: #a5b4fc;
        }

        /* Title */
        .rup-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -.03em;
            color: #fff;
            margin-bottom: .4rem;
        }

        .rup-sub {
            font-size: .9rem;
            color: rgba(255, 255, 255, .35);
            margin-bottom: 2.5rem;
        }

        /* Card */
        .rup-card {
            background: rgba(15, 23, 42, .65);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 1.25rem;
            padding: 2rem;
            backdrop-filter: blur(12px);
        }

        /* Drop zone */
        .rup-dropzone {
            border: 2px dashed rgba(99, 102, 241, .3);
            border-radius: 1rem;
            padding: 3rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all .25s ease;
            background: rgba(99, 102, 241, .03);
            position: relative;
            margin-bottom: 1.5rem;
        }

        .rup-dropzone:hover,
        .rup-dropzone.drag-over {
            border-color: rgba(99, 102, 241, .6);
            background: rgba(99, 102, 241, .08);
        }

        .rup-dz-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto .9rem;
            background: rgba(99, 102, 241, .12);
            border: 1px solid rgba(99, 102, 241, .2);
            border-radius: .9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rup-dz-icon svg {
            width: 22px;
            height: 22px;
            color: #818cf8;
        }

        .rup-dz-title {
            font-size: .95rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .7);
            margin-bottom: .35rem;
        }

        .rup-dz-sub {
            font-size: .78rem;
            color: rgba(255, 255, 255, .3);
        }

        .rup-dz-sub span {
            color: #818cf8;
            font-weight: 600;
        }

        /* Hidden file input */
        #resume-file {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
        }

        /* Selected file name */
        #rup-filename {
            margin-top: .85rem;
            font-size: .8rem;
            color: #6ee7b7;
            font-weight: 600;
            display: none;
        }

        /* Error messages */
        .rup-errors {
            margin-bottom: 1.25rem;
        }

        .rup-error-item {
            font-size: .8rem;
            color: #f87171;
            background: rgba(239, 68, 68, .07);
            border: 1px solid rgba(239, 68, 68, .18);
            border-radius: .55rem;
            padding: .5rem .85rem;
            margin-bottom: .4rem;
        }

        /* Submit button */
        .rup-submit {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            padding: .75rem 1.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .9rem;
            font-weight: 700;
            border: none;
            border-radius: .8rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 0 24px rgba(99, 102, 241, .35);
            transition: all .2s;
        }

        .rup-submit svg {
            width: 16px;
            height: 16px;
        }

        .rup-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 32px rgba(99, 102, 241, .5);
        }

        /* Info note */
        .rup-note {
            margin-top: 1.25rem;
            padding: .75rem 1rem;
            background: rgba(99, 102, 241, .07);
            border: 1px solid rgba(99, 102, 241, .15);
            border-radius: .75rem;
            display: flex;
            align-items: flex-start;
            gap: .55rem;
            font-size: .78rem;
            color: rgba(255, 255, 255, .4);
            line-height: 1.5;
        }

        .rup-note svg {
            width: 14px;
            height: 14px;
            color: #818cf8;
            flex-shrink: 0;
            margin-top: .05rem;
        }
    </style>

    <div class="rup-wrap">

        <!-- Back -->
        <a href="{{ route('resumes.index') }}" class="rup-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Back to Resumes
        </a>

        <h1 class="rup-title">Upload Your Resume</h1>
        <p class="rup-sub">Our AI will analyze it and match you with the best job opportunities.</p>

        <div class="rup-card">

            @if ($errors->any())
                <div class="rup-errors">
                    @foreach ($errors->all() as $error)
                        <div class="rup-error-item">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Drop zone -->
                <div class="rup-dropzone" id="rup-dropzone"
                    ondragover="event.preventDefault();this.classList.add('drag-over')"
                    ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event)">
                    <input type="file" name="resume" id="resume-file" accept=".pdf" onchange="showFilename(this)">
                    <div class="rup-dz-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>
                    </div>
                    <div class="rup-dz-title">Drag & drop your PDF here</div>
                    <div class="rup-dz-sub">or <span>click to browse</span> from your computer</div>
                    <div id="rup-filename"></div>
                </div>

                <button type="submit" class="rup-submit" id="rup-submit-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    Upload & Analyze with AI
                </button>
            </form>

            <div class="rup-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                Only PDF files are accepted. After upload, our AI will automatically extract your summary, skills,
                education, and experience.
            </div>
        </div>
    </div>

    <script>
        function showFilename(input) {
            const el = document.getElementById('rup-filename');
            if (input.files && input.files[0]) {
                el.textContent = '📄 ' + input.files[0].name;
                el.style.display = 'block';
            }
        }

        function handleDrop(e) {
            e.preventDefault();
            document.getElementById('rup-dropzone').classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file) {
                const input = document.getElementById('resume-file');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                showFilename(input);
            }
        }
    </script>
</x-app-layout>
