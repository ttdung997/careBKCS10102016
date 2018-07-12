<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToMedicalApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_applications', function (Blueprint $table) {
              $table->integer('kham');
              $table->string('khoa')->nullable();
              $table->string('chucvu')->nullable();
              $table->string('bangcap')->nullable();
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
            $table->dropColumn('kham');
            $table->dropColumn('khoa');
            $table->dropColumn('chucvu');
            $table->dropColumn('bangcap');
        });
    }
}
