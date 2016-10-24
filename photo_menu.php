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

mysql_select_db($database_My, $My);
$query_Album = "SELECT * FROM album ORDER BY A_NUM DESC";
$Album = mysql_query($query_Album, $My) or die(mysql_error());
$row_Album = mysql_fetch_assoc($Album);
$totalRows_Album = mysql_num_rows($Album);
?>
<!doctype html>
<html>
<head>
<title>照片清單</title>
</head>
<body>
  <div id="page_content_right">
    <div class="content_text"> 
      <?php do { ?>
      <table width="140" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="bottom" height="140"><a href="photo_view.php?A_NUM=<?php echo $row_Album['A_NUM']; ?>"><img src="Photos/<?php echo $row_Album['A_Filename']; ?>" alt="" class="pic" border="0" /></a></td>
        </tr>
        <tr>
          <td align="center"><?php echo $row_Album['A_Comment']; ?></td>
        </tr>
      </table>
        <?php } while ($row_Album = mysql_fetch_assoc($Album)); ?>
<a href="file:///G|/EXAMPLES/CHAPTER 09 網路相簿/ALBUM/details.html"></a></div>
  </div>
</div>
</div></body>
</html>
<?php
mysql_free_result($Album);
?>
