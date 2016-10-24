<?php require_once('Connections/My.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "From_Pro")) {
  $insertSQL = sprintf("INSERT INTO project (C_NO, P_Name, M_ID, Start_Date, Close_Date) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['C_NO'], "int"),
                       GetSQLValueString($_POST['P_Name'], "text"),
                       GetSQLValueString($_POST['M_ID'], "text"),
                       GetSQLValueString($_POST['Start_Date'], "date"),
                       GetSQLValueString($_POST['Close_Date'], "date"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($insertSQL, $My) or die(mysql_error());

  $insertGoTo = "project_update_Menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_My, $My);
$query_user = "SELECT * FROM `user` WHERE Job = 'Consultant'";
$user = mysql_query($query_user, $My) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

mysql_select_db($database_My, $My);
$query_Customer = "SELECT * FROM customer";
$Customer = mysql_query($query_Customer, $My) or die(mysql_error());
$row_Customer = mysql_fetch_assoc($Customer);
$totalRows_Customer = mysql_num_rows($Customer);
?>
<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>顧問傭兵</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
    <style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
    </style>
</head>
<body>
	<div id="header">
		<div class="clearfix">
			<div class="logo">
				<a href="index.html"><img src="images/logo.png" alt="LOGO" height="52" width="362"></a>
			</div>
				<ul class="navigation">
				<li class="active">
					<a href="index.html">回首頁</a>
				</li>
				<li>
					<a href="news.html">職員管理</a>
					<div>
						<a href="user_add2.php">職員新增</a>
					 
						<a href="user_update_Menu2.php">職員修改</a>
					</div>
				</li>
				<li>
					<a href="news.html">專案任務管理</a>
					<div>
						
					 
						<a href="project_update_Menu2.php"><font size="-1">專案任務管理</font></a>
							<a href="project_view2.php"><font size="-1">專案任務狀態</font></a>
					</div>
				</li>
				<li>
					<a href="news.html">客戶公司管理</a>
					<div>
						<a href="customer_add2.php">客戶公司新增</a>
					 
					
					</div>
				</li>
				
				<li>
					<a href="contact.html">聯絡我們</a>				</li>
				<li>
					<a href="index.php">登出系統</a>
				</li>
			</ul>
		</div>
	</div>
	<div id="contents">
		<div class="clearfix">
			<div class="sidebar">
				<div>
					<h2>專案任務管理</h2>
					<ul>
						<li>
							<a href="project_add2.php">專案任務新增</a>
						</li>
						<li>
							<a href="project_update_Menu2.php">專案任務管理</a>
						</li>
						<li>
							<a href="project_view2.php">專案任務狀態</a>
						</li>
					</ul>
				</div>
				<div>
					<h2>什麼是管理顧問</h2>
					<p>
						管理顧問負責跟蹤、參與客戶企業的經營管理與決策，並提出對企業發展及營運的建議，或避免客戶企業出現經營管理問題。透過顧問與客戶企業的經常性接觸，協助企業快速健康發展。 
					</p>
				</div>
			</div>
			<div class="main">
				<h1>專案新增</h1>
				<p>






<center>
<form action="<?php echo $editFormAction; ?>" id="From_Pro" name="From_Pro" method="POST">
  <table width="60%" border="0">
    <tbody>
      <tr>
        <td width="30%" height="40" bgcolor="#646464" style="text-align: right"><span class="style1">專案名稱</span></td>
        <td style="text-align: left"><input name="P_Name" type="text" id="P_Name"></td>
      </tr>
      <tr>
        <td height="40" bgcolor="#646464" style="text-align: right"><span class="style1">指派顧問</span></td>
        <td style="text-align: left"><select name="M_ID" id="M_ID">
          <?php
do {  
?>
          <option value="<?php echo $row_user['ID']?>"<?php if (!(strcmp($row_user['ID'], $row_user['Name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_user['Name']?></option>
          <?php
} while ($row_user = mysql_fetch_assoc($user));
  $rows = mysql_num_rows($user);
  if($rows > 0) {
      mysql_data_seek($user, 0);
	  $row_user = mysql_fetch_assoc($user);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td width="30%" height="40" bgcolor="#646464" style="text-align: right"><span class="style1">客戶公司</span></td>
        <td style="text-align: left"><select name="C_NO" id="C_NO">
          <?php
do {  
?>
          <option value="<?php echo $row_Customer['C_NO']?>"<?php if (!(strcmp($row_Customer['C_NO'], $row_Customer['C_NAME']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Customer['C_NAME']?></option>
          <?php
} while ($row_Customer = mysql_fetch_assoc($Customer));
  $rows = mysql_num_rows($Customer);
  if($rows > 0) {
      mysql_data_seek($Customer, 0);
	  $row_Customer = mysql_fetch_assoc($Customer);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td width="30%" height="40" bgcolor="#646464" style="text-align: right"><span class="style1">開始日期</span></td>
        <td style="text-align: left"><input type="date" name="Start_Date" id="Start_Date"></td>
      </tr>
      <tr>
        <td width="30%" height="40" bgcolor="#646464" style="text-align: right"><span class="style1">結束日期</span></td>
        <td style="text-align: left"><input type="date" name="Close_Date" id="Close_Date"></td>
      </tr>
      </tbody>
  </table>
  <input type="submit" name="P_A_Button" id="P_A_Button" value="送出">
  <input type="reset" name="P_A_reset" id="P_A_reset" value="重設">
  <input type="hidden" name="MM_insert" value="From_Pro">
</form>
</center>









				</p>
		  </div>
		</div>
	</div>
<div id="footer">
		<div class="clearfix">
			<div class="section">
				<h4>何謂「專案」? </h4>
				<p>
					廣義而言，所謂「專案」係指一個特殊而有一定限度的 (Finite)任務，或由一群聚相互關連性的工作所共同組合起來的任務，而該任務是以獲得特殊結果或圓滿達成某種成就為目標。
 
				</p>
			</div>
			<div class="section contact">
				<h4>關於我們</h4>
				<p>
					<span>地址:</span> 台北市OO路OO號
				</p>
				<p>
					<span>Phone:</span> (02) XXXX-XXXX
				</p>
				<p>
					<span>Email:</span> XXX@XXX.com.TW
				</p>
			</div>
			<div class="section">
				<h4>&nbsp; </h4>
				</div>
		</div>
		<div id="footnote">
			<div class="clearfix">
				<div class="connect">
					 
				</div>
				<p>
					© 版權所有
				</p>
			</div>
		</div>
	</div>
</body>
</html>