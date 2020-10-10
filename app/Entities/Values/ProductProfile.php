<?php

namespace App\Entities\Values;

class ProductProfile
{
    public string $title;
    public string $description;
    public string $imageUrl;

    public function __construct(string $title, string $description, string $imageUrl)
    {
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    public function changeProfile(string $title, string $description, string $imageUrl)
    {
        if($title)
        {
            $this->title = $title;
        }

        if($description)
        {
            $this->description = $description;
        }

        if($imageUrl)
        {
            $this->imageUrl = $imageUrl;
        }
    }

    public static function create(string $title, string $description, string $imageUrl)
    {
        return new self($title, $description, $imageUrl);
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->imageUrl,
        ];
    }
}
