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

$colname_Album = "-1";
if (isset($_GET['A_NUM'])) {
  $colname_Album = $_GET['A_NUM'];
}
mysql_select_db($database_My, $My);
$query_Album = sprintf("SELECT * FROM album WHERE A_NUM = %s", GetSQLValueString($colname_Album, "int"));
$Album = mysql_query($query_Album, $My) or die(mysql_error());
$row_Album = mysql_fetch_assoc($Album);
$totalRows_Album = mysql_num_rows($Album);
?>
<!doctype html>
<html>
<head>
<title>照片查看</title>
</head>
<body>
  <div id="page_content_right">
    <div class="content_text">
      <table width="640" border="1" align="center" cellpadding="1" cellspacing="1">
        <tr>
          <td align="center" valign="middle"><img src="Photos/<?php echo $row_Album['A_Filename']; ?>" alt="" /></td>
        </tr>
        <tr>
          <td align="center" class="title_font"><?php echo $row_Album['A_Comment']; ?><br />
          <a href="photo_del.php?A_Filename=<?php echo $row_Album['A_Filename']; ?>">[刪除]</a></td>
        </tr>
      </table>
    <a href="file:///G|/EXAMPLES/CHAPTER 09 網路相簿/ALBUM/details.html"></a></div>
  </div>
  <div id="page_bottom">
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
<div id="footer">
  <div id="footer_content">
    <div></div>
  </div>
</div></body>
</html>
<?php
mysql_free_result($Album);
?>
