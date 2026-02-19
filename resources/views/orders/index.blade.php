@extends('layouts.app')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Orders List</h5>
        <a href="{{ url('/orders/create') }}" class="btn btn-primary btn-sm">+ Add Order</a>
    </div>

    <div class="card-body">

        @if($orders->isEmpty())
            <div class="alert alert-warning">No orders found.</div>
        @endif

        @foreach($orders as $order)
            <div class="border rounded p-3 mb-4">

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Order No:</strong> {{ $order->order_no }}</div>
                    <div class="col-md-4"><strong>Store ID:</strong> {{ $order->store_id }}</div>
                    <div class="col-md-4"><strong>Customer:</strong> {{ $order->customer_name }}</div>
                </div>

                <table class="table table-bordered table-sm mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th width="100">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endforeach

    </div>
</div>
@endsection
