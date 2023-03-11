<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Models\JobApplication;
use App\Models\JobPosting;
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
        return Inertia::render('Jobs/Apply', [
            'jobPosting' => $jobPosting,
            'genders' => array_combine($genders, array_map(fn(string $k): string => __($k), $genders)),
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
        //
    }
}
