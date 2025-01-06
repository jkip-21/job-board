<x-layout>
    <x-bread-crumbs :links="['My Jobs'=> route('my_jobs.index')]" class="mb-4"/>

        <div class="mb-8 text-right">
            <x-link-button href="{{route('my_jobs.create')}}">Add New</x-link-button>
        </div>
        @forelse ($jobs as $job)
        <x-job-card :$job>
            <div class="text-sm text-slate-500">
                @forelse ($job->JobApplications as $application)
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <div>{{$application->user->name}}</div>
                        <div>{{$application->created_at->diffForHumans()}}</div>
                        <div><a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="text-blue-500 hover:underline">Download CV</a></div>

                    </div>
                    <div>
                        ${{number_format($application->expected_salary)}}

                    </div>
                </div>
                @empty
                <div>
                    No applications yet
                </div>
                @endforelse
                <div class="flex space-x-2">
                    <x-link-button href="{{route('my_jobs.edit', $job)}}">Edit</x-link-button>

                    <form action="{{route('my_jobs.destroy', $job)}} " method="POST">
                        @csrf
                        @method('Delete')
                        <x-button>Delete</x-button>
                    </form>
                </div>

            </div>

        </x-job-card>

        @empty
        <div class="rounded-md border border-dashed border-slate-300 p-8">
               <div class="text-center font-medium">    No jobs yet</div>
               <div class="text-center">
                Post your first job <a href="{{route('my_jobs.create')}}" class="text-indigo-500 hover:underline">here!</a>
               </div>
        </div>
        @endforelse
</x-layout>
