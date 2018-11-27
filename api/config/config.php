<?php
//db config data
if (!defined('IN')){die('Hacking attempt');}

define("DB_HOST", "127.0.0.1");
define("DB_USER", 'test');
define("DB_PWD", 'test');
define("DB_NAME", 'MIPHA');
define("DB_CHASET",'utf8');


//site
define( 'NAME' , 'MIPHA' );//系统名称
define( 'VER' , '0.1' );//系统版本
define( 'ADDRESS', "http://127.0.0.1");//网站地址


//path
define( 'DS' , DIRECTORY_SEPARATOR );//目录分隔符号
define('PATH',$_SERVER['DOCUMENT_ROOT'].DS);//系统根目录


//page
define("MINPAGESIZE", 3);//每页行数
define("PAGESIZE", 15);//每页行数
define("MAXPAGESIZE", 20);//每页行数


//salt
define("SALT_TOKEN", "asdf13edFXa@");//加密token用混淆码
define("SALT_ADMIN", "Xyf@150714");//管理员密码混淆码
define("SALT_CLIENT", "alkjdsalkj12879");//用户密码混淆码
