<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostingRequest;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
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
        $this->middleware('active')->only(['show', 'edit', 'update', 'destroyConfirm', 'destroy']);

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
            'paginator' => JobPosting::active()->orderBy('id', 'desc')->paginate(20),
            'title' => config('meta.jobs.index.title'),
            'description' => config('meta.jobs.index.description'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobPosting = JobPosting::make([
            'employment_type' => 'FULL_TIME',
            'is_remote' => false,
            'closed_at' => today()->addDays(30),
            'salary_min' => 0,
            'salary_unit' => 'MONTH',
        ]);

        return Inertia::render('Jobs/Form', [
            'jobPosting' => $jobPosting,
            'title' => config('meta.jobs.create.title'),
            'description' => config('meta.jobs.create.description'),
        ]);
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
        session()->flash('message', __('Your job has been successfully posted!'));

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
        $keys = [
            '[TITLE]' => 'title',
            '[COMPANY]' => 'company_name',
            '[REGION]' => 'region',
            '[LOCALITY]' => 'locality',
            '[EMPLOYMENT_TYPE]' => 'employment_type',
        ];
        $title = config('meta.jobs.show.title');
        foreach ($keys as $key => $property) {
            $title = str_replace($key, $jobPosting->$property, $title);
        }
        $description = config('meta.jobs.show.description');
        foreach ($keys as $key => $property) {
            $description = str_replace($key, $jobPosting->$property, $description);
        }
        return view('jobs.show', [
            'jobPosting' => $jobPosting,
            'title' => $title,
            'description' => $description,
            'amp' => Route::currentRouteName() === 'jobs.show.amp',
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
        return Inertia::render('Jobs/Form', [
            'jobPosting' => $jobPosting,
            'title' => config('meta.jobs.edit.title'),
            'description' => '',
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
        session()->flash('message', __('Your job has been successfully updated!'));

        return redirect()->route('jobs.index');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function destroyConfirm(JobPosting $jobPosting)
    {
        return Inertia::render('Jobs/Delete', [
            'jobPosting' => $jobPosting,
            'title' => config('meta.jobs.destroy.title'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPosting  $jobPosting
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();
        session()->flash('message', __('Your job has been deleted.'));
        return redirect()->route('jobs.index');
    }
}
