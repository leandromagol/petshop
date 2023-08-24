<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
/**
 * @OA\Schema(
 *     schema="ListOrderRequest",
 *     title="ListOrderRequest",
 *     description="List Order Request",
 *     @OA\Property(property="limit", type="integer", example=10),
 *     @OA\Property(property="sort_by", type="string", enum={"uuid", "user_id", "order_status_id","products.*.product'"}),
 *     @OA\Property(property="desc", type="integer", enum={0, 1}),
 * )
 */
class ListOrderRequest extends BaseRequest
{
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
            'limit' => 'nullable|integer|min:1',
            'sort_by' => 'nullable|string|in:uuid,user_id,order_status_id,products.*.product',
            'desc' => 'nullable|in:0,1',
        ];
    }
}
