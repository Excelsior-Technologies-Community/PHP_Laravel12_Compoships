<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_orders(): void
    {
        Order::factory()->count(3)->create();

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    public function test_can_create_order_with_items(): void
    {
        $payload = [
            'order_no' => 'ORD-1',
            'store_id' => 1,
            'customer_name' => 'Test Customer',
            'status' => 'pending',
            'items' => [
                ['product_name' => 'A', 'qty' => 2],
                ['product_name' => 'B', 'qty' => 3],
            ],
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201)->assertJsonPath('data.total_qty', 5);
        $this->assertDatabaseCount('order_items', 2);
    }

    public function test_validation_fails_when_items_missing(): void
    {
        $response = $this->postJson('/api/orders', [
            'order_no' => 'X',
            'store_id' => 1,
            'customer_name' => 'T',
        ]);

        $response->assertStatus(422);
    }

    public function test_can_update_order(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->create();

        $response = $this->putJson('/api/orders/'.$order->id, [
            'customer_name' => 'Updated Name',
            'items' => [['product_name' => 'C', 'qty' => 1]],
        ]);

        $response->assertStatus(200)->assertJsonPath('data.customer_name', 'Updated Name');
        $this->assertDatabaseCount('order_items', 1);
    }

    public function test_can_soft_delete_and_restore(): void
    {
        $order = Order::factory()->create();

        $this->deleteJson('/api/orders/'.$order->id)->assertStatus(200);
        $this->assertSoftDeleted('orders', ['id' => $order->id]);

        $this->postJson('/api/orders/'.$order->id.'/restore')->assertStatus(200);
        $this->assertNotSoftDeleted('orders', ['id' => $order->id]);
    }

    public function test_api_resource_returns_nested_items(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->count(2)->create();

        $response = $this->getJson('/api/orders/'.$order->id);

        $response->assertStatus(200)->assertJsonCount(2, 'data.items');
    }
}
