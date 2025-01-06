<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MyJobController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // authorizing a policy from the JobPolicy which needs a user to be authenticated first
        $this->authorize('viewAnyEmployer', Job::class);
        return view('my_job.index', [
            // Passing data to the 'my_job.index' view

            'jobs' => auth()->user()->employer // Access the currently authenticated user and retrieve their employer relationship
                ->jobs() // Access the 'jobs' relationship from the 'Employer' model
                ->with([ // Eager load related models to reduce database queries
                    'employer', // Load the 'employer' relationship for each job
                    'jobApplications', // Load the 'jobApplications' relationship for each job
                    'jobApplications.user' // Load the 'user' relationship for each job application
                ])
                ->withTrashed() //to get soft deleted data
                ->get() // Retrieve all the jobs with the specified relationships loaded
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Job::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create', Job::class);
        $request->user()->employer->jobs()->create($request->validated());
        return redirect()->route('my_jobs.index')->with('success', 'Job was created successfully');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Job $myJob)
    {
        $this->authorize('update', $myJob);
        $myJob->update($request->validated());
        return redirect()->route('my_jobs.index')->with('success', 'Your job has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $myJob)
    {
        $myJob->delete();

        return redirect()->route('my_jobs.index')->with('success', 'Your job has been deleted successfully');
    }
}
