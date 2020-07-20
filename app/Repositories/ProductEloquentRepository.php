<?php

namespace App\Repositories;

use App\Entities\ProductEntity;
use App\Entities\Profiles\ProductProfile;
use App\ProductModel;

class ProductEloquentRepository implements ProductRepositoryInterface
{
    public function findAllBySellerId(int $id)
    {

        return ProductModel::where('seller_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($product) {
                return new ProductEntity(
                    $product->id,
                    $product->seller_id,
                    $product->price,
                    new ProductProfile(
                        $product->title,
                        $product->description,
                        $product->image_url
                    )
                );
            });
    }

    public function findById(int $id)
    {
        $product = ProductModel::findOrFail($id);

        return new ProductEntity(
            $product->id,
            $product->seller_id,
            $product->price,
            new ProductProfile(
                $product->title,
                $product->description,
                $product->image_url
            )
        );
    }

    public function findByBasketProducts(array $basketProducts)
    {
        $products = [];

        foreach ($basketProducts as $basketProduct)
        {
            $product = ProductModel::findOrFail($basketProduct->productId);

            $products[] = new ProductEntity(
                $product->id,
                $product->seller_id,
                $product->price,
                new ProductProfile(
                    $product->title,
                    $product->description,
                    $product->image_url
                )
            );
        }

        return $products;
    }

    public function add(ProductEntity $productEntity)
    {
        if (!ProductModel::find($productEntity->id)) {
            return ProductModel::create($productEntity->toArray());
        }

        return null;
    }

    public function save(ProductEntity $productEntity)
    {

        ProductModel::findOrNew($productEntity->id)->fill($productEntity->toArray())->save();
    }

    public function delete(ProductEntity $productEntity)
    {
        ProductModel::findOrFail($productEntity->id)->delete();
    }
}
