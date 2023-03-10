<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostingRequest;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Jobs/Index', [
            'paginator' => JobPosting::active()->orderBy('id', 'desc')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employmentTypes = [];
        foreach (JobPosting::EMPLOYMENT_TYPE as $key) {
            $employmentTypes[$key] = __($key);
        }
        $salaryUnit = [];
        foreach (JobPosting::SALARY_UNIT as $key) {
            $salaryUnit[$key] = __($key);
        }
        return Inertia::render('Jobs/Create', [
            'employmentTypes' => $employmentTypes,
            'salaryUnit' => $salaryUnit,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobPostingRequest $request)
    {
        $validated = $request->validated();
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $validated['password'] = Hash::make($validated['password']);
        JobPosting::create($validated);
        $request->session()->flash('message', __('Your job has been successfully posted!'));

        return redirect()->route('jobs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function show(JobPosting $jobPosting)
    {
        return view('jobs.show', [
            'jobPosting' => $jobPosting,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPosting $jobPosting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPosting $jobPosting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPosting $jobPosting)
    {
        //
    }
}
