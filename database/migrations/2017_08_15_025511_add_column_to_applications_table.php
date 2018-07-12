<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_applications', function (Blueprint $table) {
             $table->date('medical_date')->nullable();
        });
        Schema::table('medical_specialist_applications', function (Blueprint $table) {
             $table->date('medical_date')->nullable();
        });
        Schema::table('medical_test_applications', function (Blueprint $table) {
             $table->date('medical_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_applications', function (Blueprint $table) {
              $table->dropColumn('medical_date');
        });
        Schema::table('medical_specialist_applications', function (Blueprint $table) {
              $table->dropColumn('medical_date');
        });
        Schema::table('medical_test_applications', function (Blueprint $table) {
              $table->dropColumn('medical_date');
        });
    }
}
