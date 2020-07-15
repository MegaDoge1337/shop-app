<?php

namespace App\Repositories;

use App\CustomerModel;
use App\User;

use App\Entities\CustomerEntity;

class CustomerEloquentRepository implements CustomerRepositoryInterface
{
    public function findById($id)
    {
        $user = User::findOrFail($id);

        return new CustomerEntity($user->id, $user->name, $user->customer->address);
    }

    public function save(CustomerEntity $customerEntity)
    {
        $update = [
            'address' => $customerEntity->address
        ];

        CustomerModel::findOrNew($customerEntity->id)->update($update);

        return CustomerModel::find($customerEntity->id);
    }
}
