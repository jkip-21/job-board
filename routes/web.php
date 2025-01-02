<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Route to redirect to the jobs page
Route::get('', fn()=> to_route('jobs.index'));
Route::resource('jobs', JobController::class)->only(['index', 'show']);
