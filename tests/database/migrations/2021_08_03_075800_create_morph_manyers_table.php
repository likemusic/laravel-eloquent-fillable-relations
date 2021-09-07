<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMorphManyersTable extends Migration
{
    const TABLE_NAME = 'morph_manyers';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->unsignedInteger('manyerable_id');
            $table->string('manyerable_type');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(self::TABLE_NAME);
    }
}