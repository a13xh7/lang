<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_text', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('text_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('translate_to_lang_id');
            $table->integer('current_page')->default(0);

            $table->foreign('text_id')->references('id')->on('texts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_text');
    }
}
