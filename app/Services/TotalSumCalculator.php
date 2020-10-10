<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TotalSumCalculator {

    public function productPricesSum(Collection $products)
    {
        $sum = 0.0;

        foreach ($products as $product)
        {
            $sum += $product->price;
        }

        return $sum;
    }

}
