<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Application Details') }}
            </h2>
            <a href="{{ route('job-applications.index') }}"
                class="text-sm font-medium text-zinc-400 hover:text-white transition-colors flex items-center group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Side: Analysis & Context --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Header Card --}}
                    <div
                        class="bg-zinc-900/40 backdrop-blur-md border border-zinc-800/50 rounded-3xl p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8">
                            @php
                                $status = $jobApplication->status;
                                $statusStyles = match ($status) {
                                    'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                    'accepted' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                    'rejected' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
                                    default => 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20',
                                };
                            @endphp
                            <span
                                class="px-4 py-1.5 text-xs font-black uppercase tracking-widest rounded-full border {{ $statusStyles }}">
                                {{ $status }}
                            </span>
                        </div>

                        <div class="relative z-10">
                            <h1 class="text-4xl font-black mb-4 leading-tight tracking-tight">
                                {{ $jobApplication->job->title }}
                            </h1>
                            <div class="flex flex-wrap items-center text-zinc-400 gap-x-6 gap-y-2 mb-8">
                                <span class="flex items-center font-bold text-blue-400">
                                    {{ $jobApplication->job->company->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-zinc-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $jobApplication->job->location }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-zinc-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Applied {{ $jobApplication->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Intelligence Card --}}
                    <div class="bg-blue-600/5 backdrop-blur-md border border-blue-500/10 rounded-3xl p-8">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="p-3 bg-blue-500 rounded-2xl shadow-lg shadow-blue-500/20 text-white">
                                <svg class="w-8 h-8 font-black" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black tracking-tight">Intelligence Analysis</h3>
                                <p class="text-sm text-zinc-500 font-medium">AI-Driven Resume Matching Insights</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div
                                class="md:col-span-1 flex flex-col items-center justify-center p-6 bg-zinc-900/50 rounded-3xl border border-zinc-800">
                                <span
                                    class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 text-center">Match
                                    Score</span>
                                <div class="text-5xl font-black text-blue-500 mb-1 leading-none">
                                    {{ $jobApplication->ai_generated_score }}%</div>
                                <div class="h-1 w-12 bg-blue-500 rounded-full"></div>
                            </div>
                            <div class="md:col-span-3">
                                <div class="relative">
                                    <svg class="absolute -top-4 -left-2 w-10 h-10 text-blue-500/10 fill-current"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11.5M4 11.5V9C4 8.44772 4.44772 8 5 8H9C9.55228 8 10 8.44772 10 9V15C10 15.5523 9.55228 16 9 16H6C4.89543 16 4 16.8954 4 18V21" />
                                    </svg>
                                    <p class="text-lg text-zinc-300 leading-relaxed italic relative z-10 pl-4 py-2">
                                        "{{ $jobApplication->ai_generated_feedback }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Resume Details --}}
                    <div class="bg-zinc-900/40 backdrop-blur-md border border-zinc-800/50 rounded-3xl p-8">
                        <h3 class="text-xl font-bold mb-8 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Extracted Resume Profile
                        </h3>

                        <div class="space-y-8">
                            <div>
                                <h4 class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Professional
                                    Summary</h4>
                                <p class="text-zinc-300 leading-relaxed">
                                    {{ is_null($jobApplication->resume->summary) ? 'No summary' : $jobApplication->resume->summary }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <h4 class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Key
                                        Skills</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $skills = is_null($jobApplication->resume->skills)
                                                ? []
                                                : explode(',', $jobApplication->resume->skills);
                                        @endphp
                                        @forelse ($skills as $skill)
                                            <span
                                                class="px-3 py-1 bg-zinc-800 text-zinc-300 text-xs font-medium rounded-lg border border-zinc-700/50">
                                                {{ $skill }}
                                            </span>
                                        @empty
                                            <span
                                                class="px-3 py-1 bg-zinc-800 text-zinc-300 text-xs font-medium rounded-lg border border-zinc-700/50">
                                                No skills
                                            </span>
                                        @endforelse
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Education
                                    </h4>
                                    <p class="text-zinc-300 text-sm italic">
                                        {{ is_null($jobApplication->resume->education) ? 'No education' : $jobApplication->resume->education }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Experience
                                </h4>
                                <div class="text-zinc-300 text-sm whitespace-pre-line leading-relaxed">
                                    {{ is_null($jobApplication->resume->experience) ? 'No experience' : $jobApplication->resume->experience }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Job Context & Actions --}}
                <div class="space-y-8">

                    {{-- Quick Info --}}
                    <div class="bg-zinc-900/40 backdrop-blur-md border border-zinc-800/50 rounded-3xl p-8">
                        <h3 class="text-lg font-bold mb-6">Job Snapshot</h3>
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest">Base
                                        Salary</p>
                                    <p class="text-lg font-bold text-white">
                                        ${{ number_format($jobApplication->job->salary) }} <span
                                            class="text-xs text-zinc-500 font-normal">/ Year</span></p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest">
                                        Employment Type</p>
                                    <p class="text-lg font-bold text-white">
                                        {{ str_replace('_', '-', ucfirst($jobApplication->job->type)) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-zinc-500 uppercase font-black tracking-widest">Deadline
                                    </p>
                                    <p class="text-lg font-bold text-white">
                                        {{ \Carbon\Carbon::parse($jobApplication->job->application_deadline)->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-zinc-900/40 backdrop-blur-md border border-zinc-800/50 rounded-3xl p-8">
                        <h3 class="text-lg font-bold mb-6 text-center">Manage Application</h3>
                        <div class="space-y-4">
                            <a href="{{ asset('storage/' . $jobApplication->resume->file_url) }}" target="_blank"
                                class="w-full flex items-center justify-center py-4 px-6 bg-blue-600 hover:bg-blue-500 text-white font-black text-sm uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-blue-500/20 active:scale-[0.98]">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Full Resume View
                            </a>

                            <form action="{{ route('job-applications.destroy', $jobApplication->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center py-4 px-6 bg-zinc-800 hover:bg-rose-500/10 hover:text-rose-500 text-zinc-400 font-bold text-sm uppercase tracking-widest rounded-2xl transition-all border border-zinc-700/50 hover:border-rose-500/30">
                                    Archive Application
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
