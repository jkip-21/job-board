<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        // Allows the user to view all the jobs without being authenticated
        $this->authorize('viewAny', Job::class);
        $filters = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');
        // we load all the jobs then we load all the employers before we filter the data
        $jobs = Job::with('employer')->latest()->filter($filters)->get();

        return view('job.index', ['jobs' => $jobs]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $this->authorize('viewAny', $job);
        return view('job.show', ['job' => $job->load('employer.jobs')]);
    }
}
