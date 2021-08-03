<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->unsignedInteger('main_id');
            $table->foreign('main_id')->references('id')->on('mains');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('details');
    }
}