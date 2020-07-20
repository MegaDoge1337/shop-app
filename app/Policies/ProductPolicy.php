<?php

namespace App\Policies;

use App\Entities\ProductEntity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function allowUpdate(User $user, ProductEntity $product)
    {
        if($user->seller->id === $product->sellerId) return true;

        return false;
    }
}
