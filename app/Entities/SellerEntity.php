<?php

namespace App\Entities;

class SellerEntity
{
    public int $id;
    public string $name;
    public string $address;

    public function __construct(int $id, string $name, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }

    public function changeAddress(string $address)
    {
        $this->address = $address;
    }
}
