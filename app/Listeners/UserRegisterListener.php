<?php

namespace App\Listeners;

use App\CustomerModel;
use App\SellerModel;
use Illuminate\Auth\Events\Registered;

class UserRegisterListener
{
    public function handle(Registered $event)
    {
        SellerModel::create(['user_id' => $event->user->id]);
        CustomerModel::create(['user_id' => $event->user->id]);
    }
}
