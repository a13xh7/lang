<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->integer('lang_id');
            $table->integer('translate_to_lang_id');
            $table->integer('current_page')->default(1);
            $table->string('title');
            $table->integer('total_symbols');
            $table->integer('total_pages')->default(1);
            $table->integer('total_words');
            $table->integer('unique_words');
            $table->longText('words');
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
        Schema::dropIfExists('texts');
    }
}
