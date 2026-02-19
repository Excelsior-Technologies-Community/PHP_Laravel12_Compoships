<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
{
    return view('orders.create');
}

public function store(Request $request)
{
    $request->validate([
        'order_no' => 'required',
        'store_id' => 'required',
        'customer_name' => 'required',
        'product_name.*' => 'required',
        'qty.*' => 'required|integer|min:1',
    ]);

    Order::create($request->only('order_no','store_id','customer_name'));

    foreach ($request->product_name as $i => $product) {
        OrderItem::create([
            'order_no' => $request->order_no,
            'store_id' => $request->store_id,
            'product_name' => $product,
            'qty' => $request->qty[$i],
        ]);
    }

   return redirect('/orders-list')
        ->with('success', 'Order created successfully');

}

public function list()
{
    $orders = Order::with('items')->get();
    return view('orders.index', compact('orders'));
}


    public function index()
    {
        return Order::with('items')->get();
    }
    
}
