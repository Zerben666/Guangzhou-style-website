<?php require_once('../Connections/conn.php'); ?>
<?php
session_start();
?>
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
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

$colname_rs = "-1";
if (isset($_GET['username'])) {
  $colname_rs = $_GET['username'];
}
mysql_select_db($database_conn, $conn);
$query_rs = sprintf("SELECT * FROM `user` WHERE username = %s", GetSQLValueString($colname_rs, "text"));
$rs = mysql_query($query_rs, $conn) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

mysql_select_db($database_conn, $conn);
$query_edit = "SELECT * FROM edit ORDER BY id DESC";
$edit = mysql_query($query_edit, $conn) or die(mysql_error());
$row_edit = mysql_fetch_assoc($edit);
$totalRows_edit = mysql_num_rows($edit);
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>关于我们</title>
<style type="text/css">
.container .content {
	background-image: url(../images/cloud.gif);
}
.title {
	text-align: center;
	margin-bottom: 1px;
}
#sitetime{
	display: block;
	text-align: center;
	margin-bottom: 1em;
}
hr {/*渐变水平线*/
	margin: 0 auto;
	border: 0;
	height: 1px;
	background: #333;
	background-image: linear-gradient(to right, #ccc, #333, #ccc);
	margin-bottom:10px;
}
.container .content p:first-of-type::first-letter{
	font-size:200%;
}
.container .content a h5 {
	float: left;
	color: #09F;
}
.container .header .banner .banner_in marquee {
  width: 92%;
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
.footer p {
	text-align: center;
	display: block;
	font-family: "Courier New", Courier, monospace;
}
</style>
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
<!-- InstanceEndEditable -->
<link rel="shortcut icon"  href="../images/logo.JPG"/>
<link href="../CSS/style2.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<style type="text/css">
#apDiv1 {
	position: absolute;
	left: 65%;
	top: 99px;
	width: 237px;
	height: 237px;
	z-index: 1;
	visibility: hidden;
	background-color: #FFF;
	border: thin solid #CCC;
}
.hideimg {
	float: right;
	margin-top:0px;
	padding-top:0px;
}
</style>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="../jquery-1.2.6.pack.js"></script>
<script type="text/javascript">
var t = n = 0, count;
	$(document).ready(function(){	
		count=$("#tupian_list a").length;
		$("#tupian_list a:not(:first-child)").hide();
		$("#tupian_info").html($("#tupian_list a:first-child").find("img").attr('alt'));
		$("#tupian_info").click(function(){window.open($("#tupian_list a:first-child").attr('href'), "_blank")});
		$("#tupian li").click(function() {
			var i = $(this).text() - 1;//获取Li元素内的值，即1，2，3，4
			n = i;
			if (i >= count) return;
			$("#tupian_info").html($("#tupian_list a").eq(i).find("img").attr('alt'));
			$("#tupian_info").unbind().click(function(){window.open($("#tupian_list a").eq(i).attr('href'), "_blank")})
			$("#tupian_list a").filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000);
			document.getElementById("tupian").style.background="";
			$(this).toggleClass("on");
			$(this).siblings().removeAttr("class");
		});
		t = setInterval("showAuto()", 4000);
		$("#tupian").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 4000);});
	})
	
	function showAuto()
	{
		n = n >=(count - 1) ? 0 : ++n;
		$("#tupian li").eq(n).trigger('click');
	}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body onLoad="MM_preloadImages('../images/up2.JPG','../images/hide1.JPG')">
<!-- jQuery实现页面顶部显示的加载进度条 -->
<div id="web_loading"><div></div></div>
<script src="jquery1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">// < ![CDATA[
  jQuery(document).ready(function(){
    jQuery("#web_loading div").animate({width:"100%"},800,function(){ 
      setTimeout(function(){jQuery("#web_loading div").fadeOut(500); 
      }); 
    }); 
  });
// ]]></script>
<style>
#web_loading{
z-index:99999;
width:100%;
}
#web_loading div{
width:0;
height:5px;
background:#FF9F15;
}
</style>

<?php if ($totalRows_rs > 0) { // Show if recordset not empty ?>
  <div id="apDiv1">
    <?php
if( $row_rs['username']=="" ){
	$user_img = "../images/logo.jpg";
	$username = "游客";
	$img = "../images/login.JPG";
	$tip = "<strong>如要体验本网站的高级功能，请进行登录。</strong>";
	$url = "";
}else{
	$user_img = "../images/user_logo.JPG";
	$username = $row_rs['username'];
	$img = "../images/information.JPG";
	$tip = "<a href='../admin/zcxx.php?id=$row_rs[id]'>注册信息</a><br><a href='../admin/changePwd.php?id=$row_rs[id]>更改密码</a><br>";
	$url = "?username=".$row_rs['username'];
}?>
    <img src="<?php echo $user_img; ?>" width="55" height="48">
<h1><?php echo $username; ?><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../images/hide1.JPG',1)"><img src="../images/hide2.JPG" width="28" height="23" class="hideimg" onClick="MM_showHideLayers('apDiv1','','hide')"></a></h1>
    <?php echo $tip; ?><br>
    <?php if ($totalRows_rs == 0) { // Show if recordset empty ?>
      <a href="../admin/login.php">登录</a> <a href="../admin/register.php">注册</a>
      <?php } // Show if recordset empty ?>
  <a href="<?php echo $logoutAction ?>"><font color='red'>注销</font></a></div>
  <?php } // Show if recordset not empty ?>
<div class="container">
  <div class="header">
  <!--增加大图-->
  <div class="banner">
  <div class="banner_in">🔊<marquee direction="left" loop="-1">欢迎使用广州风情网，请用您注册时的用户密码进行登录，登陆后您可进行评论。</marquee></div>
  <form id="form1" name="form1" method="post" action="">
         <span>搜索</span>
         <span id="sprytextfield1">
         <label for="sousuo"></label>
         <input type="text" name="sousuo" id="sousuo" />
         <input type="submit" name="button" id="button" value="搜索" />
      </form>
    <div class="login_file"><img src="<?php echo $user_img; ?>" width="29" height="27" /><img src="<?php echo $img; ?>" width="90" height="25" onClick="MM_showHideLayers('apDiv1','','show')" /></div>
</div>
    <!-- end .header --></div>
  <ul id="MenuBar1" class="MenuBarHorizontal">
    <li><a class="MenuBarItemSubmenu" href="nyly.php<?php echo $url; ?>">南粤旅游</a>
      <ul>
        <li><a href="#<?php echo $username; ?>">项目 1.1</a></li>
        <li><a href="#<?php echo $url; ?>">项目 1.2</a></li>
        <li><a href="#<?php echo $url; ?>">项目 1.3</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">广府活动</a>
      <ul>
        <?php if ($totalRows_edit > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            <li><a href="hd.php?username=<?php echo $row_rs['username']; ?>&id=<?php echo $row_edit['id']; ?>"><?php echo $row_edit['title']; ?></a></li>
            <?php } while ($row_edit = mysql_fetch_assoc($edit)); ?>
          <?php } // Show if recordset not empty ?>
<li><a href="contribution.php<?php echo $url; ?>">投稿</a></li>
      </ul>
    </li>
    <li><a id="index" href="../index.php<?php echo $url; ?>">首页</a>    </li>
    <li><a href="gzys.php<?php echo $url; ?>" class="MenuBarItemSubmenu">广州元素</a>
      <ul>
        <li><a href="gsdh.php<?php echo $url; ?>">广式动画</a></li>
        <li><a href="jlgz.php<?php echo $url; ?>">记录广州</a></li>
        <li><a href="sygz.php<?php echo $url; ?>">诗意广州</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">网站信息</a>
      <ul>
        <li><?php
	if(!isset( $_SESSION['MM_Username']) ){
		echo "<a href='#'><font color='#999999'>&quot;游客&quot;的注册信息</font></a>";
	}else{
		echo "<a href='../admin/zcxx.php?username=".$username."'><strong>$username</strong>"."的注册信息</a>";
	}?></li>
        <li><a href="AboutUs.php<?php echo $url; ?>">关于我们</a></li>
      </ul>
    </li>
  </ul>
  <div class="content"><!-- InstanceBeginEditable name="EditRegion1" -->
  <a href="javascript:window.history.back();"><h5>☚Back</h5></a>
    <h1 class="title"><img src="../images/logo.JPG" width="40" height="36">广州风情</h1>
    <span id="sitetime"></span>
    <h3 class="title">”关于我们“网站信息和相关介绍</h3>
    <hr width="90%">
    <h4>　　您现在看到的是技能节过后我不断修改后的广州风情4.0版本，我的网站在3.2版本的基础上添加了一些新的实用功能（多是后台页面的,也有前端的改进），并修复了部分问题。</br>　　站长正在肝更多新功能，敬请期待。。。</h4>
    <p>本网站(2.1版本)于2021年5月21日制作完成，是<a href="#">安全班Zerben</a>为参加<strong><a href="../others/2021年技能节网页作品比赛方案.docx"  title="下载比赛方案">2021天河职中技能节&ldquo;网页设计与制作&rdquo;</a></strong>比赛专门制作的作品，并附有<a href="../网站说明书.docx" title="下载网站说明书">网站说明书</a>。网站主题为<strong>我的家乡</strong>，大标题为<strong>广州风情</strong>，设有5个菜单分别为”<a href="nyly.php" title="点我跳转" target="_blank">南粤旅游</a>”、“广府活动”、“<a href="../index.php" title="点我跳转" target="_blank">首页</a>”、“<a href="gzys.php" title="点我跳转" target="_blank">广州元素</a>”和“<a href="#" title="本页">网站信息</a>”，下设25个子页面。<br>
    　　为了达到融会贯通的效果，本网站用到了几乎所有我会的技术，包括但不限于实现登录/注册功能、支持评论、表格和表单、走马灯效果、链接及鼠标经过图像、命名锚记、图片轮播、搜索功能、禁止修改的密码框、AP元素、在控制台显示文字、文件下载、网页计时器、模板的使用、标签行为、悬浮框、JS脚本、隐藏错误、PHP、富文本编辑器等等。另外，我强烈建议您使用微软<a href="https://www.microsoft.com/zh-cn/edge?r=1" title="没有这个浏览器？去下载" target="_blank">Edge浏览器</a>浏览本站，否则可能呈现不出显示密码的效果。</p><p class="img"><img src="../images/logo3.png" width="283" height="74"></p>
    <p>　　这是我学了PHP后<strong>自己一人独立</strong>地做出的第一个<strong>网站</strong>也应该可能说不定也许是最后一个。这个项目里囊括了不少干货<span style="text-decoration: line-through;">和糟粕</span>,如果你能消化掉它们，我保证你以后做网站99.314159265358975不用面向某度、某SND编程。</p>
    <script>
a = "站长受到如知乎、天猫、爱奇艺等网站的启发，决定吸取它们的先进经验，在本网站的一些页面的控制台（Console)留有一句英文的小彩蛋哦，你能找到它们吗？你还有什么其他有趣的想法要告诉我吗？欢迎加微信/QQ讨论哦。\n flag:login.php/register.php";
console.log(a);
</script>
    <h3>彩蛋✪ ω ✪</h3>
    <p>　　站长受到如知乎、天猫、爱奇艺等网站的启发，决定吸取它们的先进经验，在本网站的一些页面的控制台（Console)留有一句英文的小彩蛋哦，你能找到它们吗？你还有什么其他有趣的想法要告诉我吗？欢迎在本站投稿或加微信/QQ讨论哦。</p>
    <h3><a href="contribution.php<?php if( $row_rs['username']!="" ){echo $url;}?>" target="_blank">投稿</a>(@^0^@)</h3>
    <p>　　本网站欢迎所有人进行投稿，内容可以是旅游信息、广府活动的报道，也可以是内容或技术的改进建议。要进行投稿，请您点击上方的投稿小标题，或将鼠标移到”广府活动“的标签处，并点击随之出现的投稿链接。当然，您也可以扫描下方我的二维码直接跟我联系。</p>
    <h3>鸣谢( •̀ ω •́ )✧</h3>
    <p>　　感谢CSDN、博客园等论坛上的大佬们和老楚师周供技术支持😜。</p>
    <p>　　也感谢thzz207机房提供的环境以及《CSgo、战争雷霆》等为游戏手残党的我提供视觉盛宴！</p>
    <h3 class="img2">联系作者</h3>
    <div class="father">
    <p class="none">　　　　　　　　　　　　　　<img src="../images/QQ_QRcode.jpg" width="194" height="225">　　　　　　<img src="../images/Wechat_QRcode.jpg" width="194" height="225"></p>
    <h5 class="img3">欢迎加我微信/QQ切磋讨论！</h5>
    </div>
    <h2>温馨提示</h2>
    <p>本网站的很多功能都需要进行登录，因此我强烈建议您注册一个本网站的账号。如果您是测试人员，那就更加要进行这个操作了，当然，在后者的情况下，您也可以使用数据库中原有的账号。</p>
    <p>还有，网站作者我的代码可能写得有点拉跨，文案比起真正的高手可能也好不到哪去，但是，请相信我<strong><em>你所看到的可能并不是所有~</em></strong></p>
    <p><a title="☚Back" href="javascript:window.history.back();"><h5>◀返回</h5></a></p>
	<!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">
    <p>台上一分钟,台下十年功.</br>One minute on the stage needs ten years practice off stage. </p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
<div id="broadside"><a href="#index" title="Go to top" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('up','','../images/up2.JPG',1)"><img src="../images/up1.JPG" width="49" height="47" id="up"></a></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs);
?>
