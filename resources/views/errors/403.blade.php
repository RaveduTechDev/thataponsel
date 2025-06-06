<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Forbidden')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="text-center">
        <h1 class="display-1 text-danger">@yield('code', '403')</h1>
        <h2 class="mb-4">@yield('title', 'Forbidden')</h2>
        <p class="lead">@yield('message', 'Anda tidak memiliki izin untuk mengakses halaman ini.')</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Go to Homepage</a>
    </div>
</body>

</html>
