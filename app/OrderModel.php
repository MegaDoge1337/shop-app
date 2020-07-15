<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrderModel
 *
 * @property int $id
 * @property int $seller_id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_address
 * @property mixed $products_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereCustomerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereProductsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\SellerModel $seller
 * @property-read \App\User $user
 * @property array $products
 * @property float $total_sum
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderModel whereTotalSum($value)
 */
class OrderModel extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'seller_id',
        'customer_id',
        'customer_name',
        'customer_address',
        'products',
        'total_sum',
        'status',
    ];

    protected $casts = [
        'products' => 'array',
    ];

    public function seller()
    {
        return $this->belongsTo('App\SellerModel');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }
}
