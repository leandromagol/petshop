<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="OrderStatus",
 *      title="OrderStatus",
 *      description="Order status model",
 *      type="object",
 *   @OA\Property(
 *      property="id",
 *      type="integer",
 *      description="Order status ID"
 *  ),
 *  @OA\Property(
 *      property="uuid",
 *      type="string",
 *      description="UUID of the order status"
 *  ),
 *  @OA\Property(
 *      property="title",
 *      type="string",
 *      description="Title of the order status"
 *  ),
 * )
 *
 * App\Models\OrderStatus
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus query()
 * @mixin \Eloquent
 */
class OrderStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'title'
    ];

}
