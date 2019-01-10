<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:17
 */

namespace App\Contracts\Foundation;


use Elasticsearch\ClientBuilder;
use App\Contracts\ElasticSearchClient as IElasticSearchClient;

class ElasticSearchClient implements IElasticSearchClient
{

    protected $client;

    protected $documents = [];

    public function __construct()
    {
        $hosts = config('elasticsearch.hosts');
        $this->client = ClientBuilder::create()->setHosts($hosts)->build(); // 实例化一个客户端
    }

    /**
     * 获取 ElasticSearch 客户端
     * @return \Elasticsearch\Client
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * 添加日志
     * @param array $document
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function addDocument(array $document)
    {
        $this->documents[] = $document;
    }

    /**
     * 获取所有已添加日志
     * @return array
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function getDocuments()
    {
        return $this->documents;
    }
}