
<?php

use Faker\Generator as Faker;
use App\User;
use App\Profile;
use App\Post;
use App\Skill;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'ip' => $faker->ipv4,
        'headline' => $faker->jobTitle,
        'phone' => $faker->phoneNumber,
        'status' => 'activated',
        'last_seen' => $faker->dateTime,
        'view' => $faker->randomDigit,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
    ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $user->profile()->save(factory(Profile::class)->make());
    $user->posts()->save(factory(Post::class)->make());
    $user->skills()->save(factory(Skill::class)->make());
});








