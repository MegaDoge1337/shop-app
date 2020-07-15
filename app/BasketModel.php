<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BasketModel
 *
 * @property int $id
 * @property int $seller_id
 * @property int $customer_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\CustomerModel $customer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property array $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereProducts($value)
 */
class BasketModel extends Model
{
    protected $table = 'baskets';

    protected $fillable = [
        'customer_id',
        'products',
    ];

    protected $casts = [
        'products' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo('App\CustomerModel', 'customer_id');
    }
}
