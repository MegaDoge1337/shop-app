<?php

namespace App\Entities;

class BasketProductEntity
{
    public ?int $id;
    public int $productId;

    public function __construct(?int $id, int $productId)
    {
        $this->id = $id;
        $this->productId = $productId;
    }

    public static function actualize(array $basketProducts, $productId)
    {
        foreach ($basketProducts as $basketProduct)
        {
            if (!$basketProduct) return false;

            if ($basketProduct->productId == $productId) return true;
        }
        return false;
    }

    public static function create(int $productId)
    {
        return new self(null, $productId);
    }

    public function toArray()
    {
        return [
            'product_id' => $this->productId,
        ];
    }
}
