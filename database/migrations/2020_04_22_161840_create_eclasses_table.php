<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEclassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eclasses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('abbreviation', 10)->nullable();
            $table->string('description')->nullable();
            $table->boolean('full_time')->nullable();
            $table->string('category')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('eclasses');
    }
}
