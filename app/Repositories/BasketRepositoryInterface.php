<?php

namespace App\Repositories;

use App\Entities\BasketEntity;
use App\Entities\CustomerEntity;

interface BasketRepositoryInterface
{
    public function findById(int $id);

    public function findCustomerBaskets(CustomerEntity $customerId);

    public function add(BasketEntity $basketEntity);

    public function save(BasketEntity $basketEntity);

    public function delete(BasketEntity $basketEntity);
}
