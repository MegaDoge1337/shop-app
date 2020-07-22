<?php

namespace App\Repositories;

use App\Entities\BasketEntity;
use App\Entities\CustomerEntity;
use App\Entities\Values\BasketProduct;
use Illuminate\Support\Collection;

interface BasketRepositoryInterface
{
    public function findBasketById(int $id);

    public function findCustomerBaskets(CustomerEntity $customerId);

    public function addBasket(BasketEntity $basketEntity);

    public function saveBasket(BasketEntity $basketEntity);

    public function deleteBasket(BasketEntity $basketEntity);

    public function syncBaskets(Collection $baskets);

    public function findProductsByBasket(BasketEntity $basket);

    public function findProductInBaskets(Collection $baskets, int $productId);

    public function addBasketProduct(BasketProduct $basketProductEntity);

    public function saveBasketProduct(BasketProduct $basketProductEntity);

    public function deleteBasketProduct(BasketEntity $basketEntity);
}
