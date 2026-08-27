<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;

class StoreController extends Controller
{
    // Compoships showcase: stores with their products (composite key relation)
    public function index()
    {
        $stores = Store::with('products')->get();

        return view('stores.index', compact('stores'));
    }

    // Multi-store dashboard summary using composite keys
    public function dashboard()
    {
        $orders = Order::with('items')->get();

        $stores = $orders
            ->groupBy('store_id')
            ->map(function ($group) {
                return (object) [
                    'store_id' => $group->first()->store_id,
                    'orders_count' => $group->count(),
                    'items_count' => $group->sum(fn ($o) => $o->items->count()),
                    'total_qty' => $group->sum(fn ($o) => $o->items->sum('qty')),
                    'completed' => $group->where('status', 'completed')->count(),
                    'pending' => $group->where('status', 'pending')->count(),
                ];
            })
            ->values();

        return view('stores.dashboard', compact('stores'));
    }
}
