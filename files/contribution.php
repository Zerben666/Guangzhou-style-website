<?php require_once('../Connections/conn.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO contribution (username, aspect, title, content, `time`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['aspect'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['content'], "text"),
                       GetSQLValueString($_POST['time'], "date"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "tg_secc.php";
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
$totalRows_rs = mysql_num_rows($rs);$colname_rs = "-1";
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
<title>投稿</title>
<script type="text/javascript" src="../ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../ueditor/ueditor.all.min.js"></script>
<script type="application/javascript" src="../ueditor/lang/zh-cn/zh-cn.js"></script>
<!-- InstanceEndEditable -->
<link rel="shortcut icon"  href="../images/logo.JPG"/>
<link href="../CSS/style2.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<style type="text/css">
.container .header .banner .banner_in marquee {
  width: 92%;
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
    <h1>您对本网站有什么改进意见吗？欢迎投稿！</h1>
    <form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
      <?php if ($totalRows_rs > 0) { // Show if recordset not empty ?>
        <table width="600" border="0">
          <tr>
            <td>方面</td>
            <td><label for="aspect"></label>
              <select name="aspect" id="aspect">
                <option value="0">&lt;-请选择-&gt;</option>
                <option value="增加内容">增加内容</option>
                <option value="内容建议">内容建议</option>
                <option value="技术问题">技术问题</option>
                <option value="其他">其他</option>
              </select></td>
          </tr>
          <tr>
            <td>标题</td>
            <td><label for="title"></label>
              <input type="text" name="title" id="title"></td>
          </tr>
          <tr>
            <td>内容</td>
            <td><label for="content"></label>
              <textarea name="content" cols="50" rows="5" id="content"></textarea></td>
          </tr>
          <tr>
            <td><input type="submit" name="button2" id="button2" value="提交"></td>
            <td><input name="username" type="hidden" id="username" value="<?php echo $row_rs['username']; ?>">
            <input name="time" type="hidden" id="time" value="<?php date_default_timezone_set('PRC');echo date("Y-d-m H:i:s"); ?>"></td>
          </tr>
        </table>
        <p><a href="../admin/zcxx.php?username=<?php echo $row_rs['username']; ?>#tg">我的投稿</a></p>
        <?php } // Show if recordset not empty ?>
<input type="hidden" name="MM_insert" value="form2">
    </form>
    <?php if ($totalRows_rs == 0) { // Show if recordset empty ?>
  <p> 请在登陆后使用该功能，去<a href="../admin/login.php">登录</a> </p>
  <?php } // Show if recordset empty ?>
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
mysql_free_result($rs);
?>
<script type="text/javascript">
	UE.getEditor('content',{initialFrameWidth:630,initialFrameHeight:200})
</script>
