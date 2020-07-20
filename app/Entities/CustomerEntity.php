<?php

namespace App\Entities;

class CustomerEntity
{
    public ?int $id;
    public string $name;
    public string $address;

    public function __construct(?int $id, string $name, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }

    public function changeAddress(string $address)
    {
        //if(!$policy->allowUpdate($this)) throw new \Exception();
        $this->address = $address;
    }

    public function toArray()
    {
        return [
            'address' => $this->address
        ];
    }
}

//class CustomerPolicy
//{
//    protected AuthService $authService;
//
//    public function allowUpdate(CustomerEntity $customer)
//    {
//        $auth = $this->authService->current();
//
//        if ($auth->isAdmin()) return true;
//
//        if (!$auth->hasId($this->id)) return false;
//
//        if ($this->banned) return false;
//
//        return true;
//    }
//}
