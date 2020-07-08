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
        return $this->belongsTo('App\User');
    }
}
