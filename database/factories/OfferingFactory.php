<?php

/** @var Factory $factory */

use App\Models\Offering;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Offering::class, function (Faker $faker) {
    return [
        'crn' => $faker->randomNumber(5),
        'section' => (string) $faker->randomNumber(2)
    ];
});
