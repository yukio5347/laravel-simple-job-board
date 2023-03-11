<?php

namespace App\Http\Requests;

use App\Models\JobApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobApplicationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:job_applications',
            'telephone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'gender' => [Rule::in(JobApplication::GENDER), 'nullable'],
            'summary' => 'required|string|max:20000',
            'education' => 'nullable|string|max:20000',
            'work_history' => 'nullable|string|max:20000',
            'certificates' => 'nullable|string|max:20000',
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
            'email.unique' => __('You have already applied for this job.'),
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
            'telephone' => __('Telephone'),
            'address' => __('Address'),
            'birthday' => __('Birthday'),
            'gender' => __('Gender'),
            'summary' => __('Summary'),
            'education' => __('Education'),
            'work_history' => __('Work History'),
            'certificates' => __('Skills and Certificates'),
        ];
    }
}
