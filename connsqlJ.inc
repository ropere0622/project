<?php
//資料庫主機設定
$db_host = "localhost";
$db_username = "root";  //管理者帳號
$db_password = "root";  //管理者密碼
//連線伺服器
$db_link = @mysql_connect($db_host, $db_username, $db_password;
if (!$db_link) die("資料庫連結失敗!");
mysql_query("SET NAME 'utf8'");  //設定字元集宇連線校對
?>