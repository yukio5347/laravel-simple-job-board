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
        @include('shared.meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('description')">
        <title>@yield('title')</title>
    </head>
    <body class="bg-white font-sans break-words text-gray-700">
        @include('shared.header')
        <main class="container my-10">
            @yield('content')
        </main>
        @include('shared.footer')
    </body>
</html>
