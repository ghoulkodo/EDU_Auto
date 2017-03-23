<?php
namespace app\common\controller;

use think\Controller;
use think\Cookie;
use think\Session;

class Common extends Controller
{
    protected $uid;
    protected $uname;
    protected $role;

    public function _initialize()
    {

        if (!Session::has('uid')) {
            $this->error('Please login first', '/signin');
        }

        $this->uid = Session::get('uid');
        $this->uname = Session::get('uname');
        $this->role = Session::get('role');
    }

    //验证权限
    public function verify($role)
    {

        switch ($role) {
            case 'stu':
                $role = 0;
                break;
            case 'assis':
                $role = 1;
                break;
            case 'teach':
                $role = 2;
                break;
            case 'admin':
                $role = 3;
                break;
        }

        if ($role != $this->role) {
            dump($role);
            die;
            $this->error('Role Type Error');
        }
    }
}