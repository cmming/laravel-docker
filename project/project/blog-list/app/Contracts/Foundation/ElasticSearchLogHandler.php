<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:19
 */

namespace App\Contracts\Foundation;


use JWTAuth;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use App\Facades\ElasticSearchClient;
use Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class ElasticSearchLogHandler extends AbstractProcessingHandler
{
    protected function write(array $record)
    {
        try{
//            dd(JWTAuth::parseToken());
            $user_id = JWTAuth::parseToken()&&JWTAuth::parseToken()->authenticate()->toArray()['id'];
        }catch (JWTException $e){
//            echo $e->getMessage();
            $user_id = -1;
        }
        if ($record['level'] >= 200) {
            $record['url'] = Request::path();
            $record['method'] = Request::method();
            $record['ip'] = Request::ip();
            $record['params'] = Request::all();
            $record['user_id'] = $user_id;
            $dateFormat = "Y-m-d H:i:s";
            // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
            $output = "[%datetime%] [%ip%] [%url%] [%method%] [%params%] %channel%.%level_name%: %message% %context% %extra%\n";
            $formatter = new LineFormatter($output, $dateFormat);
            $record['formatted'] = $formatter->format($record);
//            dd($record,Request::path(),Request::method());
            ElasticSearchClient::addDocument($record);
        }
    }
}