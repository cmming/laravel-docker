<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/5/7
 * Time: 18:29
 */

namespace App\Logging;


use Monolog\Formatter\JsonFormatter as BaseJsonFormatter;
use Request;

class JsonFormatter extends BaseJsonFormatter
{
    public function format(array $record)
    {
        // 这个就是最终要记录的数组，最后转成Json并记录进日志

//        dd($record);
        $newRecord = [
            'time' => $record['datetime']->format('Y-m-d H:i:s'),
            'message' => $record['message'],
            'level_name' => $record['level_name'],
        ];
        $newRecord['url'] = Request::path();
        $newRecord['method'] = Request::method();
        $newRecord['ip'] = Request::ip();

        if (!empty($record['context'])) {
            $newRecord = array_merge($newRecord, $record['context']);
        }

        if (!empty($record['extra'])) {
            $newRecord = array_merge($newRecord, $record['extra']);
        }

        //$json = 'aaa,bbb,ccc';  // 这是最终返回的记录串，可以按自己的需求改
        $json = $this->toJson($this->normalize($newRecord), true) . ($this->appendNewline ? "\n" : '');

        return $json;
    }
}