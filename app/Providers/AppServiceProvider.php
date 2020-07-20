<?php

namespace App\Providers;

use App\Repositories\BasketEloquentRepository;
use App\Repositories\BasketProductEloquentRepository;
use App\Repositories\BasketRepositoryInterface;
use App\Repositories\CustomerEloquentRepository;
use App\Repositories\OrderEloquentRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductEloquentRepository;
use App\Repositories\BasketProductRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\SellerEloquentRepository;
use App\Repositories\SellerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerEloquentRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductEloquentRepository::class);
        $this->app->bind(BasketProductRepositoryInterface::class, BasketProductEloquentRepository::class);
        $this->app->bind(SellerRepositoryInterface::class, SellerEloquentRepository::class);
        $this->app->bind(BasketRepositoryInterface::class, BasketEloquentRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
