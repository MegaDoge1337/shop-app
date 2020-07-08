<?php


namespace App\Listeners;

use App\SellerModel;
use Illuminate\Auth\Events\Registered;

class MakeUserASellerNotificator
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        SellerModel::create(['user_id' => $event->user->id]);
    }
}
