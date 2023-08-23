<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\Admin\CreateAdminRequest;
use App\UseCases\Admin\CreateAdminUseCase;

class AdminController
{
    /**
     * @OA\Post(
     *     path="/api/v1/admin/create",
     *     operationId="createAdmin",
     *     tags={"Admin"},
     *     summary="Create a new admin",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateAdminRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Admin created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Admin created successfully"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     ),
     * )
     * @throws \Exception
     */
    public function create(CreateAdminRequest $request, CreateAdminUseCase $createAdminUseCase): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $createAdminUseCase($data);

        return response()->json(['message' => 'Admin created successfully'], 201);

    }
}
