<?php

/** @var Factory $factory */

use App\Models\Department;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'department_phone_number' => (int) preg_replace('/[^0-9]/', '', $faker->phoneNumber),
    ];
});
