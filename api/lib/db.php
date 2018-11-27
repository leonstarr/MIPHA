<?php
if (!defined('IN')){die('Hacking attempt');}

//链接数据库
function _connect(){
    global $con;
    if(!($con=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME))){//mysql_connect连接数据库函数
        _json('200.3', mysqli_error());
    }
    mysqli_set_charset($con,DB_CHASET);//使用mysql_query 设置编码  格式：mysql_query("set names utf8")

}


//执行sql
function _query($sql){

    global $con;
    if (!$sql){
        _json('200.3', '数据库查询语句为空');
    }
    if(!($query = mysqli_query($con,$sql))){//使用mysql_query函数执行sql语句
        _json('200.3', '数据库查询语句错误，或者未连接数据库');//mysql_error 报错
    }else{
        return $query;
    }

}

//查所有
function _findAll($query){
    while($rs=mysqli_fetch_array($query, MYSQLI_ASSOC)){//mysql_fetch_array函数把资源转换为数组，一次转换出一行出来
        $list[]=$rs;
    }
    return isset($list)?$list:"";
}
//获取指定行的指定字段的值
function _findResult($query, $row = 0, $filed = 0){
    $rs = mysqli_result($query, $row, $filed);
    return $rs;
}
//查单个
function _findOne($query){
    $rs = mysqli_fetch_array($query, MYSQLI_ASSOC);
    return $rs;
}
//修改
function _update($table,$arr,$where){//数据（$arr键值对形式）
    //update 表名 set 字段=字段值 where ……
    if(sizeof($arr)<1){
        _json('400','未输入修改内容！');
    }
    foreach($arr as $key=>$value){
        //$value = mysqli_real_escape_string($value);//转义 SQL 语句中使用的字符串中的特殊字符
        $keyAndvalueArr[] = "`".$key."`='".$value."'";
    }
    $keyAndvalues = implode(",",$keyAndvalueArr);
    $sql = "update ".$table." set ".$keyAndvalues." where ".$where;//修改操作 格式 update 表名 set 字段=值 where 条件
    if(_query($sql)){
        _json('200.1',"更新成功!");
    }else{
        _json('200.2',"更新失败!");
    }
}

//真删除
function _del($table,$where){
    global $con;
    $sql = "delete from `".$table."` where ".$where;//删除sql语句 格式：delete from 表名 where 条件
    _query($sql);
    $row = mysqli_affected_rows($con);
    if($row>=1){
        _json('200.1',"删除成功!");
    }else{
        _json('200.2',"删除失败!");
    }
}

//关闭链接
function _close(){
    global $con;
    mysqli_close($con);
}