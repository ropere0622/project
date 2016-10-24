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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_view")) {
  $updateSQL = sprintf("UPDATE project SET Status=%s WHERE P_NO=%s",
                       GetSQLValueString($_POST['Status'], "int"),
                       GetSQLValueString($_POST['P_NO'], "int"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($updateSQL, $My) or die(mysql_error());

  $updateGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
<title>專案狀態</title>
</head>

<body>
<center>
  <table width="60%" border="1">
      <tbody>
        <tr  bgcolor="#CCCCCC">
          <td style="text-align: center">專案名稱          </td>
          <td width="30%" style="text-align: center">專案狀態</td>
        </tr>
    </tbody>
  </table>
  <div>
  <?php do { ?>
    <table width="60%" border="1">
      <tbody>
        <tr id="theRow" style="">
          <td style="text-align: center"><?php echo $row_Project_Name['P_Name']; ?>
            <input type="hidden" name="P_NO" id="P_NO"></td>
          <td width="30%" style="text-align: center">
           <?php 
		  if ($row_Project_Name['Status']== 'G'){echo "專案進行中";}
		  if ($row_Project_Name['Status']== 'N'){echo "徵詢顧問中";}  
		  if ($row_Project_Name['Status']== 'C'){echo "專案完成";}
		  if ($row_Project_Name['Status']== 'V'){echo "專案作廢";}
		   ?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php } while ($row_Project_Name = mysql_fetch_assoc($Project_Name)); ?>
    </div>
      <table width="60%" border="1">
      <tbody>
        <tr bgcolor="#CCCCCC">
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, 0, $queryString_Project_Name); ?>">第一頁</a>
              <?php } // Show if not first page ?>
]</td>
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, max(0, $pageNum_Project_Name - 1), $queryString_Project_Name); ?>">上一頁</a>
              <?php } // Show if not first page ?>
]</td>
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name < $totalPages_Project_Name) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, min($totalPages_Project_Name, $pageNum_Project_Name + 1), $queryString_Project_Name); ?>">下一頁</a>
  <?php } // Show if not last page ?>
]</td>
          <td style="text-align: center">[
            <?php if ($pageNum_Project_Name < $totalPages_Project_Name) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Project_Name=%d%s", $currentPage, $totalPages_Project_Name, $queryString_Project_Name); ?>">最末頁</a>
              <?php } // Show if not last page ?>
]</td>
        </tr>
    </tbody>
  </table>
</center>
</body>
</html>
<?php
mysql_free_result($Project_Name);
?>
