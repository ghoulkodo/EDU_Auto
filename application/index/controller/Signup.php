<?php
namespace app\index\controller;

use think\Controller;

/**
 * Class Signup
 * @package app\index\controller
 * 注册界面显示
 */
class Signup extends Controller
{
    public function signup()
    {
        return $this->fetch('/index/signup');
    }
}