<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnersTable extends Migration
{
    const TABLE_NAME = 'oners';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->unsignedInteger('main_id');
            $table->foreign('main_id')->references('id')->on('mains');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(self::TABLE_NAME);
    }
}