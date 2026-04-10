<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __($resume->file_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                <div class="mt-4">
                    <a href="{{ asset('storage/' . $resume->file_url) }}" target="_blank" class="btn btn-primary">
                        {{ __('Download Resume') }}
                    </a>
                </div>
                <div class="mt-4">
                    <a href="{{ route('resumes.index') }}" class="btn btn-primary">
                        {{ __('Back to Resumes') }}
                    </a>
                </div>
                <div class="mt-4">
                    <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            {{ __('Delete Resume') }}
                        </button>
                    </form>
                </div>
                <div class="mt-4">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Summary') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Education') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Experience') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Skills') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Uploaded At') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/' . $resume->file_url) }}" target="_blank">
                                        {{ $resume->file_name }}
                                    </a>
                                </td>
                                <td>{{ $resume->summary == '' ? 'N/A' : $resume->summary }}</td>
                                <td>{{ $resume->education == '' ? 'N/A' : $resume->education }}</td>
                                <td>{{ $resume->experience == '' ? 'N/A' : $resume->experience }}</td>
                                <td>{{ $resume->skills == '' ? 'N/A' : $resume->skills }}</td>
                                <td>{{ $resume->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Delete Resume') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
