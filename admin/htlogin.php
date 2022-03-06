<?php require_once('../Connections/conn.php'); ?>
<?php
session_start();
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "user_group";
  $MM_redirectLoginSuccess = "../htfiles/admin.php";
  $MM_redirectLoginFailed = "login_error.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conn, $conn);
  	
  $LoginRS__query=sprintf("SELECT username, password, user_group FROM `user` WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'user_group');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广州风情|登录</title>
<link  href="../images/logo.JPG" rel="shortcut icon"/>
<link href="../CSS/style_login.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#apDiv1 {
	position: absolute;
	z-index: 1;
}
#apDiv2 {
	position: absolute;
	left: 85%;
	top: 5%;
	width: auto;
	height: auto;
	z-index: 2;
	border-style: groove;
	visibility: hidden;
}
#apDiv2 a {
	text-decoration: none;
	color: #0CC;
}
#apDiv2 a:hover {
	text-decoration: underline;
}
</style>
<script type="text/javascript">
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>
<script type="text/javascript">
function DivFlying() {
  var div = document.getElementById("divFly");
  if (!div) {
 return;
  }
  var intX = window.event.clientX + "1px";
  var intY = window.event.clientY;
  div.style.left = intX + "px";
  div.style.top = intY + "px";
}
document.onmousemove = DivFlying;
</script>
</head>

<body>
<div id="divFly" style="position:absolute;">
<img src="../images/GZ.jpeg" width="30" height="23" />
</div>
<div id="apDiv2"><a href="../files/AboutUs.php" title="点我了解网站信息！" target="_blank">关于我们</a></div>
<script>
a = "Welcome to login--By Zerben Chen";
console.log(a);
</script>
<div class="banner"><marquee direction="left" loop="-1">
    <p>欢迎使用广州风情网，请用您注册时的用户密码进行登录，登陆后您可进行评论。</p></marquee>
</div>
	<div class="window demo1"><a href="javascript:window.history.back();" class="a0"></a>
    <div class="login">
      <h2>后台登录</h2>
      <form action="<?php echo $loginFormAction; ?>" method="POST" id="from">
        <div class="user">
          <p><img src="../images/user_logo.JPG" width="69" height="65" /></p>
          <p><img src="../images/user.JPG" width="26" height="24" />用户名：
            <label for="username"></label>
            <input type="text" name="username" id="username" placeholder="账号/手机号/邮箱"/>
          </p>
          <p><img src="../images/passwd.JPG" width="22" height="21" />密码：
            <label for="username"></label>
            <input type="password" name="password" id="password" placeholder="请输入账户密码"/>
          <button type="button" onclick="alert('暂不支持直接显示密码的功能，但你可以按F12修改密码框的type类型为text来手动显示密码')"><img src="../images/yy.gif" width="27" height="16" /></button></p>
          <p>
            <input type="submit" name="button" id="button" value="登录" />
            <input type="reset" name="button2" id="button2" value="重置" />
          </p>
          <p><a href="findPwd.php" class="a1 a">忘记密码</a></font></p>
          <p><a href="register.php" class="a2 a">没有账号？去注册</a></font></p>
        </div>
        <p><a href="javascript:window.history.back();" class="a0"> <img src="../images/back.jpeg" width="20" height="22" />返回</a></p>
        <p>&nbsp;</p>
      </form>
      <p>
      <button type="button" id="apDiv1" class="login qq" onclick="alert('暂不支持此登陆方式，不过您可以点击即将出现的”关于我们“并扫描二维码加我QQ/微信来在“官方数据库”中添加您的账户');MM_showHideLayers('apDiv2','','show')"><img src="../images/qq.JPG" width="108" height="32" class="login" /></button>
      <button type="button" class="login wechat" onclick="alert('暂不支持此登陆方式，不过您可以点击即将出现的”关于我们“并扫描二维码加我QQ/微信来在“官方数据库”中添加您的账户');MM_showHideLayers('apDiv2','','show')"><img src="../images/wechat.JPG" width="118" height="31" class="login" /></button>
      </p>
	</div>
</div>
</body>
</html>