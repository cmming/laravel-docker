<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:13
 */

return [
    'hosts' => [
        env('ELASTICSEARCH_HOST')
    ],

    'log_index' => env('ELASTIC_LOG_INDEX'),
    'log_type' => env('ELASTIC_LOG_TYPE'),
];