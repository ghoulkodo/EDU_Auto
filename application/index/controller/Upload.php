<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Request;
use think\Session;
use think\Loader;

class Upload extends Common
{
    public function upload()
    {
        //ajax 验证
        if (! request()->isAjax()){
            $this->error('Request Type Error');
        }

        $files = request()->file('file-zh');
        $title = Request::instance()->post();
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                //上传成功
                $data = [
                    'path'      => ROOT_PATH . 'public' . DS . 'uploads\\' . $info->getSavename(),
                    'uid'       => $this->uid,
                    'filename'  => $info->getFilename(),
                    'type'      => $info->getExtension(),
                    'title'     => $title['title'],
                ];
                Loader::model('Res')->upload($data);
                echo json_encode($data['path']);
            }else{
                // 上传失败
                echo json_encode($file->getError());
            }
        }
    }

}