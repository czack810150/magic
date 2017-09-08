<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('newbie');
            $table->string('employeeNumber');
            $table->string('email');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('cName');
            $table->date('hired');
            $table->date('termination')->nullable();
            $table->enum('status',['active','vacation','terminated']);
            $table->timestamps();
        });

        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->integer('employee_id');
            $table->string('sin',10)->nullable();
            $table->string('alias',16)->nullable();
            $table->string('phone',16)->nullable();
            $table->string('address')->nullable();
            $table->string('city',32)->nullable();
            $table->string('state',2)->nullable();
            $table->string('zip',16)->nullable();
            $table->boolean('married')->nullable();
            $table->boolean('sex')->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('img')->default('system/avatar.png');
            $table->timestamps();
        });

          Schema::create('employee_backgrounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->enum('education',['below highschool','highschool','college','university','graduate']);
            $table->string('major',32)->nullable();
            $table->string('school')->nullable();
            $table->boolean('student')->default(false);
            $table->string('hometown')->nullable();
            $table->enum('canada_status',['visitor','study permit','work permit','pr','citizen']);
            $table->string('interest')->nullable();
            $table->string('emergency_person',32)->nullable();
            $table->string('emergency_phone',16)->nullable();
            $table->string('emergency_relation',16)->nullable();
            $table->boolean('english')->default(false);
            $table->boolean('french')->default(false);
            $table->boolean('chiness')->default(true);
            $table->boolean('cantonese')->default(false);
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
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_profiles');
        Schema::dropIfExists('employee_backgrounds');
    }
}
