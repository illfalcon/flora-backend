<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Card;
use Faker\Generator as Faker;

$factory->define(Card::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'message'=> $faker->paragraph,
        'flower_id' => factory(\App\Flower::class),
        'destination' => $faker->name
    ];
});
