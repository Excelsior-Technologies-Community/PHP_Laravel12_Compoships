<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComposhipsRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_has_items_via_composite_key(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->count(3)->create();

        $this->assertCount(3, $order->items);
        $this->assertEquals($order->order_no, $order->items->first()->order_no);
        $this->assertEquals($order->store_id, $order->items->first()->store_id);
    }

    public function test_order_total_qty_and_items_accessors(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->create(['qty' => 2]);
        OrderItem::factory()->forOrder($order)->create(['qty' => 3]);

        $this->assertEquals(5, $order->total_qty);
        $this->assertEquals(2, $order->total_items);
    }

    public function test_store_has_products_via_composite_key(): void
    {
        $store = Store::factory()->create();
        Product::factory()->forStore($store)->count(2)->create();

        $this->assertCount(2, $store->products);
        $this->assertEquals($store->region, $store->products->first()->region);
        $this->assertEquals($store->code, $store->products->first()->store_code);
    }

    public function test_product_belongs_to_store_via_composite_key(): void
    {
        $store = Store::factory()->create();
        $product = Product::factory()->forStore($store)->create();

        $this->assertNotNull($product->store);
        $this->assertEquals($store->id, $product->store->id);
    }
}
