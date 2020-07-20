<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CustomerModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CustomerModel whereUserId($value)
 */
class CustomerModel extends Model
{
    protected $fillable = [
        'user_id',
        'address'
    ];

    protected $table = 'customers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'customer_id');
    }

    public function baskets()
    {
        return $this->hasMany(BasketModel::class, 'customer_id');
    }
}
