<?php

/**
 * Created by PhpStorm.
 * User: chmi
 * Date: 2019/1/10
 * Time: 17:19
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ElasticSearchClient extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'App\Contracts\ElasticSearchClient';
    }
}