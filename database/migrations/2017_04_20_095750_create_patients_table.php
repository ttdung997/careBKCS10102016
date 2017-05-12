<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
            $table->string('url')->nullable();
            $table->string('gender')->nullable();
            $table->datetime('birthday')->nullable();
            $table->string('id_number')->nullable();
            $table->datetime('id_date')->nullable();
            $table->string('id_address')->nullable();
            $table->string('permanent_residence')->nullable();
            $table->string('staying_address')->nullable();
            $table->string('job')->nullable();
            $table->string('company')->nullable();
            $table->string('family_history')->nullable();
            $table->string('personal_history')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
