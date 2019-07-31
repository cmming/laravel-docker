<?php
/**
 * Created by PhpStorm.
 * User: chenming
 * Date: 2019/7/28
 * Time: 15:37
 */

namespace App\Exceptions;


class ErrorMessage
{
    const PASSWORD_OR_NAME_ERROR = 400001;

    //鉴权错误
    const TOKEN_EXPIRED = 401001;
    const TOKEN_INVALID = 401002;
    const TOKEN_BLACKLISTED = 401003;
    const TOKEN_NOT_PROVIDED = 401004;
    const TOKEN_CANT_REFRESHED = 401005;

    //未知错误
    const UNKNOWN = 404001;


    static public $message = [
        400001 => "账号或密码错误",
        401001 => "token expired",
        401002 => "token invalid",
        401003 => "token black list",
        401004 => "token not provided",    #请求头中没有token
        401005 => "Token has expired and can no longer be refreshed",    #请求头中没有token


        404001 => "unknown",


    ];


    static public function getMessage($code)
    {
        if (isset(self::$message[$code])) {
            $result = ['message' => self::$message[$code], 'code' => $code];
        } else {
            $code = self::UNKNOWN;
            $result = ['message' => self::$message[$code], 'code' => $code];
        }

        return $result;

    }

}