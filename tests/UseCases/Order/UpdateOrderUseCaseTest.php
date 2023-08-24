<?php

namespace Tests\UseCases\Order;


use App\Models\Order;
use App\Models\OrderStatus;
use App\UseCases\Order\UpdateOrderUseCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateOrderUseCaseTest extends TestCase
{
    use DatabaseMigrations;

    public function testUpdateOrder()
    {
        $order = Order::factory()->create();
        $orderStatus = OrderStatus::factory()->create();

        $updatedOrderData = [
            'order_status_id' => $orderStatus->uuid,
            'products' => [],
            'address' => ['billing' => '123 Main St', 'shipping' => '456 Shipping Ave'],
            'delivery_fee' => 15.0,
        ];

        $updateOrderUseCase = new UpdateOrderUseCase();

        $updatedOrder = $updateOrderUseCase($updatedOrderData, $order->uuid);

        $this->assertEquals($orderStatus->uuid, $updatedOrder->order_status_id);

    }
}
