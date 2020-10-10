<?php

namespace App\Repositories;

use App\BasketModel;
use App\BasketProductModel;
use App\Entities\BasketEntity;
use App\Entities\CustomerEntity;
use App\Entities\Values\BasketProduct;
use Illuminate\Support\Collection;

class BasketEloquentRepository implements BasketRepositoryInterface
{
    public function findBasketById(int $id)
    {
        $basket = BasketModel::findOrFail($id);

        $basketProducts = [];

        foreach ($basket->products as $product)
        {
            $basketProduct = BasketProductModel::find($product)->first();

            $basketProducts[] = new BasketProduct(
                $basketProduct->id,
                $basketProduct->product_id,
                $basketProduct->productPrice(),
                $basketProduct->productTitle(),
            );
        }

        return new BasketEntity(
            $basket->id,
            $basket->findSeller(),
            $basket->findCustomer(),
            collect($basketProducts));
    }

    public function findCustomerBaskets(CustomerEntity $customer)
    {
        $baskets = BasketModel::where('customer_id', $customer->id)->get();

        $customerBaskets = [];

        foreach ($baskets as $basket)
        {
            $basketProducts = [];

            foreach ($basket->products as $product)
            {
                $basketProduct = BasketProductModel::find($product)->first();

                $basketProducts[] = new BasketProduct(
                    $basketProduct->id,
                    $basketProduct->product_id,
                    $basketProduct->productPrice(),
                    $basketProduct->productTitle(),
                );
            }

            $customerBaskets[] = new BasketEntity(
                $basket->id,
                $basket->findSeller(),
                $customer,
                collect($basketProducts));
        }

        return collect($customerBaskets);
    }

    public function addBasket(BasketEntity $basketEntity)
    {

        $basketModel = BasketModel::where('seller_id', $basketEntity->seller->id)
            ->where('customer_id', $basketEntity->customer->id)
            ->first();

        if(!$basketModel)
        {
           $basketModel = BasketModel::create($basketEntity->toArray());

           return new BasketEntity(
               $basketModel->id,
               $basketEntity->seller,
               $basketEntity->customer,
               $basketEntity->products
           );
        }

        return null;
    }

    public function saveBasket(BasketEntity $basketEntity)
    {

        $basketModel = BasketModel::where('seller_id', $basketEntity->seller->id)
            ->where('customer_id', $basketEntity->customer->id)
            ->first();

        if($basketModel)
        {
            foreach ($basketModel->products as $product)
            {
                $basketProductModel = BasketProductModel::find($product)->first();

                $basketEntity->addToBasket(
                    new BasketProduct(
                        $basketProductModel->id,
                        $basketProductModel->product_id,
                        $basketProductModel->productPrice(),
                        $basketProductModel->productTitle(),
                    )
                );
            }

            $basket = BasketModel::findOrFail($basketModel->id)->fill($basketEntity->toArray());

            $basket->save();

            return $basket;
        }

        $basket = BasketModel::findOrNew($basketEntity->id)->fill($basketEntity->toArray());

        $basket->save();

        return $basket;
    }

    public function deleteBasket(BasketEntity $basketEntity)
    {
        BasketModel::where('seller_id', $basketEntity->seller->id)
            ->where('customer_id', $basketEntity->customer->id)
            ->delete();
    }

    public function syncBaskets(Collection $baskets)
    {
        $syncBaskets = [];

        foreach ($baskets as $basket)
        {
            $basketProducts = [];

            foreach ($basket->products as $basketProduct)
            {

                $basketProductModel = BasketProductModel::find($basketProduct->id);

                if($basketProductModel->product === null)
                {
                    $basketProducts[] = new BasketProduct(
                        $basketProductModel->id,
                        $basketProductModel->product_id,
                        0.0,
                        'Deleted product',
                        true
                    );
                    continue;
                }

                $basketProducts[] = $basketProduct;
            }

            $basket->setProductList(collect($basketProducts));

            $syncBaskets[] = $basket;
        }

        return collect($syncBaskets);
    }

    public function findProductsByBaskets(Collection $baskets)
    {
        $productsList = [];

        foreach ($baskets as $basket) {
            foreach ($basket->products as $basketProduct) {
                $basketProduct = BasketProductModel::find($basketProduct->id);

                $productsList[] = new BasketProduct(
                    $basketProduct->id,
                    $basketProduct->product_id,
                    $basketProduct->productPrice(),
                    $basketProduct->productTitle()
                );
            }
        }

        return collect($productsList);
    }

    public function findProductsByBasket(BasketEntity $basket)
    {
        $products = [];

        foreach ($basket->products as $basketProductId) {
            $basketProduct = BasketProductModel::find($basketProductId);

            $products[] = new BasketProduct(
                $basketProduct->id,
                $basketProduct->product_id,
                $basketProduct->productPrice(),
                $basketProduct->productTitle()
            );
        }

        return $products;

    }

    public function findProductInBaskets(Collection $baskets, int $productId)
    {

        foreach ($baskets as $basket) {
            foreach ($basket->products as $basketProduct) {
                $basketProduct = BasketProductModel::find($basketProduct->id);

                if ($basketProduct->product_id == $productId)
                {
                    return new BasketProduct(
                        $basketProduct->id,
                        $basketProduct->product_id,
                        $basketProduct->productPrice(),
                        $basketProduct->productTitle()
                    );
                }
            }
        }
        return null;
    }

    public function addBasketProduct(BasketProduct $basketProductEntity)
    {
        if (!BasketProductModel::find($basketProductEntity->id)) {
            $basketProductModel = BasketProductModel::create($basketProductEntity->toArray());

            return new BasketProduct(
                $basketProductModel->id,
                $basketProductEntity->productId,
                $basketProductEntity->price,
                $basketProductEntity->title
            );
        }

        return null;
    }

    public function saveBasketProduct(BasketProduct $basketProductEntity)
    {
        $basketProduct = BasketProductModel::findOrNew($basketProductEntity->id)->fill($basketProductEntity->toArray());

        $basketProduct->save();

        return $basketProduct;
    }

    public function deleteBasketProduct(BasketEntity $basketEntity)
    {
        foreach ($basketEntity->products as $basketProduct)
        {
            BasketProductModel::findOrFail($basketProduct->id)->delete();
        }
    }
}
