<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 Compoships</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
        }

        .container {
            margin-top: 25px;
        }

        /* Card */
        .card {
            background: rgba(255, 255, 255, 0.92);
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
        }

        .card-header {
            background: rgba(255,255,255,0.6);
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        .btn-outline-light {
            border-radius: 10px;
            color: #fff;
            border: 1px solid #fff;
        }

        /* ALERT */
        .alert {
            border-radius: 12px;
        }

        /* =========================
           🚀 MODERN TABLE DESIGN
        ==========================*/

        .table {
            border: none;
            background: transparent;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            background: #ffffff;
            margin-bottom: 15px;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .table tbody tr:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .table td {
            display: block;
            border: none !important;
            padding: 6px 0;
            font-size: 14px;
        }

        .table td::before {
            font-weight: 600;
            color: #6b7280;
            display: inline-block;
            width: 120px;
        }

        .table td:nth-child(1)::before { content: "#"; }
        .table td:nth-child(2)::before { content: "Product"; }
        .table td:nth-child(3)::before { content: "Qty"; }

        .order-box {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 14px;
            background: rgba(255,255,255,0.85);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand">⚡ Laravel 12 Compoships</a>
        <div class="d-flex gap-2">
            <a href="{{ url('/orders-list') }}" class="btn btn-outline-light btn-sm">Orders</a>
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="{{ url('/stores') }}" class="btn btn-outline-light btn-sm">Stores</a>
            <a href="{{ url('/orders/trashed') }}" class="btn btn-outline-light btn-sm">Trash</a>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>