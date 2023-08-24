<?php

namespace App\UseCases\Order;


use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class UpdateOrderUseCase
{
    /**
     * @throws \Throwable
     */
    public function __invoke(array $orderData, string $uuid)
    {
        $order = Order::where('uuid',$uuid)->firstOrFail();
        return DB::transaction(function () use ($order, $orderData) {
            $products = $orderData['products'];
            $calOrderAmountUseCase = new CalcOrderAmountUseCase();

            $totalAmount = $calOrderAmountUseCase($products);

            $orderStatus = OrderStatus::where('uuid', $orderData['order_status_id'])->first();

            $order->update([
                'order_status_id' => $orderStatus->uuid ?? $order->order_status_uuid,
                'products' => $products, // Store the array of products as-is
                'address' => $orderData['address'],
                'delivery_fee' => $orderData['delivery_fee'],
                'amount' => $totalAmount,
            ]);

            return $order;
        });
    }
}
