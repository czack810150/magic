<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('top')->nullable();
            $table->boolean('hour')->default(true);
            $table->boolean('valid')->default(true);
            $table->enum('type',['server','cook','noodle','driver','dish','pantry','chef','office','management','hq']);
            $table->string('rank',32);
            $table->string('short',16);
            $table->integer('rate');
            $table->enum('night',['f','b','d','o','n']);
            $table->float('tip')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
