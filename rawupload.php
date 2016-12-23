
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: text/html; charset=utf-8");
$upfile = $_FILES["upfile"];
//print_r($upfile); 
$error = $upfile["error"]; //上传后系统返回的值 
if ($error == 0) {
    if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {

//获取数组里面的值 
        $name = $upfile["name"]; //上传文件的文件名 
        $type = $upfile["type"]; //上传文件的类型 
        $size = $upfile["size"]; //上传文件的大小 
        $tmp_name = $upfile["tmp_name"]; //上传文件的临时存放路径 
//判断是否为制定文件 
        if ($type == 'text/plain') {
            $okType = true;
        } else {
            $okType = false;
        }
        /*
          switch ($type){
          case 'image/pjpeg':$okType=true;
          break;
          case 'image/jpeg':$okType=true;
          break;
          case 'image/gif':$okType=true;
          break;
          case 'image/png':$okType=true;
          break;
          } */

        if ($okType) {
            /**
             * 0:文件上传成功<br/> 
             * 1：超过了文件大小，在php.ini文件中设置<br/> 
             * 2：超过了文件的大小MAX_FILE_SIZE选项指定的值<br/> 
             * 3：文件只有部分被上传<br/> 
             * 4：没有文件被上传<br/> 
             * 5：上传文件大小为0 

              echo "================<br/>";
              echo "上传文件名称是：".$name."<br/>";
              echo "上传文件类型是：".$type."<br/>";
              echo "上传文件大小是：".$size."<br/>";
              echo "上传后系统返回的值是：".$error."<br/>";
              echo "上传文件的临时存放路径是：".$tmp_name."<br/>";

              echo "开始移动上传文件<br/>";
             */
//把上传的临时文件移动到up目录下面 
            move_uploaded_file($tmp_name, 'up/tel.txt');
            echo '文件"' . $name . '"上传成功啦!' . "\n";
            echo "正在整理数据,请稍后......";
            $con = mysql_connect("caijian.51vip.biz", "tel", "cj2894");
            $succ = 0;
            $false = 0;
            if (!$con) {
                die("不能连接数据库:" . mysql_error() . "\n");
            }

            mysql_select_db("Tel", $con);
            $myfile = fopen("up/tel.txt", "r") or die("不能打开上传文件! \n");
            
            
            while (!feof($myfile)) {
                $cont = fgets($myfile);
                $cont=  trim($cont);
                if (preg_match("/^1[34578]\d{9}$/", $cont)) {
                    if (!mysql_query("INSERT INTO coll_num (telnum) VALUES ({$cont})")) {
                        $false++;
                    } else {
                        $succ++;
                    }
                }else{$false++;}
            }
            fclose($myfile);
            echo "整理完成. \n";
            echo "成功:" . $succ . "  失败:" . $false . "\n";
        } else {
            echo "请上传txt的文本文件!\n";
        }
    }
} elseif ($error == 1) {
    echo "超过了文件大小，在php.ini文件中设置\n";
} elseif ($error == 2) {
    echo "超过了文件的大小MAX_FILE_SIZE选项指定的值\n";
} elseif ($error == 3) {
    echo "文件只有部分被上传\n";
} elseif ($error == 4) {
    echo "没有文件被上传\n";
} else {
    echo "上传文件大小为0\n";
}


