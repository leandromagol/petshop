<?php

namespace App\DTO;

use App\Models\Product;

class CreateOrderDto
{
    /**
     * @param array<mixed, Product> $products
     * @param array<string, mixed> $address
     * @param float $deliveryFee
     */
    public function __construct(
        public array $products,
        public array $address,
        public float $deliveryFee
    ) {
    }
}
