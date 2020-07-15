<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SellerModel
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BasketProductModel[] $basket
 * @property-read int|null $basket_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderModel[] $order
 * @property-read int|null $order_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductModel[] $product
 * @property-read int|null $product_count
 * @property-read \App\User $user
 * @property string|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SellerModel whereAddress($value)
 */
class SellerModel extends Model
{
    protected $table = 'sellers';

    protected $fillable = [
        'user_id',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->hasMany('App\ProductModel', 'seller_id');
    }

    public function order()
    {
        return $this->hasMany('App\OrderModel', 'seller_id');
    }

    public function basket()
    {
        return $this->hasMany('App\BasketProductModel', 'seller_id');
    }
}
