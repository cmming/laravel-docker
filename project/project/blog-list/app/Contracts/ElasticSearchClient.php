<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:16
 */

namespace App\Contracts;


interface ElasticSearchClient
{
    /**
     * 获取 ElasticSearch 客户端
     * @return mixed
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function getClient();

    /**
     * 添加日志
     * @param array $document
     * @return mixed
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function addDocument(array $document);

    /**
     * 获取所有已添加日志
     * @return mixed
     * Written by Zhou Yubin(zhouyb@fengrongwang.com)
     */
    public function getDocuments();
}