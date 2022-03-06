<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广州风情|注册</title>
<link  href="../images/logo.JPG" rel="shortcut icon"/>
<link href="../CSS/style_login.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<style type="text/css">
.container .header .banner .banner_in marquee {
  width: 92%;
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
<div class="banner">🔊<marquee direction="left" loop="-1">
    <p>欢迎使用广州风情网，请用您注册时的用户密码进行登录，登陆后您可进行评论。</p></marquee>
</div>
	<div class="window demo1"><a href="javascript:window.history.back();" class="a0"></a>
    <div class="login"><h2>注册</h2>
      <form action="register2.php" method="post" id="form1">
        <div class="user">
          <p><img src="../images/user_logo.JPG" width="69" height="65" /></p>
          <table width="300" border="0" align="center">
            <tr>
              <td width="40%" align="left"><img src="../images/user.JPG" alt="" width="26" height="24" />用户名：</td>
              <td><span id="sprytextfield1">
            <label for="username"></label>
            <input type="text" name="username" id="username" placeholder="可填写账号/手机号/邮箱"/>
          <span class="textfieldRequiredMsg">请填写用户名。</span></span></td>
            </tr>
            <tr>
              <td align="left"><img src="../images/passwd.JPG" width="22" height="21" />密码：</td>
              <td><span id="sprypassword1">
            <label for="password1"></label>
            <input type="password" name="password1" id="password1" placeholder="请输入该账户的密码"/>
          <span class="passwordRequiredMsg">请填写密码。</span><span class="passwordMinCharsMsg">不符合最小字符数要求。</span></span></td>
            </tr>
            <tr>
              <td align="left"><img src="../images/passwd.JPG" width="22" height="21" />重复密码：</td>
              <td><span id="spryconfirm1">
            <label for="password2"></label>
            <input type="password" name="password2" id="password2" placeholder="请再次输入该账户密码"/>
          </span></td>
            </tr>
          </table>
          <p><span>          <span class="confirmRequiredMsg">请确认密码。</span><span class="confirmInvalidMsg">您两次输入的密码不一致</span></span></p>
          <p>
            <input type="submit" name="button" id="button" value="注册" />
            <input type="reset" name="button2" id="button2" value="重置" />
          </p>
        </div>
        <p><a href="javascript:window.history.back();" class="a0"> <img src="../images/back.jpeg" width="20" height="22" />返回</a></p>
      </form>
      <p>
      <button type="button" class="login qq" onclick="alert('暂不支持此登陆方式，不过您可以点击即将出现的”关于我们“并扫描二维码加我QQ/微信来在“官方数据库”中添加您的账户');MM_showHideLayers('apDiv2','','show')"><img src="../images/qq.JPG" width="108" height="32" class="login" /></button>
      <button type="button" class="login wechat" onclick="alert('暂不支持此登陆方式，不过您可以点击即将出现的”关于我们“并扫描二维码加我QQ/微信来在“官方数据库”中添加您的账户');MM_showHideLayers('apDiv2','','show')"><img src="../images/wechat.JPG" width="118" height="31" class="login" /></button>
      </p>
	</div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:8});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password1");
</script>
</body>
</html>