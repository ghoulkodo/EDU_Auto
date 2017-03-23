<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

//管理员登录验证类
class Auth extends Controller
{
    public function _initialize()
    {
        if (! Session::get('uname')){
            $this->error('Please Login First' , '/login');
        }elseif (Session::get('role') != 3) {
            $this->error('Role Type Erroe');
        }
    }
}