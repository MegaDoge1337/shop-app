<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Basket
 *
 * @property int $id
 * @property int $seller_id
 * @property mixed $products
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Basket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Basket extends Model
{
    protected $fillable = [
        'seller_id',
        'customer_id',
        'product_id',
    ];
}
