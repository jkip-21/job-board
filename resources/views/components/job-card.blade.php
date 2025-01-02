<x-card class="mb-4">
    <div class="flex justify-between">
        <h2 class="mb-4 text-lg font-medium">{{ $job->title }}</h2>
        <div class="text-slate-500">
            ${{ number_format($job->salary) }}
        </div>
    </div>
    <div class="mb-4 flex items-center justify-between text-sm text-slate-500">
        <div class="flex space-x-4">
            <div>
                Company Name
            </div>
            <div>
                {{ $job->location }}
            </div>
        </div>
        <div class="flex space-x-1 text-xs items-center">
            <x-tag >
                {{ Str::ucfirst($job->experience) }}
            </x-tag>
            <x-tag>{{ $job->category }}
            </x-tag>
        </div>
    </div>

    

    {{$slot}}
</div>
</x-card>
