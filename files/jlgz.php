<!--滚动指示器beta版-->
<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../Connections/conn.php');error_reporting(0); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "ly")) {
  $insertSQL = sprintf("INSERT INTO ly (username, `time`, ly) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['time'], "date"),
                       GetSQLValueString($_POST['ly2'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "jlgz.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_rs = "SELECT * FROM `user`";
$rs = mysql_query($query_rs, $conn) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

mysql_select_db($database_conn, $conn);
$query_rs2 = "SELECT * FROM ly ORDER BY id DESC";
$rs2 = mysql_query($query_rs2, $conn) or die(mysql_error());
$row_rs2 = mysql_fetch_assoc($rs2);
$totalRows_rs2 = mysql_num_rows($rs2);

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
<title>记录广州</title>
<!--滚动指示器（纯CSS）开始-->
<style>
.container .header .banner .banner_in marquee {
  width: 92%;
}
  .div {
      position: relative;
  }
  .indicator {
    height: 13000px;
      position: absolute;
      top: 0; right: 0; left: 0; bottom: 0;
      background: linear-gradient(to right top, teal 50%, transparent 50%) no-repeat;
      background-size: 100% calc(100% - 100vh);
      z-index: 1;
      pointer-events: none;
      mix-blend-mode: darken;
  }
  .indicator::after {
      content: '';
      position: fixed;
      top: 5px; bottom: 0; right: 0; left: 0;
      background: #fff;
      z-index: 1;
  }
  </style>
<!--滚动指示器（纯CSS）结束-->
<style type="text/css">
.container .content p:first-of-type::first-letter{
	font-size:200%;
}
.jilu{
	margin-top: 1em;
	border-width: thick;
	border-left-style: double;
	border-color: #0FC;
}
.img {
	text-align: center;
}
.container .content #TabbedPanels1 .TabbedPanelsContentGroup .TabbedPanelsContent.TabbedPanelsContentVisible {
	text-indent: 2em;
}
.yaoqing {
	width:90%;
	margin:0 auto;
}
.yaoqing2 {
	line-height: 0px;
	float: right;
}
hr {/*渐变水平线*/
	margin: 0 auto;
	border: 0;
	height: 1px;
	background: #333;
	background-image: linear-gradient(to right, #ccc, #333, #ccc);
}
form table tr td #button {
	float: right;
}
.msg .info .back {
	font-size: 12px;
}
</style>
<style>
	.wrap{width: 600px;margin: 0px auto;}
	.msg{margin: 20px 0px;background: #ccc;padding: 5px;transition: all 0.2s ease-in;}
	.msg:hover{    
    background: #f7f7f7;
    -webkit-box-shadow: 0 0 30px rgba(0,0,0,0.1);
    box-shadow: 0 0 30px rgba(0,0,0,0.15);
    -webkit-transform: translate3d(0, 0px, -2px);
    transform: translate3d(0, 1px, -2px);    
}
	.msg .info{overflow: hidden;}
	.msg .user{float: left;color: blue;}
	.msg .time{float: right;color: #999}
	.msg .content{width: 100%;}
</style>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
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
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
</head>

<body onLoad="MM_preloadImages('../images/up2.JPG','../images/hide1.JPG')">

  <!--滚动指示器 --><div class="div"><div class="indicator"></div></div>

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
    <p>一座城市，在每个人的眼里一定会有不同的风貌，让我们分别跟随不同的视角，去领略羊城广州的点点滴滴。</p>
    <div id="TabbedPanels1" class="TabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">纪录片里的广州</li>
        <li class="TabbedPanelsTab" tabindex="0">有心者眼中的广州</li>
        <li class="TabbedPanelsTab" tabindex="0">广州的历史沿革</li>
      </ul>
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <h1>《航拍中国》里的广州，简直美上了云霄！</h1>
          <h5><font color="#999999">2019-03-15 20:00</font></h5>
          <p>最近，广州登上了大火的纪录片——《航拍中国》第二季，在广东篇50分钟的篇幅中，<strong>广州的镜头整整占据了四分之一！</strong></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/afef5bfd846b45518c04e5f1dcb87e5b.gif" alt=""></p>
          <p><strong>更让我们觉得骄傲的是，有关广州的每一个镜头，都太美了。</strong>无论是城市的交通枢纽、节日期间的装饰与摆设、忙碌的人群，还是平时我们经常出入的高楼、大厦……当这一切从云端之中展露时，都变得绝美无比。</p>
          <p>今天，让站长带你过云层，从空中俯瞰广州这座城市的魅力！</p>
          <p>广州塔</p>
          <p>纪录片开头就是广州的标志性建筑——广州塔。</p>
          <p>广州塔给人们的第一印象，总是柔美和性感，这座塔腰身纤细，最细处直径大约只有30米，因此，也被人们称为&ldquo;小蛮腰&rdquo;。</p>
          <p><strong>有人说，在天愿做广州塔，在地愿做小蛮腰。</strong>作为这样一座令人羡慕的塔，她的瘦身历程，却不是那么容易。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/4223b8d0490c4a65822209c359f6e862.gif" alt=""></p>
          <p>整个电视塔用钢量大约6万吨，她的内核是一个圆形混凝土柱子，外层则用强度极高的钢随塔身盘旋扭转，从建筑学上说，600米高的电视塔保持曼妙姿态并不容易，越细的部分，越需要钢的支撑，需要建筑师花费的精力也越大。</p>
          <p><strong>据说，每让塔身细1米，造价就会成指数级增长。</strong></p>
          <p>广州天河CBD</p>
          <p>穿过广州塔，正对我们的，是广州天河中心商务区——广州CBD。</p>
          <p>这里是广州最繁华的地带，四处充满无尽的生机。从2007年开始，密密麻麻的建筑就如春笋般冒了出来。到了今天，它诞生的一串串数字令人感到惊讶。</p>
          <p>中国<strong>300米</strong>以上超高层建筑最密集地</p>
          <p>世界五百强企业机构超过<strong>200家</strong></p>
          <p>每年税收超过<strong>10亿元</strong>的写字楼多达<strong>15座</strong></p>
          <p>每天有<strong>数十万</strong>白领其中穿梭忙碌</p>
          <p>这里，是广州最<strong>&ldquo;有钱&rdquo;</strong>的地方</p>
          <p>（数据来源于《航拍中国》）</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/9deed4460af148b1a2461c4f3034f66e.gif" alt=""></p>
          <p>广州国际金融中心（广州IFC），也是广州CBD的代表性建筑之一，它被人们称作广州的&ldquo;西塔&rdquo;，<strong>楼高103层，总高度440.75米，建筑造型修长挺拔。</strong></p>
          <p>2012年，它荣获<strong>英国皇家建筑师协会莱铂金奖。</strong></p>
          <p>2015年，它通过<strong>天河CBD可持续发展楼宇评定。</strong></p>
          <p>2017年，它正式获得<strong>LEED铂金级认证</strong>，成为了<strong>国内第一个</strong>以LEED V4标准，获得运营阶段LEED铂金级认证的超高层地标建筑。铂金级认证是LEED所有认证级别中最高级、最难获得的，被誉为<strong>绿色建筑界的&ldquo;奥斯卡奖&rdquo;。</strong>这充分显示出广州IFC在节能环保、可持续发展领域的杰出表现，以及项目在设计、运营管理阶段的卓越水准。</p>
          <p>2018年，<strong>它陪广州扛过了15级强台风&ldquo;山竹&rdquo;，并根据其科学的防风抗震结构，做到了毫发无伤。</strong></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/f308cb5e4cdc4b029e9cecc4d4809c2a.gif" alt=""></p>
          <p>在很多人心里，广州IFC不仅仅只是一个工作场所。</p>
          <p>它拥有基于6S星钻再提升的<strong>&ldquo;双至尊服务体系&rdquo;</strong>，通过更高的服务理念，带给每一个人更优质的服务体验。</p>
          <p>它还是广州市内<strong>首家设立并开放母婴室的超高层写字楼，</strong>在大厦的<strong>12楼、31楼、48楼、49楼</strong>都设有<strong>&ldquo;爱心母婴室&rdquo;</strong>，给予职场妈妈一个温馨而便利的私密空间，让每一个职场妈妈，都能在&ldquo;爱心母婴室&rdquo;这个小小的房间里，感受到<strong>广州IFC满满的爱。</strong></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/8cdf994f2211487b9c1e7672fd8829c3.jpeg" alt=""></p>
          <p>活在广州</p>
          <p>早出晚归，是广州职场人的生活常态。早晚高峰，珠江新城地铁站会让人挤到怀疑人生，<strong>但活在广州的人们依然乐此不疲，因为在这里，夜晚是属于生活的。</strong></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/4a79c6cc4b2246229c49fd3eb53fea2e.gif" alt=""></p>
          <p>20世纪50年代，广州形成了一年一度的迎春花市，用鲜花装点节日的喜悦。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/0141bd036149496183496bb0674bb462.gif" alt=""></p>
          <p>自2011年起，广州每年都要举办国际灯光节，奇幻的灯光点燃了这里的夜晚，为每一个白天奔波于事业的职场人，制造盛大的狂欢。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/0792365f861d4a67a069a1ee96748832.gif" alt=""></p>
          <p>他们到广州市最大的体育中心观看赛事，让每一场比赛，都成为一个节日的开始。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/db9cba787b924d0bb573283e7b9e6f19.gif" alt=""></p>
          <p>到了沙面，人们散步、拍照、喝早茶，在充满欧式建筑的小岛上，布满粤式的生活韵味。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/2aa8e3e6de5b4b609946123d127ee21f.gif" alt=""></p>
          <p>当我们从空中俯瞰广州，当城市的样貌被完整呈现出来，你就会明白，忙碌虽说是这座城市的常态，但也是一种&ldquo;表象&rdquo;。<strong>活在广州的人们，需要接受高强度的工作压力，所以，他们也学着用更多彩的方式享受着生活。</strong></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/b69a9cd93fea4a70b894ef1e76ed3f5c.jpeg" alt=""></p>
          <p>在容纳着多家国内外知名企业、拥有着广州各领域顶尖的人才的广州IFC里，<strong>繁忙也不是它唯一的代名词，</strong><strong>那些属于文化的盛宴、艺术的狂欢，也不断从这里诞生。</strong></p>
          <p>广州IFC珐琅分享会在广州IFC[M空间]隆重举行，现代化与传统工艺在这里进行了一场精彩的碰撞。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/70b8da3563ba4e64868b62f4e2e2c5c8.jpeg" alt=""></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/46869e06e9544f2ab0f4390097bfbba0.jpeg" alt=""></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/ab1ef6f824964eaca4f47c84919c5e09.jpeg" alt=""></p>
          <p>广州IFC珐琅分享会</p>
          <p>悦见——广州IFC手机摄影分享沙龙在广州IFC[M空间]开启，众多摄影爱好者在这里交流、探讨摄影的奥妙。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/203f974bd4874e03aa5880c320221ee3.jpeg" alt=""></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/65de562eb6d14d87abaac636e171e628.jpeg" alt=""></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/b7c5af1f2cae4119ae4938df8bb1ffdc.jpeg" alt=""></p>
          <p>广州IFC手机摄影分享沙龙</p>
          <p>一个又一个展览在这里成功举行。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/bc7d75df85cc484083c53a9ee19693f8.jpeg" alt=""></p>
          <p>糖果手鞠展</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/eaf65881ba3443be90bde83a47999856.jpeg" alt=""></p>
          <p>老广新游</p>
          <p>左右滑动查看更多</p>
          <p>2019，广州国际金融中心的艺术文化活动仍在继续。</p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/569d0bd2162b4785a9f22e35542e7110.gif" alt=""></p>
          <p>在《航拍中国》第二季的预告片中有一段话：<strong>&ldquo;我们总是在远离之后，才有机会看清那些熟悉的风景&rdquo;。</strong></p>
          <p>当我们俯瞰这座熟悉的城市，高大的地标性建筑被一个个缩小，融合在一片平静美好的画面之中时，现代建筑的设计感、人文的关怀、自然的温度，<strong>那些我们平常看不到的一面，都一个个展现了出来。</strong></p>
          <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20190316/0a9675f6c313451cbff3479ee783cd71.jpeg" alt=""></p>
          <p>也只有站在高处之后才会发现，其实在充斥着严肃气氛的办公室之外，我们还有商场、体育馆、大剧院、少年宫、图书馆、博物馆……<strong>以文化丰富生活，在工作之中找寻令人喜悦的细节，这就是广州的态度。</strong></p>
          <p>送上《航拍中国》广东篇，广州部分视频节选</p>
          <p>▼▼▼</p>
          <p>
            <iframe allowfullscreen="" data-src="https://v.qq.com/iframe/preview.html?width=500&height=375&auto=0&vid=b084690n532" src="https://v.qq.com/iframe/player.html?width=500&height=375&auto=0&vid=b084690n532" width="500" height="375"></iframe>
          </p>
          <p> <strong>图片来源｜</strong>《航拍中国》</p>
        </div>
        <div class="TabbedPanelsContent">
          <div id="CollapsiblePanel1" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="0">震撼！这位摄影师记录的广州，看完你再也不想离开！</div>
            <div class="CollapsiblePanelContent">
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/171b300917db4269842c2eda49125576.jpeg" alt="上下九"></p>
              <p>这里是时尚与市井交错的神奇地方，白天我可以去珠江新城的小资咖啡厅听着音乐小口喝着咖啡，晚上我可以去宝业路大排档支吹珠啤吃着烤生蚝。这里有拥挤热闹的城中村，也有优雅别致的东山别墅。</p>
              <p><strong>这里是，广州。</strong></p>
              <p>同热爱这片土地，我想把它不同的样子拍下，留起...</p>
              <p>本文除了少数用手机拍摄外，其它照片使用的器材都是索尼A7+FE24-240和大疆精灵4pro。</p>
              <p><strong>一月</strong></p>
              <p>2017年的元旦就去上下九爬楼拍照。随着电商的冲击和新城区大商场的崛起，老城区的步行街人流逐年稀疏。只有在节假日，才能重新往昔街头人头攒动的热闹景象。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/9a0bea73015141e79f5b2a7719c8fd45.jpeg" alt=""></p>
              <p>△上下九。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/ee5876056cf54b199313eaa92d61c9de.jpeg" alt=""></p>
              <p>△莲香楼。</p>
              <p>新年花市是广州人过年的特色。在年前回家之前抽空拍摄的<strong>荔湾花街</strong>。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/4d5d9e1de8be4174aa8cdb3aa8eda5e3.jpeg" alt=""></p>
              <p>△荔湾花街。</p>
              <p><strong>二月</strong></p>
              <p>在这个月，终于咬咬牙，把心水了几个月的大疆精灵4pro买了下来。从此开始了背着飞机走广州的日子。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/9e07e4c5f2bf49749445671697198305.jpeg" alt=""></p>
              <p>△第一次试飞拍摄的宿舍附近的停车场。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/7388ff61384f48808c1191f0e84e668b.jpeg" alt=""></p>
              <p>△天河立交。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/5acbb6c3243c44be9f5448f7b48560fe.jpeg" alt=""></p>
              <p>△天环广场。</p>
              <p><strong>三月</strong></p>
              <p>广州的三月开始进入春天。<strong>标志之一是木棉花的怒放。标志之二是大叶榕的落叶。</strong></p>
              <p>广州在历史的很长一段时间里，都有种植木棉树的传统。所以每年的三月也是拍摄广州历史建筑最好的季节。在红棉的衬托下，这些建筑显得更有传统的韵味。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/c6dccf2857bb4f498707a882cff49c84.jpeg" alt=""></p>
              <p>△镇海楼。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/3192cfa2061348669b9c60001bcb916e.jpeg" alt=""></p>
              <p>△中山纪念堂。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/cfa535be2cff4e0c904afb242db2c05f.jpeg" alt=""></p>
              <p>△鲁迅纪念馆。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/7cfa7f30960c4552a1da3ebcfab287e0.jpeg" alt=""></p>
              <p>△陵园西路。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/ac496fded8784be6a0945e6e5d0291bb.jpeg" alt=""></p>
              <p>△六榕塔。</p>
              <p>在经历接连的雨天之后，满街的大叶榕开始换季掉叶子。这是迟到了半年的秋色。下图是我利用无人机在华师西区球场拍摄的半场秋叶。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/49625d3306784548a580fa09108dfbe0.jpeg" alt=""></p>
              <p>△看漫天黄叶远飞。</p>
              <p>除了拍摄季节性的景观，用无人机探索这座城市的脚步也并未停止 。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/d5f8890c335c4092b3c96ad1af6e72a5.jpeg" alt=""></p>
              <p>△最后的渔村。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/86051f07bdde483ea6a5ee59ea6b486a.jpeg" alt=""></p>
              <p>△西塔。</p>
              <p><strong>四月</strong></p>
              <p>在这个月开始将无人机的拍摄题材拓宽到城中村。航拍是视角特别适合这些密密麻麻的建筑，从高空俯瞰，排列整齐的房屋带给我的是有别于地面的秩序感。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/2a5c89f4f2f64414923f21b2105c9e2c.jpeg" alt=""></p>
              <p>△马卡龙之城。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/8540ed756ac748bfa6208219c3165e59.jpeg" alt=""></p>
              <p>△大塘村。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/1c44abee7a554f24bb96784c7e069f28.jpeg" alt="莲香楼"></p>
              <p>△废墟之城——拆迁中的冼村。</p>
              <p>在四月底出现了17年入春以来的第一个好天气。下图用航拍接片拍摄的中信和天体。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/d4480aef011a482eabe434f470afe870.jpeg" alt=""></p>
              <p><strong>五月</strong></p>
              <p>春夏之交天气开始多变。冷空气夹带的雨水冲刷着灼热的南方大地。暴雨过后，地面的水汽上升，预冷凝结成大块的云雾，漂浮在城市之间。珠江新城的摩天高楼，在这时候开始出现了穿云的奇观。拍到了一次穿云，也算是了却了买无人机的一个心愿。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/7cf0d5c66356488a9e7ca9ea2744b265.jpeg" alt=""></p>
              <p>△广州塔。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/b0882c27780444f090cf4cda3ea38cd8.jpeg" alt=""></p>
              <p>△西塔。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/fe17cd19aeed4fa2ad569779439068a4.jpeg" alt=""></p>
              <p>△东塔。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/a4d26b5caeba4261ac1cd1eb3e077874.jpeg" alt=""></p>
              <p>△从远处眺望的穿云之城。</p>
              <p>17年的端午难得留在了广州。凑热闹地拍摄了猎德的龙舟招景。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/33cc8e4a607d4c5da40a01f9f8ea56e5.jpeg" alt=""></p>
              <p>△很多只龙舟。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/de2c665913b44004bf9d3066401592a4.jpeg" alt=""></p>
              <p>△穿过猎德涌。</p>
              <p><strong>六月</strong></p>
              <p>空气通透，白昼最长，迎来了一年之中最适合风光摄影的一个季节。然而也是广州全年最热的一个季节。</p>
              <p>跟风去拍了两次日出。五点半的日出，四点钟的出门，夏天拍日出真是对意志力的考验。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/4af7f298bb004d1cabdc4e25997d8143.jpeg" alt=""></p>
              <p>△一道光。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/d4612deb6a6843949111ecee0b34f1ca.jpeg" alt=""></p>
              <p>△云中城。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/e3ebd384a9ec479293633e554fec8bf0.jpeg" alt=""></p>
              <p>△一支穿云箭。</p>
              <p>在一次台风天来临之前，能见度几十公里的天气，下班后挤了地铁跑到了沥滘拍到了三塔夕映。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/b272745a903c411bb55788fb255d8194.jpeg" alt=""></p>
              <p>空气越来越通透，追逐广州塔的足迹也越走越远。</p>
              <p>这段时间我是计划拍摄一个关于城市远景的专题的。人们日复一日地重复从郊区到城区的工作和生活，我用照片将两个地方连接起来。专门挑了一些城市远景，前景是居民楼或者通向城市的桥梁。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/dd389a5969764c01a76ac6676f72f471.jpeg" alt=""></p>
              <p>△鹤洞大桥。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/ec9e59e144a440318d03cf45d3b99a76.jpeg" alt=""></p>
              <p>△广园新村与CBD。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/1df81d095c9548949cf7a11ebd2b853d.jpeg" alt=""></p>
              <p>△大塘村夏夜。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/7b35da23d9c6477ca98bd9c4a2429bd0.jpeg" alt=""></p>
              <p>△鸿鹄楼视角的广州全景。</p>
              <p><strong>七月</strong></p>
              <p>广州的好天气在延续，最充足的日照时间，最通透的天气，让我每天的生活在五点半分割。五点半下班后的我有一个小时的时间可以去到一个理想的机位，准备好机器慢慢等待每天的日落时分。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/856bb556b1d94724856e13bd0c3b0613.jpeg" alt=""></p>
              <p>△黄金水道。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/9b565a4a64064476aacfee05b9eb2bfc.jpeg" alt=""></p>
              <p>△爱群大厦。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/65b19f946c7b4566be7f062e0473778d.jpeg" alt=""></p>
              <p>△三塔。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/28c8f4ef01eb4f6a80d4a25a4c7bd9a1.jpeg" alt=""></p>
              <p>△半城阳光。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/14a7a4aafc4e4cde944f0d3b8c4b645e.jpeg" alt=""></p>
              <p>△一次好看的晚霞。</p>
              <p>随着无人机禁令的临近，这个月的航拍也越发勤奋。周末地铁换公车三个小时到达的南沙港。拍摄了港口排列整齐的这一画面。在货柜中穿梭来往的货车，就像是游戏中贪吃蛇。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/939ae3d1bc19400ca7aa2493c5710a82.jpeg" alt=""></p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/15293809042c4402a7276c47222be0c7.jpeg" alt=""></p>
              <p>△南沙港。</p>
              <p>航拍的北京路与中山路交界的斑马线。夏天的大中午，感觉是可以煎蛋的路面。车辆的存在是为了增加画面的趣味性，取自连拍的另一张照片的同个位置的素材。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/3fd5dfd3d64d412db0455b92ee7c969e.jpeg" alt=""></p>
              <p>△车来人往。</p>
              <p>一次天气不如意的爬楼，用相机俯瞰拍摄的高楼旁边的游泳池。画面中充满了生活的趣味。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/716a752e80c34845bf50570c12fc5dbc.jpeg" alt=""></p>
              <p>△一百种泡泳池的姿势。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/fe6d349e8b954688ae15f6e22a770595.jpeg" alt=""></p>
              <p>△甜甜圈。中间偏右上是的胖子幸福的一家。</p>
              <p>航拍城中村的球场仍在持续。在卫星地图上用肉眼逐个村子排查，再到现场踩点拍摄。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/6c696f9458404125b956089b3eda3a27.jpeg" alt=""></p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/607e18fbb55a42828ba89ef70d2ee296.jpeg" alt=""></p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/4167ead3146a46738dabd867d0943046.jpeg" alt=""></p>
              <p>△城中村的球场系列。</p>
              <p><strong>八月</strong></p>
              <p>夏天的尽头，印象中八月的天气并没有很如意。随着航拍禁令的开始，也很少把无人机带出来拍摄。这个月的出片比七月份少了很多。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/fce9b5af1dfe49789a6ebdaed7e71598.jpeg" alt=""></p>
              <p>△尝试了25张接片的一个黄昏。</p>
              <p>一直在有意拍摄的一个都市夜景马路系列。通过提高快门来表现车辆穿梭期间的都市感。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/a4d1e52eb3434d0d86feb6edba699534.jpeg" alt=""></p>
              <p>△windows</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/40696e1ba5c44b33a287ce5ff2f0dc49.jpeg" alt=""></p>
              <p>△连续弯道。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/47711de90899489d98c90fe933b5ba26.jpeg" alt=""></p>
              <p>△随波逐流。</p>
              <p><strong>九月</strong></p>
              <p>除去了月底的新疆旅游，这个月拍的没有很多，但是有三张我挺喜欢的。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/daa2b12fbd7c45f6a6a44acf0c726a6f.jpeg" alt=""></p>
              <p>△北京路225号。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/6d2f04e0846d4f7182a4f79cba546d77.jpeg" alt=""></p>
              <p>△孤窗一扇为谁明。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/83120007a6af49d4a24b5ac540d24f42.jpeg" alt=""></p>
              <p>△半城秋水。</p>
              <p><strong>十月</strong></p>
              <p>白昼时间变短，下班之后的时间开始不够日落的拍摄，这个月拍的没有很多。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/1ee06eb707d243288b5c472a87f3789d.jpeg" alt=""></p>
              <p>△秋日之光。</p>
              <p>月底迎来了广州国际灯光节的开幕。很幸运地得到了在花城广场航拍的许可，记录了当晚涌进三十万人的盛况。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/b68e0893148248d28ed072835c51f3c3.jpeg" alt=""></p>
              <p>△人头攒动的花城广场。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/864b7b417f664cc2b0aceff78eca9ad8.jpeg" alt=""></p>
              <p>△city shine</p>
              <p><strong>十一月</strong></p>
              <p>搭了灯光节的晚班车，拍摄了广州塔的射灯和亮灯的东塔。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/86f80aec33084939a5165046c5b8c210.jpeg" alt=""></p>
              <p>△金闪闪的广州塔。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/6fe5567a27334e1d8384563d10d8cc24.jpeg" alt=""></p>
              <p>△冷雨夜。很喜欢的一张手机照片。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/ee5547f0ceee4549abe3da85556e5739.jpeg" alt=""></p>
              <p>△大塘的街市。</p>
              <p><strong>十二月</strong></p>
              <p>这个月是财富论坛月。周末难得的好天气，又把无人机拿出来飞了几次。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/a36c15217a904869896827a33a05201f.jpeg" alt=""></p>
              <p>△财富专列。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/77bce4928b02443dbbe5efd71ea3f3f3.jpeg" alt=""></p>
              <p>△熊猫形状的花卉。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/c658852ec4ab4ee1a6f02b8fc0b9eae5.jpeg" alt=""></p>
              <p>△red in red。拍摄于新光大桥。</p>
              <p>平安夜的石室亮灯，终于把七月份发现的新机位派上了用场。</p>
              <p><img src="http://5b0988e595225.cdn.sohucs.com/images/20180120/efe2d981a18f480580c6f4d7610e92df.jpeg" alt=""></p>
              <p>△灯火万家城四畔，星河一道水中央。</p>
            </div>
          </div>
          <div id="CollapsiblePanel2" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="0">
              从20世纪90年代到2020，他记录下广州30年市井生活
            </div>
            <div class="CollapsiblePanelContent">
              <p>存古知新，</p>
              <p>没有过去就没有未来，</p>
              <p>广州城相就是这样的过去现在未来相吧。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689296/1000" alt=""></p>
              <p>你可曾记得或耳闻二三十年前的广州天河？</p>
              <p>彼时，茫茫草地，草长莺飞，水牛遍地，一片城郊田野。</p>
              <p>而另一边，在那以西的旧城里，人声鼎沸，川流不息，商业旺盛，广州城的兴旺喧哗都聚集在这片以西关为中心的区域。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689297/1000" alt=""></p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689298/1000" alt=""></p>
              <p>那时，有一位叫许培武的年轻记者，背着一台尼康一三五相机，走街串巷，用镜头记录下这座城的生活图景，追逐这东山以东城市扩张的变化痕迹。许培武从1990年代早期开始拍摄广州城市影像，这批珍贵的老照片从某个角度见证了广州这座城市20年来的变迁更迭、城市快速发展后的变化面貌以及背后值得留忆的时光故事。原本，它们珍藏于他的百宝箱中，直到2021年1月，遇上了位处于天河市中心的广州超级文和友。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689299/1000" alt=""></p>
              <p>广州超级文和友太古汇店是超级文和友走出长沙后的第一站。&ldquo;文和友&rdquo;于2010年起步于长沙街巷，当时不过是一块一米见方的小摊。于其而言，市井街巷是他们回忆的起源，也是他们对美好光景的第一定义。保留每一座城市不一样的市井回忆，保护那些即将逝去的地方街头美食，创造空间让朋友们可在此走街串巷，体会市井百态，获得轻松与快乐，这是文和友人的初衷。2019年，随着长沙超级文和友的扩建，&ldquo;超级文和友社区&rdquo;逐渐丰富，其中，市井文化是重要的组成之一。各地超级文和友每年计划举行4场艺术展览。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689300/1000" alt=""></p>
              <p>老城记忆</p>
              <p>2021年1月9日，本年度的第一场，《广州城相——许培武影像展》正式亮相，由超级文和友与广州日报联合主办，中国邮政协办。许培武的照片与重现的广州城市空间彼此唤醒证明，获得存在。许培武老师与（超级）文和友在此相遇，没有比这更合适的缘分了。文和友，是植入到新城的广州旧城记忆容器，而许培武拥有的，是二维纸面的影像宝盒。前者是旧物的聚合，后者是旧影的秘藏，前者虽实却虚，乃是以八十年代的实在之物，在新城虚拟出一个过去时的空间，后者虽虚也实，这些照片恰是旧日生活旧时风貌不可辩驳的证据。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689302/1000" alt=""></p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689303/1000" alt=""></p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689304/1000" alt=""></p>
              <p>影像作品有机地布局于超级文和友内，与各处空间融合对话。镜头记录下的不同时刻，在如今汇集成线对比，形成强烈的观感，深处天河市中心，我们追随那份&ldquo;报纸&rdquo;导览手册，一步步朝前，透过摄影作品深刻感受这座城市真实的性格。</p>
              <p>新中轴线</p>
              <p>新城市中轴线的变迁代表着珠江新城的诞生，照片刻下的时间进程记录了中轴线由渐变到巨变的过程。1999年国庆50周年大型晚会选址在新城中央，这年6月至9月，新城中央从南至北铺出一条长长绿化带，就是新城中轴线前身。而今历时20年镜头转换，这里已是广州人流最密集的地区，是广州最繁华的新缩影。</p>
              <p>老城记忆</p>
              <p>1993年，许培武在中山六路已经拆掉的华北饭店向一位摄影前辈请教在云南拍摄的照片，那位前辈说，可以缓拍永远不变的风景，记录广州城市改造中可能消失的街景。此后，许培武开始游走老城区，拍摄了已经消失的新华电影院、艳芳照相馆、致美斋等老字号，以及着戏服唱粤曲的市相场景，这批封存多年的照片首次在这里展览。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689307/1000" alt=""></p>
              <p>长街掠影</p>
              <p>2002年，一款刚面世不久的宽画幅相机，拓展了许培武的城市拍摄风格。他用这架相机拍广州珠江出海口到南沙，以及老城街区。宽幅横图舒展，竖图高仰，造成视觉上的强烈对比。这辑长街掠影照片入选广东美术馆举办的首届广州国际摄影双年展，被美术馆典藏。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689308/1000" alt=""></p>
              <p>广州塔</p>
              <p>广州塔无疑是现在广州最有名的地标景点。2006年12月，广州塔开建之时，许培武在临江大道江边找到一处可以拍摄广州塔建造全过程的地点，记录了广州塔建造过程中鲜为人知的细节。610米高度曾是在照片记录里最高处，2010年广州塔竣工不久，由于处于飞机航线转向区，为确保飞行安全，塔顶天线修去10米，即是现在的真实高度。</p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689309/1000" alt=""></p>
              <p><img src="https://inews.gtimg.com/newsapp_bt/0/13022689311/1000" alt=""></p>
              <p>#时光邮局#</p>
              <p>写一封信给未来的TA</p>
              <p>广州邮政作为《广州城相—— 许培武影像展》的协办单位，与广州超级文和友、许培武联合定制了12款关于广州城市变迁记忆的主题明信片与专属展览邮戳，明信片限量发售。超级文和友于展览现场3楼特设了&ldquo;时光邮局&rdquo;互动区域，观展顾客可参与互动，给亲朋好友写上一封关于广州城市记忆的故事。填写限量版明信片，投递入90年代怀旧邮筒内，广州邮政将提供收寄服务。</p>
              <p>广州邮政定制的&ldquo;时光邮局&rdquo;现场更设有&ldquo;时光漫邮&rdquo;写给未来一封信互动环节。观展顾客可于现场亲自挑选主题信纸，选择想要给未来一年、十年、甚至二十年后的自己或者亲友送出一封现在与未来对话的时光信件，给未来的TA一个值得时光珍惜的惊喜。</p>
              <p>展出时间：2021年1月9日-2021年3月31日</p>
              <p>展览地点：广州超级文和友（广州市天河区天河东路75号）</p>
            </div>
          </div>
      <div id="CollapsiblePanel3" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">广州，一座富有文化底蕴的城市，有着自己独特的味道</div>
      <div class="CollapsiblePanelContent">
        <div>
          <p>岁月的味道</p>
        </div>
        <div>
          <p>我是自从大二，开始接触的摄影，然后就被这个神奇的东西给套住了，然后后来有机会去了广州，闲逛，而且没课的时候也随便坐一辆公交车，到处游荡，我特别喜欢老城街的小巷子里面逛街，觉得那些房子都很有岁月的味道。</p>
        </div>
        <div>
          <div><img src="https://t12.baidu.com/it/u=1126416041,1588222163&fm=173&app=25&f=JPEG?w=640&h=433&s=F23230C646E5976C56EFF68D0300608D" alt="" width="640"></div>
        </div>
        <div>
          <p>风格别致的小巷子</p>
        </div>
        <div>
          <p>而且，广州给我的感觉好像都是一些风格别致的小巷子，有时候扫着扫着就感觉到这个地方好像似曾相识一样，总感觉自己什么时候好像来过，而且我们小区的小伙子都结婚了，邻居，大哥哥大姐姐都在给他们道喜，所以我就非常有荣幸能够看到这种画面，感觉这种画面，给人的感觉特别强烈，感染力比较强。</p>
        </div>
        <div>
          <div><img src="https://t11.baidu.com/it/u=2661401020,328044788&fm=173&app=25&f=JPEG?w=640&h=407&s=1FB66C850831EADE06B9F88003008088" alt="" width="640"></div>
        </div>
        <div>
          <p>聚众玩耍</p>
        </div>
        <div>
          <p>而且在广州我们也可以经常看到一群人围在一起，他们在下象棋，随便的放一张桌子，就能够聚集很多的人，就开始看到一群大叔在下棋，玩的不亦乐乎，或者是一些小朋友，他们三三两两的，在一块玩耍，还能够看到他们成群结队的去捉蝉什么的，我觉得夏天吃西瓜或者冰糕这种事情都是特别闲惬的事情，特别是一些便利店的门口都是一些聚众，玩耍的佳地。</p>
        </div>
        <div>
          <div><img src="https://t10.baidu.com/it/u=2100661416,2399338601&fm=173&app=25&f=JPEG?w=640&h=425&s=1E83F605C4475B4F0AB8BDE103006085" alt="" width="640"></div>
        </div>
        <div>
          <p>白发苍苍</p>
        </div>
        <div>
          <p>我觉得大叔他们喜欢下棋，而大妈们一般都会凑在一起搓麻将，搓到白发苍苍一起搓麻将，跟搓到白头到老的邻居，我觉得他们在一起也真的挺有意思的，而且，在这里我们还能看到一条很有味道的菜市场，觉得这里的菜都比较的新鲜，很像以前古代的那种集市，可以说是一个生活气息比较浓厚的地方在这里，完全都能够感受到当地人。</p>
        </div>
        <div>
          <div><img src="https://t10.baidu.com/it/u=1123818747,3357761130&fm=173&app=25&f=JPEG?w=639&h=427&s=F506D71482A54B0D069AEDC10300F0AB" alt="" width="639"></div>
        </div>
        <div>
          <p>广州人的生活</p>
        </div>
        <div>
          <p>我有时候也很喜欢去菜市场买菜，因为这样可以真实的接触到，广州人他们的生活，我觉得广州人其实给人的感觉还挺好，然后比较热情，比较大方，而且有时候你买菜也不用只去菜市场，你在小巷子门口也可以直接买到菜，当然了，这对于周围住的居民更是方便，而且我更喜欢的去的地方就是学校是附近的小巷子，我每次去学校的时候也喜欢看这条路，回到学校，觉得这边的水果非常的新鲜，而且还不贵，所以我就特别喜欢这里熙熙攘攘的气氛，然后有时候一些热心的，老大爷或者老大妈，还要呵斥，我们走路的时候不要玩手机，这样很危险。</p>
        </div>
        <div>
          <div><img src="https://t12.baidu.com/it/u=675375110,3452481662&fm=173&app=25&f=JPEG?w=640&h=406&s=D6289E468E44784FD887CD690300F01B" alt="" width="640"></div>
        </div>
        <div>
          <p>搭讪</p>
        </div>
        <div>
          <p>有时候我在广州街上看到一些落寞的老年人，就想上去跟他们搭讪，不知道他们是否真的这么的孤单，有时候也想坐到他们身边，跟他们说说家里心里话，拉拉家常，但是又怕打扰到他们的生活，我也不知道别人孤单是一种什么样的体质，我只知道在门口纳凉的老太太能够让我想起来，小时候，在家里跟着奶奶和隔壁家老奶奶一起乘凉，聊家常的事情。</p>
        </div>
        <p>&nbsp;</p>
      </div>
    </div>
        </div>
        <div class="TabbedPanelsContent">公元前221年，秦始皇统一中国，秦始皇33年(公元前214年)平南越后，在广州地区设南海郡。广州为郡治所在地。后赵佗续任南海郡郡尉，于秦末汉初时， 自立为南越国武帝，汉武帝于公元前111年平定了南越国，把原赵佗割据地区划分为九郡，广州仍称南海郡，归属交趾称交州，交州治所在地移至广西梧州，东汉末年，广州属于三国时的吴国，公元216年，吴国交州刺史步骘把交州治从梧州迁回广州，公元226年将交州改为广州，广州之名由此开始。晋代广州仍称南海郡，为州治所在。南北朝与隋代，广州仍为州治。唐代广州称广州都督府，是岭南道的道治与都督府治所在地，唐末期刘岩在广州称帝，号称南汉国。 公元970年，宋平南汉后，废都督府仍称为广州(以后一直沿用广州名称)，广州为广南东路路治地(简称广东。广东省之称自此开始)。
        </br>　　广州由秦汉起至明清2000多年间，一直是中国对外贸易的重要港口城市。是中国海上丝绸之路的起点。据《新唐书·地理志》记载，到唐朝时，这条海上“丝绸之路”称为“广州通海夷道”，其航程从广州起，经南海、印度洋，直驶巴士拉港，到达东非赤道以南海岸，这是16世纪以前世界上最长的远洋航线。到唐宋时期，广州已发展成为世界著名的东方大港，并首设全国第一个管理外贸事务的机构——市舶使；明清时期，广州更是特殊开放的口岸，在一段较长的时间内，曾是全国惟一的对外贸易港口城市。鸦片战争后，中国与英国签订《南京条约》，被迫开放广州、上海、宁波、福州、厦门五个通商口岸，广州一口通商的局面从此结束。
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <p>　　<font size="200%">广</font>东的重点其实还是在人文景观。这里有城市化水平最高的城市群，有规模巨大的人口迁移，有中国改革开放的前沿阵地，是客家人的目的地，是重要侨乡，毗邻港澳，文化交融，交通便利，面朝大海，春暖花开，人文景观确实值得大书特书。但片中为数不多的自然景观也非常亮眼，丹霞山风光、英西峰林、乳源大峡谷......在粤港澳城市群的人间繁华之下，粤西、粤北、粤东的自然风光似乎存在感有些稀薄。但我真的想大声说一句：广东真的很美！</p>
    <hr width="90%">
    <h2 class="jilu">我也来记录</h2>
    <div class="yaoqing">
      <p>逮嘎侯！看完这张页面，同样热爱这片土地的你对广州，又有怎样刻骨铭心的记忆？如果您也是一位“老广”，并且有意分享您的广州印象，欢迎留言哦！温馨提示：本功能需要登录才能使用。</p>
      <h5 class="yaoqing2">————来自“小广”站长的邀请</h5>
    </div>
    <form name="ly" action="<?php echo $editFormAction; ?>" method="POST" id="ly">
      <?php if ($totalRows_rs > 0) { // Show if recordset not empty ?>
  <table width="800" border="0" align="center">
    <tr>
      <td><label for="ly">
        <textarea name="ly2" cols="90%" rows="5" id="ly2" placeholder="吉时已到，请在此处写下您的留言"></textarea>
        </label></td>
      <td id="t">当前时间：<span></span>年<span></span>月<span></span>日<span></span>时<span></span>分<span></span>秒</td>
      <script>
	        var ss=document.getElementById('t').getElementsByTagName('span');
	        function changetime(){
	            var time=new Date();
	            ss[0].innerHTML=time.getFullYear();
	            ss[1].innerHTML=time.getMonth()+1;
	            ss[2].innerHTML=time.getDate();
	            ss[3].innerHTML=time.getHours();
	            ss[4].innerHTML=time.getMinutes();
	            ss[5].innerHTML=time.getSeconds();
	        }
	        changetime();
	        setInterval(function(){
	            changetime();
	        },1000)
		  </script>
      </tr>
    <tr>
      <td><input name="username" type="hidden" id="username" value="<?php echo $row_rs['username']; ?>">
        <input name="time" type="hidden" id="time" value="<?php echo date("Y-m-d H:i:s");?>">
        <input type="submit" name="button" id="button" value="发表"></td>
      <td>&nbsp;</td>
      </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<input type="hidden" name="MM_insert" value="ly">
    </form>
<div class="wrap">
  <?php if ($totalRows_rs2 == 0) { // Show if recordset empty ?>
    <!--无人评论时显示-->
    <div class="msg">
      <div class="info"> <span class="user">root</span>
        <from class="time">
        2021-5-16 20-51-00</span></div>
      <div class="content"> 还没有留言哦,来做楼主吧 </div>
    </div>
    <div class="msg">
      <div class="info"> <span class="user"></span>
        <from class="time">
        </span></div>
      <div class="content"></div>
    </div>
    <?php } // Show if recordset empty ?>
<!--有人评论时显示-->
<?php if ($totalRows_rs2 > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <div class="msg">
      <div class="info"> <span class="user"><?php echo $row_rs2['username']; ?></span>
      <?php if($username==$row_rs2['username']){ // Show if recordset not empty ?>
		  <a href="#" class="back" onclick="javascript:if(confirm('确认撤回吗？撤回后将刷新页面')) location='del.php?id=<?php echo $row_rs2[id];?>'">撤回</a>
      <?php  } ?>
        <from class="time">
        <?php echo $row_rs2['time']; ?></span></div>
      <div class="content"> <?php echo $row_rs2['ly']; ?></div>
    </div>
    <?php } while ($row_rs2 = mysql_fetch_assoc($rs2)); ?>
  <?php } // Show if recordset not empty ?>
</div>
    <script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2");
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3");
    </script>
  <!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">
    <p>友情链接：<a href="https://www.423down.com">423down</a>|<a href="https://www.ghxi.com/">果核剥壳</a>|<a href="https://searx.tiekoetter.com/">searXNG聚合搜索</a>|<a href="https://www.wolframalpha.com">Wolfram Alpha</a><br>推荐公众号：<a title="QQ">小怪很无奈、差评君、街头象棋、16的好奇心</a>、<a title="WeChat">啊虚同学</a></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
<div id="broadside"><a href="#index" title="Go to top" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('up','','../images/up2.JPG',1)"><img src="../images/up1.JPG" width="49" height="47" id="up"></a></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs2);

mysql_free_result($rs);
?>
