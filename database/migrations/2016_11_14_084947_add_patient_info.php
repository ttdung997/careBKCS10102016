<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPatientInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
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
        Schema::table('users', function ($table) {
        $table->dropColumn([
            'gender',
            'birthday',
            'id_number',
            'id_date',
            'id_address',
            'permanent_residence',
            'staying_address',
            'job',
            'company',
            'family_history',
            'personal_history',
            ]);
        });
    }        
    
}
