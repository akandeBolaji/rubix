<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Profile;
use App\Post;
use App\Experience;
use App\Accomplishment;
use App\Skill;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         // Un Guard model

         // Ask for db migration refresh, default is no
         if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {

             // Call the php artisan migrate:fresh using Artisan
             $this->command->call('migrate:fresh');

             $this->command->line("Data cleared, starting from blank database.");
         }
         $this->call([
            UserSeed::class,
         ]);
         $users = factory(User::class, 100)->create();
         factory(Post::class, 367)->create();
         factory(Experience::class, 103)->create();
         factory(Accomplishment::class, 120)->create();
         factory(Skill::class, 200)->create();



         $this->command->info("Hurrah! Database has been seeded.");
    }
}
