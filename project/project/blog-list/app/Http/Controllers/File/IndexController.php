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

    public function uploadCompanyImg(Request $request)
    {

        $file = $request->file('file');
        header('Content-type: application/json');
        // 文件是否上传成功
        if ($file->isValid()) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); //文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名

            $realPath = $file->getRealPath();   //临时文件的绝对路径

            $type = $file->getClientMimeType();     // image/jpeg
            $size = $file->getSize();
            if ($size > 2 * 1024 * 1024) {
                return array('error' => '文件大小超过2M');
            }
            $extArr = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($ext, $extArr)) {

            }

            // 拼接文件名称
            $filename = date('Ymd') . '/' . date('His') . uniqid() . '.' . $ext;
            $bool = \Storage::disk('upload_company_img')->put($filename, file_get_contents($realPath));

            if ($bool) {
                $url = \Storage::disk('upload_company_img')->url($filename);
                return array('url' => $url);
            } else {
                return array('error' => '上传失败');
            }

        } else {
            return array('error' => '上传失败');
        }

    }
}
