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

    public function getRole($id)
    {
        $user = User::get($id);
        return $user->role->role;
    }

}