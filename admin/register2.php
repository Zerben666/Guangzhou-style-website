<?php require_once('../Connections/conn.php'); ?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="register_error.php";
  $loginUsername = $_POST['username'];
  $LoginRS__query = sprintf("SELECT username FROM user WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conn, $conn);
  $LoginRS=mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user (username, nickname, gender, password, education, city, hobby, question, answer, phone, email, self-introduction, regtime, style) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['nickname'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['education'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString(isset($_POST['hobby[]']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['question'], "text"),
                       GetSQLValueString($_POST['answer'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['text'], "text"),
                       GetSQLValueString($_POST['datetime'], "date"),
                       GetSQLValueString($_POST['style'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "register_view.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>广州风情|确认注册</title>
<link href="../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<style type="text/css">
.container .header .banner .banner_in marquee {
  width: 92%;
}
.tap1 {
	color: #999;
	text-align: right;
}
</style>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function firm() { 
    //利用对话框返回的值 （true 或者 false） 
    if (confirm("你确定要退出此账号的注册吗？")) { 
      window.location.href="register.php"; 
    } 
    else { 
    } 
  
  }
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
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
<script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
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
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <fieldset>
        <legend>完善信息</legend>
        <table width="800" height="349" border="1">
  <tr>
    <td colspan="4"><h4>"<?php echo $_POST["username"];?>"的提交结果如下（可进行修改和完善），请确认：</h4></td>
    </tr>
  <tr>
    <td class="tap1">注册方式：</td>
    <td colspan="3" class="tap2"><span id="style">
      <label>
        <input type="radio" name="style" value="账号注册" id="style_0">
        账号注册</label>
      <label>
        <input type="radio" name="style" value="手机号注册" id="style_1">
        手机号注册</label>
      <label>
        <input type="radio" name="style" value="邮箱注册" id="style_2">
        邮箱注册</label>
      <span class="radioRequiredMsg">请进行选择。</span></span></td>
    </tr>
  <tr>
    <td class="tap1">注册邮箱：</td>
    <td class="tap2"><label for="Email"></label>
      <span id="sprytextfield2">
      <label for="Email"></label>
      <input type="text" name="Email" id="Email" placeholder="请输入您要注册的邮箱">
      <span class="textfieldInvalidFormatMsg">格式无效。</span></span></td>
    <td class="tap1">性别：</td>
    <td class="tap2"><span id="gender">
    <label>
      <input type="radio" name="gender" value="男" id="gender_0">
      男</label>
    <label>
      <input type="radio" name="gender" value="女" id="gender_1">
      女</label>
</span>（选填）</td>
  </tr>
  <tr>
    <td class="tap1">注册手机：</td>
    <td class="tap2"><label for="phone"></label>
      <input name="phone" type="text" id="phone" placeholder="请输入您要注册的手机号" maxlength="14" title="不能超过14个字符" ></td>
    <td class="tap1">学历：</td>
    <td class="tap2"><select name="education" id="education">
      <option value="0" selected>-请选择-</option>
        <option value="中职/高中">中职/高中</option>
        <option value="专科/本科">专科/本科</option>
        <option value="硕士研究生">硕士研究生</option>
        <option value="博士研究生">博士研究生</option>
      </select>
    （选填）</td>
  </tr>
  <tr>
    <td class="tap1">登录密码：</td>
    <td class="tap2"><input name="password" type="password" id="password" title="该项不可修改" value="<?php echo $_POST["password1"];?>" readonly><label for="password"></label><button type="button" onclick="alert('暂不支持直接显示密码的功能，但你可以按F12修改密码框的type类型为text来手动显示密码')"><img src="../images/yy.gif" width="27" height="16" /></button></td>
    <td class="tap1">所在城市</td>
    <td class="tap2"><select name="city" id="city">
      <option value="0" selected>-请选择-</option>
        <option value="北京">北京</option>
        <option value="上海">上海</option>
        <option value="广州">广州</option>
        <option value="深圳">深圳</option>
      </select>
    （选填）</td>
  </tr>
  <tr>
    <td class="tap1">昵称：</td>
    <td class="tap2"><span id="sprytextfield1">
      <label for="nickname"></label>
      <input name="nickname" type="text" id="nickname" style="" placeholder="请给你注册的帐号指定一个昵称(<?php echo $_POST["username"];?>)" value="<?php echo $_POST["username"];?>" size="30" title="给你的账号指定一个比[<?php echo $_POST["username"];?>]更好听的昵称吧">
      <span class="textfieldRequiredMsg">这是必填项。</span></span></td>
    <td class="tap1">浏览偏好：</td>
    <td class="tap2"><span id="hobby">
<input name="hobby[]" type="checkbox" id="hobby[]" value="历史" title="历史偏好">
历史
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="科技" title="科技偏好">
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
<span class="checkboxRequiredMsg">请进行选择（可多选）。</span></span></td>
  </tr>
  <tr>
    <td class="tap1">安全问题：</td>
    <td class="tap2"><label for="question"></label>
      <label for="question"></label>
      <input type="text" name="question" id="question" title="请为你的账户设置一个安全问题，这会在你找回密码时用到">
      （选填）</td>
    <td class="tap1">问题答案：</td>
    <td class="tap2"><label for="answer"></label>
      <input name="answer" type="text" id="answer" title="请为你的安全问题设置一个答案，并保证它的安全性" size="30">
      （选填）</td>
    </tr>
  <tr>
    <td class="tap1">自我介绍（选填）：</td>
    <td colspan="3" class="tap2"><textarea name="text" cols="60" rows="5" id="text" title="介绍一下自己呗😉" placeholder="评论的时候，请遵纪守法并注意语言文明">该用户很懒，还没有自我介绍呢...</textarea></td>
  </tr>
  </table>
  <input name="datetime" type="hidden" id="datetime" value="<?php echo date("Y-m-d H:i:s");?>">
      <input name="username" type="hidden" id="username" value="<?php echo $_POST["username"];?>">
      </fieldset>
      <input type="submit" name="button2" id="button2" value="完成注册">
      <input type="reset" name="button3" id="button3" value="重置">
      <input name="button4" type="button" id="button4" onClick="MM_callJS('firm()')" value="取消">
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <script type="text/javascript">
var spryradio1 = new Spry.Widget.ValidationRadio("style");
var spryradio2 = new Spry.Widget.ValidationRadio("gender", {isRequired:false});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("hobby");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {isRequired:false});
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