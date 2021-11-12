<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_number', 100)->nullable();
            $table->string('chair', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('abbreviation')->nullable();
            $table->string('department_building', 100)->nullable();
            $table->string('department_office_number', 25)->nullable();
            $table->bigInteger('department_phone_number')->nullable();
            $table->bigInteger('contact_user_id')->unsigned()->nullable();
            $table->integer('college_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('contact_user_id')->references('id')->on('users');
            $table->foreign('college_id')->references('id')->on('form_field_lookups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
