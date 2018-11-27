<?php

if (!defined('IN')){die('Hacking attempt');}

//启动 session
if (session_status() == PHP_SESSION_NONE) {
    //session_set_cookie_params(3600*24*7);
    session_start();
}

//Account登陆
function _login($id = null, $name = null, $pass = null, $keep = 0)
{

    //生成唯一token 防止token重复  //不要放密码
    //$sign=md5($name.SALT_TOKEN)."_".md5($pass.SALT_TOKEN)."_".md5($browse.$ip.SALT_TOKEN)."_".md5($keep.SALT_TOKEN);

    //存服务器
    $_SESSION['username'] = $name;
    $_SESSION['uid'] = $id;
    $_SESSION['keep'] = $keep;


    //$_SESSION['browseIp']=md5($browse.$ip.SALT_TOKEN);

    //ip id 入库
    $sessionId = session_id();//获取ID
    $ip = _get_real_ip();//??是否需要正则

    _connect();

    $sql = "UPDATE `admin` SET `session` = '{$sessionId}', `last_ip` = '{$ip}' ,`last_login`=CURRENT_TIMESTAMP WHERE `admin_id` = {$id};";



    _query($sql);


    if ($keep == 1) {

        //保持登入7天
        $lifeTime = 24 * 3600 * 7;
        //过期时间
        $_SESSION['expiretime'] = time() + $lifeTime;
        setcookie("PHPSESSID", session_id(), time() + $lifeTime, "/");
        setcookie('flag', 1, time() + $lifeTime, "/");
        setcookie('username', $name, time() + $lifeTime, "/");

    } else {
        //保留1小时
        $_SESSION['expiretime'] = time() + 3600;
        setcookie("PHPSESSID", session_id(), time() + 3600, "/");
        setcookie('flag', 1, time() + 3600, "/");
        setcookie('username', $name, time() + 3600, "/");
    }

}


//Client登陆
function _loginForClient($id = null, $name = null, $pass = null, $keep = 0)
{

    $browse = '';
    $ip = '';
    $sign = '';

    //$browse=$_SERVER['HTTP_USER_AGENT'];

    $ip = _get_real_ip();

    //生成唯一token 防止token重复  //不要放密码
    // $sign=md5($name.SALT_TOKEN)."_".md5($pass.SALT_TOKEN)."_".md5($browse.$ip.SALT_TOKEN)."_".md5($keep.SALT_TOKEN);

    //存服务器

    $_SESSION['c_username'] = $name;
    $_SESSION['uid'] = $id;
    //$_SESSION['browseIp']=md5($browse.$ip.SALT_TOKEN);
    $_SESSION['keep'] = $keep;


    //ip id 入库
    $sessionId = session_id();//获取ID
    $ip = _get_real_ip();//??是否需要正则

    _connect();
    $sql = "UPDATE `client` SET `sID` = '{$sessionId}', `IP` = '{$ip}' WHERE `client`.`id` = {$id};";

    _query($sql);


    if ($keep == 1) {
        //保持登入7天
        $lifeTime = 24 * 3600 * 7;
        //过期时间
        $_SESSION['expiretime'] = time() + $lifeTime;
        setcookie("PHPSESSID", session_id(), time() + $lifeTime, "/");
        setcookie('flag', 1, time() + $lifeTime, "/");
        setcookie('c_username', $name, time() + $lifeTime, "/");

    } else {

        $_SESSION['expiretime'] = time() + 3600;
        setcookie("PHPSESSID", session_id(), time() + 3600, "/");
        setcookie('flag', 1, time() + 3600, "/");
        setcookie('c_username', $name, time() + 3600, "/");
    }

}

//登出
function _logout()
{




    session_unset();//清除SESSION值.


    session_destroy(); //销毁一个会话中的全部数据




    if (isset($_COOKIE['PHPSESSID'])) { //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
        setcookie("PHPSESSID", '', time() - 3600, '/');
    }

    if (isset($_COOKIE['username'])) { //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
        setcookie("username", '', time() - 3600, '/');
    }

    if (isset($_COOKIE['flag'])) { //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
        setcookie("flag", '', time() - 3600, '/');
    }


    if (isset($_COOKIE['c_username'])) { //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
        setcookie("c_username", '', time() - 3600, '/');
    }


}

//判断 session
function _session()
{
    //判断borwse ip
    $browse = '';
    $ip = '';

    //$browse=$_SERVER['HTTP_USER_AGENT'];
    //$ip=get_real_ip();


    //判断session过期
    if ((!isset($_SESSION['expiretime'])) || ($_SESSION['expiretime'] < time())) {

        _logout();
        _json('401', '未登录系统或授权过期请重新登陆');

    } else if ($_SESSION['keep'] == '0') {//当 keep=0时 计算活动时间


        $_SESSION['expiretime'] = time() + 3600;
        setcookie("PHPSESSID", session_id(), time() + 3600, "/");
        setcookie('flag', 1, time() + 3600, "/");

        if (isset($_SESSION['c_username'])) {
            setcookie('c_username', $_SESSION['c_username'], time() + 3600, "/");
        }

        if (isset($_SESSION['username'])) {
            setcookie('username', $_SESSION['username'], time() + 3600, "/");
        }


    }


    //判断uid

    if (isset($_SESSION['uid'])) {
        $id = $_SESSION['uid'];
    } else {
        _json('401', '请登陆系统');
    }

    _connect();

    //判断SessionID 是否和数据库中匹配
    $sID = session_id();

    $sql = "select account_id from `account` where `session`='{$sID}' and account_id='{$id}'";


    if (mysqli_num_rows(_query($sql)) < 1) {

        _logout();

        _json('401', '账号在其他地点登陆');

    }


}


//判断 用户是否有api权限
function _checkSessionClient()
{
    //判断borwse ip
    $browse = '';
    $ip = '';

    //$browse=$_SERVER['HTTP_USER_AGENT'];
    //$ip=get_real_ip();


    //判断session过期
    if ((!isset($_SESSION['expiretime'])) || ($_SESSION['expiretime'] < time())) {

        _logout();
        _json('401', '未登录系统或授权过期请重新登陆');

    } else if ($_SESSION['keep'] == '0') {//当 keep=0时 计算活动时间


        $_SESSION['expiretime'] = time() + 3600;
        setcookie("PHPSESSID", session_id(), time() + 3600, "/");
        setcookie('flag', 1, time() + 3600, "/");

        if (isset($_SESSION['c_username'])) {
            setcookie('c_username', $_SESSION['c_username'], time() + 3600, "/");
        }

        if (isset($_SESSION['username'])) {
            setcookie('username', $_SESSION['username'], time() + 3600, "/");
        }


    }


    //判断uid

    if (isset($_SESSION['uid'])) {
        $id = $_SESSION['uid'];
    } else {
        _json('401', '请登陆系统');
    }

    _connect();

    //判断SessionID 是否和数据库中匹配
    $sID = session_id();

    $sql = "select id from `client` where sID='{$sID}' and id='{$id}'";

    if (mysqli_num_rows(_query($sql)) < 1) {

        _logout();

        _json('401', '账号在其他地点登陆');

    }


}