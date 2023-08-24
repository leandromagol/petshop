<?php

namespace Tests\UseCases\Order;
use App\Models\Order;
use App\UseCases\Order\ListOrdersUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListOrdersUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function testListOrders()
    {
        Order::factory()->count(15)->create();

        $listOrdersUseCase = new ListOrdersUseCase();

        $ordersPaginator = $listOrdersUseCase([]);

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $ordersPaginator);

        $this->assertCount(10, $ordersPaginator->items());
    }
}
