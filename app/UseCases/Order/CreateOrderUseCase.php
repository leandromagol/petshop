<?php

namespace App\UseCases\Order;

use App\DTO\CreateOrderDto;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\DB;
use Str;

class CreateOrderUseCase
{
    /**
     * @throws \Throwable
     */
    public function __invoke(CreateOrderDto $orderData): Order
    {
        return DB::transaction(function () use ($orderData) {
            $products = $orderData->products;
            $calOrderAmountUseCase = new CalcOrderAmountUseCase();

            $totalAmount = $calOrderAmountUseCase($products);
            $orderOpened = OrderStatus::where('title','open')->firstOrFail();
            return Order::create([
                'user_id' => Auth::user()->uuid,// @phpstan-ignore-line
                'order_status_id' => $orderOpened->uuid,
                'uuid' => Str::uuid()->toString(),
                'products' => $products, // Store the array of products as-is
                'address' => $orderData->address,
                'delivery_fee' => $orderData->deliveryFee,
                'amount' => $totalAmount,
            ]);
        });
    }
}
