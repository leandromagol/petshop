<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Rules\ObjectOrJsonRule;
use Illuminate\Contracts\Validation\ValidationRule;
/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     title="UpdateProductRequest",
 *     description="Update Product Request",
 *     required={"title", "price", "description", "metadata"},
*      @OA\Property(
 *         property="title",
 *         description="Title of the product",
 *         type="string",
 *         example="Updated Product"
 *      ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         example=39.99
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="This is the updated product description."
 *     ),
 *     @OA\Property(
 *         property="metadata",
 *         type="object",
 *         example={"key": "updated_value"}
 *     ),
 * )
 */

class UpdateProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int,ObjectOrJsonRule|string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'metadata' => ['required',new ObjectOrJsonRule()],
        ];
    }
}
