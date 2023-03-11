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
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Pass variables
        $this->middleware(function ($request, $next) {
            Inertia::share('employmentTypes', function() {
                $employmentTypes = JobPosting::EMPLOYMENT_TYPE;
                return array_combine($employmentTypes, array_map(fn(string $k): string => __($k), $employmentTypes));
            });
            Inertia::share('salaryUnit', function() {
                $salaryUnit = JobPosting::SALARY_UNIT;
                return array_combine($salaryUnit, array_map(fn(string $k): string => __($k), $salaryUnit));
            });
            return $next($request);
        })->only(['create', 'edit']);

        // Verify password
        $this->middleware(function ($request, $next) {
            if (
                $request->email === $request->job->email &&
                Hash::check($request->password, $request->job->password)
            ) {
                return $next($request);
            }

            return back()->withInput($request->except('password'))->withErrors([
                'email' => __('auth.failed'),
                'password'=>  ' ',
            ]);
        })->only(['update', 'destroy']);
    }

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
        return Inertia::render('Jobs/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\JobPostingRequest  $request
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
        return Inertia::render('Jobs/Edit', [
            'jobPosting' => $jobPosting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\JobPostingRequest  $request
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function update(JobPostingRequest $request, JobPosting $jobPosting)
    {
        $validated = $request->validated();
        unset($validated['name']);
        unset($validated['email']);
        unset($validated['password']);
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $jobPosting->fill($validated)->save();
        $request->session()->flash('message', __('Your job has been successfully updated!'));

        return redirect()->route('jobs.edit', $jobPosting);
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
