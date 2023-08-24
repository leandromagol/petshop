<?php

namespace App\UseCases\Order;

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
    public function __invoke(array $orderData)
    {
        return DB::transaction(function () use ($orderData) {
            $products = $orderData['products'];
            $calOrderAmountUseCase = new CalcOrderAmountUseCase();

            $totalAmount = $calOrderAmountUseCase($products);

            $orderOpened = OrderStatus::where('title','open')->first();
            return Order::create([
                'user_id' => Auth::user()->uuid,
                'order_status_id' => $orderOpened->uuid,
                'uuid' => Str::uuid()->toString(),
                'products' => $products, // Store the array of products as-is
                'address' => $orderData['address'],
                'delivery_fee' => $orderData['delivery_fee'],
                'amount' => $totalAmount,
            ]);
        });
    }
}
