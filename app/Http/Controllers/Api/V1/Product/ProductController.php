<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\DTO\PaginationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ListProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\UseCases\Products\CreateProductUseCase;
use App\UseCases\Products\ListProductsUseCase;
use App\UseCases\Products\UpdateProductUseCase;
use Exception;
use League\Container\Exception\NotFoundException;
use Request;
/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for Products"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/product",
     *     operationId="listProducts",
     *     tags={"Products"},
     *     summary="List all products",
     *     description="Retrieves a list of all products.",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of products to retrieve (optional)",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1)
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Sort products by field (optional)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"title", "price", "description"})
     *     ),
     *     @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         description="Sort in descending order (optional)",
     *         required=false,
     *         @OA\Schema(type="integer", enum={0, 1})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Products retrieved successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @throws Exception
     */
    public function index(ListProductRequest $request, ListProductsUseCase $listProductsUseCase): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $paginationDto = new PaginationDTO(
            $data['limit'] ?? 10,
            $data['sort_by']?? 'id',
            $data['desc']?? false
        );
        $products = $listProductsUseCase($paginationDto);
        return response()->json(['message' => 'Products retrieved successfully', 'data' => $products]);

    }
    /**
     * @OA\Post(
     *     path="/api/v1/product/create",
     *     operationId="createProduct",
     *     tags={"Products"},
     *     summary="Create a new product",
     *     description="Creates a new product.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(property="product", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @throws Exception
     */
    public function create(CreateProductRequest $request, CreateProductUseCase $createProductUseCase): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $product = $createProductUseCase($data);

        return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/product/{uuid}",
     *     operationId="getProductByUuid",
     *     tags={"Products"},
     *     summary="Get product by UUID",
     *     description="Retrieves a product by its UUID.",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product retrieved successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function show(string $uuid): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('uuid',$uuid)->firstOrFail();
        return response()->json(['message'=>'Product retrieved successfully','data'=>$product]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/product/{uuid}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     summary="Update a product",
     *     description="Updates an existing product.",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @throws Exception
     */
    public function update(UpdateProductRequest $request, string $uuid, UpdateProductUseCase $updateProductUseCase): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $product = $updateProductUseCase($data,$uuid);

        return response()->json(['message'=>'Product updated successfully','data'=>$product]);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/product/{uuid}",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     summary="Delete a product",
     *     description="Deletes an existing product.",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="UUID of the product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function destroy(string $uuid): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('uuid',$uuid)->firstOrFail();
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
