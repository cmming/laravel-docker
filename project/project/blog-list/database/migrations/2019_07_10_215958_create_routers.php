<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('parent_id')->default(0);
            $table->string('path')->default('')->comment('页面url路径');
            $table->string('component')->default('')->comment('页面文件位置');
            $table->string('name')->unique()->comment('路由的 key 唯一 不能重复');
            $table->string('title')->default('')->comment('页面 title key');
            $table->string('icon')->default('')->comment('菜单的icon');
            $table->integer('type')->default(1)->comment('路由 的类型  1： menu');
            $table->integer('hidden')->default(1)->comment('路由 是否显示在菜单上 1不显示');
            $table->string('model')->default('')->comment('路由 所属的模块');
            $table->integer('sort')->default(0)->comment('路由 排序依据');
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
        Schema::dropIfExists('routers');
    }
}
