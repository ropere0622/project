<?php
//Step 1 DB 連線
mysql_connect('localhost','hb141','hb141');

//Step 2 select your DB
mysql_select_db("hdb");

//Step 3 避免中文亂碼
include("unicode.php");

//Step 4 SQL   
$sql= "SELECT m.m_no,p_name,c_name,date_format(date,'%m/%d') date,time_format(time,'%p%h:%m') time,contact,address FROM mission m,project p,customer c where m.p_no=p.p_no and p.c_no=c.c_no and p.m_id='".$_GET['u']."' order by date asc";

//$echo $sql;  debug 用

$rs=mysql_query($sql); //執行SQL

echo mysql_error();
//$res='任務編號/日期/時間/專案名稱/公司/聯絡人,';
while($r=mysql_fetch_object($rs)){
   $res.="".$r->m_no."->";
   $res.=$r->date." ";
   $res.=$r->time."/";
   $res.=$r->p_name."/";
   $res.=$r->c_name."/";
   $res.=$r->contact."/";
   $res.=$r->address.",";
}
echo $res;
?>
