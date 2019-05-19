<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Language;
use App\Models\Course;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Course::class, function (Faker $faker) {
    /* @var Language $language */
    $language = Language::inRandomOrder()->first();
    $level = $faker->numberBetween(1, 7);
    return [
        'language_id' => $language->id,
        'name' => 'Berlitz ' . $language->name . ' ' . $level,
        'description' => $faker->text(100),
        'year' => $faker->numberBetween(1999, 2019),
        'level' => $level,
    ];
});
