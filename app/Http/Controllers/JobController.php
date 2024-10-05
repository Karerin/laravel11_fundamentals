<?php

namespace App\Http\Controllers;


use App\Models\Job;
use App\Models\User;
use App\Mail\JobPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->paginate(3);

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
        // dd('hello from the post request');
        //validation..
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        Mail::to($job->employer->user)->send(
            new JobPosted($job)
        );
        return redirect('/jobs');
    }
    public function edit(Job $job)
    {

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        //1. authorize (On hold...)
        //2. validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);


        //3. update the job
        //4. and persist
        // $job = Job::findOrFail($id);//the laravel style
        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);
        //5. redirect to the job page
        return redirect('/jobs/' . $job->id);
    }
    public function destroy(Job $job)
    {
        //1. authorize (On hold...)

        //2. delete the job
        $job->delete();

        //3. redirect
        return redirect('/jobs');
    }
}
