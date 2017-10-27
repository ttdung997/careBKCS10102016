<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalTestApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_test_applications', function (Blueprint $table) {
            $table->increments('medical_id');
            $table->integer('patient_id')->unsigned();
            $table->tinyInteger('status');
            $table->integer('xetnghiem');
            $table->integer('phongban');
            $table->string('url')->unique();
            $table->timestamps();
            $table->foreign('patient_id')
                ->references('patient_id')
                ->on('patients')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_test_applications');
    }
}
