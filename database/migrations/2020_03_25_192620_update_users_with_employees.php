<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersWithEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('prefix_id')->unsigned()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('spartan_id')->unsigned()->nullable()->unique();
            $table->foreign('prefix_id')->references('id')->on('form_field_lookups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_prefix_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'spartan_id',
                'last_name',
                'first_name',
                'prefix_id',
            ]);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
        });
    }
}
