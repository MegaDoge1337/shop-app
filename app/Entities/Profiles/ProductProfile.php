<?php

namespace App\Entities\Profiles;

class ProductProfile
{
    public string $title;
    public float $price;
    public string $description;
    public string $imageUrl;

    public function __construct(string $title, float $price, string $description, string $imageUrl)
    {
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    public function changeProfile(array $data)
    {
        foreach ($data as $field => $value)
        {
            if($field == 'title')
            {
                $this->title = $value;
            }

            if($field == 'price')
            {
                $this->price = $value;
            }

            if($field == 'description')
            {
                $this->description = $value;
            }

            if($field == 'imageUrl')
            {
                $this->imageUrl = $value;
            }
        }
    }
}
