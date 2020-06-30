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
            $user->seller()->save(factory(App\Seller::class)->make());
        };

        factory(App\User::class, 5)->create()->each($sellersCallback)->each(
            function ($user) {
                $user->seller->product()->saveMany(factory(App\Product::class, 5)->make());
            }
        );
    }
}
