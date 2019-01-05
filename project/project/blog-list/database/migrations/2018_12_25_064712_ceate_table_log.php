<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CeateTableLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->comment('操作用户的id');
            $table->string('url')->comment('接口的url');
            $table->string('method')->comment('请求的方法');
            $table->string('params')->comment('请求的参数');
            $table->string('ip')->default('0.0.0.0')->comment('请求人的');
            $table->string('operation')->default('')->comment('接口注释');
            $table->longText('response')->default('')->comment('响应数据');
            $table->integer('time')->default(0);
            //时间戳
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('logs');
    }
}
