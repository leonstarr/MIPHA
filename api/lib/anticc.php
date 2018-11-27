<?php

if (!defined('IN')){die('Hacking attempt');}

/**
 * @name cc防御模块
 * @author leon starr
 * @param
 * @return json
 * @date 2018/9/21
 */

//声明utf-8编码
header('Content-Type:text/html;charset=utf-8');


//判断代理访问直接退出
if(!empty($_SERVER['HTTP_VIA'])) _json("403","禁止代理访问");


//防止快速刷新
if (session_status() == PHP_SESSION_NONE) {
    session_start();}


//参数
$seconds = '3'; //时间段[秒]
$refresh = '5'; //刷新次数


//设置监控变量
$cur_time = time();

if(isset($_SESSION['last_time'])){
    $_SESSION['refresh_times'] += 1;
}else{
    $_SESSION['refresh_times'] = 1;
    $_SESSION['last_time'] = $cur_time;
}


//处理监控结果
if($cur_time - $_SESSION['last_time'] < $seconds){

    if($_SESSION['refresh_times'] >= $refresh){
        _json("403","过度刷新禁止访问");
    }

}else{
    $_SESSION['refresh_times'] = 0;
    $_SESSION['last_time'] = $cur_time;
}
