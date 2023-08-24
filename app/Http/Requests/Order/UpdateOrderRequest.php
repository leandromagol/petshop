<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="UpdateOrderRequest",
 *     title="Update Order Request",
 *     description="Update Order Request body data",
 *     type="object",
 *     required={"order_status_id", "products", "address", "delivery_fee"},
 *     @OA\Property(
 *         property="order_status_id",
 *         description="UUID of the order status for the order",
 *         type="string",
 *         format="uuid",
 *         example="de305d54-75b4-431b-adb2-eb6b9e546014",
 *     ),
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
class UpdateOrderRequest extends FormRequest
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
            'order_status_id' => 'required|string|uuid|exists:order_statuses,uuid',
            'products' => 'array',
            'products.*.product' => 'string|uuid',
            'products.*.quantity' => 'integer|min:1',
            'address' => 'array',
            'address.billing' => 'string',
            'address.shipping' => 'string',
            'delivery_fee' => 'numeric',
        ];
    }
}
