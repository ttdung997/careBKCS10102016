<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMedical extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_applications', function (Blueprint $table) {
             $table->smallInteger('Shift')->nullable()->default(1);
        });
        Schema::table('medical_specialist_applications', function (Blueprint $table) {
             $table->smallInteger('Shift')->nullable()->default(1);
             $table->mediumText('so_bo')->nullable();
             $table->mediumText('chan_doan')->nullable();
        });
        Schema::table('medical_test_applications', function (Blueprint $table) {
             $table->smallInteger('Shift')->nullable()->default(1);
             $table->smallInteger('register_by')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_specialist_applications', function (Blueprint $table) {
            //
        });
    }
}
