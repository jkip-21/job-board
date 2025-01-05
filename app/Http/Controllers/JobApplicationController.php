<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show the form for creating a new resource.
     */
    public function create(Job $job)
    {
        $this->authorize('apply', $job);
        return view('job_application.create', ['job' => $job]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Job $job, Request $request)
    {

        $validateData = $request->validate([
                'expected_salary' => 'required|min:1|max:1000000',
                'cv' => 'required|file|mimes:pdf|max:2048'
            ]);
            // how to access the cv
            $file= $request->file('cv');
            // Store cv in a specific folder and disk
            $path= $file->store('cvs','private');


        $job->jobApplications()->create([
            'user_id' => $request->user()->id,
            'expected_salary' => $validateData['expected_salary'],
            'cv' => $path
        ]);

        return redirect()->route('jobs.show', $job)->with('success', 'Job application created submitted');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
