<?php

namespace app\index\validate;

use think\Validate;

class Profile extends Validate
{
    //指定验证规则
    protected $rule = [
        'name' => 'require|max:25',
        'email' => 'email',
        'phone' => 'checkNum:phone',
    ];
    //指定验证错误提示信息
    protected $message = [
        'name.require' => 'a名称不能为空',
        'name.max' => 'b最大不超过25',
        'email' => 'c邮箱格式不正确',
        'phone' => '电话格式不对',
    ];

    protected function checkNum($value, $rule, $data)
    {
        return true;
    }
}