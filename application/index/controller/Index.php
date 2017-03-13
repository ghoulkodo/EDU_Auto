<?php
namespace app\index\controller;


use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index');
    }

    public function work()
    {
        return $this->fetch('work');
    }

    public function signup()
    {
        return $this->fetch('signup');
    }
}

