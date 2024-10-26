<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store()
    {
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
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        // Authorize
        //Validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        //Update the job (we dont this after 'Routed reloaded episode') (Laravel Route Model Binding)
        //$job = Job::findOrFail($id);

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
    }

    public function destroy(Job $job)
    {
        // Authorize request
        // Delete the job
        $job->delete();
        //short variant of previous 2 commands
        //Job::findOrFail($id)->delete();

        // Redirect
        return redirect('/jobs');
    }
}


// Index(old)
//Route::get('/jobs', function () {
//    $jobs = Job::with('employer')->latest()->simplePaginate(3);
//
//    return view('jobs.index', [
//        'jobs' => $jobs
//    ]);
//});


// Old show (new show in controller as well)
/*Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);

   return view('jobs.show', ['job' => $job]);
}); */
