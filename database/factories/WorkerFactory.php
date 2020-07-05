<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'cin' => $faker->randomNumber(8),
        'phone_number' => $faker->randomNumber(8),
        'verified' => $faker->boolean(10),
        'rating' => 2.5,

    ];
});
