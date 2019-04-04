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
        return $bookingTermicalOrders->attributesToArray();
        //添加关联关系
//        return $user->attributesToArray()+['code'=>Mail::where('email','=',$user->email)->first(['code'])];
    }

}