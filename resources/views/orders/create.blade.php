@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Create Order</h5>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ url('/orders/store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Order No</label>
                            <input type="text" name="order_no" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Store ID</label>
                            <input type="number" name="store_id" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>

                    <hr>

                    <h6>Order Items</h6>

                    <div id="items">
                        <div class="row mb-2 item-row">
                            <div class="col-md-8">
                                <input type="text" name="product_name[]" class="form-control" placeholder="Product name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="qty[]" class="form-control" placeholder="Qty" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm" onclick="addItem()">+ Add Item</button>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success">Save Order</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
function addItem() {
    document.getElementById('items').insertAdjacentHTML('beforeend', `
        <div class="row mb-2 item-row">
            <div class="col-md-8">
                <input type="text" name="product_name[]" class="form-control" placeholder="Product name" required>
            </div>
            <div class="col-md-4">
                <input type="number" name="qty[]" class="form-control" placeholder="Qty" required>
            </div>
        </div>
    `);
}
</script>
@endsection
