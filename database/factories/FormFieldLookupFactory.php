<?php

/** @var Factory $factory */

use App\Models\FormFieldLookup;
use Illuminate\Database\Eloquent\Factory;

$factory->define(FormFieldLookup::class, function () {
    return [
        'field' => 'test',
        'abbreviation' => 'test',
        'name' => 'Test Record',
    ];
});

$factory->state(FormFieldLookup::class, 'campus', [
    'field' => 'campus',
]);

$factory->state(FormFieldLookup::class, 'college', [
    'field' => 'college',
]);

$factory->state(FormFieldLookup::class, 'eclass', [
    'field' => 'eclass',
]);

$factory->state(FormFieldLookup::class, 'position', [
    'field' => 'position',
]);

$factory->state(FormFieldLookup::class, 'prefix', [
    'field' => 'prefix',
]);

$factory->state(FormFieldLookup::class, 'state', [
    'field' => 'state',
]);

$factory->state(FormFieldLookup::class, 'subject', [
    'field' => 'subject',
]);
