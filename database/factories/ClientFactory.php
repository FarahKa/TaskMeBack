<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'cin' => $faker->randomNumber(8),
        'phone_number' => $faker->randomNumber(8),
                'rating' => 2.5,
    ];
});
