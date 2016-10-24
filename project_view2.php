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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_view")) {
  $updateSQL = sprintf("UPDATE project SET Status=%s WHERE P_NO=%s",
                       GetSQLValueString($_POST['Status'], "int"),
                       GetSQLValueString($_POST['P_NO'], "int"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($updateSQL, $My) or die(mysql_error());

  $updateGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_Project_Name = 10;
$pageNum_Project_Name = 0;
if (isset($_GET['pageNum_Project_Name'])) {
  $pageNum_Project_Name = $_GET['pageNum_Project_Name'];
}
$startRow_Project_Name = $pageNum_Project_Name * $maxRows_Project_Name;

mysql_select_db($database_My, $My);
$query_Project_Name = "SELECT * FROM project ORDER BY P_NO ASC";
$query_limit_Project_Name = sprintf("%s LIMIT %d, %d", $query_Project_Name, $startRow_Project_Name, $maxRows_Project_Name);
$Project_Name = mysql_query($query_limit_Project_Name, $My) or die(mysql_error());
$row_Project_Name = mysql_fetch_assoc($Project_Name);

if (isset($_GET['totalRows_Project_Name'])) {
  $totalRows_Project_Name = $_GET['totalRows_Project_Name'];
} else {
  $all_Project_Name = mysql_query($query_Project_Name);
  $totalRows_Project_Name = mysql_num_rows($all_Project_Name);
}
$totalPages_Project_Name = ceil($totalRows_Project_Name/$maxRows_Project_Name)-1;
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
				<h1>專案狀態</h1>
				<p>






<center>
  <table width="60%" border="1">
      <tbody>
        <tr  bgcolor="#CCCCCC">
          <td style="text-align: center">專案名稱          </td>
          <td width="30%" style="text-align: center">專案狀態</td>
        </tr>
    </tbody>
  </table>
  <div>
  <?php do { ?>
    <table width="60%" border="1">
      <tbody>
        <tr id="theRow" style="">
          <td style="text-align: center"><?php echo $row_Project_Name['P_Name']; ?>
            <input type="hidden" name="P_NO" id="P_NO"></td>
          <td width="30%" style="text-align: center">
           <?php 
		  if ($row_Project_Name['Status']== 'G'){echo "專案進行中";}
		  if ($row_Project_Name['Status']== 'N'){echo "徵詢顧問中";}  
		  if ($row_Project_Name['Status']== 'C'){echo "專案完成";}
		  if ($row_Project_Name['Status']== 'V'){echo "專案作廢";}
		   ?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php } while ($row_Project_Name = mysql_fetch_assoc($Project_Name)); ?>
    </div>
      <table width="60%" border="1">
      <tbody>
        <tr bgcolor="#CCCCCC">
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, 0, $queryString_Project_Name); ?>">第一頁</a>
              <?php } // Show if not first page ?>
]</td>
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, max(0, $pageNum_Project_Name - 1), $queryString_Project_Name); ?>">上一頁</a>
              <?php } // Show if not first page ?>
]</td>
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name < $totalPages_Project_Name) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, min($totalPages_Project_Name, $pageNum_Project_Name + 1), $queryString_Project_Name); ?>">下一頁</a>
  <?php } // Show if not last page ?>
]</td>
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name < $totalPages_Project_Name) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, $totalPages_Project_Name, $queryString_Project_Name); ?>">最末頁</a>
              <?php } // Show if not last page ?>
]</td>
        </tr>
    </tbody>
  </table>
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