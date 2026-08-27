@extends('layouts.app')

@section('content')

<style>
    .store-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .key-badge {
        background: #4f46e5;
        color: #fff;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .product-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 14px;
        border-top: 1px solid #e5e7eb;
    }
</style>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="page-title fw-bold fs-4">🏬 Stores & Products (Composite Key Relation)</div>
        <a href="{{ url('/dashboard') }}" class="btn btn-dark btn-sm">📊 Multi-store Dashboard</a>
    </div>

    @foreach($stores as $store)
    <div class="store-card">
        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mb-2">
            <div>
                <strong>{{ $store->name }}</strong>
                <span class="key-badge">region: {{ $store->region }}</span>
                <span class="key-badge">code: {{ $store->code }}</span>
            </div>
            <span class="text-muted">{{ $store->products->count() }} products</span>
        </div>

        @foreach($store->products as $product)
        <div class="product-row">
            <div>🛒 {{ $product->name }}</div>
            <div>₹{{ $product->price }}</div>
        </div>
        @endforeach
    </div>
    @endforeach

</div>

@endsection
