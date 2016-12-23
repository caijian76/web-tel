<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$con = mysql_connect("caijian.51vip.biz","tel","cj2894");
$succ=0;
$false=0;
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
 mysql_select_db("Tel", $con);
$myfile = fopen("up/tel.txt", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $cont=fgets($myfile);
    
if (!mysql_query("INSERT INTO coll_num (telnum) 
VALUES ({$cont})"))
{ $false++;}else{$succ++;}
}
fclose($myfile);
echo 'succ:'.$succ.'  false:'.$false;

