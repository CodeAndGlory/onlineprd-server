<?php

/** @var Factory $factory */

use App\Models\Assignment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Assignment::class, function (Faker $faker) {
    return [
        'hours_worked' => $faker->randomNumber(2),
        'stipend' => $faker->randomFloat(2, 0, 5000)
    ];
});
