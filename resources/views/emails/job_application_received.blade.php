{!! $jobApplication->jobPosting->name !!} 様

{{ __('Received a new application for :title', ['title' => $jobApplication->JobPosting->title]) }}

[Applicant information]
- {{ __('Name') }}: {!! $jobApplication->name !!}
- {{ __('Email') }}: {!! $jobApplication->email !!}
@if ($jobApplication->telephone)
- {{ __('Telephone') }}: {!! $jobApplication->telephone !!}
@endif
@if ($jobApplication->address)
- {{ __('Address') }}: {!! $jobApplication->address !!}
@endif
@if ($jobApplication->birthday)
- {{ __('Birthday') }}: {!! $jobApplication->birthday !!}
@endif
@if ($jobApplication->gender)
- {{ __('Gender') }}: {!! $jobApplication->gender !!}
@endif
@if ($jobApplication->education)
- {{ __('Summary') }}: {!! $jobApplication->summary !!}
- {{ __('Education') }}: {!! $jobApplication->education !!}
@endif
@if ($jobApplication->work_history)
- {{ __('Work History') }}: {!! $jobApplication->work_history !!}
@endif
@if ($jobApplication->certificates)
- {{ __('Skills and Certificates') }}: {!! $jobApplication->certificates !!}
@endif

[Job information]
- {{ __('Job Title') }}: {!! $jobApplication->jobPosting->title !!}
- {{ __('Employment Type') }}: {!! $jobApplication->jobPosting->employment_type_text !!}
- {{ __('Work Place') }}: {!!  $jobApplication->jobPosting->work_place !!}
- {{ __('Salary') }}: {!! $jobApplication->jobPosting->salary !!}
- {{ __('Job Description') }}: {!! $jobApplication->jobPosting->description !!}
- {{ __('Company Name') }}: {!! $jobApplication->jobPosting->company_name !!}
- {{ __('Company Description') }}: {!! $jobApplication->jobPosting->company_description !!}
- {{ __('Name') }}: {!! $jobApplication->jobPosting->name !!}
- {{ __('Email') }}: {!! $jobApplication->jobPosting->email !!}

───────────────────────────
{{ config('app.name') }}
{{ config('app.url') }}
