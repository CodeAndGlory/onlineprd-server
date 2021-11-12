<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments_letters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('letter_id')->unsigned()->nullable();
            $table->bigInteger('assignment_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('letter_id')->references('id')->on('letters');
            $table->foreign('assignment_id')->references('id')->on('assignments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments_letters');
    }
}
