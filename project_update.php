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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "From_Pro")) {
  $updateSQL = sprintf("UPDATE project SET C_NO=%s, P_Name=%s, M_ID=%s, Start_Date=%s, Close_Date=%s, Status=%s WHERE P_NO=%s",
                       GetSQLValueString($_POST['C_NO'], "int"),
                       GetSQLValueString($_POST['P_Name'], "text"),
                       GetSQLValueString($_POST['M_ID'], "text"),
                       GetSQLValueString($_POST['Start_Date'], "date"),
                       GetSQLValueString($_POST['Close_Date'], "date"),
                       GetSQLValueString($_POST['Status'], "text"),
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "Form_mission1")) {
  $updateSQL = sprintf("UPDATE mission SET `Date`=%s, `Time`=%s, Asistant=%s, Ass_ID=%s WHERE M_NO=%s",
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Time'], "date"),
                       GetSQLValueString($_POST['Asistant'], "text"),
                       GetSQLValueString($_POST['Ass_ID'], "text"),
                       GetSQLValueString($_POST['M_NO'], "int"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($updateSQL, $My) or die(mysql_error());

  $updateGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Form_mission2")) {
  $insertSQL = sprintf("INSERT INTO mission (P_NO, `Date`, `Time`, Asistant, Ass_ID) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['P_NO'], "int"),
                       GetSQLValueString($_POST['Date'], "date"),
                       GetSQLValueString($_POST['Time'], "date"),
                       GetSQLValueString($_POST['Asistant'], "text"),
                       GetSQLValueString($_POST['Ass_ID'], "int"));

  mysql_select_db($database_My, $My);
  $Result1 = mysql_query($insertSQL, $My) or die(mysql_error());

  $insertGoTo = "menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_My, $My);
$query_User_Con = "SELECT * FROM `user` WHERE Job = 'Consultant'";
$User_Con = mysql_query($query_User_Con, $My) or die(mysql_error());
$row_User_Con = mysql_fetch_assoc($User_Con);
$totalRows_User_Con = mysql_num_rows($User_Con);

mysql_select_db($database_My, $My);
$query_Customer = "SELECT * FROM customer";
$Customer = mysql_query($query_Customer, $My) or die(mysql_error());
$row_Customer = mysql_fetch_assoc($Customer);
$totalRows_Customer = mysql_num_rows($Customer);

mysql_select_db($database_My, $My);
$query_User_Ass = "SELECT * FROM `user` WHERE Job = 'Assistant'";
$User_Ass = mysql_query($query_User_Ass, $My) or die(mysql_error());
$row_User_Ass = mysql_fetch_assoc($User_Ass);
$totalRows_User_Ass = mysql_num_rows($User_Ass);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>專案維護</title>
</head>

<body>
<center>
<form action="<?php echo $editFormAction; ?>" id="From_Pro" name="From_Pro" method="POST">
  <table width="60%" border="1">
    <tbody>
      <tr>
        <td height="40" colspan="2" style="text-align: center">專案管理
          <input name="P_NO" type="hidden" id="P_NO" value="<?php echo $row_Project_update['P_NO']; ?>"></td>
        </tr>
      <tr>
        <td width="30%" height="40" style="text-align: right">專案名稱</td>
        <td style="text-align: left"><input name="P_Name" type="text" id="P_Name" value="<?php echo $row_Project_update['P_Name']; ?>"></td>
      </tr>
      <tr>
        <td height="40" style="text-align: right">指派顧問</td>
        <td style="text-align: left"><select name="M_ID" id="M_ID" title="<?php echo $row_Project_update['M_ID']; ?>">
          <?php
do {  
?>
          <option value="<?php echo $row_User_Con['ID']?>"<?php if (!(strcmp($row_User_Con['ID'], $row_Project_update['M_ID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_User_Con['Name']?></option>
          <?php
} while ($row_User_Con = mysql_fetch_assoc($User_Con));
  $rows = mysql_num_rows($User_Con);
  if($rows > 0) {
      mysql_data_seek($User_Con, 0);
	  $row_User_Con = mysql_fetch_assoc($User_Con);
  }
?>
        </select></td>
      </tr>
      <tr>
        <td width="30%" height="40" style="text-align: right">客戶公司</td>
        <td style="text-align: left"><select name="C_NO" id="C_NO" title="<?php echo $row_Project_update['C_NO']; ?>">
          <?php
do {  
?>
          <option value="<?php echo $row_Customer['C_NO']?>"<?php if (!(strcmp($row_Customer['C_NO'], $row_Project_update['C_NO']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Customer['C_NAME']?></option>
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
        <td style="text-align: left"><input name="Start_Date" type="date" id="Start_Date" value="<?php echo $row_Project_update['Start_Date']; ?>"></td>
      </tr>
      <tr>
        <td height="40" style="text-align: right">結束日期</td>
        <td style="text-align: left"><input name="Close_Date2" type="date" id="Close_Date2" value="<?php echo $row_Project_update['Close_Date']; ?>"></td>
      </tr>
      <tr>
        <td width="30%" height="40" style="text-align: right">專案狀態</td>
        <td style="text-align: left"><select name="Status" id="Status">
              <option value="N" <?php if (!(strcmp("N", $row_Project_update['Status']))) {echo "selected=\"selected\"";} ?>>徵詢顧問中</option>
              <option value="G" <?php if (!(strcmp("G", $row_Project_update['Status']))) {echo "selected=\"selected\"";} ?>>專案進行中</option>
              <option value="C" <?php if (!(strcmp("C", $row_Project_update['Status']))) {echo "selected=\"selected\"";} ?>>已結案</option>
              <option value="V" <?php if (!(strcmp("V", $row_Project_update['Status']))) {echo "selected=\"selected\"";} ?>>專案作廢</option>
            </select></td>
      </tr>
      </tbody>
  </table>
  <input type="hidden" name="MM_update" value="From_Pro">
  <input type="submit" name="submit2" id="submit2" value="送出">
</form>
<form method="POST" action="<?php echo $editFormAction; ?>" name="Form_mission1" id="Form_mission1">
  <?php do { ?>
    <table width="60%" border="1">
      <tbody>
        <tr style="text-align: center">
          <td height="40" colspan="2">任務時間、地點
            <input name="M_NO" type="hidden" id="M_NO" value="<?php echo $row_Mission['M_NO']; ?>"></td>
          </tr>
        <tr>
          <td width="30%" height="40" style="text-align: right">任務日期、時間</td>
          <td style="text-align: left"><input name="Date" type="date" id="Date" value="<?php echo $row_Mission['Date']; ?>">
            <input name="Time" type="time" id="Time" value="<?php echo $row_Mission['Time']; ?>"></td>
          </tr>
        <tr>
          <td height="40" style="text-align: right">助理</td>
          <td style="text-align: left"><select name="Ass_ID" id="Ass_ID">
            <?php
do {  
?>
            <option value="<?php echo $row_User_Ass['ID']?>"<?php if (!(strcmp($row_User_Ass['ID'], $row_Mission['Ass_ID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_User_Ass['Name']?></option>
            <?php
} while ($row_User_Ass = mysql_fetch_assoc($User_Ass));
  $rows = mysql_num_rows($User_Ass);
  if($rows > 0) {
      mysql_data_seek($User_Ass, 0);
	  $row_User_Ass = mysql_fetch_assoc($User_Ass);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td height="40" style="text-align: right">地點</td>
          <td style="text-align: left"><input name="Asistant" type="text" id="Asistant" value="<?php echo $row_Mission['Asistant']; ?>" size="40%"></td>
          </tr>
        </tbody>
    </table>
    <?php } while ($row_Mission = mysql_fetch_assoc($Mission)); ?>
    <input type="hidden" name="MM_update" value="Form_mission1">
    <input type="submit" name="submit3" id="submit3" value="送出">
</form>
<form method="POST" action="<?php echo $editFormAction; ?>" name="Form_mission2" id="Form_mission2">
    <table width="60%" border="1">
      <tbody>
        <tr style="text-align: center">
          <td height="40" colspan="2">任務時間、地點
            <input name="P_NO" type="hidden" id="P_NO" value="<?php echo $row_Project_update['P_NO']; ?>"></td>
          </tr>
        <tr>
          <td width="30%" height="40" style="text-align: right">任務日期、時間</td>
          <td style="text-align: left"><input name="Date" type="date" id="Date">
            <input name="Time" type="time" id="Time"></td>
          </tr>
        <tr>
          <td height="40" style="text-align: right">助理</td>
          <td style="text-align: left"><select name="Ass_ID" id="Ass_ID">
            <?php
do {  
?>
            <option value="<?php echo $row_User_Ass['ID']?>"><?php echo $row_User_Ass['Name']?></option>
            <?php
} while ($row_User_Ass = mysql_fetch_assoc($User_Ass));
  $rows = mysql_num_rows($User_Ass);
  if($rows > 0) {
      mysql_data_seek($User_Ass, 0);
	  $row_User_Ass = mysql_fetch_assoc($User_Ass);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td height="40" style="text-align: right">地點</td>
          <td style="text-align: left"><input name="Asistant" type="text" id="Asistant"></td>
          </tr>
        </tbody>
    </table>
    <input type="submit" name="submit" id="submit" value="送出">
<input type="hidden" name="MM_insert" value="Form_mission2">
    </form>
</center>
</body>
</html>
<?php
mysql_free_result($Project_update);

mysql_free_result($Mission);

mysql_free_result($User_Con);

mysql_free_result($Customer);

mysql_free_result($User_Ass);
?>
