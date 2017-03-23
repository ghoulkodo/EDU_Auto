<?php
namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Loader;

class Notice extends Controller
{
    //发布全站通知
    public function announce($data)
    {
        Loader::model('Notice')->announce($data);
    }

    //查看我未读的通知内容
    public function getNotices($uid)
    {
        $data = Loader::model('Notice')->getNotices($uid);
        //$data 为数组，元素为对象，数据处理：
        return $data;
    }

    //查看所有通知记录
    public function getAllNotices($uid)
    {
        $data = Loader::model('Notice')->getAllNotices($uid);
        return $data;
    }
    //查看已经发布的通知（stu没有发布通知权限）（uid查看指定用户发布的通知，null为所有）
    public function getAnnouncedNotice($uid = null)
    {
        Loader::model('Notice')->getAnnouncedNotice($uid);
    }

    public function setRead($nid , $uid)
    {
        return Loader::model('Notice')->setRead(1 , $uid , $nid);
    }

    public function setUnRead($nid , $uid)
    {
        return Loader::model('Notice')->setRead(0 , $uid , $nid);
    }

    public function setAllRead($uid)
    {
        return Loader::model('Notice')->setRead(1 , $uid);
    }

    //删除通知
    public function delNtc()
    {

    }
}