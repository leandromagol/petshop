<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Create Admin Request",
 *     description="Request payload for creating a new admin",
 *     type="object",
 *     required={"first_name", "last_name", "email", "password"},
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password123"),
 *     @OA\Property(property="avatar", type="string", example="avatar.jpg", nullable=true),
 *     @OA\Property(property="address", type="string", example="123 Street, City", nullable=true),
 *     @OA\Property(property="phone_number", type="string", example="123-456-7890", nullable=true),
 * )
 */
class CreateAdminRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|string',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ];
    }
}
