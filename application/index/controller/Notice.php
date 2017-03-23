<?php
namespace app\index\controller;

use think\Controller;
use think\Loader;

class Notice extends Controller
{
    //发布全站通知
    public function announce($data)
    {
        Loader::model('Notice')->announce($data);
    }

    //查看我收到的通知内容
    public function getNotices($uid)
    {
        $data = Loader::model('Notice')->getNotices($uid);

        return $data;
    }

    //查看已经发布的通知（stu没有发布通知权限）（uid查看指定用户发布的通知，null为所有）
    public function getAnnouncedNotice($uid = null)
    {
        Loader::model('Notice')->getAnnouncedNotice($uid);
    }

    //删除通知
    public function delNtc()
    {

    }
}