<?php

namespace App\Repositories;

use App\CustomerModel;
use App\User;

use App\Entities\CustomerEntity;

class CustomerRepository
{
    public function makeEntity(CustomerModel $customer = null, User $user = null)
    {
        return CustomerEntity::create(
            $customer ?? \Auth::user()->customer()->first(),
            $user ?? \Auth::user()
        );
    }

    public function save(CustomerEntity $customerEntity)
    {
        $update = [
            'address' => $customerEntity->address
        ];

        CustomerModel::find($customerEntity->id)->update($update);

        return CustomerModel::find($customerEntity->id);
    }
}
