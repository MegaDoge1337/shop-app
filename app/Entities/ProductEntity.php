<?php

namespace App\Entities;

use App\Entities\Profiles\ProductProfile;

class ProductEntity
{
    public int $id;
    public int $sellerId;
    public ProductProfile $profile;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(int $id,
                                int $sellerId,
                                ProductProfile $profile,
                                string $createdAt,
                                string $updatedAt)
    {
        $this->id = $id;
        $this->sellerId = $sellerId;
        $this->profile = $profile;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function changeProfile(array $data)
    {
        $this->profile->changeProfile($data);
    }

    public function canBeDeleted($policy)
    {
        if($policy) return $this;
        return null;
    }

    public static function create(array $data)
    {
        $profile = new ProductProfile($data['title'], $data['price'], $data['description'], $data['image_url']);

        return new self(0,
            $data['seller_id'],
            $profile, // ProductProfile
            'product:createdAt',
            'product:updatedAt');
    }
}
