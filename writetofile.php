<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$con = mysql_connect("caijian.51vip.biz","tel","cj2894");
$expnum=1000;
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
 mysql_select_db("Tel", $con);
$myfile = fopen("up/exp.txt", "w") or die("Unable to open file!");
    
$res=mysql_query("select telnum from coll_num limit 0 , {$expnum}");
while($row = mysql_fetch_array($res))
  {
    fwrite($myfile,$row[0]."\n");
 
  }
fclose($myfile);
mysql_close($con);


