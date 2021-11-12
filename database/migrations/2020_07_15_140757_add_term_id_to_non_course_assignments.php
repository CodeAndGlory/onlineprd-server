<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermIdToNonCourseAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('non_course_assignments', function (Blueprint $table) {
            $table->integer('term_id')->unsigned()->nullable();

            $table->foreign('term_id')
                ->references('id')
                ->on('terms')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('non_course_assignments', function (Blueprint $table) {
            $table->dropForeign('non_course_assignments_term_id_foreign');
        });

        Schema::table('non_course_assignments', function (Blueprint $table) {
            $table->dropColumn(['term_id']);
        });
    }
}
