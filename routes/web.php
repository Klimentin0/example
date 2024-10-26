<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {

    return view('home');
});

// Index
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

// Create
Route::get('/jobs/create', function() {
    return view('jobs.create');
});

// Show
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);

   return view('jobs.show', ['job' => $job]);
});

// Store
Route::post('/jobs', function() {
    // validation
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});

// Edit
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

   return view('jobs.edit', ['job' => $job]);
});


// Update
Route::patch('/jobs/{id}', function ($id) {
    //Validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);
    //Authorize
    //Update the job (Laravel Route Model Binding)
    $job = Job::findOrFail($id);

    //Persist
    // $job->title = request('title');
    // $job->salary= request('salary');
    // $job->save();
    // its the same as below

    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);
    //redirect to the job page
    return redirect('/jobs/' . $job->id);
});

// Destroy
Route::delete('/jobs/{id}', function ($id) {
    // Authorize request
    // Delete the job
    $job = Job::findOrFail($id);
    $job->delete();
    //short variant of previous 2 commands
    //Job::findOrFail($id)->delete();

    // Redirect
    return redirect('/jobs');
});


Route::get('/contacts', function () {
    return view('contacts');
});
