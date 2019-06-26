<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texts', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('language_id');
            $table->string('title');
            $table->integer('total_pages')->default(1);;
            $table->integer('current_page')->default(1);;
            $table->timestamp('created_at');
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
