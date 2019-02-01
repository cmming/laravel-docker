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
        $allFile = Storage::files($request->get('path'));
//        dd($allFile);
        $result = [];
        foreach ($allFile as $key => $val) {
            $result[] = $this->getFileDetailByPath(($val));
        }
        return $result;
    }

    private function getFileDetailByPath($path)
    {
        $name = $path;
        //取出所用的文件驱动类型
        $path = config('filesystems.disks.'.config('filesystems.default').'.root') . '/' . $path;
        dd($path);
        return [
            "name" => $name,
            "type" => \File::type($path),
            "size" => \File::size($path),
            "lastModified" => \File::lastModified($path),
            "isDirectory" => \File::isDirectory($path),
            "isFile" => \File::isFile($path),
            "isWritable" => \File::isWritable($path),
            "extension" => \File::extension($path),

        ];
    }
}
