@extends('layouts.app')

@section('content')

<style>
    .trash-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .btn-restore {
        background: #16a34a;
        color: white;
        padding: 5px 10px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
    }
</style>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="page-title fw-bold fs-4">🗑️ Trashed Orders</div>
        <a href="{{ url('/orders-list') }}" class="btn btn-dark btn-sm">← Back to Orders</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->count() == 0)
        <div class="alert alert-warning text-center">No trashed orders found.</div>
    @endif

    @foreach($orders as $order)
    <div class="trash-card">
        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
            <div>
                <span class="label fw-semibold">Order No:</span> {{ $order->order_no }}
                &nbsp;|&nbsp;
                <span class="label fw-semibold">Store:</span> {{ $order->store_id }}
                &nbsp;|&nbsp;
                <span class="label fw-semibold">Customer:</span> {{ $order->customer_name }}
                &nbsp;|&nbsp;
                <span class="text-muted">Deleted: {{ $order->deleted_at->format('d M Y h:i A') }}</span>
            </div>
            <a href="{{ url('/orders/restore/' . $order->id) }}" class="btn-restore">♻ Restore</a>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
