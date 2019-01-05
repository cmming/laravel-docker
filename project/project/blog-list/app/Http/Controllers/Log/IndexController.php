<?php

namespace App\Http\Controllers\Log;

use App\Transformers\LogTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Log;

class IndexController extends Controller
{
    //
    private $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function index()
    {
        $logs = $this->log->paginate();

        return $this->response->paginator($logs, new LogTransformer());
    }
}
