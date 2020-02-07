<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_page', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('text_id');
            $table->integer('page_number');
            $table->text('content');

            $table->foreign('text_id')->references('id')->on('text')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_pages');
    }
}
