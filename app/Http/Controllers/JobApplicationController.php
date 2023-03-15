<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Mail\JobApplicationReceived;
use App\Mail\JobApplicationSent;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class JobApplicationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('active');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function create(JobPosting $jobPosting)
    {
        $genders = JobApplication::GENDER;
        $genders = array_combine($genders, array_map(fn(string $k): string => __($k), $genders));
        $genders = array_merge([null => __('- Select -')], $genders);
        return Inertia::render('Jobs/Apply', [
            'jobPosting' => $jobPosting,
            'title' => config('meta.jobs.apply.title'),
            'genders' => $genders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\JobApplicationRequest  $request
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function store(JobApplicationRequest $request, JobPosting $jobPosting)
    {
        $validated = $request->validated();
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $jobApplication = $jobPosting->jobApplications()->create($validated);
        Mail::to($validated['email'])->queue(new JobApplicationSent($jobApplication));
        Mail::to($jobApplication->jobPosting->email)->bcc(config('mail.admin'))->queue(new JobApplicationReceived($jobApplication));
        session()->flash('message', __('You have applied for ":title".', ['title' => $jobPosting->title]));

        return redirect()->route('jobs.index');
    }
}
