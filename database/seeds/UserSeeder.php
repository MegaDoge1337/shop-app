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
        };

        factory(App\UserModel::class, 5)->create()->each($sellersCallback)->each(
            function ($user) {
                $user->seller->product()->saveMany(factory(App\ProductModel::class, 5)->make());
            }
        );
    }
}
