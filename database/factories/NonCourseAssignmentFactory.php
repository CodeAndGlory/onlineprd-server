<?php

/** @var Factory $factory */

use App\Models\NonCourseAssignment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(NonCourseAssignment::class, function (Faker $faker) {
    return [
        'hours_worked' => random_int(3, 40),
        'stipend' => $faker->randomFloat(2, 0, 10000),
    ];
});
