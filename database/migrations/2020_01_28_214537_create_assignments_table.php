<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->integer('position_id')->nullable()->unsigned();
            $table->bigInteger('offering_id')->nullable()->unsigned();
            $table->integer('hours_worked')->nullable();
            $table->decimal('stipend', 8, 2)->nullable();
            $table->boolean('accept_assignment')->nullable();
            $table->integer('minimum_enrollment')->nullable();
            $table->boolean('accept_prorate')->nullable();
            $table->string('signature', 100)->nullable();
            $table->timestamp('signature_timestamp')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('position_id')->references('id')->on('form_field_lookups');
            $table->foreign('offering_id')->references('id')->on('offerings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
