<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBookingTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('booking_times', function (Blueprint $table) {
            $table->integer('date_length')->after('time')->comment('可以预约的时间天数');
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
        Schema::table('booking_times', function (Blueprint $table) {
            $table->dropIfExists('booking_times');
        });
    }
}
