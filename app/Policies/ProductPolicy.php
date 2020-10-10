<?php

namespace App\Policies;

use App\Repositories\ProductRepositoryInterface;

class ProductPolicy
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function allowManage(int $userId, int $productId)
    {
        $product = $this->productRepository->findById($productId);

        if($product->isSeller($userId)) return true;

        return false;
    }
}
