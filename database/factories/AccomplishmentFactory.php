<?php

use Faker\Generator as Faker;
use App\Accomplishment;

$factory->define(Accomplishment::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->realText(50),
        'links' => $faker->url.$faker->slug(4).'/accomplishment',
        'user_id' => function () {
            return App\User::where('id', '<=' , 100)->inRandomOrder()->first()->id;
        },
    ];
});

