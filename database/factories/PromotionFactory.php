<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Promotion;
use Faker\Generator as Faker;

$factory->define(Promotion::class, function (Faker $faker) {
    return [
        'title' => Str::random(10),
        'price' => random_int(0, 9999).random_int(00, 99),
        'address' => random_int(00, 99)." ".Str::random(4)." ".random_int(00, 99)."-".random_int(00, 99)." zona ".random_int(00, 99),
        'latitude' => random_int(00, 99).".".random_int(0, 99999999),
        'longitude' => random_int(00, 99).".".random_int(0, 99999999),
    ];
});
