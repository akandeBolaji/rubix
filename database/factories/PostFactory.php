<?php

use Faker\Generator as Faker;
use App\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'text' => $faker->realText(1500),
        'user_id' => function () {
            return App\User::where('id', '<=' , 100)->inRandomOrder()->first()->id;
        },

    ];
});
