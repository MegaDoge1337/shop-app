<?php

namespace App\Services;

class TotalSumCalculator {

    public function productPricesSum(array $products)
    {
        $sum = 0.0;

        foreach ($products as $product)
        {
            $sum += $product->price;
        }

        return $sum;
    }

}
