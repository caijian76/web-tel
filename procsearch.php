
<?php
$searchid = (int)$_POST["searchid"];
if ($searchid==1){
    require_once 'datatable1.php';
}else if ($searchid==2 or $searchid==3){
    require_once 'datatable2.php';
}
