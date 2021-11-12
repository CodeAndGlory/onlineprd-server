<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Permission;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'guard_name' => 'web'
    ];
});
