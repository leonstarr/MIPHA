<?php

//   ^是正则表达式匹配字符串开始位置
//   $是正则表达式匹配字符串结束位置

if (!defined('IN')){die('Hacking attempt');}

//验证函数
function _regex($strand, $type)
{

    $row = false;

    if ($type == "id") { //身份证

        if (preg_match("/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "web") { //网址

        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $strand)) {

            $row = true;

        }

    } elseif ($type == "email") { //email

        if (preg_match("/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "name") { //姓名 中文

        if (preg_match("/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "team_name") { //姓名 中文英文数字

        if (preg_match("/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u", $strand)) {

            $row = true;

        }

    } elseif ($type == "telephone") { //固定电话

        if (preg_match("/^(0\\d{2}-\\d{8}(-\\d{1,4})?)|(0\\d{3}-\\d{7,8}(-\\d{1,4})?)$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "cellphone") { //手机电话

        /*接下来的正则表达式("/130,131,132,133,135,136,139开头随后跟着任意的8为数字 '|'(或者的意思)
        * 151,152,153,156,158.159开头的跟着任意的8为数字
        * 或者是188开头的再跟着任意的8为数字,匹配其中的任意一组就通过了
        * 199 173
        */

        if (preg_match("#^19[\d]{9}$|13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,3,6,7,8]{1}\d{8}$|^18[\d]{9}$#", $strand)) {
            $row = true;
        }

    } elseif ($type == "ip") { //ip地址

        if (preg_match("/^(?:(?:1[0-9][0-9]\.)|(?:2[0-4][0-9]\.)|(?:25[0-5]\.)|(?:[1-9][0-9]\.)|(?:[0-9]\.)){3}(?:(?:1[0-9][0-9])|(?:2[0-4][0-9])|(?:25[0-5])|(?:[1-9][0-9])|(?:[0-9]))$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "pint") { //非0正整数

        if (preg_match("/^[1-9]\d*$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "int") { //从0开始正整数

        if (preg_match("/^[0-9]\d*$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "zo") { //从0开始正整数

        if (preg_match("/^[0-1]{1}\d*$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "bankcard") { //银行卡号

        if (preg_match("/\d{15}|\d{19}/", $strand)) {

            $row = true;

        }

    } elseif ($type == "smallnumber") { //验证小数点后1位***

        if (preg_match("/^\d+(\.\d{1})?$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "money2") { //验证小数点后2位***

        if (preg_match("/^\d+(\.\d{2})?$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "en") { //纯英文

        if (preg_match("/^[A-Za-z]+$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "password") { //密码格式

        if (preg_match("/^[a-zA-Z\d_]{6,}$/", $strand)) {

            $row = true;

        }

    } elseif ($type == "username") { //用户名格式

        if (preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $strand)) {

            $row = true;

        }


    } elseif ($type == "time") { //YYYY-MM-DD 还需要改进

        if (preg_match("/\d{4}-1[0-2]|0?[1-9]-0?[1-9]|[12][0-9]|3[01]/", $strand)) {

            $row = true;

        }


    } elseif ($type == "model") { //产品型号 英文加数字加下划线 中划线

        if (preg_match("/^[A-Za-z0-9-_]+$/", $strand)) {

            $row = true;

        }


    } elseif ($type == "photoFilename") { //产品型号 英文加数字加下划线 中划线

        if (preg_match("/^[A-Za-z0-9]+\.(jpg|png|gif|jpeg)$/i", $strand)) {  //'jpg','jpeg','gif','png')  $imagePatter = '/[A-Za-z0-9]*\.(jpg|png|gif|jpeg)/';

            $row = true;

        }


    }

    return $row;

}


function clearRemark($remark)
{

    $regex = "/\/|\~|\@|\#|\\$|\%|\^|\&|\*|\（|\）|\(|\)|\_|\+|\；|\{|\}|\<|\>|\[|\]|\/|\;|\'|\`|\ |\"|\【|\】|\-|\=|\\\|\|/";
    return preg_replace($regex, "", $remark);
}   
	
