<?php

namespace App\UseCases\Order;

use App\Models\Order;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListOrdersUseCase
{
    /**
     * @throws Exception
     */
    public function __invoke(array $data): LengthAwarePaginator
    {
        try {
            $perPage = $data['limit'] ?? 10;
            $sortBy = $data['sort_by'] ?? 'id';
            $sortDesc = $data['sort_desc'] ?? false;
            $query = Order::query();

            $query->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
                ->with(['user', 'orderStatus']);

            return $query->paginate($perPage);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
