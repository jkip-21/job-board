<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\MyJobController;

// Home redirect
Route::get('/', fn() => redirect()->route('jobs.index'));

// Job routes
Route::resource('jobs', JobController::class)->only(['index', 'show']);

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store'])->name('auth.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::delete('logout', [AuthController::class, 'destroy'])->name('auth.logout');

    // My Job Applications Routes
    Route::resource('my-job-applications', MyJobApplicationController::class)
        ->only(['index', 'destroy'])
        ->names([
            'index' => 'my_job_applications.index',
            'destroy' => 'my_job_applications.destroy'
        ]);

    // Job Application Routes
    Route::resource('job.application', JobApplicationController::class)->only(['create', 'store']);
    // Employer  routes

    Route::resource('employer', EmployerController::class)->only(['create', 'store']);

    // route to employer job listings
    Route::middleware('employer')->resource('my_jobs', MyJobController::class);
});
