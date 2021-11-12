<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonCourseAssignmentsLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_course_assignments_letters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('letter_id')->unsigned()->nullable();
            $table->bigInteger('non_course_assignment_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('letter_id')->references('id')->on('letters');
            $table->foreign('non_course_assignment_id')->references('id')->on('non_course_assignments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_course_assignments_letters');
    }
}
