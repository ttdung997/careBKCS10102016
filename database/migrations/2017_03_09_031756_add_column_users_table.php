<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->boolean('is_local')->default(true);
            $table->string('domain')->nullable();
            $table->string('last_auth')->nullable();
            $table->string('expired')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table){
            $table->dropColumn('is_local');
            $table->dropColumn('domain');
            $table->dropColumn('last_auth');
            $table->dropColumn('expired');
        });
    }
}
