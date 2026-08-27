<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Composite-key demo: stores + products
        $stores = Store::factory()->count(3)->create();

        foreach ($stores as $store) {
            Product::factory()->forStore($store)->count(3)->create();
        }

        // Orders + items (Compoships relationship)
        Order::factory()->count(15)->create()->each(function ($order) {
            $count = rand(1, 4);
            OrderItem::factory()->forOrder($order)->count($count)->create();
        });
    }
}
