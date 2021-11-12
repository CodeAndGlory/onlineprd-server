<?php

/** @var Factory $factory */

use App\Models\DepartmentUserRole;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(DepartmentUserRole::class, function (Faker $faker) {
    return [
//        'user_id' => $faker->randomNumber(1),
//        'department_id' => $faker->randomNumber(2),
//        'role_id' => $faker->randomNumber(1)
    ];
});
