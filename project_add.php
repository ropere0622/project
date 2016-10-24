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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>專案新增</title>
</head>

<body>
<center>
<form action="<?php echo $editFormAction; ?>" id="From_Pro" name="From_Pro" method="POST">
  <table width="60%" border="1">
    <tbody>
      <tr>
        <td width="30%" height="40" style="text-align: right">專案名稱</td>
        <td style="text-align: left"><input name="P_Name" type="text" id="P_Name"></td>
      </tr>
      <tr>
        <td height="40" style="text-align: right">指派顧問</td>
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
        <td width="30%" height="40" style="text-align: right">客戶公司</td>
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
        <td width="30%" height="40" style="text-align: right">開始日期</td>
        <td style="text-align: left"><input type="date" name="Start_Date" id="Start_Date"></td>
      </tr>
      <tr>
        <td width="30%" height="40" style="text-align: right">結束日期</td>
        <td style="text-align: left"><input type="date" name="Close_Date" id="Close_Date"></td>
      </tr>
      </tbody>
  </table>
  <input type="submit" name="P_A_Button" id="P_A_Button" value="送出">
  <input type="reset" name="P_A_reset" id="P_A_reset" value="重設">
  <input type="hidden" name="MM_insert" value="From_Pro">
</form>
</center>
</body>
</html>
<?php
mysql_free_result($user);

mysql_free_result($Customer);
?>
