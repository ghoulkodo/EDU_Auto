<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;

/**
 * Class Assis
 * @package app\index\controller
 * 助教控制器
 */
class Assis extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        parent::verify('assis');
    }

    public function index($func)
    {

        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('index');
    }

    public function announce()
    {
        return $this->fetch('announce');
    }

    public function mywork()
    {
        return $this->fetch('mywork');
    }

    public function doAnnounce()
    {
        $data = Request::instance()->post();
        $data['sender_id'] = $this->uid;
        $result = Loader::model('Notice')->announce($data);
        if ($result){
            $this->success('发布成功');
        }
    }

    public function homework()
    {
        $homework = Loader::model('Homework')->showHomework();

        $homeworkNum = Loader::model('Homework')->homeworkNum();

        $teach_info = db('profile')
            ->where('pid', $_SESSION['think']['uid'])
            ->find();

        //处理拼接的班级字符串
        $class = explode('/' , $teach_info['class']);
        //dump($class);
        $this->assign('class', $class);
        $this->assign('homeworkNum', $homeworkNum);
        $this->assign('homework', $homework);
        return $this->fetch('homework');
    }

    public function doHomework()
    {
        $sdata = input('post.');

        if (!empty($sdata['subject_type'])) {
            if ($sdata['subject_type'] == 'del_work') {
                $homework = Loader::model('Homework')->delHomework();
            } elseif ($sdata['subject_type'] == 'send_work') {
                $homework = Loader::model('Homework')->sendHomework($sdata);
            } elseif ($sdata['subject_type'] == 'deltimu') {
                $homework = Loader::model('Homework')->deltimu($sdata);
            } else {
                $homework = Loader::model('Homework')->setSubject($sdata);
            }
        }

    }
}