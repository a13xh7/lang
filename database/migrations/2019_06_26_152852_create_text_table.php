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
            $table->string('title');
            $table->integer('total_symbols');
            $table->integer('total_words');
            $table->integer('unique_words');
            $table->longText('words');
            $table->integer('total_pages')->default(1);
            $table->integer('current_page')->default(1);
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
