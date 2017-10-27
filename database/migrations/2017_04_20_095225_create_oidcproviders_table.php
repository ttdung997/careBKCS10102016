<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOidcprovidersTable extends Migration
{
    /**
     * Run the migrations.
     *  Tạo bảng OidcProviders để lưu thông tin về các OpenId Provider.
     * @return void
     */
    public function up()
    {
        Schema::create('oidcproviders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_provider')->unique();
            $table->string('name_provider')->nullable();
            $table->string('domain')->nullable();
            $table->string('registration_endpoint');
            $table->string('authen_endpoint');
            $table->string('del_endpoint');
            $table->string('info_endpoint');
            $table->string('session_endpoint');
            $table->string('id_token_endpoint');
            $table->string('client_id');
            $table->string('key_secret');
            $table->string('algorithm');
            $table->string('max_age')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oidcproviders');
    }
}
