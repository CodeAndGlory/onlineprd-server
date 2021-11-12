<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('subject_id')->unsigned()->nullable();
            $table->string('number', 10)->nullable();
            $table->tinyInteger('credit_hours')->nullable();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('subject_id')->references('id')->on('form_field_lookups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
