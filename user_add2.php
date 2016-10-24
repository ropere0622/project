<?php require_once('Connections/HCMWS.php'); ?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="user_add.php";
  $loginUsername = $_POST['Account_Num'];
  $LoginRS__query = sprintf("SELECT Account_Num FROM `user` WHERE Account_Num=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_HCMWS, $HCMWS);
  $LoginRS=mysql_query($LoginRS__query, $HCMWS) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "NewUser")) {
  $insertSQL = sprintf("INSERT INTO user (Account_Num, Password, Name, Job, E_Mail, Phone_Num, Specialty) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Account_Num'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Job'], "text"),
                       GetSQLValueString($_POST['E_Mail'], "text"),
                       GetSQLValueString($_POST['Phone_Num'], "int"),
                       GetSQLValueString($_POST['Specialty'], "text"));

  mysql_select_db($database_HCMWS, $HCMWS);
  $Result1 = mysql_query($insertSQL, $HCMWS) or die(mysql_error());

  $insertGoTo = "user_update_Menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
			<h1>職員新增</h1>
			<div class="frame2">
				<div class="box">
					<img src="images/thumb-up.jpg" alt="Img" height="298" width="924">
				</div>
			</div>
			<h2>
			
			
			
			
			<center>
  <form action="<?php echo $editFormAction; ?>" id="NewUser" name="NewUser" method="POST">
          <table width="60%" border="0">
            <tbody>
              <tr>
                <td width="30%" height="40" bgcolor="#323338" style="text-align: right"><span class="style1">帳號</span></td>
                <td width="70%" height="40" style="text-align: left"><input name="Account_Num" type="text" id="Account_Num" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" bgcolor="#323338" style="text-align: right"><span class="style1">密碼</span></td>
                <td height="40" style="text-align: left"><input name="password" type="password" id="password" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" bgcolor="#323338" style="text-align: right"><span class="style1">姓名</span></td>
                <td height="40" style="text-align: left"><input name="Name" type="text" id="Name" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" bgcolor="#323338" style="text-align: right"><span class="style1">職務</span></td>
                <td height="40" style="text-align: left"><select name="Job" id="Job" form="NewUser">
                  <option value="Assistant">助理</option>
                  <option value="Consultant">顧問</option>
                </select></td>
              </tr>
              <tr>
                <td height="40" bgcolor="#323338" style="text-align: right"><span class="style1">E-Mail</span></td>
                <td height="40" style="text-align: left"><input name="E_Mail" type="text" id="E_Mail" form="NewUser" size="35"></td>
              </tr>
              <tr>
                <td height="40" bgcolor="#323338" style="text-align: right"><span class="style1">連絡電話</span></td>
                <td height="40" style="text-align: left"><input name="Phone_Num" type="text" id="Phone_Num" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" bgcolor="#323338" style="text-align: right"><span class="style1">專長</span></td>
                <td height="40" style="text-align: left"><textarea name="Specialty" cols="35" rows="5" id="Specialty" form="NewUser"></textarea></td>
              </tr>
            </tbody>
    </table>
          <input name="submit" type="submit" id="submit" form="NewUser" formmethod="POST" value="送出">
          <input type="reset" name="reset" id="reset" value="重設">
          <input name="MM_insert" type="hidden" form="NewUser" value="NewUser">
          <input type="hidden" name="MM_insert" value="NewUser">
  </form>
  </p>
</center>
			
			
			
			
			</p>
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