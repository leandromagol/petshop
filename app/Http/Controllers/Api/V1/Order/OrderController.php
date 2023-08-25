<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\DTO\CreateOrderDto;
use App\DTO\PaginationDTO;
use App\DTO\UpdateOrderDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\ListOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\UseCases\Order\CreateOrderUseCase;
use App\UseCases\Order\ListOrdersUseCase;
use App\UseCases\Order\UpdateOrderUseCase;

/**
 * @OA\Tag(
 *     name="Oders",
 *     description="API Endpoints for Orders"
 * )
 */
class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/orders",
     *     operationId="listOders",
     *     tags={"Oders"},
     *     summary="List orders",
     *     description="Retrieves a list of all orders.",
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Number of orders to retrieve (optional)",
     *          required=false,
     *          @OA\Schema(type="integer", minimum=1)
     *      ),
     *      @OA\Parameter(
     *          name="sort_by",
     *          in="query",
     *          description="Sort orderss by field (optional)",
     *          required=false,
     *          @OA\Schema(type="string", enum={"uuid", "user_id", "order_status_id","products.*.product'"})
     *      ),
     *      @OA\Parameter(
     *          name="desc",
     *          in="query",
     *          description="Sort in descending order (optional)",
     *          required=false,
     *          @OA\Schema(type="integer", enum={0, 1})
     *      ),
     *       security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\RequestBody(ref="#/components/schemas/ListOrderRequest"),
     *     @OA\Response(response="200", description="Successful operation"),
     * )
     *
     * @throws \Exception
     */
    public function index(ListOrderRequest $request, ListOrdersUseCase $listOrdersUseCase): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $paginationDto = new PaginationDTO(
            $data['limit'] ?? 10,
            $data['sort_by'] ?? 'id',
            $data['desc'] ?? false
        );
        $orders = $listOrdersUseCase($paginationDto);
        return response()->json($orders);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/order/create",
     *     operationId="createOder",
     *     tags={"Oders"},
     *     summary="Create a new order",
     *     description="Creates a new order.",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateOrderRequest")
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Order created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Order created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Order")
     *          )
     *      ),
     * )
     *
     * @throws \Throwable
     */
    public function store(CreateOrderRequest $request, CreateOrderUseCase $createOrderUseCase): \Illuminate\Http\JsonResponse
    {
        $orderData = $request->validated();
        $createOrderDto = new CreateOrderDto(
            $orderData['products'],
            $orderData['address'],
            $orderData['delivery_fee']
        );

        $order = $createOrderUseCase($createOrderDto);
        return response()->json(['message' => 'Order created successfully', 'data' => $order], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/order/{uuid}",
     *     operationId="getOrderByUuid",
     *     tags={"Oders"},
     *     summary="Get a specific order",
     *  security={
     *            {"bearerAuth": {}}
     *        },
     *      @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID of the order to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *     response="200",
     *      description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Order retrieved successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Order")
     *          )
     * ),
     *     @OA\Response(response="404", description="Order not found"),
     * )
     */
    public function show(string $uuid): \Illuminate\Http\JsonResponse
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        return response()->json(['message' => 'Order retrieved successfully','data' => $order]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/order/{uuid}",
     *     operationId="updateOrder",
     *     tags={"Oders"},
     *     summary="Update a specific order",
     *   security={
     *            {"bearerAuth": {}}
     *        },
     *       @OA\Parameter(
     *          name="uuid",
     *          in="path",
     *          description="UUID of the order",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     * @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateOrderRequest")
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Order order successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Order updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/Order")
     *          )
     *      ),
     *     @OA\Response(response="404", description="Order not found"),
     * )
     *
     * @throws \Throwable
     */
    public function update(UpdateOrderRequest $request, string $uuid, UpdateOrderUseCase $updateOrderUseCase): \Illuminate\Http\JsonResponse
    {
        $orderData = $request->validated();
        $updateOrderDto = new UpdateOrderDto(
            $orderData['order_status_id'],
            $orderData['products'],
            $orderData['address'],
            $orderData['delivery_fee']
        );
        $updatedOrder = $updateOrderUseCase($updateOrderDto, $uuid);
        return response()->json(['message' => 'Order updated successfully','data' => $updatedOrder]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/order/{uuid}",
     *     operationId="deleteOrder",
     *     tags={"Oders"},
     *     summary="Delete a specific order",
     *      security={
     *            {"bearerAuth": {}}
     *        }    ,
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID of the order to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Order deleted successfully"),
     *     @OA\Response(response="404", description="Order not found"),
     * )
     */
    public function destroy(string $uuid): \Illuminate\Http\JsonResponse
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $order->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
