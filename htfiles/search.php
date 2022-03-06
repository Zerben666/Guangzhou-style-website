<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../Connections/conn.php');error_reporting(0);?>
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

$colname_rs1 = "-1";
if (isset($_POST['search'])) {
  $colname_rs1 = $_POST['search'];
}

mysql_select_db($database_conn, $conn);
$query_rs1 = sprintf("SELECT * FROM contribution WHERE username LIKE %s or aspect LIKE %s or title LIKE %s or content LIKE %s or %s LIKE 'contribution' or %s LIKE '用户建议表' ORDER BY id DESC", GetSQLValueString("%" . $colname_rs1 . "%", "text"),GetSQLValueString("%" . $colname_rs1 . "%", "text"),GetSQLValueString("%" . $colname_rs1 . "%", "text"),GetSQLValueString("%" . $colname_rs1 . "%", "text"),GetSQLValueString("%" . $colname_rs1 . "%", "text"),GetSQLValueString("%" . $colname_rs1 . "%", "text"));
$rs1 = mysql_query($query_rs1, $conn) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);

$colname_rs2 = "-1";
if (isset($_POST['search'])) {
  $colname_rs2 = $_POST['search'];
}
mysql_select_db($database_conn, $conn);
$query_rs2 = sprintf("SELECT * FROM ly WHERE username LIKE %s or ly LIKE %s or %s LIKE 'ly' or %s LIKE '留言' ORDER BY id DESC", GetSQLValueString("%" . $colname_rs2 . "%", "text"),GetSQLValueString("%" . $colname_rs2 . "%", "text"),GetSQLValueString("%" . $colname_rs2 . "%", "text"),GetSQLValueString("%" . $colname_rs2 . "%", "text"));
$rs2 = mysql_query($query_rs2, $conn) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

$colname_Recordset1 = "-1";
if (isset($_POST['search'])) {
  $colname_Recordset1 = $_POST['search'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM contribution WHERE username LIKE %s or aspect LIKE %s or title LIKE %s or content LIKE %s or %s LIKE 'contribution' or %s LIKE '用户建议表' ORDER BY id DESC", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname_Recordset1 . "%", "text"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_POST['search'])) {
  $colname_Recordset2 = $_POST['search'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset2 = sprintf("SELECT * FROM ly WHERE username LIKE %s or ly LIKE %s or %s LIKE 'ly' or %s LIKE '留言' ORDER BY id DESC", GetSQLValueString("%" . $colname_Recordset2 . "%", "text"),GetSQLValueString("%" . $colname_Recordset2 . "%", "text"),GetSQLValueString("%" . $colname_Recordset2 . "%", "text"),GetSQLValueString("%" . $colname_Recordset2 . "%", "text"));
$Recordset2 = mysql_query($query_Recordset2, $conn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_conn, $conn);
$query_suggest = "SELECT * FROM contribution ORDER BY id DESC";
$suggest = mysql_query($query_suggest, $conn) or die(mysql_error());
$row_suggest = mysql_fetch_assoc($suggest);
$totalRows_suggest = mysql_num_rows($suggest);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>模糊搜索-站内留言搜索引擎</title>
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
.form{
	width: 100px;
	margin-left:2px;
	border-bottom-style: solid;
	border-width: thin;
	border-color: #CF0;
}
hr {
	margin-left: 5px;
}
.search {
	font-family: "宋体";
	font-size: large;
}
</style>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
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
  <form id="form1" name="form1" method="post" action="">
      <label for="search"></label>
      <a class="search"><strong>🔍搜索留言</strong></a>
      <input name="search" type="text" id="search" placeholder="查询作者/标题/内容" />
      <input type="submit" name="button" id="button" value="搜索" />
    </form>
    <p>你搜索的关键字是：<?php echo "<strong>$_POST[search]</strong>"; ?></p>
    <p>表中共有<?php $totalRows = $totalRows_rs1+$totalRows_rs2;echo $totalRows; ?>条<?php if($_POST[search] != ""){echo "符合要求的";}?>记录:</p>
    <?php if ($totalRows_rs1 > 0 or $totalRows_rs2 > 0) { // Show if recordset not empty ?>
  <p class="form">显示形式</p>
  <div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup">
      <li class="TabbedPanelsTab" tabindex="0">表格</li>
      <li class="TabbedPanelsTab" tabindex="0">文字</li>
    </ul>
    <div class="TabbedPanelsContentGroup">
      <div class="TabbedPanelsContent">
        <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
          <table width="95%" border="1" cellpadding="5" cellspacing="0">
            <tr>
              <td>留言编号</td>
              <td>留言标题</td>
              <td>留言主题</td>
              <td>留言内容</td>
              <td>留言时间</td>
              <td>留言人</td>
              <td>来源</td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_rs1['id']; ?></td>
                <td><?php echo "<a href='tg_more.php?id=$row_rs1[id]' target='_blank' title='编辑投稿'>".str_ireplace($colname_rs2,"<font color='red'>$colname_rs2</font>",$row_rs1['title'])."</a>"; ?></td>
                <td><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_rs2</font>",$row_rs1['aspect']); ?></td>
                <td><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_rs2</font>",$row_rs1['content']); ?></td>
                <td><?php echo $row_rs1['time']; ?></td>
                <td><a href="../admin/zcxx.php?username=<?php echo $row_rs1['username']; ?>" target="_blank" title="用户信息"><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_rs2</font>",$row_rs1['username']); ?></a></td>
                <td>用户建议表</td>
              </tr>
              <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
          </table>
          <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_rs1 > 0 and $totalRows_rs2 > 0) { // Show if recordset not empty ?><br><?php } // Show if recordset not empty ?>
        <?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
          <table width="95%" border="1" cellpadding="5" cellspacing="0">
            <tr>
              <td>留言编号</td>
              <td>留言内容</td>
              <td>留言时间</td>
              <td>留言人</td>
              <td>来源</td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_rs2['id']; ?></td>
                <td><?php echo "<a href='../../../phpmyadmin/sql.php?server=1&db=gdgz&table=ly&pos=0' target='_blank' title='留言详情'>".str_ireplace($colname_rs2,"<font color='red'>$colname_rs2</font>",$row_rs2['ly'])."</a>"; ?></td>
                <td><?php echo $row_rs2['time']; ?></td>
                <td><a href="../admin/zcxx.php?username=<?php echo $row_rs2['username']; ?>" target="_blank" title="用户信息"><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_rs2</font>",$row_rs2['username']); ?></a></td>
                <td>留言簿</td>
              </tr>
              <?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
          </table>
          <?php } // Show if recordset not empty ?>
      </div>
      <div class="TabbedPanelsContent">
      <?php if ($totalRows_rs1 > 0) { // Show if recordset not empty ?>
      <ol>
      <?php do { ?>
      <li><h2><a href="tg_more.php?id=<?php echo $row_Recordset1['id']; ?>" target='_blank' title='投稿详情'><?php echo str_ireplace($colname_Recordset1,"<font color='red'>$colname_Recordset1</font>",$row_Recordset1['title']); ?></a></h2></li>
      <h4><?php echo str_ireplace($colname_Recordset1,"<font color='red'>$colname_Recordset1</font>",$row_Recordset1['content']); ?>
      <h5>来源：用户建议表（<a href="../admin/zcxx.php?username=<?php echo $row_Recordset1['username']; ?>" target="_blank" title="用户信息"><?php echo str_ireplace($colname_Recordset1,"<font color='red'>$colname_Recordset1</font>",$row_Recordset1['username']); ?></a>） 留言时间：<?php echo $row_Recordset1['time']; if($row_Recordset1['read']=="0"){echo "<font color=#FF00FF>（未读）</font>";}?></h5></h4>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?></ol>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
      <?php while($num=1){?>
      <?php do { ?>
      <h2>留言<?php echo $num;$num++;?>：By <a href="../admin/zcxx.php?username=<?php echo $row_Recordset2['username']; ?>" target="_blank" title="用户信息"><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_Recordset2</font>",$row_Recordset2['username']); ?></a></h2>
      <h4><a href="../../../phpmyadmin/sql.php?server=1&db=gdgz&table=ly&pos=0" target="_blank" title="留言详情"><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_Recordset2</font>",$row_Recordset2['ly']); ?></a>
      <h5>来源：留言簿（<a href="../admin/zcxx.php?username=<?php echo $row_Recordset2['username']; ?>" target="_blank" title="用户信息"><?php echo str_ireplace($colname_rs2,"<font color='red'>$colname_Recordset2</font>",$row_Recordset2['username']); ?></a>） 留言时间：<?php echo $row_Recordset2['time']; ?></h5></h4>
      <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
      <?php break;}} // Show if recordset not empty ?>
      </div>
    </div>
  </div>
  <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_rs1 == 0 and $totalRows_rs2 == 0) { // Show if recordset empty ?>
      <p>　　暂无搜索记录，或许你可以检查一下您的输入模式再重新搜索（本功能区分中英文但不区分大小写）。如您不清楚本功能的使用，可以查看下面的搜索建议。本模块支持缺省搜索，但您搜索的输入内容必须都包含在目标表格中；同理，如果没有输入内容，则将直接搜出数据库里的全部内容。</p>
      <hr align="left" width="20%">
  <h5><font color="#999999">搜索建议：&quot;</font><?php echo $row_suggest['username']; ?>、<?php echo $row_suggest['title']; ?><font color="#999999">"</font></h5>
  <?php } // Show if recordset empty ?>
  <script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
  </script>
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

mysql_free_result($rs2);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($suggest);
?>
