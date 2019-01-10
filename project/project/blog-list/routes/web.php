<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/elastic', function () {
    $hosts = [
        'http://172.20.0.3:9200',
    ];
    $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
    try {
        $response = $client->info();
        return $response;
    } catch (\Exception $e) {
        return 'error: ' . $e->getMessage();
    }
});

Route::get('/test/log', function () {
    // 日志同时写入 文件系统 和 ElasticSearch 系统
    Log::emergency('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::alert('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::critical('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::error('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::warning('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::notice('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::info('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
    Log::debug('写入成功啦，日志同时写入 文件系统 和 ElasticSearch 系统', ['code' => 0, 'msg' => '成功了，日志同时写入 文件系统 和 ElasticSearch 系统', 'data' => [1,2,3,4,5]]);
});
