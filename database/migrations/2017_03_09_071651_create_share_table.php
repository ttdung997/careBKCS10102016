<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('share', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resource_owner')->unsigned();
            $table->foreign('resource_owner')->references('id')->on('users')->onDelete('cascade');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->integer('resource_id')->unsigned();
            $table->foreign('resource_id')->references('id')->on('medical_applications')->onDelete('cascade');
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
        Schema::drop('user_role');
    }
}
