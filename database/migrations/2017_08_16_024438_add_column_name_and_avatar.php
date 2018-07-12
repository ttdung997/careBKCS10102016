<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNameAndAvatar extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('name');
            $table->string('avatar')
                    ->default('default.jpg');
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->string('name');
            $table->string('avatar')
                    ->default('default.jpg');
        });
        Schema::table('staffs', function (Blueprint $table) {
            $table->string('name');
            $table->string('avatar')
                    ->default('default.jpg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('doctors', function (Blueprint $table) {
             $table->dropColumn('name');
             $table->dropColumn('avatar');
        });
        Schema::table('patients', function (Blueprint $table) {
             $table->dropColumn('name');
             $table->dropColumn('avatar');
        });
        Schema::table('staffs', function (Blueprint $table) {
             $table->dropColumn('name');
             $table->dropColumn('avatar');
        });
    }

}
