<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TotalSumCalculatorProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('TotalSumCalculator', function()
        {
            return new \App\Services\TotalSumCalculator;
        });
    }
}
