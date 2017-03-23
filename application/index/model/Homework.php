<?php
namespace app\index\model;

use think\Model;
use think\Cookie;
use think\Loader;
use think\Session;

class Homework extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function homeworkNum()
    {
        if (empty($_SESSION['think']['workcacheid'])) {
            return false;
        } else {
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('del_work', 1)
                    ->select();
            if (!$cache) {
                return false;
            }
        }

        $title = $xuanze = db('homeworkcache')
                ->where('keyid', $_SESSION['think']['workcacheid'])
                ->where('title', '<>', 'null')
                ->where('del_work', 1)
                ->select();
        if ($title) {
            foreach($title as $value) {
                $titlename = $value['title'];
            }
            $shownum['content'] = $value['title'];
        }

        $xuanze = db('homeworkcache')
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('xuanzenum', 1)
                    ->where('del_work', 1)
                    ->count('hcid');
        if ($xuanze) {
            $shownum['xuanze'] = $xuanze;
        }

        $panduan = db('homeworkcache')
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('panduannum', 1)
                    ->where('del_work', 1)
                    ->count('hcid');
        if ($panduan) {
            $shownum['panduan'] = $panduan;
        }

        $jianda = db('homeworkcache')
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('jiandanum', 1)
                    ->where('del_work', 1)
                    ->count('hcid');
        if ($jianda) {
            $shownum['jianda'] = $jianda;
        }
        return $shownum;
    }

    //将缓存表中的题目按顺序拼接为整段字符串
    public function showhomework()
    {

        if (empty($_SESSION['think']['workcacheid'])) {
            return false;
        } else {
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('del_work', 1)
                    ->select();
            if (!$cache) {
                return false;
            }
        }

        $title = $xuanze = db('homeworkcache')
                ->where('keyid', $_SESSION['think']['workcacheid'])
                ->where('title', '<>', 'null')
                ->where('del_work', 1)
                ->select();

        $xuanze = db('homeworkcache')
                ->where('keyid', $_SESSION['think']['workcacheid'])
                ->where('xuanzenum', 1)
                ->where('del_work', 1)
                ->select();

        $panduan = db('homeworkcache')
                ->where('keyid', $_SESSION['think']['workcacheid'])
                ->where('panduannum', 1)
                ->where('del_work', 1)
                ->select();

        $jianda = db('homeworkcache')
                ->where('keyid', $_SESSION['think']['workcacheid'])
                ->where('jiandanum', 1)
                ->where('del_work', 1)
                ->select();

        if ($title) {
            foreach($title as $value) {
                $titlename = $value['title'];
                $titleid = $value['hcid'];
            }
            $newtitle['content'] = '<h4>'.$value['title'].'</h4>';
            $newtitle['hcid'] = $value['hcid'];
            $homework[] = $newtitle;
        }
        
        foreach($xuanze as $xuan) {
            $homework[] = $xuan;
        }

        foreach($panduan as $pan) {
            $homework[] = $pan;
        }

        foreach($jianda as $jian) {
            $homework[] = $jian;
        }
        return $homework;
    }

    public function deltimu($data)
    {
        $deldata = ['del_work' => '0'];
        $result = db('homeworkcache')
                    ->where('hcid',$data['delid'])
                    ->update($deldata);
    }

    //教师列表页展示发过的作业
    public function homework($data)
    {   
        $show = db('homework')
                ->where('teach_id', $_SESSION['think']['uid'])
                ->select();
        return $show;
    }

    //学生载入作业方法！
    public function gethomework($data)
    {
        $show = db('homework')
                ->where('class_id', $data['class'])
                ->where('dowork', null)
                ->select();

        return $show;
    }

    //学生交作业方法
    public function pushwork($data)
    {
        dump($data);
        die;
    }

    //发布作业方法
    public function sendHomework($data)
    {
    	if (!empty($_SESSION['think']['workcacheid'])) {
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('del_work', 1)
                    ->select();
            if ($cache) {
                $homework = true;
            } else {
                $homework = false;
            }
        } else {
            $homework = false;
        }
        if(!empty($data['class'])) {
            $class = join('/', $data['class']);
        }
        $content = $this->showhomework();

        

        foreach ($content as $val) {
            $newcontent[] = $val['content'];
        }
        $string = join('', $newcontent);

        $title = $xuanze = db('homeworkcache')
                ->where('keyid', $_SESSION['think']['workcacheid'])
                ->where('title', '<>', 'null')
                ->where('del_work', 1)
                ->select();
        
        $senddata['title'] = $title[0]['title'];

        $senddata['end_time'] = $data['work_time']*3600*24 + time();
        $senddata['class_id'] = $class;
        $senddata['content'] = '<div class="jumbotron">'.$string.'</div>';
        $senddata['teach_id'] = $_SESSION['think']['uid'];

        $result = db('homework')->insertGetId($senddata);

        $deldata = ['del_work' => '0'];
        $del = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->update($deldata);

        if ($result) {
            return true;
        } else {
            return false;
        }

        
    }

    //删除未发布的作业方法
    public function delHomework()
    {
        $deldata = ['del_work' => '0'];
        $result = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->update($deldata);
    }

    //编辑作业方法
    public function setSubject($data)
    {
        //Session::delete('workcacheid', 'think');

        //判断这个老师有没有正在布置的作业！
        //如果session中没有缓存元素，说明没有近期没发布作业，重新生成作业缓存Id
        if (!empty($_SESSION['think']['workcacheid'])) {
            $cache = db('homeworkcache')
                    ->where('uid',$_SESSION['think']['uid'])
                    ->where('keyid', $_SESSION['think']['workcacheid'])
                    ->where('del_work', 1)
                    ->select();
            if ($cache) {
                $homework = true;
            } else {
                $homework = false;
            }
        } else {
            $homework = false;
        }

        //取出数组中的题目类型和uid
        $key = $data['subject_type'];
        $uid = $_SESSION['think']['uid'];

        dump($data);
        //die;
        if (!$homework) {
            $keyid = ceil($uid + (time() / 2));
            Session::set('workcacheid' , $keyid);
        } else {
            $keyid = $_SESSION['think']['workcacheid'];
        }

        //如果是选择题，需要输出选项
        if ($key == 'xuanze') {
            $new_timu = '<div class="table-responsive" id="homework"><h4>'.$data['pick_main'].'</h4><h4>A: '.$data['pick_1'].'</h4><h4>B: '.$data['pick_2'].'</h4><h4>C: '.$data['pick_3'].'</h4><h4>D: '.$data['pick_4'].'</h4></div>';
            $send = ['uid' => $uid, 'content' => $new_timu, 'keyid' => $keyid, $key.'num' => 1];
        //如果是题目，去掉题目数量字段
        } elseif($key == 'title'){
            $new_timu =$data['pick_main'];
            $send = ['uid' => $uid, $key => $new_timu, 'keyid' => $keyid];
        //判断和简答可以通用
        } else {
            $new_timu = '<div class="table-responsive" id="homework"><h4>'.$data['pick_main'].'</h4></div>';
            $send = ['uid' => $uid, 'content' => $new_timu, 'keyid' => $keyid, $key.'num' => 1];
        }
            
        $result = db('homeworkcache')->insert($send);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
