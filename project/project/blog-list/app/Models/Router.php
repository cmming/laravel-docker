<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/7/10
 * Time: 18:27
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Router extends Model
{

    protected $table = 'routers';

    protected $guarded = [];

    //子路由
    public function son_routers()
    {
        return $this->belongsToMany('App\Models\Router', 'routers_rel', 'parent_id', 'son_id')->withPivot(['parent_id', 'son_id']);
    }

    public function parent_routers()
    {
        return $this->belongsToMany('App\Models\Router', 'routers_rel', 'son_id', 'parent_id')->withPivot(['parent_id', 'son_id']);
    }

    //保存一个子路由
    public function add_son_router($router)
    {
        return $this->son_routers()->save($router);
    }

    //删除一个子路由
    public function delete_son_router($router)
    {
        return $this->son_routers()->detach($router);
    }
}