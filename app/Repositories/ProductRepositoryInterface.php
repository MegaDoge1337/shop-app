<?php

namespace App\Repositories;

use App\Entities\ProductEntity;

interface ProductRepositoryInterface
{
    public function findAllBySellerId(int $id);

    public function findById(int $id);

    public function findByBasketProducts(array $basketProducts);

    public function add(ProductEntity $productEntity);

    public function save(ProductEntity $productEntity);

    public function delete(ProductEntity $productEntity);
}
