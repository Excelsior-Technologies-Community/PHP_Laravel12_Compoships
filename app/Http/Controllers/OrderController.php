<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Redirect old route (optional safe)
    public function index()
    {
        return redirect('/orders-list');
    }

    // Create page
    public function create()
    {
        return view('orders.create');
    }

    // Store order + items
    public function store(Request $request)
    {
        $request->validate([
            'order_no' => 'required',
            'store_id' => 'required',
            'customer_name' => 'required',
            'product_name.*' => 'required',
            'qty.*' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'order_no' => $request->order_no,
            'store_id' => $request->store_id,
            'customer_name' => $request->customer_name,
            'status' => 'pending',
        ]);

        foreach ($request->product_name as $i => $product) {
            OrderItem::create([
                'order_no' => $order->order_no,
                'store_id' => $order->store_id,
                'product_name' => $product,
                'qty' => $request->qty[$i],
            ]);
        }

        return redirect('/orders-list')
            ->with('success', 'Order created successfully');
    }

    // List + search + pagination
    public function list(Request $request)
    {
        $search = $request->search;

        $orders = Order::with('items')
            ->when($search, function ($query) use ($search) {
                $query->where('order_no', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('store_id', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(4);

        // Dashboard Statistics
        $totalOrders = Order::count();

        $completedOrders = Order::where('status', 'completed')->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $totalProducts = OrderItem::sum('qty');

        return view('orders.index', compact(
            'orders',
            'search',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalProducts'
        ));
    }

    // Toggle status
    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);

        $order->status = $order->status === 'pending' ? 'completed' : 'pending';
        $order->save();

        return back()->with('success', 'Status updated successfully');
    }

    // Delete order + items
    public function delete($id)
    {
        $order = Order::findOrFail($id);

        OrderItem::where([
            'order_no' => $order->order_no,
            'store_id' => $order->store_id
        ])->delete();

        $order->delete();

        return back()->with('success', 'Order deleted successfully');
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function exportCsv()
    {
        $fileName = 'orders_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Order No',
                'Store ID',
                'Customer',
                'Status',
                'Product',
                'Quantity'
            ]);

            $orders = Order::with('items')->get();

            foreach ($orders as $order) {

                foreach ($order->items as $item) {

                    fputcsv($file, [
                        $order->order_no,
                        $order->store_id,
                        $order->customer_name,
                        $order->status,
                        $item->product_name,
                        $item->qty
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
