<?php

require_once 'vendor/autoload.php';

use niklaslu\Auth;
use think\Config;

define('RUNTIME_PATH', 'runtime');

$database = [
    // 数据库类型
    'type'           => 'mysql',
    // 数据库连接DSN配置
    'dsn'            => '',
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
    // 数据库连接参数
    'params'         => [],
    // 数据库编码默认采用utf8
    'charset'        => 'utf8',
    // 数据库表前缀
    'prefix'         => 't_',
    // 数据库调试模式
    'debug'          => false,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'         => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'    => false,
    // 读写分离后 主服务器数量
    'master_num'     => 1,
    // 指定从服务器序号
    'slave_no'       => '',
    // 是否严格检查字段是否存在
    'fields_strict'  => true,
    // 自动写入时间戳字段
    'auto_timestamp' => false,
];

Config::set('database' , $database);


$auth = new Auth();

$uid = 1;
// $groupIds = $auth->getRules($uid);

// print_r($groupIds);


// $check = $auth->checkRule('route', $uid);

$check = $auth->check('test,route', $uid , 'and');

if (!$check){
    $error = $auth->getErrorInfo();
    
    print_r($error);
    
}else{
    echo 1;
}
