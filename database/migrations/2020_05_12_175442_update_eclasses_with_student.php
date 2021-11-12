<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEclassesWithStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eclasses', function (Blueprint $table) {
            $table->string('student', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('eclasses', 'student')) {
            Schema::table('eclasses', function (Blueprint $table) {
                $table->dropColumn('student');
            });
        }
    }
}
