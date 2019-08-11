<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

//class User extends Authenticatable
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
//        var_dump($token);exit();
        $this->notify(new \App\Notifications\ResetPassword($token));
    }

    //一个用户的 角色
    public function roles(){

        return $this->belongsToMany('App\Models\Role', 'users_roles', 'user_id', 'role_id')->withPivot('role_id', 'user_id');
    }

    public function role(){

        return $this->belongsToMany('App\Models\Role', 'users_roles', 'user_id', 'role_id')->withPivot('role_id', 'user_id');
    }

    //为用户添加 角色
    public function addRoles($role){

        return $this->roles()->save($role);
    }


    //为用户删除角色
    public function deleteRoles($role){

        return $this->roles()->detach($role);
    }

    //一个用户的菜单
    public function routers(){
//        $rolesId = array_column($this->roles->toArray(),'id');
//        dd($rolesId);
        //获取每个角色的router
        $routers = [];
        foreach ($this->roles as $role){
            $router = $role->routers->toArray();
            $routers = array_unique($router, SORT_REGULAR);
        }
//        dd($routers);
        return $routers;
    }

}
