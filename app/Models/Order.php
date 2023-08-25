<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Order",
 *     title="Order",
 *     description="Order model",
 *     type="object",
 *     required={"uuid", "user_id", "order_status_id", "products", "address", "delivery_fee", "amount", "shipped_at"},
 *     @OA\Property(
 *         property="uuid",
 *         description="UUID of the order",
 *         type="string",
 *         format="uuid",
 *         example="de305d54-75b4-431b-adb2-eb6b9e546014",
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         description="UUID of the user associated with the order",
 *         type="string",
 *         format="uuid",
 *         example="de305d54-75b4-431b-adb2-eb6b9e546014",
 *     ),
 *     @OA\Property(
 *         property="order_status_id",
 *         description="UUID of the order status for the order",
 *         type="string",
 *         format="uuid",
 *         example="de305d54-75b4-431b-adb2-eb6b9e546014",
 *     ),
 *     @OA\Property(
 *         property="products",
 *         description="JSON array of products in the order",
 *         type="array",
 *         @OA\Items(type="object"),
 *     ),
 *     @OA\Property(
 *         property="address",
 *         description="JSON object containing address details",
 *         type="object",
 *     ),
 *     @OA\Property(
 *         property="delivery_fee",
 *         description="Delivery fee for the order",
 *         type="number",
 *         format="float",
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         description="Total amount for the order",
 *         type="number",
 *         format="float",
 *     ),
 *     @OA\Property(
 *         property="shipped_at",
 *         description="Date and time when the order was shipped",
 *         type="string",
 *         format="date-time",
 *     ),
 * )
 * App\Models\Order
 *
 * @property-read \App\Models\OrderStatus|null $orderStatus
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @mixin \Eloquent
 */

class Order extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public mixed $order_status_uuid;
    protected $fillable = [
        'uuid',
        'user_id',
        'order_status_id' ,
        'products',
        'address' ,
        'delivery_fee',
        'amount',
        'shipped_at',
    ];

    protected $casts = [
        'products' => 'json',
        'address' => 'json',
        'shipped_at' => 'datetime',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','uuid');
    }


    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class,'order_status_id','uuid');
    }

}
