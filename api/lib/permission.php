<?php

if (!defined('IN')){die('Hacking attempt');}

/*判断api方法权限返回true or false*/

function _permission($controllername=null,$actionname=null){

    //方法不能为空
    if($actionname==null||$controllername==null){
        json('400','参数错误');
    }


    _session();//判断是否登录

    //获取用户组

    _connect();


    /*查询该用户权限记录*/
    $sql = "select * from `permission` where actionname='".$actionname."' and controller='".$controllername."'";

    echo $sql;


    if(mysqli_num_rows(_query($sql))<1){
        _close();
        _json('403','权限错误！请联系超级管理员！');
    }
    _close();
}

