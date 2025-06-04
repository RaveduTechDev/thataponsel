<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('logo-thata-png-col.png') }}" type="image/x-icon">

    <title>Thata Ponsel - Aplikasi Sistem Manajemen</title>

    @stack('css')

    <link rel="stylesheet" href="{{ asset('build/assets/app-BSrKn4mZ.css') }}">
    <script type="module" src="{{ asset('build/assets/app-iFDSrMtn.js') }}" defer></script>

</head>

<body>
    {{-- @vite('resources/assets/static/js/initTheme.js') --}}
    <script src="{{ asset('build/assets/initTheme-BJZlHDHJ.js') }}"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            @include('components.layouts.header')

            <div class="content-wrapper container">
                @yield('content')
            </div>

            @include('components.layouts.footer')
        </div>
    </div>
    @stack('scripts')
</body>

</html>
