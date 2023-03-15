@extends('layout')
@section('title', $title)
@section('description', $description)

@section('content')
<div class="mb-8 bg-white border-b md:border md:rounded-lg">
    <div class="flex justify-between pb-5 px-1 border-b md:p-7 xl:p-10">
        <div class="flex-1">
            <h1 class="text-lg font-semibold leading-tight mb-2">{{ $jobPosting->title }}</h1>
            <p class="text-sky-500 font-semibold mb-3">{{ $jobPosting->company_name }}</p>
        @if ($jobPosting->short_work_place)
            <p class="flex items-center text-sm text-gray-500 mb-1 home:lg:text-sm">
                @include('icons.map') {{ $jobPosting->work_place }}
            </p>
        @endif
        @if ($jobPosting->short_salary)
            <p class="flex items-center text-sm text-gray-500 mb-1">
                @include('icons.money') {{ $jobPosting->salary }}
            </p>
        @endif
            <div class="mt-3 flex justify-between items-center text-xs">
                <span class="{{ $jobPosting->employment_type_color }} rounded font-medium py-1 px-2">
                    {{ $jobPosting->employment_type_text }}
                </span>
                <div>
                    {{ $jobPosting->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-5 px-1 border-b md:p-7 xl:p-10">
        <h4 class="font-semibold mb-2 text-lg md:mb-4">{{ __('Job Description') }}</h4>
        <p>{!! nl2br(e($jobPosting->description)) !!}</p>
    </div>
    <div class="py-5 px-1 border-b md:p-7 xl:p-10">
        <h4 class="font-semibold mb-2 text-lg md:mb-4">{{ __('Company Profile') }}</h4>
        <p>{!! nl2br(e($jobPosting->company_description)) !!}</p>
    </div>
    <div class="py-3 text-center">
        <a href="{{ route('jobs.apply', $jobPosting) }}" class="p-2 w-60 inline-block rounded-md text-center font-semibold bg-orange-500 text-white transition-colors md:py-3 hover:bg-orange-600" rel="nofollow">{{ __('Apply') }}</a>
    </div>
</div>
<div class="flex justify-between">
    <a href="{{ route('home') }}" class="text-sky-600">« {{ __('Back to home') }}</a>
    <a href="{{ route('jobs.index') }}" class="text-sky-600">{{ __('View All Jobs') }} »</a>
</div>

<script type="application/ld+json">
{
    "@context" : "https://schema.org/",
    "@type" : "JobPosting",
    "title" : "{!! Js::from($jobPosting->title) !!}",
    "description" : "{!! Js::from(nl2br($jobPosting->description)) !!}",
    "identifier": {
        "@type": "PropertyValue",
        "name": "{!! Js::from($jobPosting->company_name) !!}",
        "value": "{{ Str::slug($jobPosting->company_name) }}"
    },
    "datePosted" : "{{ $jobPosting->created_at->format('Y-m-d') }}",
    "validThrough" : "{{ $jobPosting->closed_at->format('Y-m-d') }}",
    "employmentType" : "{{ $jobPosting->employment_type }}",
    "hiringOrganization" : {
        "@type" : "Organization",
        "name" : "{!! Js::from($jobPosting->company_name) !!}"
    },
@if ($jobPosting->address && $jobPosting->locality && $jobPosting->region && $jobPosting->postal_code)
    "jobLocation": {
        "@type": "Place",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{!! Js::from($jobPosting->address) !!}",
            "addressLocality": "{!! Js::from($jobPosting->locality) !!}",
            "addressRegion": "{!! Js::from($jobPosting->region) !!}",
            "postalCode": "{!! Js::from($jobPosting->postal_code) !!}",
            "addressCountry": "{{ config('app.country') }}"
        }
    },
@endif
@if ($jobPosting->is_remote)
    "applicantLocationRequirements": {
        "@type": "Country",
        "name": "{{ config('app.country') }}"
    },
    "jobLocationType": "TELECOMMUTE",
@endif
    "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "{{ config('app.currency') }}",
        "value": {
            "@type": "QuantitativeValue",
        @if ($jobPosting->salary_max)
            "minValue": {{ $jobPosting->salary_min }},
            "maxValue": {{ $jobPosting->salary_max }},
        @else
            "value": {{ $jobPosting->salary_min }},
        @endif
            "unitText": "{{ $jobPosting->salary_unit }}"
        }
    }
}
</script>
@endsection
