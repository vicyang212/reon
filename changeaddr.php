<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json;charset=utf-8');

(!isset($_SESSION))?session_start():"";
require_once("Connections/dbset.php");

if(isset($_SESSION['emailid'])&&$_SESSION['emailid']!=""){
    $emailid=$_SESSION['emailid'];
    $addressid=$_POST['addressid'];

    $query=sprintf("UPDATE addbook SET setdefault='0' WHERE emailid='%d' AND setdefault='1';", $emailid);
    $result=$link->query($query);
    $query=sprintf("UPDATE addbook SET setdefault='1' WHERE addressid='%d';" ,$addressid);
    $result=$link->query($query);
    if($result){
        $retcode=array("c"=>"1","m"=>'收件人已經變更');
    }else{
        $retcode=array("c"=>"0","m"=>'抱歉，資料無法寫入後台資料庫，請聯絡管理人員');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return;

?>