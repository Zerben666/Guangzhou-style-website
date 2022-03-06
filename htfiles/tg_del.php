<?php require_once('../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "管理员";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../admin/login_error.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM contribution WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());

  $deleteGoTo = "tg_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['id'])) {
  $colname_rs1 = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_rs1 = sprintf("SELECT * FROM contribution WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $conn) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>投稿管理</title>
<link rel="shortcut icon"  href="../images/logo.JPG"/>
<link href="../CSS/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.title {
	text-align: center;
	margin-bottom: 1px;
}
#sitetime{
	display: block;
	text-align: center;
	margin-bottom: 1em;
}
</style>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script language=javascript>
function siteTime(){
window.setTimeout("siteTime()", 1000);
var seconds = 1000
var minutes = seconds * 60
var hours = minutes * 60
var days = hours * 24
var years = days * 365
var today = new Date()
var todayYear = today.getFullYear()
var todayMonth = today.getMonth()
var todayDate = today.getDate()
var todayHour = today.getHours()
var todayMinute = today.getMinutes()
var todaySecond = today.getSeconds()

/* Date.UTC() -- 返回date对象距世界标准时间(UTC)1970年1月1日午夜之间的毫秒数(时间戳)
year - 作为date对象的年份，为4位年份值
month - 0-11之间的整数，做为date对象的月份
day - 1-31之间的整数，做为date对象的天数
hours - 0(午夜24点)-23之间的整数，做为date对象的小时数
minutes - 0-59之间的整数，做为date对象的分钟数
seconds - 0-59之间的整数，做为date对象的秒数
microseconds - 0-999之间的整数，做为date对象的毫秒数 */
var t1 = Date.UTC(2021,0,14,11,19,00)
var t2 = Date.UTC(todayYear,todayMonth,todayDate,todayHour,todayMinute,todaySecond)
var diff = t2-t1

var diffYears = Math.floor(diff/years)
var diffDays = Math.floor((diff/days)-diffYears*365)
var diffHours = Math.floor((diff-(diffYears*365+diffDays)*days)/hours)
var diffMinutes = Math.floor((diff-(diffYears*365+diffDays)*days-diffHours*hours)/minutes)
var diffSeconds = Math.floor((diff-(diffYears*365+diffDays)*days-diffHours*hours-diffMinutes*minutes)/seconds)
document.getElementById("sitetime").innerHTML=" 已运行"+diffYears+" 年 "+diffDays+" 天 "+diffHours+" 小时 "+diffMinutes+" 分钟 "+diffSeconds+" 秒"
}
siteTime()
</script>
</head>

<body>

<div class="container">
  <div class="sidebar">
    <ul class="nav">
      <li><a href="admin.php">欢迎</a></li>
      <li><a href="tg_view.php">投稿管理</a></li>
      <li><a href="database_view.php">数据库管理</a></li>
      <li><a href="<?php echo $logoutAction ?>">注销</a></li>
    </ul>
    <p> 欢迎访问“广州风情”后台管理页面，您可在此看到整个网站的结构图和后台数据库，您有权对其进行修改。您还可以发布用户的投稿，集大家之所长完善网站，但在此之前，建议您仔细审核投稿有无问题。</p>
    <p>温馨提示：在现版本里，您做的所有操作都是不可逆的，因您做出的修改而导致问题只能由您自己负责。数据无价，为保不误删数据或产生其他误修改，请慎重操作。</p>
    <div class="find">
    <form action="search.php" method="post" id="from">
    搜索留言
    <input name="search" type="text" id="search" placeholder="🔍请输入搜索关键词">
    <input type="submit" name="button" id="button" value="搜索">
    </form>
    </div>
  <!-- end .sidebar --></div>
  <div class="content">
  <!-- InstanceBeginEditable name="EditRegion" -->
  <h1 class="title"><img src="../images/logo.JPG" width="40" height="36">广州风情后台管理</h1>
  <span id="sitetime"></span>
  <h1>【投稿管理】</h1><h4>这是投稿管理页面</h4>
  <!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">01Zerben&copy;版权所有</br>
  	海内存知己,天涯若比邻.The world is but a little place, after all.
  </div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs1);
?>
