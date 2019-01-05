<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    /**
     * 获取指定文件夹下的文件
     * @param Request $request
     */
    public function index(Request $request)
    {
        return Storage::allFiles($request->get('path'));
    }
}
