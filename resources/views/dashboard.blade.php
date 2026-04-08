<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            <h3 class="text-white text-2xl font-bold mb-4">
                {{ __('Welcome back') }} {{ Auth::user()->name }}!
            </h3>

            {{-- Search Bar --}}
            <div class="flex items-center justify-between">
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center justify-center w-1/4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full p-2 rounded-l-lg bg-gray-800 text-white" placeholder="Search for a job">
                    <button type="submit" class="bg-indigo-500 text-white p-2 rounded-r-lg border border-indigo-500">
                        {{ __('Search') }}
                    </button>
                    @if (request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    @if (request('search'))
                        <a href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                            class="text-white p-2 rounded-lg ml-2">Clear</a>
                    @endif
                </form>

                {{-- Filters --}}
                <div class="flex space-x-2">

                    <a href="{{ route('dashboard', ['filter' => 'full_time']) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Full-Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'part_time']) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Part-Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'remote']) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Remote</a>
                    <a href="{{ route('dashboard', ['filter' => 'hybrid']) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['filter' => 'contract']) }}"
                        class="bg-indigo-500 text-white p-2 rounded-lg">Contract</a>

                    @if (request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                            class="text-white p-2 rounded-lg">Clear</a>
                    @endif
                </div>
            </div>

            {{-- Job Listings --}}
            <div class="space-y-4 mt-6">
                @forelse ($jobVacancies as $jobVacancy)
                    <div class="border-b border-white/10 pb-4 flex items-center justify-between">
                        {{-- Job Items --}}
                        <div>
                            <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                                class="text-lg font-semibold text-blue-400 hover:underline">{{ $jobVacancy->title }}</a>
                            <p class="text-sm text-white">{{ $jobVacancy->company->name }} -
                                {{ $jobVacancy->location }}
                            </p>
                            <p class="text-sm text-white">${{ number_format($jobVacancy->salary) }}/ Year</p>
                        </div>
                        <span
                            class="bg-blue-500 text-white p-2 rounded-lg">{{ Str::ucfirst(str_replace('_', '-', $jobVacancy->type)) }}</span>

                    </div>
                @empty
                    <p class="text-white text-2xl font-bold">No jobs found!</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $jobVacancies->links() }}
            </div>

        </div>

    </div>
</x-app-layout>
