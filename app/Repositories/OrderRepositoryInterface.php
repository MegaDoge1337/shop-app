<?php

namespace App\Repositories;

use App\Entities\OrderEntity;

interface OrderRepositoryInterface
{
    public function findById(int $id);

    public function findBySellerId(int $sellerId);

    public function findByCustomerId(int $customerId);

    public function add(OrderEntity $orderEntity);

    public function save(OrderEntity $orderEntity);
}
