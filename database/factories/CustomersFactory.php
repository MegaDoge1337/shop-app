<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\CustomerModel::class, function (Faker $faker) {
    return [
        'address' => $faker->unique()->address,
    ];
});
