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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>專案維護選單</title>
</head>

<body>
<center>
  <table width="60%" border="1">
      <tbody>
        <tr bgcolor="#CCCCCC">
          <td style="text-align: center">專案名稱</td>
          <td width="30%" style="text-align: center">專案修改</td>
        </tr>
    </tbody>
  </table>
  <div>
  <?php do { ?>
    <table width="60%" border="1">
      <tbody>
        <tr id="theRow" style="">
          <td style="text-align: center"><?php echo $row_Project_Name['P_Name']; ?></td>
          <td width="30%" style="text-align: center"><a href="project_update.php?P_NO=<?php echo $row_Project_Name['P_NO']; ?>">修改</a>
          <a href="project_update_photo.php?P_NO=<?php echo $row_Project_Name['P_NO']; ?>">查看</a>
        </tr>
      </tbody>
    </table>
    <?php } while ($row_Project_Name = mysql_fetch_assoc($Project_Name)); ?>
	</div>
</center>
</body>
</html>
<?php
mysql_free_result($Project_Name);
?>
