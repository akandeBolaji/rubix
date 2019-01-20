<?php

use Faker\Generator as Faker;
use App\Experience;

$factory->define(Experience::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'location' => $faker->city. "," .$faker->country,
        'start_date' => $faker->monthName. "," .$faker->year,
        'end_date' => $faker->monthName. "," .$faker->year,
        'user_id' => function () {
            return App\User::where('id', '<=' , 100)->inRandomOrder()->first()->id;
        },

    ];
});

