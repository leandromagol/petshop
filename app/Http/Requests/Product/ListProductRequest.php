<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @OA\Schema(
 *     schema="ListProductRequest",
 *     title="ListProductRequest",
 *     description="List Product Request",
 *     @OA\Property(property="limit", type="integer", example=10),
 *     @OA\Property(property="sort_by", type="string", enum={"title", "price", "description"}),
 *     @OA\Property(property="desc", type="integer", enum={0, 1}),
 * )
 */
class ListProductRequest extends BaseRequest
{
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
            'limit' => 'nullable|integer|min:1',
            'sort_by' => 'nullable|string|in:title,price,description',
            'desc' => 'nullable|in:0,1',
        ];
    }
}
