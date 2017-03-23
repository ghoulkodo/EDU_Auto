<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'login'                 => 'index/auth/login',
    'logout'                => 'index/auth/logout',
    'reg'                   => 'index/auth/reg',
    'signup'                => 'signup/signup',
    'signin'                => 'signin/signin',
    'stu/[:func]'           => 'index/stu/index',
    'teach/[:func]'         => 'index/teach/index',
    'assis/[:func]'         => 'index/assis/index',
    'admin/[:func]'         => 'admin/admin/index',
    'vst/[:func]'           => 'index/vst/index',
    'download/:fileNameUrl' => 'index/download/download',
    'upload'                => 'index/upload/upload',
    'uploadMyHomework'      => 'index/upload/uploadMyHomework',
    'uploadHeadIcon'        => 'index/upload/uploadHeadIcon',
    //'uploadtmp'             => 'admin/admin/index/initStu',
];
