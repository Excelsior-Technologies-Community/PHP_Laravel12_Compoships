<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
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
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'order_no' => $request->order_no,
            'store_id' => $request->store_id,
            'customer_name' => $request->customer_name,
            'status' => $request->status ?? 'pending',
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

    // Edit page
    public function edit($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.edit', compact('order'));
    }

    // Update order + items
    public function update(UpdateOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);

        $originalOrderNo = $order->getOriginal('order_no');
        $originalStoreId = $order->getOriginal('store_id');

        $order->update($request->only('order_no', 'store_id', 'customer_name', 'status'));

        if ($request->has('product_name') && $request->has('qty')) {
            OrderItem::where([
                'order_no' => $originalOrderNo,
                'store_id' => $originalStoreId,
            ])->forceDelete();

            foreach ($request->product_name as $i => $product) {
                OrderItem::create([
                    'order_no' => $order->order_no,
                    'store_id' => $order->store_id,
                    'product_name' => $product,
                    'qty' => $request->qty[$i],
                ]);
            }
        }

        return redirect('/orders-list')
            ->with('success', 'Order updated successfully');
    }

    // List + search + date range + pagination
    public function list(Request $request)
    {
        $search = $request->search;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $orders = Order::with('items')
            ->when($search, function ($query) use ($search) {
                $query->where('order_no', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('store_id', 'like', "%{$search}%");
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('id', 'asc')
            ->paginate(4)
            ->withQueryString();

        // Dashboard Statistics
        $totalOrders = Order::count();

        $completedOrders = Order::where('status', 'completed')->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $totalProducts = OrderItem::sum('qty');

        return view('orders.index', compact(
            'orders',
            'search',
            'dateFrom',
            'dateTo',
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

    // Soft delete order + items
    public function delete($id)
    {
        $order = Order::findOrFail($id);

        OrderItem::where([
            'order_no' => $order->order_no,
            'store_id' => $order->store_id,
        ])->delete();

        $order->delete();

        return back()->with('success', 'Order deleted (moved to trash)');
    }

    // Restore soft-deleted order + items
    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);

        $order->restore();

        OrderItem::where([
            'order_no' => $order->order_no,
            'store_id' => $order->store_id,
        ])->withTrashed()->restore();

        return back()->with('success', 'Order restored successfully');
    }

    // List soft-deleted orders (trash)
    public function trashed()
    {
        $orders = Order::onlyTrashed()
            ->with('items')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('orders.trashed', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function exportCsv()
    {
        $fileName = 'orders_'.date('Ymd_His').'.csv';

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
                'Quantity',
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
                        $item->qty,
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
