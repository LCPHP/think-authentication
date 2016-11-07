<?php

require_once 'vendor/autoload.php';

use niklaslu\Auth;
use think\Config;

define('RUNTIME_PATH', 'runtime');

$database = [
    // 数据库类型
    'type'           => 'mysql',
    // 服务器地址
    'hostname'       => 'localhost',
    // 数据库名
    'database'       => 'd_auth',
    // 数据库用户名
    'username'       => 'root',
    // 数据库密码
    'password'       => 'root',
    // 数据库连接端口
    'hostport'       => '3306',
    // 数据库编码默认采用utf8
    'charset'        => 'utf8',
    // 数据库表前缀
    'prefix'         => 't_',

];

Config::set('database' , $database);


$auth = new Auth();

// 测试用户id为1
$uid = 1;

// $check = $auth->check('test', $uid);
// result : '验证通过'

// $check = $auth->check('route' , $uid);
// result : Array ( [error_code] => 100002 [error_msg] => 验证规则无权限 )

// $check = $auth->check('norule' , $uid);
// result : Array ( [error_code] => 100001 [error_msg] => 验证规则不存在 )

// $check = $auth->check('test,route', $uid , 'and');
// result : Array ( [error_code] => 100002 [error_msg] => 验证规则无权限 )

$check = $auth->check('test,route', $uid , 'or');
// result : 验证通过


if (!$check){
    // 验证不通过可以查看验证不通过错误代码
    $error = $auth->getErrorInfo();
    print_r($error);

}else{
    echo '验证通过';
}
