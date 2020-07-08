<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductModel
 *
 * @property int $id
 * @property int $seller_id
 * @property string $title
 * @property float $price
 * @property int|null $existence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel whereExistence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductModel extends Model
{
    protected $fillable = [
        'seller_id',
        'title',
        'price',
        'description',
        'image_url',
        'existence',
    ];

    public function seller()
    {
        return $this->belongsTo('App\SellerModel');
    }

    public function basket()
    {
        return $this->hasOne('App\ProductModel', 'product_id');
    }
}
