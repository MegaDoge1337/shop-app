<?php

namespace App\Repositories;

use App\Entities\BasketEntity;
use App\Entities\BasketProductEntity;

interface BasketProductRepositoryInterface
{
    public function findProductsByBaskets(array $baskets);

    public function findProductsByBasket(BasketEntity $basket);

    public function findProductInBaskets(array $baskets, int $product_id);

    public function add(BasketProductEntity $basketProductEntity);

    public function save(BasketProductEntity $basketProductEntity);

    public function delete(BasketEntity $basketEntity);
}
