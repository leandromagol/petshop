<?php

namespace App\UseCases\Order;

use App\DTO\PaginationDTO;
use App\Models\Order;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 *
 */
class ListOrdersUseCase
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
            $query = Order::query();

            $query->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
                ->with(['user', 'orderStatus']);

            return $query->paginate($perPage);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
