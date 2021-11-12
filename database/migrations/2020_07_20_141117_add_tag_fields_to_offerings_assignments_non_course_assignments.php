<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagFieldsToOfferingsAssignmentsNonCourseAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->timestamp('confirmed')->nullable();
            $table->timestamp('verified')->nullable();
            $table->timestamp('edited')->nullable();
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->timestamp('confirmed')->nullable();
            $table->timestamp('verified')->nullable();
            $table->timestamp('stipend_verified')->nullable();
            $table->timestamp('edited')->nullable();
            $table->timestamp('approved')->nullable();
            $table->timestamp('notified')->nullable();
            $table->timestamp('superseded')->nullable();
            $table->timestamp('accepted')->nullable();
            $table->timestamp('prorate_accepted')->nullable();
        });

        Schema::table('non_course_assignments', function (Blueprint $table) {
            $table->timestamp('confirmed')->nullable();
            $table->timestamp('verified')->nullable();
            $table->timestamp('stipend_verified')->nullable();
            $table->timestamp('edited')->nullable();
            $table->timestamp('approved')->nullable();
            $table->timestamp('notified')->nullable();
            $table->timestamp('superseded')->nullable();
            $table->timestamp('accepted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropColumn(['confirmed', 'verified', 'edited']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed', 'verified', 'stipend_verified', 'edited', 'approved', 'notified', 'superseded', 'accepted',
                'prorate_accepted'
            ]);
        });

        Schema::table('non_course_assignments', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed', 'verified', 'stipend_verified', 'edited', 'approved', 'notified', 'superseded', 'accepted'
            ]);
        });
    }
}
