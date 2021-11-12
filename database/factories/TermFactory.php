<?php

/** @var Factory $factory */

use App\Models\Term;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Term::class, function (Faker $faker) {
    return [
        'name' => 'Test Term',
        'start_date' => now(),
        'end_date' => now(),
    ];
});
