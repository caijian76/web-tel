<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// 设置返回json格式数据
header('content-type:application/json;charset=utf8');
 
//连接数据库
$link = mysql_connect("localhost", "tel", "cj2894") or die("Unable to connect to the MySQL!");
 
mysql_query("SET NAMES 'UTF8'");
 
mysql_select_db("Tel", $link) or die("Unable to connect to the MySQL!");
 
// 获取分页参数

 

 
// 查询数据到数组中
$result = mysql_query("select telnum,call_status,call_time,call_duration,click from proc_num where call_duration>'00:00:20' ");
$users=array();
$i=0;
while($row=mysql_fetch_row($result)){
$users[$i]=$row;
$i++;
}
echo json_encode(array('data'=>$users)); 
 
// 将数组转成json格式
//$res=array('data'=>$result);
//print_r ($res);
//print_r($res);
//echo json_encode($res);
 
// 关闭连接
mysql_free_result($result);
 
mysql_close($link);