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
<title>????????????|????????????</title>
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
			var i = $(this).text() - 1;//??????Li?????????????????????1???2???3???4
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
	font-family: "??????";
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
<!-- jQuery?????????????????????????????????????????? -->
<div id="web_loading"><div></div></div>
<?php if ($totalRows_rs > 0) { // Show if recordset not empty ?>
  <div id="apDiv1">
    <?php
if( $row_rs['username']=="" ){
	$user_img = "../images/logo.jpg";
	$username = "??????";
	$img = "../images/login.JPG";
	$tip = "<strong>?????????????????????????????????????????????????????????</strong>";
	$url = "";
}else{
	$user_img = "../images/user_logo.JPG";
	$username = $row_rs['username'];
	$img = "../images/information.JPG";
	$tip = "<a href='../admin/zcxx.php?id=$row_rs[id]'>????????????</a><br><a href='../admin/changePwd.php?id=$row_rs[id]>????????????</a><br>";
	$url = "?username=".$row_rs['username'];
}?>
    <img src="<?php echo $user_img; ?>" width="55" height="48">
<h1><?php echo $username; ?><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../images/hide1.JPG',1)"><img src="../images/hide2.JPG" width="28" height="23" class="hideimg" onClick="MM_showHideLayers('apDiv1','','hide')"></a></h1>
    <?php echo $tip; ?><br>
    <?php if ($totalRows_rs == 0) { // Show if recordset empty ?>
      <a href="login.php">??????</a> <a href="register.php">??????</a>
      <?php } // Show if recordset empty ?>
  <a href="<?php echo $logoutAction ?>"><font color='red'>??????</font></a></div>
  <?php } // Show if recordset not empty ?>
<div class="container">
  <div class="header">
  <!--????????????-->
  <div class="banner">
  <div class="banner_in">????<marquee direction="left" loop="-1">????????????????????????????????????????????????????????????????????????????????????????????????????????????</marquee></div>
  <form id="form1" name="form1" method="post" action="">
         <span>??????</span>
         <span id="sprytextfield1">
         <label for="sousuo"></label>
         <input type="text" name="sousuo" id="sousuo" />
         <input type="submit" name="button" id="button" value="??????" />
      </form>
    <div class="login_file"><img src="<?php echo $user_img; ?>" width="29" height="27" /><img src="<?php echo $img; ?>" width="90" height="25" onClick="MM_showHideLayers('apDiv1','','show')" /></div>
</div>
    <!-- end .header --></div>
  <ul id="MenuBar1" class="MenuBarHorizontal">
    <li><a class="MenuBarItemSubmenu" href="../files/nyly.php<?php echo $url; ?>">????????????</a>
      <ul>
        <li><a href="#<?php echo $username; ?>">?????? 1.1</a></li>
        <li><a href="#<?php echo $url; ?>">?????? 1.2</a></li>
        <li><a href="#<?php echo $url; ?>">?????? 1.3</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">????????????</a>
      <ul>
        <?php if ($totalRows_edit > 0) { // Show if recordset not empty ?>
          <?php do { ?>
            <li><a href="../files/hd.php?username=<?php echo $row_rs['username']; ?>&id=<?php echo $row_edit['id']; ?>"><?php echo $row_edit['title']; ?></a></li>
            <?php } while ($row_edit = mysql_fetch_assoc($edit)); ?>
          <?php } // Show if recordset not empty ?>
<li><a href="../files/contribution.php<?php echo $url; ?>">??????</a></li>
      </ul>
    </li>
    <li><a id="index" href="../index.php<?php echo $url; ?>">??????</a>    </li>
    <li><a href="../files/gzys.php<?php echo $url; ?>" class="MenuBarItemSubmenu">????????????</a>
      <ul>
        <li><a href="../files/gsdh.php<?php echo $url; ?>">????????????</a></li>
        <li><a href="../files/jlgz.php<?php echo $url; ?>">????????????</a></li>
        <li><a href="../files/sygz.php<?php echo $url; ?>">????????????</a></li>
      </ul>
    </li>
    <li><a href="#" class="MenuBarItemSubmenu">????????????</a>
      <ul>
        <li><?php
	if(!isset( $_SESSION['MM_Username']) ){
		echo "<a href='#'><font color='#999999'>&quot;??????&quot;???????????????</font></a>";
	}else{
		echo "<a href='../admin/zcxx.php?username=".$username."'><strong>$username</strong>"."???????????????</a>";
	}?></li>
        <li><a href="../files/AboutUs.php<?php echo $url; ?>">????????????</a></li>
      </ul>
    </li>
  </ul>
  <div class="content"><!-- InstanceBeginEditable name="EditRegion1" -->
    <h1 id="user"><a class="user"><?php echo $username; ?></a> ???????????????</h1>
    <a href="javascript:window.history.back();" title="???Back"><h5>???Back</h5></a>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="from" id="from">
      <fieldset>
        <legend>???????????????Registration Information???</legend>
      <table width="800" height="349" border="1">
  <tr>
    <td class="tap1">???????????????</td>
    <td colspan="3" class="tap2"><?php echo $row_rs['style']; ?>
      <input name="username" type="hidden" id="username" value="<?php echo $row_rs['username']; ?>"></td>
    </tr>
  <tr>
    <td class="tap1">???????????????</td>
    <td class="tap2"><label for="Email"></label>
      <span id="sprytextfield2">
      <label for="Email"></label>
      <input name="Email" type="text" id="Email" placeholder="??????????????????????????????" value="<?php echo $row_rs['email']; ?>">
      </td>
    <td class="tap1">?????????</td>
    <td class="tap2"><span id="gender">
    <label>
      <input <?php if (!(strcmp($row_rs['gender'],"???"))) {echo "checked=\"checked\"";} ?> type="radio" name="gender" value="???" id="gender_0">
      ???</label>
    <label>
      <input <?php if (!(strcmp($row_rs['gender'],"???"))) {echo "checked=\"checked\"";} ?> type="radio" name="gender" value="???" id="gender_1">
      ???</label>
    <input <?php if (!(strcmp($row_rs['gender'],"??????"))) {echo "checked=\"checked\"";} ?> type="radio" name="gender" id="radio" value="??????">
    <label for="gender"></label>
    ??????</span></td>
  </tr>
  <tr>
    <td class="tap1">???????????????</td>
    <td class="tap2"><label for="phone"></label>
      <input name="phone" type="text" id="phone" placeholder="?????????????????????????????????" title="????????????14?????????" value="<?php echo $row_rs['phone']; ?>" maxlength="14" ></td>
    <td class="tap1">?????????</td>
    <td class="tap2"><select name="education" id="education">
      <option value="0" selected <?php if (!(strcmp(0, $row_rs['education']))) {echo "selected=\"selected\"";} ?>>-?????????-</option>
      <option value="??????/??????" <?php if (!(strcmp("??????/??????", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>??????/??????</option>
      <option value="??????/??????" <?php if (!(strcmp("??????/??????", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>??????/??????</option>
      <option value="???????????????" <?php if (!(strcmp("???????????????", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>???????????????</option>
      <option value="???????????????" <?php if (!(strcmp("???????????????", $row_rs['education']))) {echo "selected=\"selected\"";} ?>>???????????????</option>
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
    <td class="tap1">???????????????</td>
    <td class="tap2"><input name="password" type="password" id="password" title="??????????????????" value="<?php echo $row_rs['password']; ?>" readonly>
      <a href="changePwd.php?id=<?php echo $row_rs['id']; ?>">????????????</a></td>
    <td class="tap1">????????????</td>
    <td class="tap2"><select name="city" id="city">
      <option value="0" selected <?php if (!(strcmp(0, $row_rs['city']))) {echo "selected=\"selected\"";} ?>>-?????????-</option>
      <option value="??????" <?php if (!(strcmp("??????", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>??????</option>
      <option value="??????" <?php if (!(strcmp("??????", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>??????</option>
      <option value="??????" <?php if (!(strcmp("??????", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>??????</option>
      <option value="??????" <?php if (!(strcmp("??????", $row_rs['city']))) {echo "selected=\"selected\"";} ?>>??????</option>
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
    <td class="tap1">?????????</td>
    <td class="tap2"><span id="sprytextfield1">
      <label for="nickname"></label>
      <input name="nickname" type="text" id="nickname" style="" placeholder="??????????????????????????????????????????(<?php echo $row_rs['nickname']; ?>)" value="<?php echo $row_rs['nickname']; ?>" size="30" title="??????????????????????????????[<?php echo $row_rs['nickname']; ?>]?????????????????????">
      <span class="textfieldRequiredMsg">??????????????????</span></span></td>
    <td class="tap1">???????????????</td>
    <td class="tap2"><span id="hobby">
<input <?php if (!(strpos($row_rs['hobby'],"1"))) {echo "checked=\"checked\"";} ?> name="hobby[]" type="checkbox" id="hobby[]" value="??????" title="????????????">
??????
<label for="hobby[]"></label>
<input <?php if ((strpos($row_rs['hobby'],"2"))) {echo "checked=\"checked\"";} ?> name="hobby[]" type="checkbox" id="hobby[]" value="??????" title="????????????">
??????
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="??????" title="????????????">
??????
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="??????" title="????????????">
??????
<label for="hobby[]"></label>
<input name="hobby[]" type="checkbox" id="hobby[]" value="??????" title="????????????">
??????
<label for="hobby[]"></label>
</td>
  </tr>
  <tr>
    <td class="tap1">???????????????</td>
    <td class="tap2"><label for="question"></label>
      <label for="question"></label>
      <input name="question" type="text" id="question" title="??????????????????????????????????????????????????????????????????????????????" value="<?php echo $row_rs['question']; ?>">
      ????????????</td>
    <td class="tap1">???????????????</td>
    <td class="tap2"><label for="answer"></label>
      <input name="answer" type="text" id="answer" title="?????????????????????????????????????????????????????????????????????" value="<?php echo $row_rs['answer']; ?>" size="30">
      ????????????</td>
    </tr>
  <tr>
    <td class="tap1">???????????????????????????</td>
    <td colspan="3" class="tap2"><textarea name="text" cols="60" rows="5" id="text" title="?????????????????????????" placeholder="??????????????????????????????????????????????????????"><?php echo $row_rs['self-introduction']; ?></textarea></td>
  </tr>
  </table>
    <input type="hidden" name="MM_update" value="from">
    <p><input name="buttom" type="submit" id="buttom" value="????????????">
    <input type="reset" name="button2" id="button2" value="??????">
  </p>
	</form>
      </fieldset>
  <h3 class="tab"><a id="tg">????????????</a></h3>
  <div id="main">
    <!--??????????????????????????????????????????-->
    <div id="left">
        <ul>
          <?php do { ?>
            <li onclick="testdata('<?php echo "<strong>$row_tg[title]</strong>";
			if($row_tg['read']=="1"){echo "<a id=read class=read><img src=../images/read.jpg width=12 height=13>????????????</a>";}
			echo "<br><a class=bq>$row_tg[aspect] $row_tg[time]</a>$row_tg[content]";
			if($row_tg['release']=='1'){echo "<font color=red>????????????????????????<a title=?????? href=../files/hd.php?username=$row_tg[username]&id=$row_edit_b[id]><font color=red>????????????</font></a>???</font>";} ?>')"<?php if($row_tg['release']=="1"){echo " class=release";}?>>
            <!--????????????-->
			<?php echo $row_tg['title']; ?>
			<?php if($row_tg['read']=="1"){echo "<a class='read'><img src='../images/read.jpg' width='12' height='13'>????????????</a>";}?></li>
            <?php } while ($row_tg = mysql_fetch_assoc($tg)); ?>
            <?php if ($totalRows_tg == 0) { // Show if recordset empty ?>
  <li onclick="testdata('???????????????????????????????????????????????????????????????')">??????????????????????????????????????????????????</li>
  <?php } // Show if recordset empty ?>
        </ul>
    </div>
    <!--??????????????????-->
    <div id="right"><strong>????????????v2.0</strong></br>?????????????????????????????????????????????????????????????????????????????????????????????</div>
    </div>
    <h3 class="tab" id="SYSmess">????????????</a></h3>
    <ul id="mess">
      <li><a href="../files/AboutUs.php<?php echo $url; ?>" title="???????????????????????????????????????<?php echo $row_rs[regtime];?>">????????????????????????????????????????????????????????????????????????????????????</a><a id="regtime"><?php echo $row_rs[regtime];?></a></li>
      <li>?????????????????????????????????????????????Bug?????????????????????????????????????????????<a id="regtime">2022-03-06 13:55:00</a></li>
      <?php do{?>
      <?php if ($totalRows_tg != "") {echo "
      	<li><a href='#tg' title=".$row_tg_b['time'].">???????????????????????????</a>
        	<a id='regtime'>'"; ?>
				<?php if($row_tg_b['time']!=''){echo $row_tg_b['time'];}else {echo '404 !no found!';} ?>
            <?php echo "</a>
        </li>
      ";}?>
       <?php if ($row_tg_b['release'] == "1") {echo "
      	<li><a href='#right' title=".$row_edit_b['time'].">???????????????????????????????????????</a>
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
??????????????????????????????????????????</p>
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
