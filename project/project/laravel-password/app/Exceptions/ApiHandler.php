<?php
/**
 * Created by PhpStorm.
 * User: chenming
 * Date: 2019/7/23
 * Time: 23:42
 */

namespace App\Exceptions;


use Exception;
use Dingo\Api\Exception\Handler as DingoHandler;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Exceptions\ErrorMessage;

class ApiHandler extends DingoHandler
{
    public function handle(Exception $exception)
    {
//        自定义一要捕获的异常
        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(ErrorMessage::getMessage(ErrorMessage::TOKEN_EXPIRED),401);
            } else if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                // token 错误
                return response()->json(ErrorMessage::getMessage(ErrorMessage::TOKEN_INVALID),401);
            } else if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                // token 列入黑名单
                return response()->json(ErrorMessage::getMessage(ErrorMessage::TOKEN_BLACKLISTED),401);
            }
            if ($exception->getMessage() === 'Token not provided') {
                return response()->json(ErrorMessage::getMessage(ErrorMessage::TOKEN_NOT_PROVIDED),401);
            }
        }

        if ($exception instanceof
            \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(ErrorMessage::getMessage(ErrorMessage::TOKEN_CANT_REFRESHED),401);
        }

        if($exception instanceof ClientException){
            dd(1);
        }

        return parent::handle($exception);
    }
}