<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Rules\ObjectOrJsonRule;
use Illuminate\Contracts\Validation\ValidationRule;
/**
 * @OA\Schema(
 *     title="Create Product Request",
 *     description="Create Product Request Body",
 *     type="object",
 *     required={"title", "price", "description", "metadata"},
 *     @OA\Property(
 *         property="title",
 *         description="Title of the product",
 *         type="string",
 *         example="Pet Food"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         description="Price of the product",
 *         type="number",
 *         format="float",
 *         example=19.99
 *     ),
 *     @OA\Property(
 *         property="description",
 *         description="Description of the product",
 *         type="string",
 *         example="High-quality pet food for all breeds."
 *     ),
 *     @OA\Property(
 *         property="metadata",
 *         description="Metadata of the product",
 *         type="object",
 *         example={
 *             "brand": "UUID from petshop.brands",
 *             "image": "UUID from petshop.files"
 *         }
 *     ),
 * )
 */
class CreateProductRequest extends BaseRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'metadata' => ['required',new ObjectOrJsonRule],
        ];
    }
}
