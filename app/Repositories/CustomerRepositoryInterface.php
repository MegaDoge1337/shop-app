<?php

namespace App\Repositories;

use App\Entities\CustomerEntity;

interface CustomerRepositoryInterface
{
    public function findById($id);

    public function save(CustomerEntity $customerEntity);
}
