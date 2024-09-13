<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/operating-system-97851_1920.png') }}" type="image/x-icon">
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        @vite('resources/css/app.css')
        @livewireStyles
    </head>
    <body>
        @yield('content')
        @livewireScripts
    </body>
</html>
