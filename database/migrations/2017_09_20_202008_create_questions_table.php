<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('mc')->default(true);
            $table->text('body');
            $table->unsignedTinyInteger('question_category_id');
            $table->unsignedTinyInteger('difficulty');
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->index('questionCategory_id');
        });
        Schema::create('question_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->string('answer');
            $table->boolean('correct')->default(false);
            $table->timestamps();
            $table->index('question_id');
        });
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->string('name');
            $table->unsignedTinyInteger('score')->nullable();
            $table->boolean('finished')->default(false);
            $table->datetime('taken_at')->nullable();
            $table->timestamps();
        });
         Schema::create('exam_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('question_id');
            $table->integer('answer_id')->nullable();
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
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('question_categories');
    }
}
