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

$colname_Project_update = "-1";
if (isset($_GET['P_NO'])) {
  $colname_Project_update = $_GET['P_NO'];
}
mysql_select_db($database_My, $My);
$query_Project_update = sprintf("SELECT * FROM project WHERE P_NO = %s", GetSQLValueString($colname_Project_update, "int"));
$Project_update = mysql_query($query_Project_update, $My) or die(mysql_error());
$row_Project_update = mysql_fetch_assoc($Project_update);
$totalRows_Project_update = mysql_num_rows($Project_update);

$colname_Mission = "-1";
if (isset($_GET['P_NO'])) {
  $colname_Mission = $_GET['P_NO'];
}
mysql_select_db($database_My, $My);
$query_Mission = sprintf("SELECT * FROM mission WHERE P_NO = %s", GetSQLValueString($colname_Mission, "int"));
$Mission = mysql_query($query_Mission, $My) or die(mysql_error());
$row_Mission = mysql_fetch_assoc($Mission);
$totalRows_Mission = mysql_num_rows($Mission);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>專案照片查看</title>
</head>

<body>
<center>
<form id="From_Pro" name="From_Pro" method="POST">
  <table width="60%" border="1">
    <tbody>
      <tr>
        <td width="30" height="40" style="text-align: center"><span style="text-align: left"><?php echo $row_Project_update['P_Name']; ?></span>          <input name="P_NO" type="hidden" id="P_NO" value="<?php echo $row_Project_update['P_NO']; ?>"></td>
        </tr>
      </tbody>
  </table>
</form>
<form name="Form_mission1" id="Form_mission1">
  <?php do { ?>
    <table width="60%" border="1">
      <tbody>
        <tr style="text-align: center">
          <td height="40" colspan="2">任務時間、地點
            <input name="M_NO" type="hidden" id="M_NO" value="<?php echo $row_Mission['M_NO']; ?>"></td>
          </tr>
        <tr>
          <td width="30%" height="40" style="text-align: right">任務日期、時間</td>
          <td style="text-align: left"><?php echo $row_Mission['Date']; ?><?php echo $row_Mission['Time']; ?></td>
        </tr>
        <tr>
          <td width="30%" height="40" style="text-align: right">任務地點</td>
          <td width="30%" style="text-align: left"><?php echo $row_Mission['Asistant']; ?></td>
        </tr>
        <tr>
          <td height="40" style="text-align: right">任務評分</td>
          <td style="text-align: left"><?php echo $row_Mission['Score']; ?></td>
        </tr>
		<tr>
		  <td width="60%" align="center" valign="middle" colspan="2"><img src="Photos/<?php echo $row_Mission['Photo1']; ?>" alt="" /></td>
		</tr>
        </tbody>
    </table>
    <?php } while ($row_Mission = mysql_fetch_assoc($Mission)); ?>
</form>
</center>
</body>
</html>
<?php
mysql_free_result($Project_update);

mysql_free_result($Mission);
?>
