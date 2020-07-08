<?php

namespace App\Entities;

use App\CustomerModel;
use App\User;

class CustomerEntity
{

    public function __construct(CustomerModel $customer, User $user)
    {
        $this->id = $customer->id;
        $this->name = $user->name;
        $this->address = $customer->address;
    }

    public static function create(CustomerModel $customer, User $user)
    {
        return new self($customer, $user);
    }
}
