
<?php

use Faker\Generator as Faker;
use App\Account;
use App\Fund;
use App\Profile;
use App\Bet;
use App\Vote;
use App\signupBonus;
use App\referralBonus;
use App\User;

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
        'phone' => $faker->phoneNumber,
        'status' => 'activated',
        'full_name' => $faker->name,
    ];
});


$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::where('id', '<=' , 1000)->inRandomOrder()->first()->id;
        },
        //'candidate' => rand(1, 4),
        //'category' => rand(1,2),
    ];
});






