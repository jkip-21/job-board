<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class MyJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized access');
        }

        // Fetch job applications with associated job data for instance counting number of applications per job
        $applications = $user->jobApplications()
            ->with(['job'=> fn($query)=> $query->withCount('jobApplications')->withAvg('jobApplications', 'expected_salary'),'job.employer']) // Eager load the 'job' relationship
            ->latest()
            ->get();

        return view('my_job_application.index', [
            'applications' => $applications
        ]);
    }
    public function destroy(JobApplication $myJobApplication)
    {
        $myJobApplication->delete();

        return redirect()->route('my_job_applications.index')
            ->with('success', 'Job application successfully deleted');
    }

}
