<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            // 1显示 0隐藏
            $table->integer('show')->default(1);
            $table->string('path')->default('');
            // 页面的 名称 作为页面缓存的标志
            $table->string('name')->default('');
            // 页面 组件 的路径
            $table->string('component')->default('');
            //页面的title 同时也是页面目录的文字
            $table->string('en_title')->default('');
            // 中文标题
            $table->string('zh_title')->default('');
            // 图标
            $table->string('icon')->default('');
            // 是否 缓存在页面的顶部 1 缓存 0 不缓存
            $table->integer('no_cache')->default(1);
            // 排序
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('menus');
    }
}
