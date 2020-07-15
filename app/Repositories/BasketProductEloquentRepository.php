<?php

namespace App\Repositories;

use App\BasketProductModel;
use App\Entities\BasketProductEntity;

class BasketProductEloquentRepository implements BasketProductRepositoryInterface
{
    public function findByProductId(int $productId, int $customerId)
    {
        $basketProduct = BasketProductModel::where('product_id', $productId)
            ->where('customer_id', $customerId)
            ->first();

        if ($basketProduct != null) {
            return new BasketProductEntity(
                $basketProduct->id,
                $basketProduct->seller_id,
                $basketProduct->customer_id,
                $basketProduct->product_id,
                $basketProduct->created_at,
                $basketProduct->updated_at);
        }

        return null;
    }

    public function findAllByCustomerId(int $customerId)
    {
        $productsList = [];

        $basketProducts = BasketProductModel::where('customer_id', $customerId)->get();

        foreach ($basketProducts as $basketProduct)
        {
            $productsList[] = new BasketProductEntity(
                $basketProduct->id,
                $basketProduct->seller_id,
                $basketProduct->customer_id,
                $basketProduct->product_id,
                $basketProduct->created_at,
                $basketProduct->updated_at);
        }

        return $productsList;
    }
}
