@extends('layout')
@section('title', config('meta.home.title'))
@section('description', config('meta.home.description'))

@section('content')
    @if ($jobPostings->isEmpty())
        <p>{{ __('Jobs not found.') }}</p>
    @else
        <div class="grid gap-5 md:grid-cols-2">
        @foreach ($jobPostings as $jobPosting)
            <a href="{{ route('jobs.show', $jobPosting) }}" class="flex flex-col justify-between p-4 border rounded-lg transition-colors lg:hover:border-sky-500">
                <div class="flex-1">
                    <h3 class="font-semibold leading-tight mb-1">{{ $jobPosting->title }}</h3>
                    <p class="text-sm text-sky-500 font-semibold mb-2">{{ $jobPosting->company_name }}</p>
                @if ($jobPosting->short_work_place)
                    <p class="flex items-center text-xs text-gray-500 mb-1 home:lg:text-sm">
                        @include('icons.map') {{ $jobPosting->short_work_place }}
                    </p>
                @endif
                @if ($jobPosting->short_salary)
                    <p class="flex items-center text-xs text-gray-500 mb-1">
                        @include('icons.money') {{ $jobPosting->short_salary }}
                    </p>
                @endif
                </div>
                <div class="mt-3 flex justify-between items-center text-xs">
                    <span class="{{ $jobPosting->employment_type_color }} rounded font-medium py-1 px-2">
                        {{ $jobPosting->employment_type_text }}
                    </span>
                    <div>
                        {{ $jobPosting->created_at->diffForHumans() }}
                    </div>
                </div>
            </a>
        @endforeach
        </div>
        <div class="my-10 text-center">
            <a href="{{ route('jobs.index') }}" class="py-4 px-6 rounded-md bg-sky-500 text-white text-lg font-semibold transition-colors hover:bg-sky-600">{{ __('View All Jobs') }}</a>
        </div>
    @endif
@endsection
