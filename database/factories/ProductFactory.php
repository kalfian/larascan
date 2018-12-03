<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        //
        'loc' => $faker->city,
        'batch' => $faker->numberBetween(1,99),
        'exp' => $faker->date(),
        'karton' => $faker->numberBetween(1,20),
        'status' => $faker->numberBetween(1,2),
    ];
});
