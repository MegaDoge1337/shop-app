<?php

namespace App\Repositories;

use App\BasketProductModel;
use App\Entities\BasketEntity;
use App\Entities\BasketProductEntity;

class BasketProductEloquentRepository implements BasketProductRepositoryInterface
{
    public function findProductsByBaskets(array $baskets)
    {
        $productsList = [];

        foreach ($baskets as $basket) {
            foreach ($basket->products as $basketProductId) {
                $basketProduct = BasketProductModel::find($basketProductId);

                $productsList[] = new BasketProductEntity($basketProduct->id, $basketProduct->product_id);
            }
        }

        return $productsList;
    }

    public function findProductsByBasket(BasketEntity $basket)
    {
        $products = [];

        foreach ($basket->products as $basketProductId) {
            $basketProduct = BasketProductModel::find($basketProductId);

            $products[] = new BasketProductEntity($basketProduct->id, $basketProduct->product_id);
        }

        return $products;

    }

    public function findProductInBaskets(array $baskets, int $productId)
    {

        foreach ($baskets as $basket) {
            foreach ($basket->products as $basketProductId) {
                $basketProduct = BasketProductModel::find($basketProductId);

                if ($basketProduct->product_id == $productId) return new BasketProductEntity($basketProduct->id, $basket->product_id);
            }
        }
        return null;
    }

    public function add(BasketProductEntity $basketProductEntity)
    {
        if (!BasketProductModel::find($basketProductEntity->id)) {
            return BasketProductModel::create($basketProductEntity->toArray());
        }

        return null;
    }

    public function save(BasketProductEntity $basketProductEntity)
    {
        $basketProduct = BasketProductModel::findOrNew($basketProductEntity->id)->fill($basketProductEntity->toArray());

        $basketProduct->save();

        return $basketProduct;
    }

    public function delete(BasketEntity $basketEntity)
    {
        foreach ($basketEntity->products as $basketProduct)
        {
            BasketProductModel::findOrFail($basketProduct)->delete();
        }
    }
}
