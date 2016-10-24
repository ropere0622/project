<?php
   //Step 1 DB 連線
   mysql_connect('localhost','root','hb14100');

   //Step 2 select your DB
   mysql_select_db("HCMWS");

   //Step 3 避免中文亂碼
   include("unicode.php");

   //Step 4 SQL 使用APP傳回的 m_no 和 score

   $rs=mysql_query($sql); //執行SQL
   $r=mysql_fetch_object($rs);
   echo "<center>".$r->P_Name."<br>";
   if($r->photo1<>null)
     echo '照片1<br><img src="data:image/jpeg;base64,'.base64_encode( $r->photo1).'" width=30%/><br><br>';
?>