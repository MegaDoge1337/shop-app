<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Customer
 *
 * @property int $id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereUserId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer whereUpdatedAt($value)
 */
class Customer extends Model
{
    protected $fillable = [
        'user_id',
    ];
}
