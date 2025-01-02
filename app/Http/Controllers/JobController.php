<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $jobs = Job::query();

    // Filter by search keyword in title or description
    $jobs->when(request('search'), function ($query) {
        $query->where('title', 'like', '%' . request('search') . '%')
              ->orWhere('description', 'like', '%' . request('search') . '%');
    });

    // Filter by salary range
    $jobs->when(request('min_salary'), function ($query) {
        $query->where('salary', '>=', request('min_salary'));
    });

    $jobs->when(request('max_salary'), function ($query) {
        $query->where('salary', '<=', request('max_salary'));
    });

    return view('job.index', ['jobs' => $jobs->get()]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
