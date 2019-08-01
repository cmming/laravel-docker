<?php
/**
 * Created by PhpStorm.
 * User: chenming
 * Date: 2019/8/1
 * Time: 23:35
 */

namespace App\Models\Traits;


use Hashids;


trait HashIdHelper
{

    private $hashId;


    /**
     * 访问器，对模型ID加密
     * @param $value
     * @return null|string
     */

//    public function getAttribute($key)
//    {
//        $value = parent::getAttribute($key);
//
//        if ($key === $this->getRouteKeyName()) {
//            $value = Hashids::encode($value);
//        }
//
//        return $value;
//    }

//    public function getIdAttribute($value)
//    {
//        if (!$this->hashId) {
////            $this->hashId = Hashids::encode($this->id);
//            $this->hashId = Hashids::encode($value);
//        }
//
//        return $this->hashId;
////        return Hashids::encode($value);
//    }


//    public function resolveRouteBinding($value)
//    {
//        if (!is_numeric($value)) {
//            $value = current(Hashids::decode($value));
//            if (!$value) {
//                return;
//            }
//        }
//        return parent::resolveRouteBinding($value);
//    }
////
//    public function getRouteKey()
//    {
//        return current(Hashids::decode($this->hashId));
//    }
}