<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected function initialize()
    {
        parent::initialize();
    }

    //关联详情表，外键为pid
    public function profile(){
        return $this->hasOne('Profile' , 'pid')->field('pid , profile');
    }

    //关联权限表，外键为roleid
    public function role()
    {
        return $this->hasOne('Role' , 'roleid')->field('roleid , role');
    }

    //关联资源表，外键为uid
    public function res()
    {
        return $this->hasMany('Res' , 'uid')->field('path , type , create_time');
    }

    //关联成绩表，外键为uid
    public function score()
    {
        return $this->hasMany('Score' , 'uid');
    }

    //关联  系名表，外键为xid
    public function dep()
    {
        return $this->hasOne('Dep' , 'xid');
    }

    //关联消息队列表，外键为uid
    public function notices()
    {
        return $this->hasMany('NoticeList' , 'uid');
    }

    //查询指定用户信息
    public function getUser($id)
    {
        $result = User::get($id);
        //$result = User::get($stuid[], );
        return $result;
    }

    //查询助教信息
    public function charts($uid, $class, $type = '1')
    {   
        $user = User::get($uid);
        $user->zhujiao = $type;
        $user->save();
    }

    //查询所有用户信息
    public function getAll()
    {
        $result = User::all();
        return $result;
    }

}