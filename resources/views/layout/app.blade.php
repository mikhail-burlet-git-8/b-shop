<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', env('APP_NAME'))</title>
    @vite([
    'resources/css/app.css',
    'resources/sass/main.sass'
    ])
</head>
<body>

@include('shared.flash')
@include('shared.header')
@yield('content')
@include('shared.footer')
@include('shared.mobile_menu')
</body>

@vite([
'resources/js/app.js',
])
</html>
