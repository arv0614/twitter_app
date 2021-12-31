<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_users', function (Blueprint $table) {
              $table->increments('uniqu_key');
              $table->bigInteger('id')->nullable(false);
              $table->string('id_str')->nullable(true);
              $table->string('name')->nullable(true);
              $table->string('screen_name')->nullable(true);
              $table->string('location')->nullable(true);
              $table->string('description')->nullable(true);
              $table->string('url')->nullable(true);
              //$table->string('entities')->nullable(true);{#277 ▶}
              $table->string('protected')->nullable(true);
              $table->bigInteger('followers_count')->nullable(true);
              $table->bigInteger('friends_count')->nullable(true);
              $table->bigInteger('listed_count')->nullable(true);
              $table->bigInteger('favourites_count')->nullable(true);
              $table->string('utc_offset')->nullable(true);
              $table->string('time_zone')->nullable(true);
              $table->string('geo_enabled')->nullable(true);
              $table->string('verified')->nullable(true);
              $table->bigInteger('statuses_count')->nullable(true);
              $table->string('lang')->nullable(true);
              $table->string('contributors_enabled')->nullable(true);
              $table->string('is_translator')->nullable(true);
              $table->string('is_translation_enabled')->nullable(true);
              $table->string('profile_background_color')->nullable(true);
              $table->string('profile_background_image_url')->nullable(true);
              $table->string('profile_background_image_url_https')->nullable(true);
              $table->string('profile_background_tile')->nullable(true);
              $table->string('profile_image_url')->nullable(true);
              $table->string('profile_image_url_https')->nullable(true);
              $table->string('profile_banner_url')->nullable(true);
              $table->string('profile_link_color')->nullable(true);
              $table->string('profile_sidebar_border_color')->nullable(true);
              $table->string('profile_sidebar_fill_color')->nullable(true);
              $table->string('profile_text_color')->nullable(true);
              $table->string('profile_use_background_image')->nullable(true);
              $table->string('has_extended_profile')->nullable(true);
              $table->string('default_profile')->nullable(true);
              $table->string('default_profile_image')->nullable(true);
              $table->string('following')->nullable(true);
              $table->string('follow_request_sent')->nullable(true);
              $table->string('notifications')->nullable(true);
              $table->string('translator_type')->nullable(true);
            //$table->string('withheld_in_countries')->nullable(true);[]
              
              $table->timestamp('created_at')->nullable(true);
              $table->timestamp('updated_at')->nullable(true);
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tw_users');
    }
}
