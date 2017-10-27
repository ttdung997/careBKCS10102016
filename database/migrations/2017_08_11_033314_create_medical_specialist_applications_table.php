<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalSpecialistApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_specialist_applications', function (Blueprint $table) {
            $table->increments('medical_id');
            $table->datetime('date');
            $table->integer('patient_id')->unsigned();
            $table->integer('medical_type');
            $table->integer('phongban');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('medical_specialist_applications');
    }
}
