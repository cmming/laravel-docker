<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTermical extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_termicals', function (Blueprint $table) {
//            $table->comment('预约机器表');
            $table->increments('id');
            $table->string('name',64)->comment('主机名称');
            $table->integer('state')->default(1)->comment('主机状态 1：正常 2：故障');
            $table->timestamps();
            $table->softDeletes()->comment('软删除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_termicals');
    }
}
