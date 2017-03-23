<?php
namespace app\index\model;

use app\index\validate\User as UserValidate;
use think\Cookie;
use think\Loader;
use think\Model;

class Auth extends Model
{
    //登录注册验证
    public function auth(array $data)
    {
        $validate = Loader::validate('User');
        $uname = [
                    'uname' => $data['uname'],
                ];
        $user = User::get($uname);
        if ($data['hidden'] == 1) {
            //登录验证
            if ($user) {
                //验证密码一致
                if ($user->upwd == $data['upwd']) {
                    return array(
                        0           => 0,
                        'msg'       => 'success',
                        'uid'       => $user->uid,
                        'uname'     => $user->uname,
                        'profile'   => $user->profile->profile,
                        'role'      => $user->role,
                    );
                } else {
                    return array(
                        0       => 1,
                        'msg'   => '用户名或密码错误',
                    );
                }
            } else {
                return array(
                    0       => 2,
                    'msg'   =>'用户名或密码错误'
                );
            }

        }elseif($data['hidden'] == 0) {
            //注册验证
            if(!$validate->check($data)) {
                dump($validate->getError());
                return array(
                    0       => 3,
                    'msg'   => '不满足规则',
                );
            }

            if ($user) {
                return array(
                    0       => 0,
                    'msg'   => '用户名已存在',
                );
            }else{

                //基本信息添加

                $user = new User($data);
                $user->allowField(true)->save();

                //默认权限添加
                $user->role()->save([
                    'roleid'=> $user->uid,
                    'role'  => 4,
                ]);

                //默认详情添加
                $user->profile()->save([
                    'pid'    => $user->uid,
                    'profile'=> '',
                ]);

                return array(
                    0           => 1,
                    'msg'       => 'success',
                    'uid'       => $user->uid,
                    'uname'     => $user->uname,
                    'profile'   => $user->profile->profile,
                    'role'      => $user->role->role,
                );
            }
        }
    }


}