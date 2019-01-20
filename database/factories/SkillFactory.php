<?php

use Faker\Generator as Faker;
use App\Skill;

$factory->define(Skill::class, function (Faker $faker) {
    return [
        'description' => $faker->jobTitle,
        'user_id' => function () {
            return App\User::where('id', '<=' , 100)->inRandomOrder()->first()->id;
        },
    ];
});
