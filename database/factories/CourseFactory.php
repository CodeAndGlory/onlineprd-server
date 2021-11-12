<?php

/** @var Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'number' => (string) $faker->randomNumber(3),
        'credit_hours' => $faker->randomElement([1, 2, 3, 4]),
    ];
});
