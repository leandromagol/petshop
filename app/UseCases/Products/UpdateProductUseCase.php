<?php

namespace App\UseCases\Products;

use App\Models\Product;
use Exception;
use Illuminate\Support\Str;


class UpdateProductUseCase
{
    /**
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public function __invoke(array $data, string $uuid): Product
    {
        try {
            $product = Product::where('uuid',$uuid)->firstOrFail();
            $product->update($data);
            $product->save();
            return $product;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage(), 422);

        }

    }
}
