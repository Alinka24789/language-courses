<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Unit;
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

$factory->define(Unit::class, function (Faker $faker) {
    /* @var Course $course */
    $course = Course::inRandomOrder()->first();
    return [
        'course_id' => $course->id,
        'name' => 'Unit ' . $faker->text(20)
    ];
});
