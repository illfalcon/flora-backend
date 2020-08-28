<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Flower;
use Faker\Generator as Faker;

$factory->define(Flower::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'info' => $faker->paragraph
    ];
});
