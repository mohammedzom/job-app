<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Resumes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-white">
                    {{ __('Resumes') }}
                </h3>

                <div class="mt-4">
                    <a href="{{ route('resumes.create') }}" class="btn btn-primary">
                        {{ __('Create Resume') }}
                    </a>
                </div>
                <table class="w-full text-sm text-left text-white">
                    <thead class="text-xs text-white uppercase bg-zinc-800">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ __('Name') }}
                            </th>
                        </tr>
                    </thead>
                </table>
                <tbody>
                    @foreach ($resumes as $resume)
                        <tr
                            class="bg-zinc-900/40 backdrop-blur-md border border-zinc-800/50 rounded-3xl p-6 hover:border-blue-500/30 hover:bg-zinc-900/60 transition-all duration-500 group flex flex-col h-full">
                            <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                                <a href="{{ route('resumes.show', $resume->id) }}">
                                    {{ $resume->file_name }}
                                </a>
                                <br>
                                <span class="text-xs text-zinc-400">
                                    {{ $resume->created_at->format('d M Y') }}
                                </span>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
