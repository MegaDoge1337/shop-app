<?php

namespace App\Repositories;

use App\BasketModel;
use App\Entities\BasketEntity;
use App\Entities\CustomerEntity;

class BasketEloquentRepository implements BasketRepositoryInterface
{
    public function findById(int $id)
    {
        $basket = BasketModel::findOrFail($id);

        return new BasketEntity(
            $basket->id,
            $basket->findSeller(),
            $basket->findCustomer(),
            $basket->products);
    }

    public function findCustomerBaskets(CustomerEntity $customer)
    {
        $baskets = BasketModel::where('customer_id', $customer->id)->get();

        $customerBaskets = [];

        foreach ($baskets as $basket)
        {
            $customerBaskets[] = new BasketEntity(
                $basket->id,
                $basket->findSeller(),
                $customer,
                $basket->products);
        }

        return $customerBaskets;
    }

    public function add(BasketEntity $basketEntity)
    {

        $basketModel = BasketModel::where('seller_id', $basketEntity->seller->id)
            ->where('customer_id', $basketEntity->customer->id)
            ->first();

        if(!$basketModel)
        {
           return BasketModel::create($basketEntity->toArray());
        }

        return null;
    }

    public function save(BasketEntity $basketEntity)
    {

        $basketModel = BasketModel::where('seller_id', $basketEntity->seller->id)
            ->where('customer_id', $basketEntity->customer->id)
            ->first();

        if($basketModel)
        {
            foreach ($basketModel->products as $product)
            {
                $basketEntity->addToBasket($product);
            }

            $basket = BasketModel::findOrFail($basketModel->id)->fill($basketEntity->toArray());

            $basket->save();

            return $basket;
        }

        $basket = BasketModel::findOrNew($basketEntity->id)->fill($basketEntity->toArray());

        $basket->save();

        return $basket;
    }

    public function delete(BasketEntity $basketEntity)
    {
        BasketModel::where('seller_id', $basketEntity->seller->id)
            ->where('customer_id', $basketEntity->customer->id)
            ->delete();
    }
}
