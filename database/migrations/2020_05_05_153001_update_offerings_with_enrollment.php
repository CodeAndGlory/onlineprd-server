<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferingsWithEnrollment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->smallInteger('maximum_enrollment', false, true)->nullable();
            $table->smallInteger('actual_enrollment', false, true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('offerings', 'maximum_enrollment')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('maximum_enrollment');
            });
        }

        if (Schema::hasColumn('offerings', 'actual_enrollment')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('actual_enrollment');
            });
        }

    }
}
