<?php

namespace App\UseCases\Order;

use App\DTO\UpdateOrderDto;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\DB;

class UpdateOrderUseCase
{
    /**
     * @param UpdateOrderDto $orderData
     * @param string $uuid
     *
     * @return Order
     *
     * @throws \Throwable
     */
    public function __invoke(UpdateOrderDto $orderData, string $uuid): Order
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        return DB::transaction(function () use ($order, $orderData) {
            $products = $orderData->products;
            $calOrderAmountUseCase = new CalcOrderAmountUseCase();

            $totalAmount = $calOrderAmountUseCase($products);

            $orderStatus = OrderStatus::where('uuid', $orderData->orderStatusId)->first();

            $order->update([
                'order_status_id' => $orderStatus->uuid ?? $order->order_status_uuid,
                'products' => $products,
                'address' => $orderData->address,
                'delivery_fee' => $orderData->deliveryFee,
                'amount' => $totalAmount,
            ]);

            return $order;
        });
    }
}
