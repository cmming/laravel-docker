<?php
/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:19
 */

namespace App\Contracts\Foundation;


use Monolog\Handler\AbstractProcessingHandler;
use App\Facades\ElasticSearchClient;

class ElasticSearchLogHandler extends AbstractProcessingHandler
{
    protected function write(array $record)
    {
        if ($record['level'] >= 200) {
            ElasticSearchClient::addDocument($record);
        }
    }
}