<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Seller
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereUserId($value)
 * @mixin \Eloquent
 */
class Seller extends Model
{
    protected $fillable = [
        'user_id',
    ];
}
