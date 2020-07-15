<?php

namespace App\Repositories;

interface BasketProductRepositoryInterface
{
    public function findByProductId(int $productId, int $customerId);

    public function findAllByCustomerId(int $customerId);
}
