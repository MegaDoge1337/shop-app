<?php

namespace App\Repositories;

use App\Entities\ProductEntity;

interface ProductRepositoryInterface
{
    public function findAllBySellerId(int $id);

    public function findById(int $id);

    public function add(array $data);

    public function save(ProductEntity $productEntity);

    public function delete(ProductEntity $productEntity);
}
