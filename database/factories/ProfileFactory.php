<?php

use Faker\Generator as Faker;
use App\Profile;

$factory->define(Profile::class, function (Faker $faker) {
    $city = $faker->city;
    $country = $faker->country;
    return [
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'location' => $city. ',' .$country,
        'linkedin_profile' => "https://linkedin.com/".$faker->userName,
        'facebook_profile' => "https://facebook.com/".$faker->userName,
        'twitter_profile' => "https://twitter.com/".$faker->userName,
    ];
});
