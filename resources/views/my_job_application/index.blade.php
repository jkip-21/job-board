<x-layout>
    <x-bread-crumbs class="mb-4" :links="['my-job-application' => '#']" />
    @forelse ($applications as $application)
        <x-job-card :job="$application->job">
            <div class="flex justify-between items-center text-xs text-slate-500">
                <div>
                    <div>
                        Applied {{$application->created_at->diffForHumans()}}
                    </div>
                    <div>
                        Other {{Str::plural('applicant',$application->job->job_applications_count - 1)}}
                        {{$application->job->job_applications_count - 1}}
                    </div>
                    <div>
                        Your asking salary $ {{number_format($application->expected_salary)}}
                    </div>
                    <div>
                        Average asking salary $ {{number_format($application->job->job_applications_avg_expected_salary)}}
                    </div>

                </div>
                <div>
                    <!-- Corrected form action route -->
                    <form action="{{ route('my_job_applications.destroy', $application->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" class="btn btn-danger">Cancel</x-button>
                    </form>
                </div>
            </div>
        </x-job-card>
    @empty
    <div class="rounded-md border border-dashed border-slate-300 p-8">
        <div class="text-center font-medium">
            No job applications yet.
        </div>
        <div class="text-center">
            Find some jobs <a class="text-indigo-500 hover:underline " href="{{route('jobs.index')}}">here!</a>
        </div>
    </div>
        <p></p>
    @endforelse

</x-layout>
