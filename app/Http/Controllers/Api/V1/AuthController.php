<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Models\JwtToken;
use App\UseCases\Auth\GenerateTokenUseCase;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints for user authentication"
 * )
 */

class AuthController
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     summary="User login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginAuthRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful login",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", example="jwt.token.here")
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     ),
     * )
     *
     * @throws AuthenticationException
     */
    public function login(LoginAuthRequest $request): \Illuminate\Http\JsonResponse
    {
        $generateTokenUseCase = new GenerateTokenUseCase();
        $token = $generateTokenUseCase(
            $request->email,
            $request->password
        );
        if ($token) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    /**
     * @OA\Get (
     *     path="/api/v1/auth/logout",
     *     operationId="logoutUser",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     * )
     */

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        if ($user) {
            JwtToken::where('user_id', $user->uuid)->delete();
        }
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
