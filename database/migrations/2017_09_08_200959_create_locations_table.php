<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['store','office','kitchen'])->default('store');
            $table->string('name')->nullable();
            $table->string('shortName')->nullable();
            $table->string('address');
            $table->string('city',32);
            $table->string('province',2);
            $table->string('phone',16);
            $table->string('post',16);
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->integer('head')->nullable();
            $table->timestamps();
        });
        Schema::create('employee_location', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('location_id');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
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
        Schema::dropIfExists('locations');
        Schema::dropIfExists('employee_location');
    }
}
