<?php

if (!defined('IN')){die('Hacking attempt');}


//输出json退出
function _json($code='404',$info='no page'){

    //输出
    $arr['info']=$info;
    $arr['code']=$code;
    $arr['runtime']=round((microtime(true)-START_TIME),4);
    print json_encode($arr,JSON_UNESCAPED_UNICODE);//输出json
    exit;
}
