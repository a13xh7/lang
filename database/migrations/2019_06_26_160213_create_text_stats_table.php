<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_stats', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->integer('text_id');
            $table->integer('user_id');
            $table->integer('total_words');
            $table->integer('known_words');
            $table->integer('unknown_words');
            $table->json('words');
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
        Schema::dropIfExists('text_stats');
    }
}
