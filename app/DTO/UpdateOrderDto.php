<?php

namespace App\DTO;

use App\Models\Product;

/**
 *
 */
class UpdateOrderDto
{
    /**
     * @param string $orderStatusId
     * @param array<mixed, Product> $products
     * @param array<string, mixed> $address
     * @param float $deliveryFee
     */
    public function __construct(
        public string $orderStatusId,
        public array $products,
        public array $address,
        public float $deliveryFee
    ) {
    }
}
