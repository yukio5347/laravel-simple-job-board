<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (!empty($amp)) amp @endif>
    <head>
        <meta charset="utf-8">
    @if (!empty($amp))
        <script async src="https://cdn.ampproject.org/v0.js"></script>
        <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
        <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
        @foreach (glob(public_path('build/assets/*.css')) as $css)
            <style amp-custom>
                {!! file_get_contents($css) !!}
            </style>
        @endforeach
    @else
        @vite('resources/css/app.css')
        @if (isset($jobPosting) && Route::currentRouteName() === 'jobs.show')
            <link rel="amphtml" href="{{ route('jobs.show.amp', $jobPosting) }}">
        @endif
    @endif
        <link rel="canonical" href="{{ preg_replace('/\/amp$/iu', '', url()->current()) }}">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-192x192.png') }}" sizes="192x192">
        <link rel="apple-touch-icon" type="image/png" href="{{ asset('images/favicon-180x180.png') }}">
        <meta name="msapplication-TileImage" content="{{ asset('images/favicon-270x270.png') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="format-detection" content="telephone=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('description')">
        <title>@yield('title')</title>
    </head>
    <body class="bg-white font-sans break-words text-gray-700">
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
        <main class="container my-10">
            @yield('content')
        </main>
        <footer class="bg-slate-800">
            <div class="grid grid-cols-2 gap-5 py-5 text-center md:grid-cols-4 md:container">
                <a href="{{ route('home') }}" class="text-sm text-center text-white">{{ __('Home') }}</a>
                <a href={{ route('jobs.index') }} class="text-sm text-center text-white">{{ __('Find Jobs') }}</a>
                <a href={{ route('jobs.create') }} class="text-sm text-center text-white">{{ __('Post a Job') }}</a>
                <a href={{ route('contact') }} class="text-sm text-center text-white">{{ __('Contact Us') }}</a>
            </div>
            <p class="py-3 text-xs text-white text-center border-t border-slate-500">&copy; {{ config('app.name') }}</p>
        </footer>
    </body>
</html>
