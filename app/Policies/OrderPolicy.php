<?php

namespace App\Policies;

use App\Entities\OrderEntity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function allowUpdate(User $user, OrderEntity $order)
    {
        if($user->seller->id === $order->seller->id) return true;

        return false;
    }
}
