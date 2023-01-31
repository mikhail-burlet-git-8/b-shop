<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'B-Shop')</title>
    @vite([
    'resources/css/app.css',
    'resources/sass/main.sass'
    ])
</head>
<body>
    @include('layout.parts.header')
    @yield('content')
    @include('layout.parts.footer')
    @include('layout.parts.mobile_menu')
</body>

@vite([
'resources/js/app.js',
])
</html>
