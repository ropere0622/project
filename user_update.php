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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "Form_user")) {
  $updateSQL = sprintf("UPDATE user SET Account_Num=%s, Password=%s, Name=%s, Job=%s, E_Mail=%s, Phone_Num=%s, Specialty=%s, Void=%s WHERE ID=%s",
                       GetSQLValueString($_POST['Account_Num'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Job'], "text"),
                       GetSQLValueString($_POST['E_Mail'], "text"),
                       GetSQLValueString($_POST['Phone_Num'], "int"),
                       GetSQLValueString($_POST['Specialty'], "text"),
                       GetSQLValueString($_POST['Void'], "text"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($updateSQL, $My) or die(mysql_error());

  $updateGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_User = "-1";
if (isset($_GET['ID'])) {
  $colname_User = $_GET['ID'];
}
mysql_select_db($database_My, $My);
$query_User = sprintf("SELECT * FROM `user` WHERE ID = %s", GetSQLValueString($colname_User, "int"));
$User = mysql_query($query_User, $My) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<center>
<form method="POST" action="<?php echo $editFormAction; ?>" name="Form_user" id="Form_user">
<table width="60%" border="1">
  <tbody>
    <tr style="text-align: center">
      <td height="40" colspan="2">使用者管理
        <input name="ID" type="hidden" id="ID" value="<?php echo $row_User['ID']; ?>"></td>
      </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">帳號</td>
      <td height="40" style="text-align: left"><input name="Account_Num" type="text" id="Account_Num" value="<?php echo $row_User['Account_Num']; ?>" size="20"></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">密碼</td>
      <td height="40" style="text-align: left"><input name="Password" type="password" id="Password" value="<?php echo $row_User['Password']; ?>" size="20"></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">姓名</td>
      <td height="40" style="text-align: left"><input name="Name" type="text" id="Name" value="<?php echo $row_User['Name']; ?>" size="20"></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">職務</td>
      <td height="40" style="text-align: left"><select name="Job" id="Job" form="Form_user">
        <option value="Assistant" <?php if (!(strcmp("Assistant", $row_User['Job']))) {echo "selected=\"selected\"";} ?>>助理</option>
        <option value="Consultant" selected <?php if (!(strcmp("Consultant", $row_User['Job']))) {echo "selected=\"selected\"";} ?>>顧問</option>
      </select></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">E-Mail</td>
      <td height="40" style="text-align: left"><input name="E_Mail" type="text" id="E_Mail" value="<?php echo $row_User['E_Mail']; ?>" size="20"></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">連絡電話</td>
      <td height="40" style="text-align: left"><input name="Phone_Num" type="text" id="Phone_Num" value="<?php echo $row_User['Phone_Num']; ?>" size="20"></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">專長</td>
      <td height="40" style="text-align: left"><input name="Specialty" type="text" id="Specialty" value="<?php echo $row_User['Specialty']; ?>" size="20"></td>
    </tr>
    <tr>
      <td width="30%" height="40" style="text-align: right">使用者狀態</td>
      <td height="40" style="text-align: left"><select name="Void" id="Void">
        <option value="Now" <?php if (!(strcmp("Now", $row_User['Void']))) {echo "selected=\"selected\"";} ?>>在職</option>
        <option value="Void" <?php if (!(strcmp("Void", $row_User['Void']))) {echo "selected=\"selected\"";} ?>>離職</option>
      </select></td>
    </tr>
    </tbody>
</table>
<input type="submit" name="submit" id="submit" value="送出">
<input type="hidden" name="MM_update" value="Form_user">
</form>
</center>
</body>
</html>
<?php
mysql_free_result($User);
?>
