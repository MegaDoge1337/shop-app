<?php

namespace App\Services;

class TotalSumCalculator {

    public function handler(array $collections)
    {
        $sum = 0.0;

        foreach ($collections as $collection)
        {
            $sum += $collection->price;
        }

        return $sum;
    }

}
