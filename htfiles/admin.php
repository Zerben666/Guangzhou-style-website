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
.container .content a h5 {
	float: left;
	color: #09F;
}
.img {
	margin: 0 auto;
	text-align: center;
	display: block;
}
.img2 {
	text-align: center;
	display: block;
	width: 40%;
	margin: 0 auto 6px;
	border-bottom-style: solid;
	border-color: #3C9;
}
.img3 {
	background-color: #CCC;
	width: 18em;
	margin: 0 auto;
	text-align: center;
	display: none;
	border-radius:10px;
}
.father:hover .img3 {
	display: block;
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
  <img src="../images/untitled.png" alt="网站结构图" width="776" height="480" usemap="#Map">
  <map name="Map">
    <area shape="rect" coords="58,145,125,158" href="../index.php" target="_blank" title="首页">
    <area shape="rect" coords="195,393,273,417" href="../files/AboutUs.php" target="_blank" title="关于我们">
  </map>
  <h1>说明</h1>
    <p>　　您现在看到的是技能节过后我不断修改后的广州风情4.0版本，我的网站在3.2版本的基础上添加了一些新的实用功能（多是后台页面的,也有前端的改进），并修复了部分问题。</p>
    <p>　　本网站（2.1版本）于2021年5月21日制作完成，是<a href="#">安全班Zerben</a>为参加<strong><a href="../others/2021年技能节网页作品比赛方案.docx"  title="下载比赛方案">2021天河职中技能节&ldquo;网页设计与制作&rdquo;</a></strong>比赛专门制作的作品，并附有<a href="../网站说明书.docx" title="下载网站说明书">网站说明书</a>。网站主题为<strong>我的家乡</strong>，大标题为<strong>广州风情</strong>，设有5个菜单分别为”<a href="../files/nyly.php" title="点我跳转" target="_blank">南粤旅游</a>”、“广府活动”、“<a href="../index.php" title="点我跳转" target="_blank">首页</a>”、“<a href="../files/gzys.php" title="点我跳转" target="_blank">广州元素</a>”和“<a href="../files/AboutUs.php" title="点我跳转" target="_blank">网站信息</a>”，下设25个子页面。<br>
      为了达到融会贯通的效果，本网站用到了几乎所有我会的技术，包括但不限于实现登录/注册功能、支持评论、表格和表单、走马灯效果、链接及鼠标经过图像、命名锚记、图片轮播、搜索功能、禁止修改的密码框、AP元素、在控制台显示文字、文件下载、网页计时器、模板的使用、标签行为、悬浮框、JS脚本、隐藏错误、PHP、富文本编辑器等等。另外，我强烈建议您使用微软<a href="https://www.microsoft.com/zh-cn/edge?r=1" title="没有这个浏览器？去下载" target="_blank">Edge浏览器</a>浏览本站，否则可能呈现不出显示密码的效果。</p>
    <p class="img"><img src="../images/logo3.png" width="283" height="74"></p>
    <script>
a = "站长受到如知乎、天猫、爱奇艺等网站的启发，决定吸取它们的先进经验，在本网站的一些页面的控制台（Console)留有一句英文的小彩蛋哦，你能找到它们吗？你还有什么其他有趣的想法要告诉我吗？欢迎加微信/QQ讨论哦。\n flag:login.php/register.php";
console.log(a);
</script>
    <h3>彩蛋</h3>
    <p>　　站长受到如知乎、天猫、爱奇艺等网站的启发，决定吸取它们的先进经验，在本网站的一些页面的控制台（Console)留有一句英文的小彩蛋哦，你能找到它们吗？你还有什么其他有趣的想法要告诉我吗？欢迎加微信/QQ讨论哦。</p>
    <h3><a href="contribution.php">投稿</a></h3>
    <p>　　本网站欢迎所有人进行投稿，内容可以是旅游信息、广府活动的报道，也可以是内容或技术的改进建议。要进行投稿，请您点击上方的投稿小标题，或将鼠标移到”广府活动“的标签处，并点击随之出现的投稿链接。当然，您也可以扫描下方我的二维码直接跟我联系。</p>
    <h3 class="img2">联系作者</h3>
    <div class="father">
    <p class="none">　　　　　　　<img src="../images/QQ_QRcode.jpg" width="194" height="225">　　　　<img src="../images/Wechat_QRcode.jpg" width="194" height="225"></p>
    <h5 class="img3">欢迎加我微信/QQ切磋讨论！</h5>
    </div>
    <h2>温馨提示</h2>
    <p>本网站的很多功能都需要进行登录，因此我强烈建议您注册一个本网站的账号。如果您是测试人员，那就更加要进行这个操作了，当然，在后者的情况下，您也可以使用数据库中原有的账号。</p>
  <!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">01Zerben&copy;版权所有</br>
  	海内存知己,天涯若比邻.The world is but a little place, after all.
  </div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
