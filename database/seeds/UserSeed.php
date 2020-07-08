<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'test@rubix.com',
            'password' => Hash::make('password'), // secret
            'remember_token' => str_random(10),
            'ip' => '197.45.57.6',
            'headline' => 'Works at FooBar',
            'phone' => '080456788657',
            'status' => 'activated',
            'view' => 4,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        User::create([
            'email' => 'test1@rubix.com',
            'password' => Hash::make('password'), // secret
            'remember_token' => str_random(10),
            'ip' => '197.45.57.6',
            'headline' => 'Works at FooBar',
            'phone' => '080456788687',
            'status' => 'activated',
            'view' => 4,
            'first_name' => 'Frank',
            'last_name' => 'Tim',
        ]);

        User::create([
            'email' => 'test2@rubix.com',
            'password' => Hash::make('password'), // secret
            'remember_token' => str_random(10),
            'ip' => '197.45.57.6',
            'headline' => 'Works at FooBar',
            'phone' => '08046788657',
            'status' => 'activated',
            'view' => 4,
            'first_name' => 'Jeff',
            'last_name' => 'Cook',
        ]);
    }
}
