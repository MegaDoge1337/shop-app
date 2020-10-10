<?php

namespace App\Entities;

use App\Entities\Values\BasketProduct;
use App\Services\TotalSumCalculator;
use Illuminate\Support\Collection;

class BasketEntity
{
    public ?int $id;
    public SellerEntity $seller;
    public CustomerEntity $customer;
    public Collection $products;

    public function __construct(?int $id, SellerEntity $seller, CustomerEntity $customer, Collection $products)
    {
        $this->id = $id;
        $this->seller = $seller;
        $this->customer = $customer;
        $this->products = $products;
    }

    public static function create(SellerEntity $seller, CustomerEntity $customer, Collection  $products)
    {
        return new self(null, $seller, $customer, $products);
    }

    public function addToBasket(BasketProduct $basketProduct)
    {
        $this->products[] = $basketProduct;
    }

    public function setProductList(Collection $productList)
    {
        $this->products = $productList;
    }

    public function pricesTotalSum(TotalSumCalculator $totalSumCalculator)
    {
        return $totalSumCalculator->productPricesSum($this->products);
    }

    public function toArray()
    {
        return [
            'seller_id' => $this->seller->id,
            'customer_id' => $this->customer->id,
            'products' => $this->products
        ];
    }
}
