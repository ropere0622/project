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

$maxRows_User = 10;
$pageNum_User = 0;
if (isset($_GET['pageNum_User'])) {
  $pageNum_User = $_GET['pageNum_User'];
}
$startRow_User = $pageNum_User * $maxRows_User;

mysql_select_db($database_My, $My);
$query_User = "SELECT * FROM `user` ORDER BY Job ASC";
$query_limit_User = sprintf("%s LIMIT %d, %d", $query_User, $startRow_User, $maxRows_User);
$User = mysql_query($query_limit_User, $My) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);

if (isset($_GET['totalRows_User'])) {
  $totalRows_User = $_GET['totalRows_User'];
} else {
  $all_User = mysql_query($query_User);
  $totalRows_User = mysql_num_rows($all_User);
}
$totalPages_User = ceil($totalRows_User/$maxRows_User)-1;
?>
<!doctype html>
<html>
<head>
<title>使用者維護選單</title>
</head>

<body>
<center>
  <table width="60%" border="1">
        <tbody>
        <tr bgcolor="#CCCCCC">
          <td style="text-align: center">使用者名稱</td>
          <td width="30%" style="text-align: center">職位</td>
          <td width="30%" style="text-align: center">專案修改</td>
        </tr>
    </tbody>
  </table>
    <?php do { ?>
      <table width="60%" border="1">
        <tbody>
          <tr id="theRow">
            <td style="text-align: center"><?php echo $row_User['Name']; ?></td>
            <td width="30%" style="text-align: center"><?php echo $row_User['Job']; ?></td>
            <td width="30%" style="text-align: center"><a href="user_update.php?ID=<?php echo $row_User['ID']; ?>">修改</a>
            </td>
          </tr>
        </tbody>
    </table>
      <?php } while ($row_User = mysql_fetch_assoc($User)); ?>

</center>
</body>
</html>
<?php
mysql_free_result($User);
?>
