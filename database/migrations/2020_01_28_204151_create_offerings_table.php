<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offerings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_id')->unsigned()->nullable();
            $table->integer('crn')->nullable();
            $table->integer('part_of_term_id')->unsigned()->nullable();
            $table->integer('campus_id')->unsigned()->nullable();
            $table->string('section', 10)->nullable();
            $table->string('note', 1000)->nullable();
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('part_of_term_id')->references('id')->on('parts_of_term');
            $table->foreign('campus_id')->references('id')->on('form_field_lookups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offerings');
    }
}
