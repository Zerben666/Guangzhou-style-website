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
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>广州风情|后台管理</title>
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
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
      <li><a href="../htfiles/admin.php">欢迎</a></li>
      <li><a href="../htfiles/tg_view.php">投稿管理</a></li>
      <li><a href="../htfiles/database_view.php">数据库管理</a></li>
      <li><a href="<?php echo $logoutAction ?>">注销</a></li>
    </ul>
    <p> 欢迎访问“广州风情”后台管理页面，您可在此看到整个网站的结构图和后台数据库，您有权对其进行修改。您还可以发布用户的投稿，集大家之所长完善网站，但在此之前，建议您仔细审核投稿有无问题。</p>
    <p>温馨提示：在现版本里，您做的所有操作都是不可逆的，因您做出的修改而导致问题只能由您自己负责。数据无价，为保不误删数据或产生其他误修改，请慎重操作。</p>
    <div class="find">
    <form action="../htfiles/search.php" method="post" id="from">
    搜索留言
    <input name="search" type="text" id="search" placeholder="🔍请输入搜索关键词">
    <input type="submit" name="button" id="button" value="搜索">
    </form>
    </div>
  <!-- end .sidebar --></div>
  <div class="content">
  <!-- TemplateBeginEditable name="EditRegion" -->
  <h1 class="title"><img src="../images/logo.JPG" width="40" height="36">广州风情后台管理</h1>
  <span id="sitetime"></span>
  <h1>说明</h1>
    <p>请注意，这些布局的 CSS 带有大量注释。如果您的大部分工作都在设计视图中进行，请快速浏览一下代码，获取有关如何使用固定布局 CSS 的提示。您可以先删除这些注释，然后启动您的站点。要了解有关这些 CSS 布局中使用的方法的更多信息，请阅读 Adobe 开发人员中心上的以下文章：<a href=http://www.adobe.com/go/adc_css_layouts">http://www.adobe.com/go/adc_css_layouts</a>。您可以先删除这些注释，然后启动您的站点。若要了解有关这些 CSS 布局中使用的方法的更多信息，请阅读 Adobe 开发人员中心上的以下文章：<a href=http://www.adobe.com/go/adc_css_layouts">http://www.adobe.com/go/adc_css_layouts</a>。</p>
    <h2>清除</h2>
    <p>由于所有列都是浮动的，因此，此布局对 .container 采用 overflow:hidden。此清除方法强制使 .container 了解列的结束位置，以便显示在 .container 中放置的任何边框或背景颜色。如果有任何大型元素突出到 .container 以外，该元素在显示时将被截断。您也不能使用负边距或具有负值的绝对定位将元素拉至 .container 以外，这些元素同样不会在 .container 之外显示。</p>
    <p>如果您需要使用这些属性，则需要采用其它清除方法。最可靠的方法是在最后一个浮动列之后（但在 .container 结束之前）添加 &lt;br class="clearfloat" /&gt; 或 &lt;div class="clearfloat"&gt;&lt;/div&gt;。这具有相同的清除效果。</p>
    <h3>脚注</h3>
    <p>在列后面（但仍在 .container 内）添加脚注将导致此 overflow:hidden 清除方法失败。您可以将 .footer 放到第一个 .container 之外的另一个 .container 中，而不会影响效果。最简单的选择是从含有标题和脚注的布局开始，然后删除标题以便在该布局类型中利用清除方法。</p>
    <h4>背景</h4>
    <p>本质上，任何 div 中的背景颜色将仅显示与内容一样的长度。这意味着，如果要使用背景颜色或边框创建侧面列的外观，将不会一直扩展到脚注，而是在内容结束时停止。如果 .content div 将始终包含更多内容，则可以在 .content div 中放置一个边框将其与列分开。</p>
  <!-- TemplateEndEditable -->
  <!-- end .content --></div>
  <div class="footer">01Zerben&copy;版权所有</br>
  	海内存知己,天涯若比邻.The world is but a little place, after all.
  </div>
  <!-- end .container --></div>
</body>
</html>
