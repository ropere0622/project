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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "From_Pro")) {
  $insertSQL = sprintf("INSERT INTO customer (C_NAME, Address, C_Phone, Contact) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['C_Name'], "text"),
                       GetSQLValueString($_POST['Address'], "text"),
                       GetSQLValueString($_POST['C_Phone'], "int"),
                       GetSQLValueString($_POST['Contact'], "text"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($insertSQL, $My) or die(mysql_error());

  $insertGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
<title>客戶新增</title>
</head>

<body>
<center>
<form action="<?php echo $editFormAction; ?>" id="From_Pro" name="From_Pro" method="POST">
  <table width="60%" border="1">
    <tbody>
      <tr>
        <td height="40" colspan="2" style="text-align: center">專案管理          </td>
        </tr>
      <tr>
        <td width="30%" height="40" style="text-align: right">客戶公司</td>
        <td style="text-align: left"><input name="C_Name" type="text" id="C_Name" value=""></td>
      </tr>
      <tr>
        <td height="40" style="text-align: right">公司地址</td>
        <td style="text-align: left"><input name="Address" type="text" id="Address" value=""></td>
      </tr>
      <tr>
        <td height="40" style="text-align: right">聯絡人電話</td>
        <td style="text-align: left"><input name="C_Phone" type="text" id="C_Phone" value=""></td>
      </tr>
      <tr>
        <td width="30%" height="40" style="text-align: right">聯絡人名稱</td>
        <td style="text-align: left"><input name="Contact" type="text" id="Contact" value=""></td>
      </tr>
      </tbody>
  </table>
  <input type="submit" name="submit2" id="submit2" value="送出">
  <input type="hidden" name="MM_insert" value="From_Pro">
</form>
</center>
</body>
</html>
<?php
mysql_free_result($Customer);
?>
