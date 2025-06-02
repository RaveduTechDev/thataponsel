<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('logo-thata-png-col.png') }}" type="image/x-icon">

    <title>Thata Ponsel - Aplikasi Sistem Manajemen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    @vite('resources/assets/static/js/initTheme.js')
    <section id="app">
        @yield('login')
    </section>
    </div>

    @stack('scripts')
</body>

</html>
