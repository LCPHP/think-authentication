# think-authentication
基于thinkphp5.0的权限认证

### Install

```
composer require niklaslu/think-authentication
```

### Auth Class
```
/**
     *
     * @param string $name 规则名称,多个用，隔开
     * @param int $uid 用户id
     * @param string $tpye and:且关系 or: 或关系
     */
    public function check($name , $uid , $relation = 'and'){
       // code ......
    }
```

说明：
+ $name可为多条规则, 用`,`分隔
+ 验证关系默认为 `and`(且关系) ，'or'为或关系

使用方法看示例


### 使用方式

#### 添加配置项

```php
'auth'  => [
    'is_open'           => 1, // 权限开关 1为开启，0为关闭
    'type'         => 1, // 认证方式 TODO。
    'table_group'        => 'auth_group', // 用户组数据不带前缀表名
    'table_user_group' => 'auth_user_group', // 用户-用户组关系不带前缀表
    'table_auth_rule'         => 'auth_rule', // 权限规则不带前缀表
    'table_user'         => 'user', // 用户信息不带前缀表
],
```

#### 导入数据表  

+ doc文件夹下有带测试数据的sql文件 db_with_test_data.sql
+ 1.数据表前缀都未 't_';
+ 2.导入数据前先建立数据库 默认 'd_auth';

```sql

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_group`;
CREATE TABLE `t_auth_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for t_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_rule`;
CREATE TABLE `t_auth_rule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for t_auth_user_group
-- ----------------------------
DROP TABLE IF EXISTS `t_auth_user_group`;
CREATE TABLE `t_auth_user_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

```

#### 使用示例

已带有测试数据的db文件导入为例，具体可查看`index.php`  

```php
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
```
