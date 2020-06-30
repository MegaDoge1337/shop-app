<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->streetName,
        'price' => $faker->randomFloat(2, 10, 1000),
        'existence' => $faker->boolean,
    ];
});
