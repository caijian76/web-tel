<?php


header("Content-type: text/html; charset=utf-8");
$num = (int)$_POST["telnum"];
$youxian=$_POST["boda"];
$teltype=$_POST["teltype"];
$filename=$_POST["filename"];


$con = mysql_connect("caijian.51vip.biz", "tel", "cj2894");
if (!$con) {
                die("不能连接数据库:" . mysql_error() . "\n");
            }
mysql_select_db("Tel", $con);
mysql_query("SET NAMES 'utf8'");
$rc=0;
$rc1=0;

if ($teltype=="union"){
    $sqladd="and (telnum like '130%' or telnum like '131%' or telnum like '132%' or telnum like '155%' or telnum like '156%' or telnum like '185%' or telnum like '186%' or telnum like '145%' or telnum like '176%') ";
}else if ($teltype=="no-union"){
    $sqladd="and (telnum not like '130%' and telnum not like '131%' and telnum not like '132%' and telnum not like '155%' and telnum not like '156%' and telnum not like '185%' and telnum not like '186%' and telnum not like '145%' and telnum not like '176%') ";
}else{ $sqladd="";}

if ($youxian=='weiboda'){
  $sql_str = "CREATE TEMPORARY TABLE tmp_table SELECT * FROM coll_num where `status`=0 and `down`=0 $sqladd order by `lasttime`,`id` limit $num";
  mysql_query($sql_str);

}else if ($youxian=='yiboda'){
  $sql_str = "CREATE TEMPORARY TABLE tmp_table SELECT * FROM coll_num where `status`=1 and `down`=0 and `call_no`<3 $sqladd order by `call_no`,`lasttime`,`id` limit $num";
  mysql_query($sql_str);
}
  $sql_str = "update coll_num a,tmp_table b set a.down=1 where a.id=b.id";
  mysql_query($sql_str);
  $rc = mysql_affected_rows();
  echo "按优先选择条件的要求,获取数据 $rc 条.\n";
  $sql_str="select telnum from tmp_table";
  $result=  mysql_query($sql_str);
  $file=fopen($filename, "w") or die("不能打开上传文件! \n");;
  while($row=mysql_fetch_row($result))
  {
      fputs($file, "$row[0]\r\n");
  }
    
if ($rc < $num) {
    $addnum=$num-$rc;
    if ($youxian == 'yiboda') {
        $sql_str = "CREATE TEMPORARY TABLE tmp_table_1 SELECT * FROM coll_num where `status`=0 and `down`=0 $sqladd order by `lasttime`,`id` limit $addnum";
        mysql_query($sql_str);
    } else if ($youxian == 'weiboda') {
        $sql_str = "CREATE TEMPORARY TABLE tmp_table_1 SELECT * FROM coll_num where `status`=1 and `down`=0 and `call_no`<3 $sqladd order by `call_no`,`lasttime`,`id` limit $addnum";
        mysql_query($sql_str);
    }
    $sql_str = "update coll_num a,tmp_table_1 b set a.down=1 where a.id=b.id";
    mysql_query($sql_str);
    $rc1 = mysql_affected_rows();
    echo "满足优先选择条件的记录不足,另外获取数据 $rc1 条.\n";
    $sql_str="select telnum from tmp_table_1";
    $result=  mysql_query($sql_str);
    
    while($row=mysql_fetch_row($result))
    {
        fputs($file, "$row[0]\r\n");
    }
}
$rc2=$rc+$rc1;
echo "总共获取数据 $rc2 条.\n";

fclose($file);
mysql_close($con);


