<?php

$filename=$_POST["downfile"];
$fileinfo = pathinfo($filename);

header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
header('Content-Length: '.filesize($filename));
readfile($filename);
exit();


