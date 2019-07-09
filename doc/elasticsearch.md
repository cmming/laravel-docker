https://www.jianshu.com/p/962e30a859ba
elasticsearch

1. composer require laravel/scout


 config/app.php 配置文件的 providers 数组中：

2. Laravel\Scout\ScoutServiceProvider::class,

 config 目录下生成 scout.php 配置文件
3. php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"


4. composer require tamayo/laravel-scout-elastic


5. 修改config\scout.php配合文件，将驱动修改为elasticsearch
 'driver' => env('SCOUT_DRIVER', 'elasticsearch'),

 'elasticsearch' => [
         //laravel54是项目名，可以自定义
         'index' => env('ELASTICSEARCH_INDEX', 'laravel54'),
         'hosts' => [
             env('ELASTICSEARCH_HOST', 'http://127.0.0.1:9200'),
         ],
     ],


 6.创建command命令
     php artisan make:command ESInit

7. 安装guzzlehttp/guzzle 扩展

    composer require guzzlehttp/guzzle

8. app\Console\Command\ESInit.php


public function handle()
    {
        //创建template
        $client=new Client();

        $url=config('scout.elasticsearch.hosts')[0]. '/_template/tmp';
        //$client->delete($url);

        $param = [
            'json'=>[
                'template' => config('scout.elasticsearch.index'),
                'mappings' => [
                    '_default_' => [
                        'dynamic_templates' => [
                            [
                                'strings' => [
                                    'match_mapping_type' => 'string',
                                    'mapping' => [
                                        'type' => 'text',
                                        'analyzer' => 'ik_smart',
                                        'fields' => [
                                            'keyword' => [
                                                'type' => 'keyword'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
        ];
        $client->put($url,$param);

        //记录
        $this->info("=======创建模板成功=======");

        //创建index
        $url = config('scout.elasticsearch.hosts')[0] . '/' . config('scout.elasticsearch.index');
        //$client->delete($url);
        $param=[
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => false
                        ]
                    ]
                ]
            ]
        ];

        $client->put($url,$param);

        //记录
        $this->info("=========创建索引成功=========");
    }


    9.  修改model

        use Searchable;

            //定义索引里面的type
            public function searchableAs()
            {
                return "post";
            }

            //定义有哪些字段需要搜索
            public function toSearchableArray()
            {
                return [
                    'title'=>$this->title,
                    'content'=>$this->content,
                ];
            }



            php artisan scout:import "\App\Post"



