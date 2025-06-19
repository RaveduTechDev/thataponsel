<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <img src="@yield('image')" alt="@yield('title')" class="img-fluid" style="max-width: 400px; width: 100%;">
            <h2 style="margin-top:-2rem; z-index:10;">@yield('title')</h2>
            <p class="lead">@yield('message')</p>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>

</html>
