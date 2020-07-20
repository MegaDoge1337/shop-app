<?php

namespace App\Entities;

class OrderEntity
{
    public ?int $id;
    public SellerEntity $seller;
    public CustomerEntity $customer;
    public string $customerAddress;
    public array $products;
    public float $totalSum;
    public int $status;
    public ?string $createdAt;

    public function __construct(?int $id,
                                SellerEntity $seller,
                                CustomerEntity $customer,
                                string $customerAddress,
                                array $products,
                                float $totalSum,
                                int $status,
                                ?string $createdAt)
    {
        $this->id = $id;
        $this->seller = $seller;
        $this->customer = $customer;
        $this->customerAddress = $customerAddress;
        $this->products = $products;
        $this->totalSum = $totalSum;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function changeStatus(int $status)
    {
        $this->status = $status;
    }

    public static function create(SellerEntity $seller,
                                  CustomerEntity $customer,
                                  string $customerAddress,
                                  array $products,
                                  float $totalSum,
                                  int $status)
    {
        return new  self(null, $seller, $customer, $customerAddress, $products, $totalSum, $status, null);
    }

    public function toArray()
    {
        return [
            'seller_id' => $this->seller->id,
            'customer_id' => $this->customer->id,
            'customer_address' => $this->customerAddress,
            'products' => $this->products,
            'total_sum' => $this->totalSum,
            'status' => $this->status
        ];
    }
}
