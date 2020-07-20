<?php

namespace App\Entities;

use App\Services\TotalSumCalculator;

class BasketEntity
{
    public ?int $id;
    public SellerEntity $seller;
    public CustomerEntity $customer;
    public array $products;

    public function __construct(?int $id, SellerEntity $seller, CustomerEntity $customer, array $products)
    {
        $this->id = $id;
        $this->seller = $seller;
        $this->customer = $customer;
        $this->products = $products;
    }

    public static function create(SellerEntity $seller, CustomerEntity $customer, array $products)
    {
        return new self(null, $seller, $customer, $products);
    }

    public function addToBasket(int $productId)
    {
        $products = $this->products;

        array_push($products, $productId);

        $this->products = $products;
    }

    public function changeProductsList(array $products)
    {
        $this->products = $products;
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
