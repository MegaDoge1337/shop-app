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
 */
class SellerModel extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\UserModel');
    }

    public function product()
    {
        return $this->hasMany('App\ProductModel');
    }

    public function order()
    {
        return $this->hasMany('App\OrderModel');
    }

    public function basket()
    {
        return $this->hasMany('App\BasketModel', 'seller_id');
    }
}
