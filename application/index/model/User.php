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
        return $this->hasOne('Profile' , 'pid')->field('profile');
    }

    //关联权限表，外键为roleid
    public function role()
    {
        return $this->hasOne('Role' , 'roleid')->field('role');
    }

    //关联资源表，外键为rid
    public function res()
    {
        return $this->hasMany('Res' , 'rid')->field('path , type , create_time');
    }

}