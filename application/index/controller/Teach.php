<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
class Teach extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        $role = Loader::model('Role')->getRole($this->uid);
        if ($role != 2){
            $this->error('权限不正确');
        }
    }

    public function index($uname)
    {
        //TODO:展示教师用户页
        echo $uname;
    }

}