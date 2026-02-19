<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $order = Order::create([
        'order_no' => 'ORD-1001',
        'store_id' => 1,
        'customer_name' => 'Rahul Patel'
    ]);

    OrderItem::create([
        'order_no' => 'ORD-1001',
        'store_id' => 1,
        'product_name' => 'Laptop',
        'qty' => 1
    ]);

    OrderItem::create([
        'order_no' => 'ORD-1001',
        'store_id' => 1,
        'product_name' => 'Mouse',
        'qty' => 2
    ]);
}
}
