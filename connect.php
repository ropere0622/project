<?php
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它
include("connsqlJ.inc.php");
$id = $_POST['id'];
$pw = $_POST['pw'];

//搜尋資料庫資料
$sql = "SELECT * FROM user username = '$id'";
$result = mysql_query($sql);
$row = @mysql_fetch_row($result);

?>