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
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiHandler extends DingoHandler
{
    public function handle(Exception $exception)
    {
//        自定义一要捕获的异常
//        if ($exception instanceof UnauthorizedHttpException) {
//            $preException = $exception->getPrevious();
//            if ($preException instanceof
//                \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
//                return response()->json(['error' => 'TOKEN_EXPIRED']);
//            } else if ($preException instanceof
//                \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
//                return response()->json(['error' => 'TOKEN_INVALID']);
//            } else if ($preException instanceof
//                \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
//                return response()->json(['error' => 'TOKEN_BLACKLISTED']);
//            }
//            if ($exception->getMessage() === 'Token not provided') {
//                return response()->json(['error' => 'Token not provided']);
//            }
//        }
        return parent::handle($exception);
    }
}