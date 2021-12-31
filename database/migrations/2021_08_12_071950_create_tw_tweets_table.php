<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwTweetsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_tweets', function (Blueprint $table) {
              $table->increments('uniqu_key');
              $table->bigInteger('id')->nullable(true);
              $table->string('id_str')->nullable(true);
              $table->string('text')->nullable(true);
              $table->string('truncated')->nullable(true);
              //$table->string('entities')->nullable(true); {#272 ▶}
              //$table->string('metadata')->nullable(true); {#274 ▶}
              $table->string('source')->nullable(true); 
              $table->string('in_reply_to_status_id')->nullable(true);
              $table->string('in_reply_to_status_id_str')->nullable(true);
              $table->string('in_reply_to_user_id')->nullable(true);
              $table->string('in_reply_to_user_id_str')->nullable(true);
              $table->string('in_reply_to_screen_name')->nullable(true);
              $table->string('user_id_str')->nullable(true);
              $table->string('user_screen_name')->nullable(true);
              $table->string('geo')->nullable(true);
              $table->string('coordinates')->nullable(true);
              $table->string('place')->nullable(true);
              $table->string('contributors')->nullable(true);
              //$table->string('retweeted_status')->nullable(true); {#278 ▶}
              $table->string('is_quote_status')->nullable(true); 
              $table->bigInteger('retweet_count')->nullable(true);
              $table->bigInteger('favorite_count')->nullable(true);
              $table->string('favorited')->nullable(true);
              $table->string('retweeted')->nullable(true);
              $table->string('lang')->nullable(true);
              
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
        Schema::dropIfExists('tw_tweets');
    }
}
