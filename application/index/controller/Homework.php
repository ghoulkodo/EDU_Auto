<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Loader;
use think\Model;

class Homework extends Common
{
	//出题时将题目上传到session方法
	public function setSubject()
	{
		dump($_SESSION['think']['uid']);
	}

	//作业出完后，将作业传到数据库方法
    public function setHomework()
    {
        //$fixdata = input('post.');
        //$profile = Loader::model('Profile')->updateProfile($fixdata);
    	
        
    }
}