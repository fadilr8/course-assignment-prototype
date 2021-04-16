<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Student::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'student_id_number' => 1101178000 + rand(1, 100),
    ];
});
