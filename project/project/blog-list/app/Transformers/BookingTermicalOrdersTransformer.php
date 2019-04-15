<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2018/11/14
 * Time: 11:59
 */

namespace App\Transformers;

use App\Models\BookingTermicalOrders;
use League\Fractal\TransformerAbstract;


class BookingTermicalOrdersTransformer extends TransformerAbstract
{
    public function transform(BookingTermicalOrders $bookingTermicalOrders)
    {
        $result = $bookingTermicalOrders->attributesToArray();
        //判断是否存在 user
        if(isset($bookingTermicalOrders->toArray()['user'])){
            $result+=['user_name'=>$bookingTermicalOrders->toArray()['user']['name']];
        }
        //判断是否存在 termical
        if(isset($bookingTermicalOrders->toArray()['termical'])){
            $result+=['termical_name'=>$bookingTermicalOrders->toArray()['termical']['name']];
        }

//        dd($bookingTermicalOrders->toArray()['user']);
        return $result;
//            +
//            ['user_name'=>$bookingTermicalOrders->user->name]+
//            ['termical_name'=>$bookingTermicalOrders->termical->name];
        //添加关联关系
//        return $user->attributesToArray()+['code'=>Mail::where('email','=',$user->email)->first(['code'])];
    }

}