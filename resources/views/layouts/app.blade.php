<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 Compoships</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f8f9fa; }
        .card { border-radius: 10px; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Laravel 12 Compoships</a>
        <a href="{{ url('/orders-list') }}" class="btn btn-outline-light btn-sm">Orders</a>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>
