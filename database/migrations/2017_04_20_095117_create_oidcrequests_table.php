<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOidcrequestsTable extends Migration
{
    /**
     * Run the migrations.
     * Bảng này chứa tất cả các Đăng ký Request đến server này/đi server khác.
     * @return void
     */
    public function up()
    {
        Schema::create('oidcrequests', function (Blueprint $table) {
            $table->increments('id');
            // 'domain' chứa URL registration endpoint của OP nếu là request đi, chứa domain của RP nếu là request đến.
            $table->string('domain')->unique();
            $table->string('company')->nullable();
            $table->string('url_callback')->nullable();
            $table->string('url_rp_get_result')->nullable();
            $table->string('url_rp_delete')->nullable();
            $table->string('algorithm')->nullable();
            $table->string('max_age')->nullable();
            $table->string('contacts')->nullable();
            $table->tinyInteger('isAccept')->default(-1); // 1 = request đc OP chấp nhận, 0 = không đc OP chấp nhận, các giá trị khác = chưa đc xử lý.
            $table->boolean('request_type')->default(true); // true = request đi, false = request đến.
            $table->boolean('status')->default(false); // true = đã được xử lý, ngược lại false.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oidcrequests');
    }
}
