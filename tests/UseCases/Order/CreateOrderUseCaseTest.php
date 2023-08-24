<?php

namespace Tests\UseCases\Order;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\UseCases\Order\CreateOrderUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

use Tests\TestCase;

class CreateOrderUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('user')->andReturn($user);
        $orderStatus = OrderStatus::factory()->create(['title' => 'open']);
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();
        $orderData = [
            'products' => [
                ['product' => $product1->uuid, 'quantity' => 2],
                ['product' => $product2->uuid, 'quantity' => 3],
            ],
            'address' => [
                'billing' => 'Billing Address',
                'shipping' => 'Shipping Address',
            ],
            'delivery_fee' => 10.00,
        ];

        $createOrderUseCase = new CreateOrderUseCase();
        $order = $createOrderUseCase($orderData);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($user->uuid, $order->user_id);
        $this->assertEquals($orderStatus->uuid, $order->order_status_id);
        $this->assertEquals(2 * $product1->price + 3 * $product2->price, $order->amount);
        $this->assertEquals($orderData['address'], $order->address);

        $this->assertDatabaseHas('orders', [
            'uuid' => $order->uuid,
        ]);
    }
}
