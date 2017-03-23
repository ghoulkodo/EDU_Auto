<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Session;

class Download extends Common
{
    public function download($fileNameUrl)
    {
        parent::verify(Session::get('uname'));

        $filePath = Loader::model('Res')->getResPath($fileNameUrl);
        if (! $filePath){
            $this->error('文件找不到');
        }else{
            $file = fopen($filePath , "r");

            Header ( "Content-type: application/octet-stream" );
            Header ( "Accept-Ranges: bytes" );
            Header ( "Accept-Length: " . filesize ( $filePath ) );
            Header ( "Content-Disposition: attachment; filename=" . $fileNameUrl );

            echo fread ( $file, filesize ( $filePath ) );
            fclose ( $file );
            exit ();
        }
    }
}