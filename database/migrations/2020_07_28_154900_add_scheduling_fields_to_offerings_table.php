<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchedulingFieldsToOfferingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->string('title', 300)->nullable();
            $table->boolean('wi')->nullable();
            $table->boolean('si')->nullable();
            $table->string('meeting_days', 5)->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('start_end_times_id')->unsigned()->nullable();

            $table->foreign('type_id')->references('id')->on('form_field_lookups');
            $table->foreign('start_end_times_id')->references('id')->on('form_field_lookups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('offerings', 'title')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }

        if (Schema::hasColumn('offerings', 'wi')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('wi');
            });
        }

        if (Schema::hasColumn('offerings', 'si')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('si');
            });
        }

        if (Schema::hasColumn('offerings', 'meeting_days')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('meeting_days');
            });
        }

        if (Schema::hasColumn('offerings', 'type_id')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropForeign('offerings_type_id_foreign');
            });
        }
        if (Schema::hasColumn('offerings', 'type_id')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('type_id');
            });
        }

        if (Schema::hasColumn('offerings', 'start_end_times_id')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropForeign('offerings_start_end_times_id_foreign');
            });
        }
        if (Schema::hasColumn('offerings', 'start_end_times_id')) {
            Schema::table('offerings', function (Blueprint $table) {
                $table->dropColumn('start_end_times_id');
            });
        }
    }
}
