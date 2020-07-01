<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->streetName,
        'price' => $faker->randomFloat(2, 10, 1000),
        'description' => $faker->sentence(5),
        'image_url' => "localhost:8000/images/img{$faker->randomDigit}.png",
        'existence' => $faker->boolean,
    ];
});
