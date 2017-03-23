<?php
namespace app\index\model;

use think\Model;
use think\Cookie;
use think\Loader;
use think\Session;

class Zhujiao extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function zhujiaolist($class)
    {
    	foreach($class as $val) {
    		$zhujiaoinfo = Loader::model('zhujiao')->where('class', $val)->select();
    		$classinfo[] = $zhujiaoinfo[0];
    		
    	}
    	return $classinfo;
    }

    public function delzhujiao($uid) {
    	
    }

    public function updatezhujiao($uid, $class ,$fix = 1)
    {
    	$zhujiaoinfo = Loader::model('zhujiao')->where('class', $class)->select();

    	$userdata = Loader::model('user')->where('uid', $uid)->select();
    	$uname = $userdata[0]['uname'];
    	if ($fix == 0) {
    		//删除助教部分
    		$zid = $zhujiaoinfo[0]['zid'];
    		$update = new Zhujiao;
    		if ($zhujiaoinfo[0]['zhujiao1'] == $uid.'/'.$uname) {
    			$update->save([
					'zhujiao1' => null,
					],['zid' => $zid]);
    		} elseif($zhujiaoinfo[0]['zhujiao2'] == $uid.'/'.$uname) {
    			$update->save([
					'zhujiao2' => null,
					],['zid' => $zid]);
    		} elseif($zhujiaoinfo[0]['zhujiao3'] == $uid.'/'.$uname) {
    			$update->save([
					'zhujiao3' => null,
					],['zid' => $zid]);
    		} else {
    			return false;
    		}
    	} else {
    		//添加助教部分
    		if (empty($zhujiaoinfo)) {
	    		$insert = new Zhujiao;
				$insert->data([
				    'class'  =>  $class,
				    'zhujiao1' =>  $uid,
				]);
				$insert->save();
	    	} else {
	    		$zid = $zhujiaoinfo[0]['zid'];
	    		$update = new Zhujiao;
	    		if (empty($zhujiaoinfo[0]['zhujiao1'])) {
					$update->save([
					    'zhujiao1' =>  $uid.'/'.$uname,
					],['zid' => $zid]);
	    		} elseif (empty($zhujiaoinfo[0]['zhujiao2'])) {
	    			$update->save([
					    'zhujiao2' =>  $uid.'/'.$uname,
					],['zid' => $zid]);
					die;
	    		} elseif (empty($zhujiaoinfo[0]['zhujiao3'])) {
	    			$update->save([
					    'zhujiao3' =>  $uid.'/'.$uname,
					],['zid' => $zid]);
	    		} else {
	    			return false;
	    		}
	    		
	    	}
    	}
    	
    	return true;
    }
}
