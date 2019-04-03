<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2018/11/14
 * Time: 11:59
 */

namespace App\Transformers;

use App\Models\BookingTermicals;
use League\Fractal\TransformerAbstract;


class BookingTermicalsTransformer extends TransformerAbstract
{
    public function transform(BookingTermicals $bookingTermicals)
    {
        return $bookingTermicals->attributesToArray();
        //添加关联关系
//        return $user->attributesToArray()+['code'=>Mail::where('email','=',$user->email)->first(['code'])];
    }

}