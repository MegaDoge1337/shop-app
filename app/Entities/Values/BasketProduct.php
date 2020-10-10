<?php

namespace App\Entities\Values;

use Illuminate\Support\Collection;

class BasketProduct
{
    public ?int $id;
    public int $productId;
    public float $price;
    public string $title;
    public bool $deleted;

    public function __construct(?int $id, int $productId, float $price, string $title, bool $deleted = false)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->price = $price;
        $this->title = $title;
        $this->deleted = $deleted;
    }

    public static function create(int $productId, float $price , string $title, bool $deleted = false)
    {
        return new self(null, $productId, $price, $title, $deleted);
    }

    public static function hasProduct(Collection $productsList, int $productId)
    {
        foreach ($productsList as $product)
        {
            if($product->productId == $productId)
            {
                return true;
            }
        }

        return false;
    }

    public function deleted()
    {
        $this->deleted = true;
    }

    public function toArray()
    {
        return [
            'product_id' => $this->productId,
        ];
    }
}
