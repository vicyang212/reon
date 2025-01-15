<?php
//PDO sql連線指令
$dsn="mysql:host=sql210.byethost16.com;dbname=b16_37668550_reon;charset=utf8";
$user="b16_37668550";
$password="inhaps123456";
$link=new PDO($dsn,$user,$password);
date_default_timezone_set("Asia/Taipei");
?>