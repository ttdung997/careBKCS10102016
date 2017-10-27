<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOidcclientsTable extends Migration
{
    /**
     * Run the migrations.
     *  Tạo bảng OidcClients để lưu thông tin về các Clients đăng ký.
     * @return void
     */
    public function up()
    {
        Schema::create('oidcclients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id');
            $table->string('client_name')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('algorithm')->nullable();
            $table->string('key_secret')->nullable();
            $table->string('domain')->unique();
            $table->string('del_endpoint');
            $table->string('contact')->nullable();
            $table->string('provider_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oidcclients');
    }
}
