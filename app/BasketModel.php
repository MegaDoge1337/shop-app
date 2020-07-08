<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BasketModel
 *
 * @property int $id
 * @property int $seller_id
 * @property mixed $products
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $customer_id
 * @property int $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketModel whereProductId($value)
 * @property-read \App\ProductModel $product
 * @property-read \App\SellerModel $seller
 * @property-read \App\User $user
 */
class BasketModel extends Model
{
    protected $table = 'baskets';

    protected $fillable = [
        'seller_id',
        'customer_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo('App\SellerModel', 'seller_id');
    }

    public function product()
    {
        return $this->belongsTo('App\ProductModel');
    }
}
