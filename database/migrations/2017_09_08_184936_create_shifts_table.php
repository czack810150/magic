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
            $table->dateTime('scheduleIn')->nullable();
            $table->dateTime('scheduleOut')->nullable();
            $table->dateTime('clockIn')->nullable();
            $table->dateTime('clockOut')->nullable();
            $table->boolean('published')->default(false);
            $table->string('comment');
            $table->timestamps();
            $table->integer('created_by')->unsigned();
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
    }
}
