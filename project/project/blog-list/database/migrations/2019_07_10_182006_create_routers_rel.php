<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutersRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routers_rel', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('parent_id')->comment('父菜单id');
            $table->integer('son_id')->comment('字菜单id');
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
        Schema::dropIfExists('routers_rel');
    }
}
