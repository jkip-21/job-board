<x-layout>
    <x-bread-crumbs class="mb-4" :links="[
        'Jobs' => route('jobs.index'),
        $job->title => route('jobs.show', $job),
        'Apply' => '#',
    ]" />
    <x-job-card :$job/>
    <x-card>
        <h2 class="mb-4 text-lg font-medium">
            Your job application
        </h2>
        <form action="{{route('job.application.store', $job)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <x-label for="expected_salary" :required="true">Expected salary</x-label>
                <x-text-input type="number" name="expected_salary"/>
            </div>
            <div class=" mb-4">
                <x-label for="cv" :required="true">Upload CV</x-label>
                <x-text-input name="cv" type="file"/>
            </div>
            <x-button class="w-full">Apply</x-button>
        </form>
    </x-card>
</x-layout>
