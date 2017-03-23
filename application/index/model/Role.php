<?php
namespace app\index\model;

use think\Model;

//角色查询，返回权限
class Role extends Model
{
    protected function initialize()
    {
        parent::initialize();
    }

    //查询用户权限
    public function getRole($id)
    {
        //获取多个用户权限
        if (is_array($id)){
            $list = User::all($id);
            return $list;
        }

        //获取单个用户权限
        $user = User::get($id);
        //dump($user->role());
        //die;
        return $user->role;
    }

    //设置用户权限
    //TODO:联表操作风格不一致，看着难受
    public function setRole($data , $id = null)
    {

        if (is_null($id)){
            $role = new Role;
            $role->saveAll($data);
        }else{
            $user = User::get($id);
            $user->role->save($data);
        }

//        Tips: 判断数组是否为多维
//
//        if (count($data) == count($data , COUNT_RECURSIVE)){
//            $role->save($data);
//        }
    }

}