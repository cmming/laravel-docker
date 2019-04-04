<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermicalOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_termical_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('termical_id')->comment('机器id');
            $table->date('date')->comment('预约日期');
            $table->time('start_time')->comment('开始时间');
            $table->time('end_time')->comment('结束时间');
            $table->date('btime')->comment('开始时间的时间戳 用于资源可用搜索');
            $table->date('etime')->comment('结束时间的时间戳 用于资源可用搜索');
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
        Schema::dropIfExists('booking_termical_orders');
    }
}
