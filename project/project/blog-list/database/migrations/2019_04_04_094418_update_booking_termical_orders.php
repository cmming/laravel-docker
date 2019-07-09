<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBookingTermicalOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('booking_termical_orders', function (Blueprint $table) {
            $table->integer('state')->after('etime')->default(1)->comment('订单状态 1：未使用 2：使用中 3：已经使用 4：强制下线 5：管理员拒绝订单');
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
    }
}
