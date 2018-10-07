<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('published')->default(false);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->integer('created_by')->unsigned();
        });
         Schema::create('clocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->dateTime('clockIn');
            $table->dateTime('clockOut')->nullable();
            $table->string('comment')->nullable;
            $table->timestamps();
        });
           Schema::create('ins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clock_id');
            $table->integer('employee_id');
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
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('clocks');
        Schema::dropIfExists('ins');
    }
}
