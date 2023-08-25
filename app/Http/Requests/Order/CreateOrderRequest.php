<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     title="Create Order Request",
 *     description="Create Order Request body data",
 *     type="object",
 *     required={"products", "address", "delivery_fee"},
 *     @OA\Property(
 *         property="products",
 *         description="Array of products in the order",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"product", "quantity"},
 *             @OA\Property(
 *                 property="product",
 *                 description="UUID of the product",
 *                 type="string",
 *                 format="uuid",
 *                 example="de305d54-75b4-431b-adb2-eb6b9e546014",
 *             ),
 *             @OA\Property(
 *                 property="quantity",
 *                 description="Quantity of the product in the order",
 *                 type="integer",
 *                 example=2,
 *             ),
 *         ),
 *     ),
 *     @OA\Property(
 *         property="address",
 *         description="Address details",
 *         type="object",
 *         required={"billing", "shipping"},
 *         @OA\Property(
 *             property="billing",
 *             description="Billing address",
 *             type="string",
 *         ),
 *         @OA\Property(
 *             property="shipping",
 *             description="Shipping address",
 *             type="string",
 *         ),
 *     ),
 *     @OA\Property(
 *         property="delivery_fee",
 *         description="Delivery fee for the order",
 *         type="number",
 *         format="float",
 *     ),
 * )
 */
class CreateOrderRequest extends FormRequest
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
            'products' => 'required|array',
            'products.*.product' => 'required|string|uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'address' => 'required|array',
            'address.billing' => 'required|string',
            'address.shipping' => 'required|string',
            'delivery_fee' => 'required|numeric',
        ];
    }
}
