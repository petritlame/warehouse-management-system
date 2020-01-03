<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arka', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('data');
            $table->integer('nr_arketimi');
            $table->integer('nr_pagese');
            $table->longText('shpjegmi');
            $table->float('hyrjet');
            $table->float('daljet');
            $table->float('gjendja');
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
        Schema::dropIfExists('arka');
    }
}
