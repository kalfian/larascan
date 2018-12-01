<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        //
        'loc' => $faker->city,
        'batch' => $faker->numberBetween(1,99),
        'exp' => $faker->dateTime(),
        'karton' => $faker->numberBetween(1,99),
        'status' => $faker->numberBetween(1,2),
    ];
});
