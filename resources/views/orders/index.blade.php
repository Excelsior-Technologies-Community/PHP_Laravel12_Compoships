@extends('layouts.app')

@section('content')

    <style>
        .page-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .order-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 18px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .order-card:hover {
            transform: translateY(-4px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .order-info {
            font-size: 14px;
        }

        .label {
            font-weight: 600;
        }

        /* STATUS */
        .status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: #fff;
        }

        .pending {
            background: orange;
        }

        .completed {
            background: green;
        }

        /* ITEMS */
        .items-box {
            display: none;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
        }

        .qty {
            background: #4f46e5;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* BUTTONS */
        .btn-add {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            text-decoration: none;
        }

        .btn-small {
            padding: 5px 10px;
            border-radius: 8px;
            border: none;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-show {
            background: #111827;
            color: white;
        }

        .btn-status {
            background: #2563eb;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        /* SEARCH */
        .search-box {
            background: white;
            padding: 15px;
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            margin-bottom: 20px;
        }

        /* PAGINATION */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .page-item:first-child,
        .page-item:last-child {
            display: none;
        }

        .page-link {
            border-radius: 8px !important;
            margin: 0 3px;
        }
    </style>

    <div class="container mt-4">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="page-title">⚡ Orders Dashboard</div>

            <a href="{{ url('/orders/create') }}" class="btn-add">
                + Add Order
            </a>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- SEARCH FORM --}}
        <div class="search-box">

            <form method="GET" action="{{ url('/orders-list') }}">

                <div class="row g-2">

                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by Order No or Customer Name..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ url('/orders-list') }}" class="btn btn-dark w-100">
                            Reset
                        </a>
                    </div>

                </div>

            </form>

        </div>

        {{-- ORDERS LOOP --}}
        @foreach($orders as $order)

            <div class="order-card">

                <div class="order-header">

                    <div class="order-info">
                        <span class="label">Order No:</span>
                        {{ $order->order_no }}
                    </div>

                    <div class="order-info">
                        <span class="label">Store:</span>
                        {{ $order->store_id }}
                    </div>

                    <div class="order-info">
                        <span class="label">Customer:</span>
                        {{ $order->customer_name }}
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <span class="status {{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- STATUS BUTTON --}}
                    <a href="{{ url('/orders/status/' . $order->id) }}" class="btn-small btn-status">
                        Change Status
                    </a>

                    {{-- SHOW BUTTON --}}
                    <button class="btn-small btn-show" onclick="toggleItems('items-{{ $order->id }}', this)">
                        Show
                    </button>

                    {{-- DELETE BUTTON --}}
                    <a href="{{ url('/orders/delete/' . $order->id) }}" class="btn-small btn-delete"
                        onclick="return confirm('Are you sure you want to delete this order?')">
                        Delete
                    </a>

                </div>

                {{-- ITEMS SECTION --}}
                <div class="items-box" id="items-{{ $order->id }}">

                    @foreach($order->items as $item)

                        <div class="item-row">

                            <div>
                                🛒 {{ $item->product_name }}
                            </div>

                            <div class="qty">
                                Qty: {{ $item->qty }}
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endforeach

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>

    </div>

    <script>

        function toggleItems(id, btn) {
            let box = document.getElementById(id);

            if (box.style.display === "none" || box.style.display === "") {
                box.style.display = "block";
                btn.innerText = "Hide";
            }
            else {
                box.style.display = "none";
                btn.innerText = "Show";
            }
        }

    </script>

@endsection