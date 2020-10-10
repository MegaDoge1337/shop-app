<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BasketProductModel
 *
 * @property int $id
 * @property int $seller_id
 * @property mixed $products
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $customer_id
 * @property int $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BasketProductModel whereProductId($value)
 * @property-read \App\ProductModel $product
 * @property-read \App\SellerModel $seller
 * @property-read \App\User $user
 */
class BasketProductModel extends Model
{
    protected $table = 'basket_products';

    protected $fillable = [
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function productPrice()
    {
        return $this->product->price ?? 0.0;
    }

    public function productTitle()
    {
        return $this->product->title ?? '';
    }
}
