<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year',4);
            $table->integer('minimumPay')->unsigned;
            $table->tinyInteger('overtime')->unsigned;
            $table->float('overtime_pay');
            $table->float('premium_pay');
            $table->float('server');
            $table->float('cook');
            $table->float('noodle');
            $table->float('dish');
            $table->unsignedTinyInteger('lateIn');
            $table->unsignedTinyInteger('earlyIn');
            $table->unsignedTinyInteger('lateOut');
            $table->unsignedTinyInteger('earlyOut');
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
        Schema::dropIfExists('payroll_config');
    }
}
