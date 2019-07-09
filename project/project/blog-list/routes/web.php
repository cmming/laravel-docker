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

//跳转到登陆页面 然后会跳转到是否授权的页面
Route::get('login', function () {
    return redirect('http://www.baidu.com');
})->name('login');

Route::get(/**
 * @param \App\Models\OauthClients $oauthClients
 * @param Request $request
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
    '/authorize', function (App\Models\OauthClients $oauthClients) {
    $client = $oauthClients->where('id','=',2)->first();
    $scopes = [];
    return view('vendor.passport.authorize',compact('client','scopes'));
});
//
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '1',
        'redirect_uri' => 'http://192.168.50.58/callback',
        'response_type' => 'code',
        'client_secret'=>'IZWN2wZN3dDQyZuso59n5tfn5VzqaEZHpdD5Ejdn',
        'scope' => '*',
    ]);

    return redirect('http://192.168.50.58/oauth/authorize?'.$query);
});

Route::get('/callback', function (Illuminate\Http\Request $request) {
    $http = new \GuzzleHttp\Client;

    $response = $http->post('http://192.168.50.58/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '1',
            'client_secret' => 'euwSLAk4UjkaYtKPlQuotL2v5nbyX8qUvGpEnQ49',
            'redirect_uri' => 'http://www.baidu.com',
            'code' => $request->code,
        ],
    ]);
    return json_decode((string) $response->getBody(), true);
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/elastic', function () {
    $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('elasticsearch.hosts'))->build();
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
