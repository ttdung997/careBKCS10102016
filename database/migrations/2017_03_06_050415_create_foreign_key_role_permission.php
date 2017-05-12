<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeyRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_permission', function($table){
            $table->integer('role_id')->unsigned()->change();
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade')->change();
            $table->integer('permission_id')->unsigned()->change();
            $table->foreign('permission_id')->references('id')->on('permission')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_permission', function($table){
            $table->dropForeign(['role_id']);
            $table->dropForeign(['permission_id']);
        });
    }
}
