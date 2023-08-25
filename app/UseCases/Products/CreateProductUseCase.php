<?php

namespace App\UseCases\Products;

use App\Models\Product;
use Exception;
use Illuminate\Support\Str;


class CreateProductUseCase
{
    /**
     * @param array<string, string> $data
     * @return Product
     * @throws Exception
     */
    public function __invoke(array $data): Product
    {
        try {
            $product = new Product([
                'uuid' => Str::uuid()->toString(),
                'title' => $data['title'],
                'price' => $data['price'],
                'description' => $data['description'],
                'metadata' => $data['metadata'],
            ]);

            $product->save();

            return $product;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage(), 422);

        }

    }
}
