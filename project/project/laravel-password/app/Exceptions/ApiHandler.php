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
use App\Exceptions\ErrorMessage;

class ApiHandler extends DingoHandler
{
    public function handle(Exception $exception)
    {

        // token 校验失败
//        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
//            return response()->json(ErrorMessage::getMessage(ErrorMessage::TOKEN_INVALID), 401);
//        }

        return parent::handle($exception);
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Exception $e
     * @return bool
     */
    public function shouldReport(Exception $e)
    {
        // TODO: Implement shouldReport() method.
    }
}