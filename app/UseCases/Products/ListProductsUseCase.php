<?php

namespace App\UseCases\Products;

use App\DTO\PaginationDTO;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProductsUseCase
{
    /**
     * @param PaginationDTO $data
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function __invoke(PaginationDTO $data): LengthAwarePaginator
    {
        try {
            $perPage = $data->limit ;
            $sortBy = $data->sortBy ;
            $sortDesc = $data->limit ;
            $query = Product::query();

            $query->orderBy($sortBy, $sortDesc ? 'desc' : 'asc');

            return $query->paginate($perPage);
        }catch (Exception $exception){
            throw new Exception($exception->getMessage(), 422);
        }

    }
}
