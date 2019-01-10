<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
//use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
//use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
//        try {
//            $logs = ElasticSearchClient::getLogs();
//            // 需要判断是否有日志
//            if (count($logs) > 0) {
//                dispatch(new JElasticSearchLog($logs));
//            }
//        } catch (\Exception $e) {
//            Log::error($e->getMessage());
//        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
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
//        if($exception instanceof MethodNotAllowedHttpException){
//            return response()->json(['error' => 'MethodNotAllowedHttpException']);
//        }
        return parent::render($request, $exception);
    }
}
