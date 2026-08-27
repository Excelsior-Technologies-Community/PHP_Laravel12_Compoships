@extends('layouts.app')

@section('content')

<style>
    .summary-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
</style>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="page-title fw-bold fs-4">📊 Multi-Store Dashboard</div>
        <a href="{{ url('/stores') }}" class="btn btn-dark btn-sm">🏬 Stores</a>
    </div>

    @if($stores->count() == 0)
        <div class="alert alert-warning text-center">No orders yet.</div>
    @endif

    <div class="row">
        @foreach($stores as $store)
        <div class="col-md-6">
            <div class="summary-card">
                <h5>Store #{{ $store->store_id }}</h5>
                <hr>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="text-muted small">Orders</div>
                        <h4>{{ $store->orders_count }}</h4>
                    </div>
                    <div class="col-4">
                        <div class="text-muted small">Items</div>
                        <h4>{{ $store->items_count }}</h4>
                    </div>
                    <div class="col-4">
                        <div class="text-muted small">Total Qty</div>
                        <h4 class="text-primary">{{ $store->total_qty }}</h4>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-around small">
                    <span class="text-success">Completed: {{ $store->completed }}</span>
                    <span class="text-warning">Pending: {{ $store->pending }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection
