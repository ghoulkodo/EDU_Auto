<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Model;

class Userinfo extends Common
{
    public function Userinfo()
    {
        $fixdata = input('post.');
        $profile = Loader::model('Profile')->updateProfile($fixdata, 'pid', $_SESSION['think']['uid']);
        if ($profile) {
            echo $result = json_encode(true);
        }
    }
}



