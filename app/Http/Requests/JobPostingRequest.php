<?php

namespace App\Http\Requests;

use App\Models\JobPosting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class JobPostingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'required', 'string', 'max:40',
                Rule::unique('job_postings')->where(fn ($query) => $query->where('company_name', $this->company_name))->ignore($this->job),
            ],
            'description' => 'required|string|max:20000',
            'closed_at' => 'required|date|before_or_equal:' . today()->addDays(90)->format('Y-m-d'),
            'employment_type' => [Rule::in(JobPosting::EMPLOYMENT_TYPE), 'required'],
            'is_remote' => 'required|boolean',
            'address' => 'required_unless:is_remote,1|nullable|string|max:255',
            'locality' => 'required_unless:is_remote,1|nullable|string|max:255',
            'region' => 'required_unless:is_remote,1|nullable|string|max:255',
            'postal_code' => 'required_unless:is_remote,1|nullable|string|max:255',
            'salary_min' => 'required|integer',
            'salary_max' => 'nullable|integer',
            'salary_unit' => [Rule::in(JobPosting::SALARY_UNIT), 'required'],
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string|max:20000',
            'name' => [
                'nullable', 'string', 'max:255',
                Rule::requiredIf(Route::currentRouteName() === 'jobs.create'),
            ],
            'email' => 'required|string|email:rfc,dns|max:255',
            'password' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.unique' => __('Your company has already posted ":title".', ['title' => $this->title]),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => __('Job Title'),
            'description' => __('Job Description'),
            'closed_at' => __('Close Date'),
            'employment_type' => __('Employment Type'),
            'is_remote' => __('Remote'),
            'address' => __('Address'),
            'locality' => __('City'),
            'region' => __('Region'),
            'postal_code' => __('Postal Code'),
            'salary_min' => __('Min. Salary'),
            'salary_max' => __('Max. Salary'),
            'salary_unit' => __('Salary Unit'),
            'company_name' => __('Company Name'),
            'company_description' => __('Company Description'),
        ];
    }
}
