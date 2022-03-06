<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../Connections/conn.php'); ?>
<?php require_once('../Connections/conn.php');error_reporting(0); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "from")) {
  $updateSQL = sprintf("UPDATE ``user`` SET nickname=%s, gender=%s, password=%s, education=%s, city=%s, question=%s, answer=%s, phone=%s, email=%s, self-introduction=%s WHERE username=%s",
                       GetSQLValueString($_POST['nickname'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['education'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['question'], "text"),
                       GetSQLValueString($_POST['answer'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['text'], "text"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "zcxx.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname1_rs = "-1";
if (isset($_GET['id'])) {
  $colname1_rs = $_GET['id'];
}
$colname2_rs = "-1";
if (isset($_POST['username'])) {
  $colname2_rs = $_POST['username'];
}
mysql_select_db($database_conn, $conn);
$query_rs = sprintf("SELECT * FROM `user` WHERE id = %s or username = %s", GetSQLValueString($colname1_rs, "int"),GetSQLValueString($colname2_rs, "text"));
$rs = mysql_query($query_rs, $conn) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = "-1";
if (isset($_GET['id'])) {
  $totalRows_rs = $_GET['id'];
}
$colname2_rs = "-1";
if (isset($_GET['username'])) {
  $colname2_rs = $_GET['username'];
}
$colname1_rs = "-1";
$colname1_rs = "-1";
if (isset($_GET['id'])) {
  $colname1_rs = $_GET['id'];
}
$colname2_rs = "-1";
if (isset($_GET['username'])) {
  $colname2_rs = $_GET['username'];
}
mysql_select_db($database_conn, $conn);
$query_rs = sprintf("SELECT * FROM `user` WHERE id = %s or username = %s", GetSQLValueString($colname1_rs, "text"),GetSQLValueString($colname2_rs, "text"));
$rs = mysql_query($query_rs, $conn) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$colname_tg = "-1";
if (isset($_GET['username'])) {
  $colname_tg = $_GET['username'];
}
mysql_select_db($database_conn, $conn);
$query_tg = sprintf("SELECT * FROM contribution WHERE username = %s ORDER BY id DESC", GetSQLValueString($colname_tg, "text"));
$tg = mysql_query($query_tg, $conn) or die(mysql_error());
$row_tg = mysql_fetch_assoc($tg);
$totalRows_tg = mysql_num_rows($tg);

$colname_edit = "-1";
if (isset($_GET['username'])) {
  $colname_edit = $_GET['username'];
}
mysql_select_db($database_conn, $conn);
$query_edit = sprintf("SELECT * FROM edit WHERE original = %s ORDER BY id DESC", GetSQLValueString($colname_edit, "text"));
$edit = mysql_query($query_edit, $conn) or die(mysql_error());
$row_edit = mysql_fetch_assoc($edit);
$totalRows_edit = mysql_num_rows($edit);

$colname_tg_b = "-1";
if (isset($_GET['username'])) {
  $colname_tg_b = $_GET['username'];
}
mysql_select_db($database_conn, $conn);
$query_tg_b = sprintf("SELECT * FROM contribution WHERE username = %s ORDER BY id ASC", GetSQLValueString($colname_tg_b, "text"));
$tg_b = mysql_query($query_tg_b, $conn) or die(mysql_error());
$row_tg_b = mysql_fetch_assoc($tg_b);
$totalRows_tg_b = mysql_num_rows($tg_b);

$colname_edit_b = "-1";
if (isset($_GET['username'])) {
  $colname_edit_b = $_GET['username'];
}
mysql_select_db($database_conn, $conn);
$query_edit_b = sprintf("SELECT * FROM edit WHERE original = %s ORDER BY id ASC", GetSQLValueString($colname_edit_b, "text"));
$edit_b = mysql_query($query_edit_b, $conn) or die(mysql_error());
$row_edit_b = mysql_fetch_assoc($edit_b);
$totalRows_edit_b = mysql_num_rows($edit_b);
?>
<?php
session_start();
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>广州风情|注册信息</title>
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
<style type="text/css">
.tab {
	text-align: center;
	display: block;
	width: 40%;
	margin: 0 auto 6px;
	border-bottom-style: solid;
	border-color: #3C9;
}
</style>
<style>
.container {
	background-image: url(../images/bg1.jpg);
}
.container .content #from table {
	margin-left: 5px;
	background-color: #CCFFFF;
	margin-bottom: 1em;
}
h1 .user {
	font-family: "等线";
	font-style:italic;
	color: #960;
}
#user{
	border-bottom-style: dotted;
	width: 3in;
	float: left;
	clear: none;
	margin-left: 4px;
}
input,select{
	background-color: #FFFFCC;
}
input:hover,select:hover{
	background-color:#FEFEE0;
}
textarea {
	background-color: #AEFFFF;
}
textarea:hover {
	background-color: #FFFFCC;
}
#main{ width:80%; height:auto!important; overflow:hidden; visibility:visible; margin:auto; margin-top:0px;}
#left{ width:38%; float:left; border:#CCCCCC 1px solid;}
#right{
	width: 60%;
	float: left;
	border: #CCCCCC 1px solid;
	height: 300px;
	padding-top: 40px;
	background-color: #E7E7E7;
	overflow-x:hidden;
	overflow-y:auto;
}
<!-- #right:hover{
<!--	overflow-y:auto;
<!--}
.read{
	float:right;
	font-size:9px;
}
.bq{
	font-style: italic;	
	font-size:10px;
	color:#069;
}
.release{
	background-color: #FF0;	
}
#tg{
	color: red;
}
.container .content .tab {
	margin-top: 5em;
}
#SYSmess {
	color: #B3DF00;
	margin-bottom: 4mm;
	margin-top: 4em;
}
.container .content #mess li{
	margin-left: 8em;
	margin-bottom: 2mm;
	width: 80%;
	color: #F90;
}
.container .content #mess li a{
	color: #F90;
	text-decoration: none;
}
.container .content #mess li a:hover{
	color: #6CC;
	text-decoration: underline;
}
#mess li #regtime {
	float: right;
	font-family: Georgia;
	color: #999;
}
.footer p {
	text-align: center;
	display: block;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
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
<script type="text/javascript">// < ![CDATA[
  jQuery(document).ready(function(){
    jQuery("#web_loading div").animate({width:"100%"},800,function(){ 
      setTimeout(function(){jQuery("#web_loading div").fadeOut(500); 
      }); 
    }); 
  });
// ]]></script>
<script>
function testdata(obj){
document.getElementById('right').innerHTML=obj;
 }
</script>
<!-- InstanceEndEditable -->
</head>

<body onLoad="MM_preloadImages('../images/up2.JPG','../images/hide1.JPG')">
<!-- jQuery实现页面顶部显示的加载进度条 -->
<div id="web_loading"><div></div></div>
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
      <a href="login.php">登录</a> <a href="register.php">注册</a>
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
    <li><a class="MenuBarItemSubmenu" href="../files/nyly.php<?php echo $url; ?>">南粤旅游</a>
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
            <li><a href="../files/hd.php?username=<?php echo $row_rs['username']; ?>&id=<?php echo $row_edit['id']; ?>"><?php echo $row_edit['title']; ?></a></li>
            <?php } while ($row_edit = mysql_fetch_assoc($edit)); ?>
          <?php } // Show if recordset not empty ?>
<li><a href="../files/contribution.php<?php echo $url; ?>">投稿</a></li>
      </ul>
    </li>
    <li><a id="index" href="../index.php<?php echo $url; ?>">首页</a>    </li>
    <li><a href="../files/gzys.php<?php echo $url; ?>" class="MenuBarItemSubmenu">广州元素</a>
      <ul>
        <li><a href="../files/gsdh.php<?php echo $url; ?>">广式动画</a></li>
        <li><a href="../files/jlgz.php<?php echo $url; ?>">记录广州</a></li>
        <li><a href="../files/sygz.php<?php echo $url; ?>">诗意广州</a></li>
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
        <li><a href="../files/AboutUs.php<?php echo $url; ?>">关于我们</a></li>
      </ul>
    </li>
  </ul>
  <div class="content"><!-- InstanceBeginEditable name="EditRegion1" -->
    <h1 id="user"><a class="user"><?php echo $username; ?></a> 的用户信息</h1>
    <a href="javascript:window.history.back();" title="☚Back"><h5>☚Back</h5></a>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="from" id="from">
      <fieldset>
        <legend>注册信息（Registration Information）</legend>
      <table width="800" height="349" border="1">
  <tr>
    <td class="tap1">注册方式：</td>
    <td colspan="3" class="tap2"><?php echo $row_rs['style']; ?>
      <input name="username" type="hidden" id="username" value="<?php echo $row_rs['username']; ?>"></td>
    </tr>
  <tr>
    <td class="tap1">注册邮箱：</td>
    <td class="tap2"><label for="Email"></label>
      <span id="sprytextfield2">
      <label for="Email"></label>
      <input name="Email" type="text" id="Email" placeholder="请输入您要注册的邮箱" value="<?php echo $row_rs['email']; ?>">
      </td>
    <td class="tap1">性别：</td>
    <td class="tap2"><span id="gender">
    <label>
      <input <?php if (!(strcmp($row_rs['gender'],"男"))) {echo "checked=\"checked\"";} ?> type="radio" name="gender" value="男" id="gender_0">
      男</label>
    <label>
      <input <?php if (!(strcmp($row_rs['gender'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="gender" value="女" id="gender_1">
      女</label>
    <input <?php if (!(strcmp($row_rs['gender'],"保密"))) {echo "checked=\"checked\"";} ?> type="radio" name="gender" id="radio" value="保密">
    <label for="gender"></label>
    保密</span></td>
  </tr>
  <tr>
    <td class="tap1">注册手机：</td>
    <td class="tap2"><label for="phone"></label>
      <input name="phone" type="text" id="phone" placeholder="请输入您要注册的手机号" title="不能超过14个字符" value="<?php echo $row_rs['phone']; ?>" maxlength="14" ></td>
    <td class="tap1">学历：</td>
    <td class="tap2"><select name="education" id="education">
      <option value="0" selected <?php if (!(strcmp(0, $row_rs['education']))) {echo "selected=\"selected\"";} ?>>-请选择-</option>
      <option value="中职/高中" <?php if (!(strcmp("中职/高中", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>中职/高中</option>
      <option value="专科/本科" <?php if (!(strcmp("专科/本科", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>专科/本科</option>
      <option value="硕士研究生" <?php if (!(strcmp("硕士研究生", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>硕士研究生</option>
      <option value="博士研究生" <?php if (!(strcmp("博士研究生", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>博士研究生</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rs['education']?>"<?php if (!(strcmp($row_rs['education'], $row_rs['education']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs['education']?></option>
      <?php
} while ($row_rs = mysql_fetch_assoc($rs));
  $rows = mysql_num_rows($rs);
  if($rows > 0) {
      mysql_data_seek($rs, 0);
	  $row_rs = mysql_fetch_assoc($rs);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td class="tap1">登录密码：</td>
    <td class="tap2"><input name="password" type="password" id="password" title="该项不可修改" value="<?php echo $row_rs['password']; ?>" readonly>
      <a href="changePwd.php?id=<?php echo $row_rs['id']; ?>">修改密码</a></td>
    <td class="tap1">所在城市</td>
    <td class="tap2"><select name="city" id="city">
      <option value="0" selected <?php if (!(strcmp(0, $row_rs['city']))) {echo "selected=\"selected\"";} ?>>-请选择-</option>
      <option value="北京" <?php if (!(strcmp("北京", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>北京</option>
      <option value="上海" <?php if (!(strcmp("上海", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>上海</option>
      <option value="广州" <?php if (!(strcmp("广州", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>广州</option>
      <option value="深圳" <?php if (!(strcmp("深圳", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>深圳</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rs['city']?>"<?php if (!(strcmp($row_rs['city'], $row_rs['city']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs['city']?></option>
      <?php
} while ($row_rs = mysql_fetch_assoc($rs));
  $rows = mysql_num_rows($rs);
  if($rows > 0) {
      mysql_data_seek($rs, 0);
	  $row_rs = mysql_fetch_assoc($rs);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td class="tap1">昵称：</td>
    <td class="tap2"><span id="sprytextfield1">
      <label for="nickname"></label>
      <input name="nickname" type="text" id="nickname" style="" placeholder="请给你注册的帐号指定一个昵称(<?php echo $row_rs['nickname']; ?>)" value="<?php echo $row_rs['nickname']; ?>" size="30" title="给你的账号指定一个比[<?php echo $row_rs['nickname']; ?>]更好听的昵称吧">
      <span class="textfieldRequiredMsg">这是必填项。</span></span></td>
    <td class="tap1">浏览偏好：</td>
    <td class="tap2"><span id="hobby">
<input <?php if (!(strpos($row_rs['hobby'],"1"))) {echo "checked=\"checked\"";} ?> name="hobby[]" type="checkbox" id="hobby[]" value="历史" title="历史偏好">
历史
<label for="hobby[]"></label>
<input <?php if ((strpos($row_rs['hobby'],"2"))) {echo "checked=\"checked\"";} ?> name="hobby[]" type="checkbox" id="hobby[]" value="科技" title="科技偏好">
科技
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="人文" title="人文偏好">
人文
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="美食" title="美食偏好">
美食
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="动漫" title="动漫偏好">
动漫
<label for="hobby[]"></label>
</td>
  </tr>
  <tr>
    <td class="tap1">安全问题：</td>
    <td class="tap2"><label for="question"></label>
      <label for="question"></label>
      <input name="question" type="text" id="question" title="请为你的账户设置一个安全问题，这会在你找回密码时用到" value="<?php echo $row_rs['question']; ?>">
      （选填）</td>
    <td class="tap1">问题答案：</td>
    <td class="tap2"><label for="answer"></label>
      <input name="answer" type="text" id="answer" title="请为你的安全问题设置一个答案，并保证它的安全性" value="<?php echo $row_rs['answer']; ?>" size="30">
      （选填）</td>
    </tr>
  <tr>
    <td class="tap1">自我介绍（选填）：</td>
    <td colspan="3" class="tap2"><textarea name="text" cols="60" rows="5" id="text" title="介绍一下自己呗😉" placeholder="评论的时候，请遵纪守法并注意语言文明"><?php echo $row_rs['self-introduction']; ?></textarea></td>
  </tr>
  </table>
    <input type="hidden" name="MM_update" value="from">
    <p><input name="buttom" type="submit" id="buttom" value="修改信息">
    <input type="reset" name="button2" id="button2" value="重置">
  </p>
	</form>
      </fieldset>
  <h3 class="tab"><a id="tg">投稿动态</a></h3>
  <div id="main">
    <!--整体内容（内含对应右侧内容）-->
    <div id="left">
        <ul>
          <?php do { ?>
            <li onclick="testdata('<?php echo "<strong>$row_tg[title]</strong>";
			if($row_tg['read']=="1"){echo "<a id=read class=read><img src=../images/read.jpg width=12 height=13>站长已读</a>";}
			echo "<br><a class=bq>$row_tg[aspect] $row_tg[time]</a>$row_tg[content]";
			if($row_tg['release']=='1'){echo "<font color=red>恭喜，站长发布了<a title=查看 href=../files/hd.php?username=$row_tg[username]&id=$row_edit_b[id]><font color=red>您的投稿</font></a>！</font>";} ?>')"<?php if($row_tg['release']=="1"){echo " class=release";}?>>
            <!--左侧栏目-->
			<?php echo $row_tg['title']; ?>
			<?php if($row_tg['read']=="1"){echo "<a class='read'><img src='../images/read.jpg' width='12' height='13'>站长已读</a>";}?></li>
            <?php } while ($row_tg = mysql_fetch_assoc($tg)); ?>
            <?php if ($totalRows_tg == 0) { // Show if recordset empty ?>
  <li onclick="testdata('有想法吗？快去投稿页发表专属于你的创意吧！')">?暂无投稿或您的投稿已被管理员删除?</li>
  <?php } // Show if recordset empty ?>
        </ul>
    </div>
    <!--右侧默认内容-->
    <div id="right"><strong>投稿系统v2.0</strong></br>欢迎使用网站投稿系统，快点击左边的栏目来查看你的每一条投稿吧。</div>
    </div>
    <h3 class="tab" id="SYSmess">系统信息</a></h3>
    <ul id="mess">
      <li><a href="../files/AboutUs.php<?php echo $url; ?>" title="点击访问“关于我们”页——<?php echo $row_rs[regtime];?>">欢迎注册“广州风情”网，更多新功能正在开发中，敬请期待！</a><a id="regtime"><?php echo $row_rs[regtime];?></a></li>
      <li>网页时隔半年迎来全面大更，大量Bug被修复，为我们的作者点赞！！！<a id="regtime">2022-03-06 13:55:00</a></li>
      <?php do{?>
      <?php if ($totalRows_tg != "") {echo "
      	<li><a href='#tg' title=".$row_tg_b['time'].">您已成功发表投稿！</a>
        	<a id='regtime'>'"; ?>
				<?php if($row_tg_b['time']!=''){echo $row_tg_b['time'];}else {echo '404 !no found!';} ?>
            <?php echo "</a>
        </li>
      ";}?>
       <?php if ($row_tg_b['release'] == "1") {echo "
      	<li><a href='#right' title=".$row_edit_b['time'].">恭喜，站长已发表您的投稿！</a>
        	<a id='regtime'>";?>
				<?php if($row_edit_b['time']!=''){echo $row_edit_b['time'];}else {echo '404 !no found!';} ?>
            <?php echo "</a>
        </li>
      <?php ";}?>
      <?php } while ($row_tg_2 = mysql_fetch_assoc($tg_2)); ?>
    </ul>
  <!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">
    <p>You should never judge something you don't understand.</br>
你不应该去评判你不了解的事物</p>
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

mysql_free_result($tg);

mysql_free_result($edit);

mysql_free_result($tg_b);

mysql_free_result($edit_b);
?>
