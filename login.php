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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usrename'])) {
  $loginUsername=$_POST['usrename'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.html";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_HCMWS, $HCMWS);
  
  $LoginRS__query=sprintf("SELECT A_username, Password FROM `admin` WHERE A_username=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $HCMWS) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登入</title>
<style type="text/css">
<!--
.style3 {font-family: "標楷體"; color: #FFFFFF; }
-->
</style>
</head>

<body>
<center>
<img src="Photos/HCMWSID.JPG" width="750" height="481" alt=""/>
      <td rowspan=5><form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="Login">
        <table width="287" border="0">
          <tbody>
            <tr>
              <td width="20%" align="right" bgcolor="#006699" style="text-align: right"><span class="style3">帳號</span></td>
              <td width="80%" bgcolor="#D5F1FF" style="text-align: left"><input type="text" name="usrename" id="usrename"></td>
            </tr>
            <tr>
              <td width="20%" align="right" bgcolor="#006699" style="text-align: right"><span class="style3">密碼</span></td>
              <td bgcolor="#D5F1FF" style="text-align: left"><input type="password" name="password" id="password"></td>
            </tr>
            <tr align="center" style="text-align: center">
              <td colspan="2"><input type="submit" name="submit" id="submit" value="登入"></td>
            </tr>
          </tbody>
        </table>
      </form>
  </p>
</center>
</body>
</html>
