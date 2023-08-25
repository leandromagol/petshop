<?php

namespace App\UseCases\Products;

use App\Models\Product;
use Exception;

class UpdateProductUseCase
{
    /**
     * @param array<string, string> $data
     *
     * @return Product
     *
     * @throws Exception
     */
    public function __invoke(array $data, string $uuid): Product
    {
        try {
            $product = Product::where('uuid', $uuid)->firstOrFail();
            $product->update($data);
            $product->save();
            return $product;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
