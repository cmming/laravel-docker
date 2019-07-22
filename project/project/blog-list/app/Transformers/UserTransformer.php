<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2018/11/14
 * Time: 11:59
 */

namespace App\Transformers;

use App\User;
use App\Models\Mail;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $userRole = array_column($user->roles->toArray(),'id');
        return $user->attributesToArray() + ['roles'=>$userRole];
        //添加关联关系
//        return $user->attributesToArray()+['code'=>Mail::where('email','=',$user->email)->first(['code'])];
    }

}