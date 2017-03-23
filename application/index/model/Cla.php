<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
class Cla extends Model
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

    public function getGid($id)
    {
        $result = Cla::get($id);
        //$result = User::get($stuid[], );
        return $result;
    }

    public function studens()
    {
        
    }

}