<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\UserModel
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $phone_number
 * @property string|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserModel wherePhoneNumber($value)
 */
class UserModel extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone_number', 'address', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->hasOne('App\SellerModel');
    }

    public function order()
    {
        return $this->hasMany('App\OrderModel', 'customer_id');
    }

    public function basket()
    {
        return $this->hasMany('App\BasketModel', 'customer_id');
    }
}
