<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\JsonResponse;

class OrderStatusController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/order-statuses",
     *      summary="Get a list of order statuses",
     *      tags={"OrderStatus"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response="200",
     *          description="Successful response",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/OrderStatus")
     *          )
     *      ),
     *  )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $orderStatuses = OrderStatus::all();
        return response()->json($orderStatuses);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/order-status/{uuid}",
     *      summary="Get details of a specific order status",
     *      tags={"OrderStatus"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="uuid",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          description="Order Status uuid"
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Successful response",
     *          @OA\JsonContent(ref="#/components/schemas/OrderStatus")
     *      ),
     *      @OA\Response(response="404", description="Order Status not found"),
     *  )
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function show(string $uuid): \Illuminate\Http\JsonResponse
    {
        $orderStatus = OrderStatus::where('uuid', $uuid)->firstOrFail();
        return response()->json($orderStatus);
    }
}
