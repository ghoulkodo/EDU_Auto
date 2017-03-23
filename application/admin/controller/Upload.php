<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Loader;
class Upload extends Controller
{

    public function uploadTmp(){

        $files = request()->file('file-zh');
        var_dump($files);
        // 移动到目录
        foreach ($files as $file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 输出路径
                $path = ROOT_PATH . 'public' . DS . 'uploads\\' . $info->getSavename();
                return $path;
            } else {
                // 上传失败获取错误信息
                return $file->getError();
            }
        }

    }
}