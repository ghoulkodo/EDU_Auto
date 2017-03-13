<?php
namespace app\common\controller;

use think\Controller;
use think\Cookie;
use think\Session;

class Common extends Controller
{
    protected $uid;
    public function _initialize(){

        if( !Cookie::has('uname') || !Session::has('uid')) {
            $this->error('Please login first', '/');
        }

        $this->uid = Session::get('uid');
    }
}