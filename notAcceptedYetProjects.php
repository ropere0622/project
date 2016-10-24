<?php
//Step 1 DB 連線
mysql_connect('localhost','hb141','hb141');

//Step 2 select your DB
mysql_select_db("hdb");

//Step 3 避免中文亂碼
include("unicode.php");

//Step 4 SQL  找出project狀態status為N且顧問為傳入的顧問代號 $_GET['u']
$sql= "SELECT p_no,p_name,c_name,contact,address FROM project p,customer c where p.c_no=c.c_no and p.m_id='".$_GET['u']."' and status='N'";

//$echo $sql;  debug 用

$rs=mysql_query($sql); //執行SQL

echo mysql_error();
//$res='任務編號/日期/時間/專案名稱/公司/聯絡人,';
while($r=mysql_fetch_object($rs)){
   $res.="".$r->p_no."->";  	//project代號
   $res.=$r->p_name."/";    	//project名稱
   $res.=$r->c_name."/";    	//客戶名稱
   $res.=$r->contact."/";	//客戶聯絡人
   $res.=$r->address.",";	//客戶地址
}
echo $res;
?>
