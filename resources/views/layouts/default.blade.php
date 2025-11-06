<!DOCTYPE html>
<html class="h-full bg-neutral-200" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'LARAPOS425')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    @yield('content')
    @stack('scripts')
</body>

</html>
