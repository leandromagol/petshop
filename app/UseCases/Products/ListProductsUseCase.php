<?php

namespace App\UseCases\Products;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProductsUseCase
{
    /**
     * @throws Exception
     */
    public function __invoke(array $data): LengthAwarePaginator
    {
        try {
            $perPage =$data['limit'] ?? 10;
            $sortBy =$data['sort_by'] ?? 'id';
            $sortDesc =$data['sort_desc'] ?? false;
            $query = Product::query();

            $query->orderBy($sortBy, $sortDesc ? 'desc' : 'asc');

            return $query->paginate($perPage);
        }catch (Exception $exception){
            throw new Exception($exception->getMessage(), 422);
        }

    }
}
