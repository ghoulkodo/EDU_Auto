<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;
    protected function initialize()
    {
        parent::initialize();
    }

    //获取用户列表
    public function getList( $request )
    {
        $data = $this->order('create_time')->where($request['where'])->
                limit($request['limit'] , $request['offset'])->select();
        return $data;
    }

    //修改用户
    public function upUser($request)
    {
        return $this->allowField(true)->save($request);
    }
}