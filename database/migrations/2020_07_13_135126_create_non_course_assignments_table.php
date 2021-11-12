<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonCourseAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_course_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->integer('position_id')->nullable()->unsigned();
            $table->integer('campus_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->bigInteger('eclass_id')->unsigned()->nullable();
            $table->integer('hours_worked')->nullable();
            $table->decimal('stipend', 8, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('accept_assignment')->nullable();
            $table->string('signature', 100)->nullable();
            $table->timestamp('signature_timestamp')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('position_id')->references('id')->on('form_field_lookups');
            $table->foreign('campus_id')->references('id')->on('form_field_lookups');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('eclass_id')->references('id')->on('eclasses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_course_assignments');
    }
}
