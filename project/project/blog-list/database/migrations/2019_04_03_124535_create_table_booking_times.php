<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookingTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_times', function (Blueprint $table) {
            $table->increments('id');
            $table->time('start_time')->comment('开始时间 最终转换为time');
            $table->time('end_time')->comment('结束时间 最终转换为time');
            $table->time('time')->comment('时间间隔 最终转换为 time类型');
            $table->date('start_date')->comment('开始日期 最终转换为 date');
            $table->date('end_date')->comment('结束日期 最终转换为date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_times');
    }
}
