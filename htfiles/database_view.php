<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../admin/login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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
<!doctype html>
<html><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>数据库管理</title>
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
  <h1>【数据库管理】</h1>
  <h4>由于本页的链接指向服务器的MySQL管理地址，所以加载时间会偏慢一点，请耐心等待至地址栏变化再进行刷新操作。您可点击数据库图片进行导出操作。</h4>
  <table width="650" border="1" align="center">
  <tr>
    <td><strong>数据库</strong></td>
    <td><strong>数据表</strong></td>
    <td><strong>属性</strong></td>
    <td><strong>注释</strong></td>
  </tr>
  <tr>
    <td rowspan="5" width="170"><a href="../../phpmyadmin/db_export.php?db=gdgz" target="_blank" title="导出数据库"><img src="../images/GDgz.png" alt="GDgz" width="170" height="236"></a></td>
    <td><a href="../../phpmyadmin/sql.php?server=1&db=gdgz&table=user&pos=0" target="_blank">user</a></td>
    <td>后台-自动插入、可管理</td>
    <td>网站（注册）用户表</td>
  </tr>
  <tr>
    <td><a href="../../phpmyadmin/sql.php?server=1&db=gdgz&table=poetry&pos=0" target="_blank">poetry</a></td>
    <td>后台-后台插入、可编辑</td>
    <td>广府诗词表</td>
  </tr>
  <tr>
    <td><a href="../../phpmyadmin/sql.php?server=1&db=gdgz&table=contribution&pos=0" target="_blank">contribution</a></td>
    <td>前台-用户插入、可管理</td>
    <td>用户建议表</td>
  </tr>
  <tr>
    <td><a href="../../phpmyadmin/sql.php?db=gdgz&table=edit&pos=0" target="_blank">edit</a></td>
    <td>后台-后台插入</td>
    <td>广府活动表</td>
  </tr>
  <tr>
    <td><a href="../../phpmyadmin/sql.php?server=1&db=gdgz&table=ly&pos=0" target="_blank">ly</a></td>
    <td>前台-用户插入、用户删除、可管理</td>
    <td>留言簿</td>
  </tr>
</table>
  <!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">01Zerben&copy;版权所有</br>
  	海内存知己,天涯若比邻.The world is but a little place, after all.
  </div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
