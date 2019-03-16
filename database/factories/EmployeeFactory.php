<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'position' => $faker->jobTitle,
        'hired' => $faker->date(),
        'salary' => $faker->numberBetween(700, 5000),
        'parent_id' => null,
    ];
});
