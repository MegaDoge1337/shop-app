<?php

namespace App\Entities;

use App\BasketProductModel;
use App\Entities\ProductEntity;

class BasketProductEntity
{
    public int $id;
    public int $sellerId;
    public int $customerId;
    public int $productId;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(int $id, int $sellerId, int $customerId, int $productId, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->sellerId = $sellerId;
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function actualize(array $basketProducts, $productId)
    {
        foreach ($basketProducts as $basketProduct)
        {
            if ($basketProduct->productId == $productId) return true;
        }
        return false;
    }
}
