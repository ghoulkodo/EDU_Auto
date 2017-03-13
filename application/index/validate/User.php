<?php
namespace app\index\validate;

/**
 * 过滤规则定义
 */
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'uname' => 'require|max:25',
        'upwd'  => 'require|length:6,16',
        'repwd|确认密码不一致' => 'require|confirm:upwd'
    ];

}