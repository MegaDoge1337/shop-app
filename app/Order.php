<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'seller_id',
        'customer_id',
        'customer_name',
        'customer_address',
        'products_id',
        'amount',
    ];
}
