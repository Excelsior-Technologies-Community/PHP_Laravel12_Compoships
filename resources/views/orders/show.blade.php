@extends('layouts.app')

@section('content')

<style>
    .detail-card {
        background: #fff;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .info-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .info-title {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
    }

    .table-modern {
        border-radius: 12px;
        overflow: hidden;
    }

    .total-box {
        background: linear-gradient(135deg,#4f46e5,#7c3aed);
        color: white;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        margin-top: 20px;
    }

    .back-btn {
        text-decoration: none;
        border-radius: 10px;
    }
</style>

<div class="container mt-4">

    <div class="detail-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="fw-bold mb-0">
                📦 Order Details
            </h3>

            <a href="{{ url('/orders-list') }}"
               class="btn btn-dark back-btn">
                ← Back
            </a>

        </div>

        <div class="row">

            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-title">Order Number</div>
                    <div class="info-value">
                        {{ $order->order_no }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-title">Store ID</div>
                    <div class="info-value">
                        {{ $order->store_id }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-title">Customer</div>
                    <div class="info-value">
                        {{ $order->customer_name }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-box">
                    <div class="info-title">Status</div>

                    @if($order->status == 'completed')
                        <span class="badge bg-success">
                            Completed
                        </span>
                    @else
                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>
                    @endif
                </div>
            </div>

        </div>

        <div class="mb-4">
            <strong>Created At:</strong>
            {{ $order->created_at->format('d M Y h:i A') }}
        </div>

        <h5 class="mb-3">
            🛒 Ordered Products
        </h5>

        <table class="table table-bordered table-modern">

            <thead class="table-dark">

                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th width="150">Quantity</th>
                </tr>

            </thead>

            <tbody>

                @php
                    $totalQty = 0;
                @endphp

                @foreach($order->items as $item)

                    @php
                        $totalQty += $item->qty;
                    @endphp

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->product_name }}
                        </td>

                        <td>
                            {{ $item->qty }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <div class="total-box">

            <h6>Total Quantity Ordered</h6>

            <h2 class="mb-0">
                {{ $totalQty }}
            </h2>

        </div>

    </div>

</div>

@endsection