
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
            move_uploaded_file($tmp_name, 'up/proc.txt');
            $destination = "up/proc.txt";
            echo '文件"' . $name . '"上传成功啦!' . "\n";
            echo "检查该文件是否需要转码......";
            $contents_before = file_get_contents($destination);
            $encoding = mb_detect_encoding($contents_before, array('CP936', 'ASCII', 'GBK', 'GB2312', 'UTF-8'));
            echo "原本编码是:" . $encoding;
            if ($encoding <> 'UTF-8') {
                $contents_after = iconv('GBK', 'UTF-8', $contents_before);
                file_put_contents($destination, $contents_after);
                echo "转码完成.\n";
            }
            echo "正在整理数据,请稍后......";
            $con = mysql_connect("caijian.51vip.biz", "tel", "cj2894");
            $succ = 0;
            $false = 0;
            if (!$con) {
                die("不能连接数据库:" . mysql_error() . "\n");
            }

            mysql_select_db("Tel", $con);
            mysql_query("SET NAMES 'utf8'");
            $file = fopen("up/proc.txt", "r") or die("不能打开上传文件! \n");
            while (!feof($file)) {
                $cont = fgets($file);
                //               $cont = iconv('GB2312', 'UTF-8', $cont);
                $cont = str_replace('：', ' ', trim($cont));
                $str = preg_replace('/\s(?=\s)/', '', $cont);
                //       print_r($str);
                $str = split(' ', trim($str));

                if (count($str) >= 9) {

                    $chk_str = "select down from coll_num where telnum='" . $str[1] . "'";
                    $chk_result = mysql_query($chk_str);
                    $chk_row = mysql_fetch_row($chk_result);

                    if ($chk_row[0] == 1) {
                        switch ($str[2]) {
                            case '未接听':
                                $call_status = 1;
                                $click = '';
                                break;
                            case '已接听':
                                $call_status = 2;
                                $click = '';
                                break;
                            case '转人工':
                                $call_status = 3;
                                $click = $str[8];
                                break;
                        }
                        $call_time = $str[3] . ' ' . $str[4];
                        $sql_str = "INSERT INTO proc_num (telnum, call_status, call_time, call_duration, click) VALUES ('" . $str[1] . "','" . $call_status . "','" . $call_time . "','" . $str[6] . "','" . $click . "')";
                        if (!mysql_query($sql_str)) {
                            $false++;
                        } else {
                            $succ++;
                        }
                    }else {$false++;}
                }
            }
            fclose($file);
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


