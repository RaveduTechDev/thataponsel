<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Thata Ponsel - Aplikasi Sistem Manajemen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    @vite('resources/assets/static/js/initTheme.js')
    <div id="app">
        @yield('login')
    </div>
    </div>
</body>

</html>
