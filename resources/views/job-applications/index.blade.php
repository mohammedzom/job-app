<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Tabs --}}
            <div class="flex space-x-4 mb-8 border-b border-zinc-800">
                <a href="{{ route('job-applications.index', ['archived' => 'false']) }}"
                    class="pb-3 px-4 text-sm font-medium transition-all duration-200 {{ !request('archived') || request('archived') == 'false' ? 'text-blue-500 border-b-2 border-blue-500' : 'text-zinc-500 hover:text-zinc-300 hover:border-b-2 hover:border-zinc-700' }}">
                    Active Applications
                </a>
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                    class="pb-3 px-4 text-sm font-medium transition-all duration-200 {{ request('archived') == 'true' ? 'text-blue-500 border-b-2 border-blue-500' : 'text-zinc-500 hover:text-zinc-300 hover:border-b-2 hover:border-zinc-700' }}">
                    Archived
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-zinc-900/50 border-l-4 border-emerald-500 text-emerald-400 rounded-r-xl shadow-sm backdrop-blur-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($jobApplications as $jobApplication)
                    <div
                        class="bg-zinc-900/40 backdrop-blur-md border border-zinc-800/50 rounded-3xl p-6 hover:border-blue-500/30 hover:bg-zinc-900/60 transition-all duration-500 group flex flex-col h-full">
                        {{-- Top Section with Badge and Action --}}
                        <div class="flex justify-between items-start mb-6">
                            @php
                                $status = $jobApplication->status;
                                $statusStyles = match ($status) {
                                    'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                    'accepted' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                    'rejected' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
                                    default => 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20',
                                };
                            @endphp
                            <div class="flex gap-2">
                                <span
                                    class="px-3 py-1 text-[10px] uppercase tracking-widest font-bold rounded-full border {{ $statusStyles }}">
                                    {{ $status }}
                                </span>
                                <span
                                    class="px-3 py-1 text-[10px] uppercase tracking-widest font-bold rounded-full border border-zinc-700 bg-zinc-800/50 text-zinc-400">
                                    {{ str_replace('_', '-', $jobApplication->job->type) }}
                                </span>
                            </div>

                            @if (request()->has('archived') && request('archived') == 'true')
                                <form action="{{ route('job-applications.restore', $jobApplication->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="p-2 text-zinc-500 hover:text-emerald-500 hover:bg-emerald-500/10 rounded-xl transition-all duration-200"
                                        title="Restore">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h10a8 8 0 018 8v2M3 10l5 5m-5-5l5-5" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-zinc-500 hover:text-rose-500 hover:bg-rose-500/10 rounded-xl transition-all duration-200"
                                        title="Archive">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Job Info --}}
                        <div class="mb-6 flex-grow">
                            @if ($jobApplication->trashed())
                                <h3
                                    class="text-xl font-bold text-gray-500 group-hover/title:text-blue-400 transition-colors mb-2 leading-tight">
                                    {{ $jobApplication->job->title }}
                                </h3>
                            @else
                                <a href="{{ route('job-applications.show', $jobApplication->id) }}"
                                    class="block group/title">
                                    <h3
                                        class="text-xl font-bold text-white group-hover/title:text-blue-400 transition-colors mb-2 leading-tight">
                                        {{ $jobApplication->job->title }}
                                    </h3>
                                </a>
                            @endif
                            <div class="flex items-center text-zinc-400 text-sm space-x-2">
                                <span class="font-medium">{{ $jobApplication->job->company->name }}</span>
                                <span class="text-zinc-700">•</span>
                                <span>{{ $jobApplication->job->location }}</span>
                            </div>
                        </div>

                        {{-- AI Score --}}
                        <div
                            class="flex items-center justify-between p-4 bg-blue-500/5 rounded-2xl border border-blue-500/10 mb-6">
                            <div class="flex flex-col">
                                <span class="text-zinc-500 text-[10px] uppercase tracking-widest mb-1">AI Match
                                    Score</span>
                                <span
                                    class="text-2xl font-black text-blue-500">{{ $jobApplication->ai_generated_score }}<span
                                        class="text-sm ml-0.5">%</span></span>
                            </div>
                            <div
                                class="h-12 w-12 rounded-2xl bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Resume & Date --}}
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-zinc-600 text-[10px] uppercase font-bold tracking-tight">Applied
                                    On</span>
                                <span
                                    class="text-xs text-zinc-300">{{ $jobApplication->created_at->format('d M Y') }}</span>
                            </div>
                            @if ($jobApplication->resume)
                                <div class="flex flex-col gap-1">
                                    <span class="text-zinc-600 text-[10px] uppercase font-bold tracking-tight">Resume
                                        File</span>
                                    <a href="{{ asset('storage/' . $jobApplication->resume->file_url) }}"
                                        target="_blank"
                                        class="text-xs text-blue-400 hover:text-blue-300 font-medium truncate flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        {{ $jobApplication->resume->file_name }}
                                    </a>
                                </div>
                            @else
                                <div class="flex flex-col gap-1">
                                    <span class="text-zinc-600 text-[10px] uppercase font-bold tracking-tight">Resume
                                        File</span>
                                    <span class="text-xs text-zinc-300">No resume file found</span>
                                </div>
                            @endif
                        </div>

                        {{-- AI Feedback --}}
                        <div class="mt-auto">
                            <div
                                class="p-4 bg-zinc-800/20 rounded-2xl border border-zinc-800/30 group-hover:border-zinc-700/50 transition-all">
                                <h4
                                    class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 flex items-center">
                                    <span class="w-1 h-1 bg-blue-500 rounded-full mr-2"></span>
                                    Intelligence Analysis
                                </h4>
                                <p class="text-xs text-zinc-400 leading-relaxed italic line-clamp-2">
                                    "{{ $jobApplication->ai_generated_feedback }}"
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-zinc-900 border border-zinc-800 mb-6 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-zinc-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-zinc-500 text-xl font-medium">No job applications found.</p>
                        @if (request('archived') == 'true')
                            <a href="{{ route('job-applications.index') }}"
                                class="text-blue-500 hover:text-blue-400 font-bold mt-4 inline-block transition-colors">View
                                active applications →</a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if ($jobApplications->hasPages())
                <div class="mt-12 bg-zinc-900/30 p-4 rounded-2xl border border-zinc-800/50 backdrop-blur-sm">
                    {{ $jobApplications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
