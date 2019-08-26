<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use EloquentFilter\Filterable;

class Log extends Model
{
//    php artisan scout:import "\App\Models\Log"
    use Searchable,Filterable;
    // 定义索引里面的type
    public function searchableAs()
    {
        return 'logs';
    }

// 定义有哪些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'url' => $this->url,
            'method' => $this->method,
            'params' => $this->params,
            'ip' => $this->ip,
            'operation' => $this->operation,
            'response' => $this->response,
            'time' => $this->time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    //
    protected $table = "logs";

    protected $guarded = [];

}
