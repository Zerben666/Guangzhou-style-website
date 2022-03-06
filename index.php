<?php require_once('Connections/conn.php'); ?>
<?php require_once('Connections/conn.php');error_reporting(0); ?>
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
	
  $logoutGoTo = "index.php";
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

mysql_select_db($database_conn, $conn);
$query_rs = "SELECT * FROM `user`";
$rs = mysql_query($query_rs, $conn) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
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
$query_rs2 = "SELECT * FROM edit ORDER BY id DESC";
$rs2 = mysql_query($query_rs2, $conn) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>广州风情</title>
<link rel="shortcut icon"  href="images/logo.JPG"/>
<link href="CSS/style2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#tupian {
	position: relative;
	width: 500px;
	height: 252px;
	border: 1px solid #666;
	overflow: hidden;
	margin-top: 5px;
	margin-bottom: 5px;
	float: left;
	margin-right: 5px;
	margin-left: 2px;
}
#tupian_list img {
	border:0px;
	height: 252px;
	width: 776px;
}
#tupian_bg {position:absolute; bottom:0;background-color:#000;height:30px;filter: Alpha(Opacity=30);opacity:0.3;z-index:1000;cursor:pointer; width:280px; }
#tupian_info{position:absolute; bottom:0; left:5px;height:22px;color:#fff;z-index:1001;cursor:pointer}
#tupian_text {position:absolute;width:120px;z-index:1002; right:3px; bottom:3px;}
#tupian ul {position:absolute;list-style-type:none;filter: Alpha(Opacity=80);opacity:0.8; border:1px solid #fff;z-index:1002;
			margin:0; padding:0; bottom:3px; right:5px;}
#tupian ul li { padding:0px 8px;float:left;display:block;color:#FFF;border:#e5eaff 1px solid;background:#6f4f67;cursor:pointer}
#tupian ul li.on { background:#900}
#tupian_list a{position:absolute;} <!-- 让四张图片都可以重叠在一起-->
-->
</style>
<style type="text/css">
.container .content .right p::first-letter{
	color: #63C;
}
.container .content .right p:first-of-type::first-letter{
	font-size:200%;
}
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
.container .header .banner .banner_in marquee {
	width: 92%;
}
.hideimg {
	float: right;
	margin-top:0px;
	padding-top:0px;
}
.container .content .artical {
	font-family: "等线";
	font-size: 2ex;
}
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery-1.2.6.pack.js"></script>
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
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
</script>
</head>

<?php
if(!isset( $_SESSION['MM_Username']) ){
	$user_img = "images/logo.jpg";
	$username = "游客";
	$img = "images/login.JPG";
	$tip = "<strong>如要体验本网站的高级功能，请进行登录。</strong>";
}else{
	$user_img = "images/user_logo.JPG";
	$username =  $_SESSION['MM_Username'];
	$img = "images/information.JPG";
	$tip = "<a href='admin/zcxx.php?id=$row_rs[id]'>注册信息</a><br><a href='admin/changePwd.php?id=$row_rs[id]'>更改密码</a><br>";
}?>
<body onLoad="MM_preloadImages('images/up2.JPG');MM_popupMsg('欢迎您，<?php echo $username; ?>')">

<script>
// 打印页面相关信息（代码更新时间）
let date = new Date()
let a = 'background: #606060; color: #fff; border-radius: 3px 0 0 3px;'
let b = 'background: #1475B2; color: #fff; border-radius: 0 3px 3px 0;'
console.log(`%c Now Time : %c ${date} `, a, b)

var res = `
//     __  __     ____         _       __           __    __
//    / / / /__  / / /___     | |     / /___  _____/ /___/ /
//   / /_/ / _ \\/ / / __ \\    | | /| / / __ \\/ ___/ / __  / 
//  / __  /  __/ / / /_/ /    | |/ |/ / /_/ / /  / / /_/ /  
// /_/ /_/\\___/_/_/\\____/     |__/|__/\\____/_/  /_/\\__,_/   
//                                                          
🔊欢迎使用广州风情网，请用您注册时的用户密码进行登录，登陆后您可进行评论。

[我有一个问题，尊敬的<?php if($username!="游客"){echo " $username 用户";}else{echo "用户";}?>.你是看到页面下方被我‘隐藏’在footer里的“Please F12”点进来的吗？你可以通过投稿功能分享你按F12的原因哦~]
`
console.log(res)
</script>

<div id="apDiv1">
<img src="<?php echo $user_img; ?>" width="55" height="48"><h1><?php echo $username; ?></h1><img src="images/hide2.JPG" width="28" height="23" class="hideimg" onClick="MM_showHideLayers('apDiv1','','hide')">
<?php echo $tip; ?><br>
<?php if (!isset( $_SESSION['MM_Username'])) { // Show if recordset empty ?>
  <a href="admin/login.php">登录</a> <?php if($row_rs['user_group']=="管理员"){echo "<a href='admin/htlogin.php'>后台登陆</a>";}?><a href="admin/register.php">注册</a>
  <?php } // Show if recordset empty ?>
<?php if (isset( $_SESSION['MM_Username'])) { // Show if recordset not empty ?>
  <a href="<?php echo $logoutAction ?>"><font color='red'>注销</font></a>
  <?php } // Show if recordset not empty ?>
</div>
<div class="container">
  <div class="header"><div class="banner">
  <div class="banner_in">🔊<marquee onMouseOut="this.start()" onMouseOver="this.stop()" direction="left" loop="-1">
    欢迎使用广州风情网，请用您注册时的用户密码进行登录，登陆后您可进行评论。
    我们后期可能会将优秀投稿集成到网站里，敬请期待。
  </marquee></div>
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
    <li><a class="MenuBarItemSubmenu" href="files/nyly.php?username=<?php echo $username; ?>">南粤旅游</a>
      <ul>
        <li><a href="#">项目 1.1</a></li>
        <li><a href="#">项目 1.2</a></li>
        <li><a href="#">项目 1.3</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">广府活动</a>
      <ul>
        <?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            <li><a href="files/hd.php?username=<?php echo $row_rs['username']; ?>&id=<?php echo $row_rs2['id']; ?>"><?php echo $row_rs2['title']; ?></a></li>
            <?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
          <?php } // Show if recordset not empty ?>
<li><a href="files/contribution.php?username=<?php echo $username; ?>">投稿</a></li>
      </ul>
    </li>
    <li><a id="index" href="#?username=<?php echo $username; ?>">首页</a>    </li>
    <li><a href="files/gzys.php?username=<?php echo $username; ?>" class="MenuBarItemSubmenu">广州元素</a>
      <ul>
        <li><a href="files/gsdh.php?username=<?php echo $username; ?>">广式动画</a></li>
        <li><a href="files/jlgz.php?username=<?php echo $username; ?>">记录广州</a></li>
        <li><a href="files/sygz.php?username=<?php echo $username; ?>">诗意广州</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">网站信息</a>
      <ul>
        <li><?php
	if(!isset( $_SESSION['MM_Username']) ){
		echo "<a href='#'><font color='#999999'>&quot;游客&quot;的注册信息</font></a>";
	}else{
		echo "<a href='admin/zcxx.php?username=".$username."'><strong>$username</strong>"."的注册信息</a>";
	}?></li>
        <li><a href="files/AboutUs.php?username=<?php echo $username; ?>">关于我们</a></li>
      </ul>
    </li>
  </ul>
  <div class="content">

<div id="tupian">	
	<div id="tupian_bg"></div>  <!--标题背景-->
	<div id="tupian_info"></div> <!--标题-->
    <ul>
        <li class="on">1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
    </ul>
   <div id="tupian_list">
        <a href="#" target="_blank"><img src="images/ersha.jpeg" width="252" height="500" /></a>        <a href="#" target="_blank"><img src="images/liwan.jpeg" width="252" height="500" /></a>
        <a href="#" target="_blank"><img src="images/zwy.jpg" width="252" height="500"></a>
      <a href="#" target="_blank"><img src="images/wuyang.jpg" width="252" height="500"></a>
	</div>
</div>
  	<div class="right"><p>一座明星般的花城，约1530.59万人共同的家乡，首批国家历史文化名城，广府文化的发祥地，华南地区的政治、军事、经济、文化和科教中心。这就是本站介绍的对象，约1530.59万个“我”共同的家乡——广州。
作为快速发展之中国的一线城市，在置身广交会展馆的国际人士看来，广州即是中国的缩影。这座城市有发达的交通网、百年树人的高等学府，民风开放包容，又不乏自己的特色，还有与现代风貌相映的历史底蕴。凡此种种无不是中国在国际上普遍认可的特点。</p></div>
    <img src="images/banner.jpg" width="100%" height="302">
    <div class="artical">
   　<p>　广州，简称“穗”，别称羊城、花城，广东省辖地级市，是广东省省会、副省级市、国家中心城市、超大城市  、广州都市圈核心城市，国务院批复确定的中国重要的中心城市、国际商贸中心和综合交通枢纽。截至2021年，全市下辖11个区，总面积为7434.40平方千米  ，常住人口为1867.66万人  。2021年，全市实现地区生产总值28231.97亿元 。</p>
<p>　　广州地处中国南部、珠江下游、濒临南海，是中国南部战区司令部驻地，国家物流枢纽，国家综合性门户城市  ，国际性综合交通枢纽首批沿海开放城市，是中国通往世界的南大门，粤港澳大湾区、泛珠江三角洲经济区的中心城市以及一带一路的枢纽城市。</p>
<p>　　广州是首批国家历史文化名城，广府文化的发祥地，从秦朝开始一直是郡治、州治、府治的所在地，华南地区的政治、军事、经济、文化和科教中心。从公元三世纪起成为海上丝绸之路的主港，唐宋时成为中国第一大港，是世界著名的东方港市，明清时是中国唯一的对外贸易大港，也是世界唯一两千多年长盛不衰的大港。</p>
<p>　　广州被全球权威机构GaWC评为世界一线城市，每年举办的中国进出口商品交易会吸引了大量客商以及大量外资企业、世界500强企业的投资 。2017年，福布斯中国大陆最佳商业城市排行榜居第二位；中国百强城市排行榜居第三位。2018年，广州人类发展指数居中国第一位，国家中心城市指数居中国第三位。</p>
<dl>
  <dt>中文名</dt>
  <dd>广州</dd>
  <dt>外文名</dt>
  <dd>Guangzhou<br>
    Canton<br>
    Kwangchow</dd>
  <dt>别    名</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E7%A9%97" one-link-mark="yes">穗</a>、<a target="_blank" href="https://baike.baidu.com/item/%E8%8A%B1%E5%9F%8E" one-link-mark="yes">花城</a>、<a target="_blank" href="https://baike.baidu.com/item/%E7%BE%8A%E5%9F%8E" one-link-mark="yes">羊城</a>、<a target="_blank" href="https://baike.baidu.com/item/%E4%BA%94%E7%BE%8A%E5%9F%8E" one-link-mark="yes">五羊城</a></dd>
  <dt>行政区划代码</dt>
  <dd>440100 [227]<a name="ref_[227]_10628575" one-link-mark="yes"> </a></dd>
  <dt>行政区类别</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E5%9C%B0%E7%BA%A7%E5%B8%82/2089621" data-lemmaid="2089621" one-link-mark="yes">地级市</a></dd>
  <dt>所属地区</dt>
  <dd>中国<a target="_blank" href="https://baike.baidu.com/item/%E5%8D%8E%E5%8D%97%E5%9C%B0%E5%8C%BA/7596721" data-lemmaid="7596721" one-link-mark="yes">华南地区</a></dd>
  <dt>地理位置</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E4%B8%9C%E7%9C%81" one-link-mark="yes">广东省</a>中南部，<a target="_blank" href="https://baike.baidu.com/item/%E7%8F%A0%E4%B8%89%E8%A7%92" one-link-mark="yes">珠三角</a>北部</dd>
  <dt>面    积</dt>
  <dd>7434.4 km²</dd>
  <dt>下辖地区</dt>
  <dd>11个市辖区</dd>
  <dt>政府驻地</dt>
  <dd>广东省广州市越秀区府前路1号</dd>
</dl>
<dl>
  <dt>电话区号</dt>
  <dd>020</dd>
  <dt>邮政编码</dt>
  <dd>510000</dd>
  <dt>气候条件</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E4%BA%9A%E7%83%AD%E5%B8%A6%E5%AD%A3%E9%A3%8E%E6%B0%94%E5%80%99" one-link-mark="yes">亚热带季风气候</a></dd>
  <dt>人口数量</dt>
  <dd>1867.66 万(2020年常住人口) [199]<a name="ref_[199]_10628575" one-link-mark="yes"> </a></dd>
  <dt>著名景点</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E8%8A%B1%E5%9F%8E%E5%B9%BF%E5%9C%BA/3752776" data-lemmaid="3752776" one-link-mark="yes">花城广场</a>、<a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E5%A1%94/1951402" data-lemmaid="1951402" one-link-mark="yes">广州塔</a>、<a target="_blank" href="https://baike.baidu.com/item/%E7%99%BD%E4%BA%91%E5%B1%B1/1365" data-lemmaid="1365" one-link-mark="yes">白云山</a>、<a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E5%B8%82%E9%95%BF%E9%9A%86%E6%97%85%E6%B8%B8%E5%BA%A6%E5%81%87%E5%8C%BA/23285499" data-lemmaid="23285499" one-link-mark="yes">广州市长隆旅游度假区</a>、<a target="_blank" href="https://baike.baidu.com/item/%E6%B2%99%E9%9D%A2/1777032" data-lemmaid="1777032" one-link-mark="yes">沙面</a>、<a target="_blank" href="https://baike.baidu.com/item/%E7%9F%B3%E5%AE%A4%E5%9C%A3%E5%BF%83%E5%A4%A7%E6%95%99%E5%A0%82/2965291" data-lemmaid="2965291" one-link-mark="yes">石室圣心大教堂</a>、<a target="_blank" href="https://baike.baidu.com/item/%E9%99%88%E5%AE%B6%E7%A5%A0%E5%A0%82/4242579" data-lemmaid="4242579" one-link-mark="yes">陈家祠堂</a></dd>
  <dt>机    场</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E7%99%BD%E4%BA%91%E5%9B%BD%E9%99%85%E6%9C%BA%E5%9C%BA" one-link-mark="yes">广州白云国际机场</a> 、<a target="_blank" href="https://baike.baidu.com/item/%E7%A9%97%E6%B8%AF%E6%BE%B3%E7%9B%B4%E5%8D%87%E6%9C%BA%E6%9C%BA%E5%9C%BA/54677009" data-lemmaid="54677009" one-link-mark="yes">穗港澳直升机机场</a></dd>
  <dt>火车站</dt>
  <dd><a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E7%AB%99" one-link-mark="yes">广州站</a>、<a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E4%B8%9C%E7%AB%99" one-link-mark="yes">广州东站</a>、<a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E5%8D%97%E7%AB%99" one-link-mark="yes">广州南站</a>、<a target="_blank" href="https://baike.baidu.com/item/%E5%B9%BF%E5%B7%9E%E5%8C%97%E7%AB%99" one-link-mark="yes">广州北站</a>等</dd>
  <dt>车牌代码</dt>
  <dd>粤A</dd>
  <dt>地区生产总值</dt>
  <dd>28231.97 亿元(2021年) [269]<a name="ref_[269]_10628575" one-link-mark="yes"> </a></dd>
  <dt>市委书记</dt>
  <dd>林克庆</dd>
  <dt>市    长</dt>
  <dd>郭永航 [254]<a name="ref_[254]_10628575" one-link-mark="yes"> </a> [273]<a name="ref_[273]_10628575" one-link-mark="yes"> </a></dd>
</dl>
    </div>
  <!-- end .content --></div>
  <div class="footer_index">
    <p>Please F12</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
<div id="broadside"><a href="#index" title="Go to top" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('up','','images/up2.JPG',1)"><img src="images/up1.JPG" width="49" height="47" id="up"></a></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($rs);

mysql_free_result($rs2);
?>
