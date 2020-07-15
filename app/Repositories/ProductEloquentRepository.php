<?php

namespace App\Repositories;

use App\Entities\ProductEntity;
use App\Entities\Profiles\ProductProfile;
use App\ProductModel;
use App\SellerModel;

class ProductEloquentRepository implements ProductRepositoryInterface
{
    public function findAllBySellerId(int $id)
    {
        $products = [];

        SellerModel::findOrFail($id)
            ->product()
            ->orderBy('created_at', 'desc')
            ->each(function ($product) use (&$products) {
                $products[] = new ProductEntity(
                    $product->id,
                    $product->seller_id,
                    $product->profile = new ProductProfile(
                        $product->title,
                        $product->price,
                        $product->description,
                        $product->image_url),
                    $product->created_at,
                    $product->updated_at);
            });

        return collect($products);
    }

    public function findById(int $id)
    {
        $product = ProductModel::findOrFail($id);

        return new ProductEntity(
            $product->id,
            $product->seller_id,
            $product->profile = new ProductProfile(
                $product->title,
                $product->price,
                $product->description,
                $product->image_url),
            $product->created_at,
            $product->updated_at);
    }

    public function add(array $data)
    {
        $data['seller_id'] = \Auth::user()->seller->id;

        return ProductEntity::create($data);
    }

    public function save(ProductEntity $productEntity)
    {
        $data = [
            'seller_id' => $productEntity->sellerId,
            'title' => $productEntity->profile->title,
            'price' => $productEntity->profile->price,
            'description' => $productEntity->profile->description,
            'image_url' => $productEntity->profile->imageUrl
        ];

        ProductModel::findOrNew($productEntity->id)->fill($data)->save();
    }

    public function delete(ProductEntity $productEntity)
    {
        ProductModel::findOrFail($productEntity->id)->delete();
    }
}
