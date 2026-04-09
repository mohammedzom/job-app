<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Apply — {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            <a href="{{ route(name: 'job-vacancies.show', parameters: $jobVacancy->id) }}"
                class="text-blue-400 hover:underline mb-6 inline-block">
                <- Back to Job Details </a>

                    <div class="border-b border-white/10 pb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-white">{{ $jobVacancy->title }}</h1>
                                <p class="text-md text-gray-400">{{ $jobVacancy->company->name }}</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-400">{{ $jobVacancy->location }}</p>
                                    <p class="text-sm text-gray-400">•</p>
                                    <p class="text-sm text-gray-400">{{ '$' . number_format(num: $jobVacancy->salary) }}
                                    </p>
                                    <p class="text-sm bg-indigo-500 text-white p-2 rounded-lg">
                                        {{ Str::ucfirst(str_replace('_', '-', $jobVacancy->type)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route(name: 'job-applications.store') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job_id }}">
                        @if ($errors->any())
                            <div class="bg-red-500 text-white p-4 rounded-lg">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-4">Choose Your Resume</h3>
                            <div class="space-y-4">

                                @forelse ($resumes as $resume)
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="resume_option" id="{{ $resume->id }}"
                                            value="{{ $resume->id }}"
                                            @error('resume_option') class="border-red-500" @else class="border-gray-600" @enderror />
                                        <x-input-label class="text-white cursor-pointer" for="{{ $resume->id }}"
                                            value="{{ $resume->file_name }}" />
                                        <span class="text-gray-400 text-sm">Last Updated:
                                            {{ $resume->updated_at->format('Y-m-d') }}</span>
                                    </div>
                                @empty
                                    <p class="text-white text-sm">No resumes found</p>
                                @endforelse
                            </div>
                        </div>

                        <div x-data="{ fileName: '', hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }} }">
                            <div class="flex items-center gap-2">
                                <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume"
                                    value="new_resume"
                                    @error('resume_option') class="border-red-500" @else class="border-gray-600" @enderror />
                                <x-input-label class="text-white cursor-pointer" for="new_resume"
                                    value="upload a new resume:" />
                            </div>
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <label for="new_resume_file" class="block text-white cursor-pointer">
                                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 hover:border-blue-500 transition"
                                            :class="{ 'border-blue-500': fileName, 'border-red-500': hasError }">
                                            <input
                                                @change="fileName = $event.target.files[0].name; $refs.newResumeRadio.checked = true;"
                                                type="file" name="resume_file" id="new_resume_file" class="hidden"
                                                accept=".pdf" />
                                            <div class="text-center">
                                                <template x-if="!fileName">
                                                    <p class="text-gray-400">Click to upload PDF (Max 5MB)</p>
                                                </template>

                                                <template x-if="fileName">
                                                    <div>
                                                        <p x-text="fileName" class="mt-2 text-blue-400"></p>
                                                        <p class="text-gray-400 text-sm mt-1">Click to change file</p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <x-primary-button class="w-full">Apply</x-primary-button>
                    </form>
        </div>
    </div>

</x-app-layout>
