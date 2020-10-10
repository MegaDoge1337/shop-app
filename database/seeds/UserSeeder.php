<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sellersCallback = function ($user) {
            $user->seller()->save(factory(App\SellerModel::class)->make());
            $user->customer()->save(factory(App\CustomerModel::class)->make());
        };

        factory(App\User::class, 5)->create()->each($sellersCallback)->each(
            function ($user) {
                $user->seller->products()->saveMany(factory(App\ProductModel::class, 5)->make());
            }
        );
    }
}
