<?php
namespace app\index\controller;

use think\Controller;

/**
 * Class Signin
 * @package app\index\controller
 * 登录页面显示
 */
class Signin extends Controller
{
    public function signin()
    {
        return $this->fetch('/index/signin');
    }
}