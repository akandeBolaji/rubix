<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->string('location')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('facebook_profile')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->string('google_plus_profile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
