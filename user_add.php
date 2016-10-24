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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>新增使用者</title>
</head>

<body>
<center>
  <form action="<?php echo $editFormAction; ?>" id="NewUser" name="NewUser" method="POST">
          <table width="60%" border="1">
            <tbody>
              <tr>
                <td width="30%" height="40" style="text-align: right">帳號</td>
                <td width="70%" height="40" style="text-align: left"><input name="Account_Num" type="text" id="Account_Num" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" style="text-align: right">密碼</td>
                <td height="40" style="text-align: left"><input name="password" type="password" id="password" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" style="text-align: right">姓名</td>
                <td height="40" style="text-align: left"><input name="Name" type="text" id="Name" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" style="text-align: right">職務</td>
                <td height="40" style="text-align: left"><select name="Job" id="Job" form="NewUser">
                  <option value="Assistant">助理</option>
                  <option value="Consultant">顧問</option>
                </select></td>
              </tr>
              <tr>
                <td height="40" style="text-align: right">E-Mail</td>
                <td height="40" style="text-align: left"><input name="E_Mail" type="text" id="E_Mail" form="NewUser" size="35"></td>
              </tr>
              <tr>
                <td height="40" style="text-align: right">連絡電話</td>
                <td height="40" style="text-align: left"><input name="Phone_Num" type="text" id="Phone_Num" form="NewUser" size="20"></td>
              </tr>
              <tr>
                <td height="40" style="text-align: right">專長</td>
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
</body>
</html>
