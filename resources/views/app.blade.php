<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="canonical" href="{{ preg_replace('/\/amp$/iu', '', url()->current()) }}">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon-192x192.png') }}" sizes="192x192">
        <link rel="apple-touch-icon" type="image/png" href="{{ asset('images/favicon-180x180.png') }}">
        <meta name="msapplication-TileImage" content="{{ asset('images/favicon-270x270.png') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="format-detection" content="telephone=no">
        <title inertia>{{ config('app.name') }}</title>
        @routes
        @viteReactRefresh
        @vite('resources/ts/app.tsx')
        @inertiaHead
    </head>
    <body class="bg-white font-sans break-words text-gray-700">
        @inertia
    </body>
</html>
