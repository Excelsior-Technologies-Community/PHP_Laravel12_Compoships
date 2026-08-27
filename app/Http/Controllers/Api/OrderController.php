<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiStoreOrderRequest;
use App\Http\Requests\ApiUpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List orders (nested items via Compoships)
    public function index()
    {
        return OrderResource::collection(
            Order::with('items')->latest()->paginate(10)
        );
    }

    // Create order + items (Form Request validated)
    public function store(ApiStoreOrderRequest $request)
    {
        $order = Order::create($request->only(
            'order_no',
            'store_id',
            'customer_name',
            'status'
        ));

        foreach ($request->items as $item) {
            $order->items()->create($item);
        }

        return new OrderResource($order->load('items'));
    }

    // Show single order with nested items
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return new OrderResource($order);
    }

    // Update order + optional items
    public function update(ApiUpdateOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);

        $originalOrderNo = $order->getOriginal('order_no');
        $originalStoreId = $order->getOriginal('store_id');

        $order->update($request->only(
            'order_no',
            'store_id',
            'customer_name',
            'status'
        ));

        if ($request->has('items')) {
            OrderItem::where([
                'order_no' => $originalOrderNo,
                'store_id' => $originalStoreId,
            ])->forceDelete();

            foreach ($request->items as $item) {
                $order->items()->create($item);
            }
        }

        return new OrderResource($order->load('items'));
    }

    // Soft delete order + items
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->items()->delete();
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
        ], 200);
    }

    // Restore soft-deleted order + items
    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);

        $order->restore();
        $order->items()->restore();

        return new OrderResource($order->load('items'));
    }
}
