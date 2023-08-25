<?php

namespace App\UseCases\Order;

use App\Models\Product;
use Exception;

class CalcOrderAmountUseCase
{
    /**
     * @param array<mixed> $products
     *
     * @throws Exception
     */
    public function __invoke(array $products): float|int
    {
        $totalAmount = 0;

        foreach ($products as $productData) {
            $product = Product::where('uuid', $productData['product'])->first();

            if (! $product) {
                throw new Exception("Product not found: {$productData['product']}");
            }

            $totalAmount += $product->price * $productData['quantity'];
        }

        return $totalAmount;
    }
}
