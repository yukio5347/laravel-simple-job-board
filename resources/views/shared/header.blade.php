<header class="bg-sky-500 py-5">
    <div class="flex flex-col md:container md:flex-row md:justify-between">
        <a href="{{ route('home') }}" class="flex-none text-lg text-center inline-block text-white font-semibold md:text-left">{{ config('app.name') }}</a>
        <div class="flex-1 mt-4 flex justify-between md:items-end md:justify-end md:m-0">
            <a href="{{ route('home') }}" class="hidden font-medium text-white md:flex items-center justify-center">
                {{ __('Home') }}
            </a>
            <a href={{ route('jobs.index') }} class="w-1/2 flex items-center justify-center font-medium text-white md:w-auto md:ml-8 lg:ml-12">
                @include('icons.search') {{ __('Find Jobs') }}
            </a>
            <a href={{ route('jobs.create') }} class="w-1/2 flex items-center justify-center font-medium text-white md:w-auto md:ml-8 lg:ml-12">
                @include('icons.file') {{ __('Post a Job') }}
            </a>
        </div>
    </div>
</header>
