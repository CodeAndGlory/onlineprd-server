<?php

/** @var Factory $factory */

use App\Models\PartOfTerm;
use App\Models\Term;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(PartOfTerm::class, function (Faker $faker) {
    return [
        'name' => 'Test Part of Term',
        'term_id' => function () {
            return factory(Term::class)->create()->id;
        },
        'start_date' => now(),
        'end_date' => now(),
    ];
});
