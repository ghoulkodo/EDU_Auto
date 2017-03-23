<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Request;
use think\Session;

/**
 * Class Teach
 * @package app\index\controller
 * 教师控制器
 */
class Teach extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        //角色权限检查
        parent::verify('teach');
    }

    public function index($func = null)
    {
        //方法跳转
        if (!is_null($func)){
            return $this->$func();
        }
        return $this->fetch('index');
    }

    //发布通知页面显示
    public function announce()
    {
        return $this->fetch('announce');
    }

    //发布全站通知，旋转吧小陀螺！！
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

    //展示学生请假页面
    public function bootstrapelements()
    {
        $teach_info = db('profile')
                    ->where('pid', $_SESSION['think']['uid'])
                    ->find();

        //处理拼接的班级字符串
        $class = explode('/' , $teach_info['class']);

        foreach($class as $cla) {
            $data[] = Loader::model('Qingjia')->qingjialist($cla);

            $list[] = Loader::model('Qingjia')->qingjiaall($cla);
        }

        $this->assign('qingjialist', $list);
        $this->assign('qingjia', $data);

        return $this->fetch('bootstrapelements');
    }

    //处理学生请假方法
    public function shenpi()
    {
        $sdata = input('post.');
        
        $data = Loader::model('Qingjia')->shenpi($sdata);
        
    }

    public function bootstrapgrid()
    {
        return $this->fetch('bootstrapgrid');
    }

    public function mywork()
    {
        $worklist = Loader::model('Homework')->where('teach_id', $_SESSION['think']['uid'])->paginate(5);
        $fenye = $worklist->render();
        
        $this->assign('fenye', $fenye);
        $this->assign('worklist', $worklist);
        return $this->fetch('mywork');
    }

    public function domywork()
    {
        $sdata = input('post.');
        $delwork = Loader::model('Homework')->where('hid', $sdata['hid'])->delete();
    }

    //展示对应的作业
    public function tables()
    {
        if (empty($_GET)) {
            return $this->mywork();
        }
        $info_homework = Loader::model('Homework')->where('hid', $_GET['hid'])->select();
        $list_work = Loader::model('Homework')->where('dowork', $_GET['hid'])->where('class_id', $_GET['class'])->select();
        
        $this->assign('info', $info_homework);
        $this->assign('worklist', $list_work);
        return $this->fetch('tables');
    }

    //展示助教权限页面
    public function charts()
    {
        $class = Loader::model('user')->getUser($_SESSION['think']['uid']);

        $classarr = explode('/', $class['class']);

        //按不同班级处理学生数据
        /*foreach($classarr as $value) {
            $user = Loader::model('user')->where('role', 0)->where('class', $value)->select();
            foreach($user as $val) {
                $studens[$value][] = $val;
            }
        }*/
        $i = 0;
        foreach($classarr as $value) {
            $studens[] = Loader::model('user')->where('role', 0)->where('class', $value)->paginate(5);
            $fenye[] = $studens[$i]->render();
            $i++;
        }

        //获取老师的数据
        $teach = Loader::model('user')->where('role', 2)->select();

        //助教情况获取
        $list = loader::model('zhujiao')->zhujiaolist($classarr);
        //dump($studens);
        //die;
        $this->assign('fenye', $fenye);
        $this->assign('list', $list);
        $this->assign('teach', $teach);
        $this->assign('class', $studens);

        return $this->fetch('charts');
    }

    //修改助教权限部分
    public function docharts()
    {
        $sdata = input('post.');
        if ($sdata['type'] == 'teach') {
            $teachdata = explode('/', $sdata['class']);

            $teach = Loader::model('user')->charts($teachdata[1], $teachdata[0]);

            $update = Loader::model('zhujiao')->updatezhujiao($teachdata[1], $teachdata[0]);
        } else {
            $studata = explode('/', $sdata['type']);

            $teach = Loader::model('user')->charts($sdata['uid'], $studata[0], $studata[1]);

            $update = Loader::model('zhujiao')->updatezhujiao($sdata['uid'], $studata[0], $studata[1]);
        }

    }

    //从列表页中删除助教
    public function delcharts()
    {
        $sdata = input('post.');

        $userinfo = explode('/', $sdata['type']);

        $uid = $userinfo[0];
        $class = $userinfo[2];

        $teach = Loader::model('user')->charts($uid, $class, 0);

        $update = Loader::model('zhujiao')->updatezhujiao($uid, $class, 0);
    }
	
    public function fixinfo()
    {
        $data = db('profile')->where('pid', $_SESSION['think']['uid'])->find();
        $this->assign('userinfo', $data);
        return $this->fetch('fixinfo');
        
    }


    public function setProfile()
    {
        $sdata = input('post.');

        $data = Loader::model('Profile')->getProfile($_SESSION['think']['uid']);

        dump($data['pid']);
        if (!empty($data['pid'])) {
            $profile = Loader::model('Profile')->updateProfile($sdata, 'pid', $_SESSION['think']['uid']);
        } else {
            $data = Request::instance()->post();
            Loader::model('Profile')->setProfile($sdata);
        }
    }

    public function upload()
    {
        $data = Loader::model('Res')->getRes();
        $this->assign('res' , $data);
        return $this->fetch('upload');

    }
	
    public function forms()
    {
        return $this->fetch('forms');
    }

    

}