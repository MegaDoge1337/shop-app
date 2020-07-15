<?php

namespace App\Repositories;

use App\Entities\SellerEntity;
use App\User;

class SellerRepository
{
    public function findById($id)
    {
        $user = User::findOrFail($id);

        return new SellerEntity($user->id, $user->name, $user->seller->address);
    }
}
