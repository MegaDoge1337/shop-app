<?php

namespace App;

use App\Entities\BasketEntity;
use App\Entities\CustomerEntity;
use App\Entities\SellerEntity;
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
        'seller_id',
        'customer_id',
        'products'
    ];

    protected $casts = [
        'products' => 'array'
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(SellerModel::class);
    }

    public function findSeller()
    {
        return new SellerEntity(
            $this->seller->id,
            $this->seller->user->name,
            $this->seller->address
        );
    }

    public function findCustomer()
    {
        return new CustomerEntity(
            $this->customer->id,
            $this->customer->user->name,
            $this->customer->address
        );
    }
}
