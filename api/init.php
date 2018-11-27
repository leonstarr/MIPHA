<?php
//加自定义库与初始化配置

error_reporting(E_ALL);  //调试模式

if (!defined('IN')){die('Hacking attempt');}


date_default_timezone_set('Asia/Shanghai'); //配置时区

define("START_TIME",microtime(true));//启动时间


require_once('config/config.php');//加载数据库配置文件

require_once ('lib/permission.php');//判断账号权限验证

require_once('lib/json.php');//json封装

require_once('lib/session.php');//session封装

require_once('lib/regex.php');//输入数据验证库

require_once('lib/db.php');//db库

require_once('lib/anticc.php');//cc防御模块

require_once('lib/ip.php');//获取ip方法


