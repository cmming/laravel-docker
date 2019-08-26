<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';

    protected $guarded = [];

    //一个角色拥有的路由
    public function routers()
    {
        // 多对多 关联
        return $this->belongsToMany('App\Models\Router', 'roles_routers', 'role_id', 'router_id')->withPivot('role_id', 'router_id');
    }

    //为一个角色添加一个 路由
    public function addRouter($router)
    {
        return $this->routers()->save($router);
    }

    //为一个角色删除一个路由
    public function detachRouter($router)
    {
        return $this->routers()->detach($router);
    }

}
