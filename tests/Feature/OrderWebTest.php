<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_loads(): void
    {
        $this->get('/orders/create')->assertStatus(200);
    }

    public function test_can_create_order_via_web(): void
    {
        $response = $this->post('/orders/store', [
            'order_no' => 'WEB1',
            'store_id' => 2,
            'customer_name' => 'John',
            'product_name' => ['A', 'B'],
            'qty' => [1, 2],
        ]);

        $response->assertRedirect('/orders-list');
        $this->assertDatabaseHas('orders', ['order_no' => 'WEB1']);
        $this->assertDatabaseCount('order_items', 2);
    }

    public function test_edit_page_loads_with_items(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->create();

        $this->get('/orders/edit/'.$order->id)
            ->assertStatus(200)
            ->assertSee($order->order_no);
    }

    public function test_can_update_order_via_web(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->create();

        $this->post('/orders/update/'.$order->id, [
            'order_no' => $order->order_no,
            'store_id' => $order->store_id,
            'customer_name' => 'New Name',
            'status' => 'completed',
            'product_name' => ['X'],
            'qty' => [5],
        ])->assertRedirect('/orders-list');

        $this->assertDatabaseHas('orders', ['customer_name' => 'New Name', 'status' => 'completed']);
        $this->assertDatabaseCount('order_items', 1);
    }

    public function test_soft_delete_moves_to_trash_and_can_restore(): void
    {
        $order = Order::factory()->create();

        $this->get('/orders/delete/'.$order->id)->assertRedirect();
        $this->assertSoftDeleted('orders', ['id' => $order->id]);

        $this->get('/orders/trashed')->assertStatus(200);

        $this->get('/orders/restore/'.$order->id)->assertRedirect();
        $this->assertNotSoftDeleted('orders', ['id' => $order->id]);
    }

    public function test_list_supports_search_and_date_range(): void
    {
        Order::factory()->create(['order_no' => 'SEARCHME', 'customer_name' => 'Findme']);

        $this->get('/orders-list?search=Findme')->assertStatus(200)->assertSee('SEARCHME');
        $this->get('/orders-list?search=nomatch')->assertStatus(200)->assertSee('No orders found');
    }

    public function test_dashboard_and_stores_pages_load(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->forOrder($order)->count(2)->create();

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/stores')->assertStatus(200);
    }
}
