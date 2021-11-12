<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('eclasses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('form_field_lookups', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('offerings', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('parts_of_term', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('eclasses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('form_field_lookups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('offerings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('parts_of_term', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
