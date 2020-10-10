<?php

namespace App\Entities;

use App\Entities\Values\ProductProfile;

class ProductEntity
{
    public ?int $id;
    public int $sellerId;
    public float $price;
    public ProductProfile $profile;

    public function __construct(?int $id, int $sellerId, float $price, ProductProfile $profile)
    {
        $this->id = $id;
        $this->sellerId = $sellerId;
        $this->price = $price;
        $this->profile = $profile;
    }

    public static function create(int $sellerId, float $price, ProductProfile $profile)
    {
        return new self(null, $sellerId, $price, $profile);
    }

    public function changePrice(float $price)
    {
        if($price)
        {
            $this->price = $price;
        }
    }

    public function changeProfile(ProductProfile $profile)
    {
        $this->profile = $profile;
    }

    public function isSeller(int $userId)
    {
        if($userId === $this->sellerId)
        {
            return true;
        }

        return false;
    }

    public function toArray()
    {
        return [
            'seller_id' => $this->sellerId,
            'title' => $this->profile->title,
            'price' => $this->price,
            'description' => $this->profile->description,
            'image_url' => $this->profile->imageUrl
        ];
    }

}
