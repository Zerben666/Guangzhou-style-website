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
<title>南粤旅游</title>
<link href="../SpryAssets/style-starter.css" rel="stylesheet" type="text/css">
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
  </nav>
</section>
 <!--  Main banner section -->
 <span class="banner-info container"><img src="../images/nyly/time.jpg" alt="about image" class="img-fluid"></span>
 <section class="w3l-main-banner" id="home">
  <div class="companies20-content">
    <div class="companies-wrapper">
        <div class="item">
         
            <div class="slider-info banner-view text-center">
              <div class="banner-info container">
                <h3 class="banner-text mt-5">Welcome to GuangZhou!
                  </h3>
                  <p class="my-4 mb-5">Sheep City</p><br>
               
              </div>
            </div>
          
        </div>
    </div>
  </div>
</section>
 <!--  //Main banner section -->
<section class="w3l-about ">
<div class="skills-bars py-5">
 <div class="container py-md-3">
  <div class="heading text-center mx-auto">
    <h3 class="head">欢迎来到美丽的广州</h3>
    <p class="my-3 head">传说广州最早的地名为“楚庭”（或“楚亭”）。越秀山上的中山纪念碑下，尚有清人所建一座石牌坊，上面刻着“古之楚亭”四字。不少史籍将“楚庭”视为广州的雏型，是广州最早的称谓，距今已有2847年。传说有五位仙人，身穿五彩衣，骑着五色羊，拿着一茎六穗的优良稻谷种子，降临“楚庭”，将稻穗赠给当地人民，并祝福这里永无饥荒。说完后，五位仙人便腾空而去，五只羊则变成了石头。当地人民为纪念五位仙人，修建了一座五仙观，传说五仙观即为“楚庭”所在。由此，广州又有“羊城”、“穗城”的别名。</p>
      
    </div>
<div class="row mt-5 pt-3">
    <div class="col-lg-4 col-md-4 col-sm-6 skills-bar-grids mb-4 pb-2">
        <h4>人均占地率</h4>
        <div class="progress">
        <div class="progress-bar progress-bar-striped bg-color" role="progressbar" style="width: 50% ;height:4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
      </div>
    </div>
</div>
    <div class="col-lg-4 col-md-4 col-sm-6 skills-bar-grids mb-4 pb-2">
        <h4>人均GDP</h4>
        <div class="progress">
        <div class="progress-bar progress-bar-striped bg-color" role="progressbar" style="width: 80% ;height:4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
      </div>
    </div>
</div>
<div class="col-lg-4  col-md-4 col-sm-6 skills-bar-grids mb-4 pb-2">
    <h4>人均生产总值</h4>
    <div class="progress">
    <div class="progress-bar progress-bar-striped bg-color" role="progressbar" style="width: 60% ;height:4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
  </div>
</div>
</div>
<div class="col-lg-4  col-md-4 col-sm-6 skills-bar-grids mb-4 pb-2">
    <h4>发展程度</h4>
    <div class="progress">
    <div class="progress-bar progress-bar-striped bg-color" role="progressbar" style="width: 70% ;height:4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
  </div>
</div>
</div>
<div class="col-lg-4  col-md-4 col-sm-6 skills-bar-grids mb-4 pb-2">
    <h4>城市绿化占地率</h4>
    <div class="progress">
    <div class="progress-bar progress-bar-striped bg-color" role="progressbar" style="width: 90% ;height:4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
  </div>
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-6 skills-bar-grids ">
    <h4>人均消费支出</h4>
    <div class="progress">
    <div class="progress-bar progress-bar-striped bg-color" role="progressbar" style="width: 80% ;height:4px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
  </div>
</div>
</div>

 </div>
 </div>
</div>
 </section>
<section class="w3l-feature-3" id="features">
	<div class="grid top-bottom">
		<div class="container">
			<div class="heading text-center mx-auto">
                <h3 class="head text-white">历史沿革</h3>
                <p class="my-3 head text-white">秦朝，广州一直是郡治、州治、府治的行政中心。在秦末汉初与唐末，广州曾经两次出现过割据的小国，秦末期为南越国，赵佗（秦的南海尉）自立为南越王，广州成为南越王都城（公元前206年至111年）。唐代末期刘岩（又名刘龚）据广州称帝， 国号南汉（公元917年至971年）以广州作都城（当时称兴王府）。广州地区自秦代（公元前214年）定为南海郡开始，历代以来它的行政管辖地区，最小的范围也据有现广东省的中部与北部，最大的范围包括现广东、广西的大部地区。</p>
              </div>
			<div class="middle-section grid-column text-center mt-5 pt-3">
				<div class="three-grids-columns">
					<span class="fa fa-paint-brush"></span>
					<h4>公元前214年</h4>
					<p>秦始皇统一岭南后，在广州地区设南海郡。 当时南海郡尉任嚣在现中山四路旧仓巷附近修建城廓，称为“任嚣城”，广州为郡治所在地。秦汉时南海郡行政管辖范围北至观坪石，东至福建的漳浦附近，西至湛江，面积约14万平方千米，后赵佗续任南海郡尉。秦朝为了巩固在岭南的统治，从中原迁居五十万居民到岭南，其后经过两晋、两宋、明末三次中原移民高潮，逐渐形成了广府、客家与福佬民系三大民系，并形成独特的岭南文化。秦末汉初时，赵佗自立为南越武帝，并把管辖范围扩展到雷洲半岛与广西、桂林地区，以及越南北部。</p>
					
				</div>
				<div class="three-grids-columns">
					<span class="fa fa-ils"></span>
					<h4>公元前111年</h4>
					<p>汉武帝平定了南越国后，把原赵佗割据地区划分为九郡（后缩为七郡），广州仍称南海郡，归属交趾部后称交州， 南海郡行政范围缩小。交州治所在地曾移至广西梧州，广州城曾一度较前衰落。东汉末年，广州属于吴国，公元216年吴国交州刺史步骘把交州治从梧州迁回广州，公元226年并将交州改为广州，广州之名由此开始。汉代广州地区行政范围面积约10.5万平方千米。</p>
					
				</div>
				<div class="three-grids-columns">
					<span class="fa fa-camera"></span>
					<h4>公元970年</h4>
					<p>宋平南汉后，废兴王府仍称为广州（以后一直沿用广州名称），广州为广南东路路治地（简称广东。广东省之称自此开始）。广州行政区域范围面积约4.3万平方千米。元、明、清各朝代，广州先后称广州路（元代），广州府（明、清时），均为省治地（元代广东省称广东道， 明代称广东布政司，清称广东省）。行政区域范围虽有变化，但不大，直到清代广州府行政区域面积约3.1万平方千米。
                    </p>
					
				</div>
			</div>
		</div>
	</div>
</section>
<div class="products-4" id="portfolio">
    <!-- Products4 block -->
    <div id="products4-block" class="text-center">
        <div class="container">
            <div class="heading text-center mx-auto mb-5">
                <h3 class="head">羊城风景</h3>
                <p class="my-3 head">广州位于东经112度57分至114度3分，北纬22度26分至23度56分。市中心位于北纬23度06分32秒，东经113度15分53秒。</p>
              </div>
            <input id="tab1" type="radio" name="tabs" checked>
            <label class="tabtle" for="tab1">南沙大角山海滨公园</label>

            <input id="tab2" type="radio" name="tabs">
            <label class="tabtle" for="tab2">花城广场</label>

            <input id="tab3" type="radio" name="tabs">
            <label class="tabtle" for="tab3">白云山</label>

            <input id="tab4" type="radio" name="tabs">
            <label class="tabtle" for="tab4">海心沙</label>

            <section id="content1" class="tab-content text-left">
                <div class="d-grid grid-col-3">
                    <div class="product">
                        <a href="assets/images/content1.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/content1.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/content2.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/content2.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/content3.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/content3.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/content4.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/content4.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/content5.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/content5.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                       
                    </div>
                    <div class="product">
                        <a href="assets/images/content6.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/content6.jpg" class="img-responsive" alt="" height="235px">
                            </figure>
                        </a>
                        
                    </div>
                    
                    
                </div>
            </section>

            <section id="content2" class="tab-content text-left">
                <div class="d-grid grid-col-3">
                    <div class="product">
                        <a href="assets/images/a1.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/a1.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/a2.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/a2.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                       
                    </div>
                    <div class="product">
                        <a href="assets/images/a3.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/a3.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                       
                    </div>
                    <div class="product">
                        <a href="assets/images/a4.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/a4.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                       
                    </div>
                    <div class="product">
                        <a href="assets/images/a5.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/a5.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/a6.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/a6.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                </div>
            </section>

            <section id="content3" class="tab-content text-left">
                <div class="d-grid grid-col-3">
                    <div class="product">
                        <a href="assets/images/b1.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/b1.jpg" class="img-responsive" alt="" height="193px">
                            </figure>
                        </a>
                      
                    </div>
                    <div class="product">
                        <a href="assets/images/b2.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/b2.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                       
                    </div>
                    <div class="product">
                        <a href="assets/images/b6.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/b6.jpg" class="img-responsive" alt="" height="193px">
                            </figure>
                        </a>
                        
                    </div>
                </div>
            </section>

            <section id="content4" class="tab-content text-left">
                <div class="d-grid grid-col-3">
                    <div class="product">
                        <a href="assets/images/i1.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/i1.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                    <div class="product">
                        <a href="assets/images/i2.jpg" data-lightbox="example-set"
                            data-title="点击我查看大图">
                            <figure>
                                <img src="../images/nyly/i2.jpg" class="img-responsive" alt="" />
                            </figure>
                        </a>
                        
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Products4 block -->
</div>
<!-- <script src="assets/js/jquery-3.3.1.min.js"></script> -->
<script src="../SpryAssets/lightbox-plus-jquery.min.js"></script>
<section class="services-12" id="experience">
	<div class="form-12-content">
		<div class="container">
			<div class="grid grid-column-2 ">
				
				<div class="column1">
          <h3 class="mb-5">经济</h3>
					<div class="experience-top">
            <h5>2020</h5>
						<h4>综述</h4>
						<p class="my-3 text-white">2020年我市地区生产总值25019.11亿元，同比增长2.7%。其中，第一产业增加值为288.08亿元，同比增长9.8%；第二产业增加值为6590.39亿元，同比增长3.3%；第三产业增加值为18140.64亿元，同比增长2.3%。“十三五”期间，广州地区生产总值从18560亿元提高到25019亿元，5年跨越7个千亿元台阶，年均增长6%。人均地区生产总值突破2万美元，达到高收入经济体水平。</p>
            </div>
            <div class="experience-top">
              <h5>2017</h5>
              <h4>综述</h4>
              <p class="my-3 text-white">广州汽车产量达310.8万辆，产量居全国第一。2016年，广州汽车工业总产值达4346.27亿元，成为第一大支柱产业。2017年，广州市软件和信息服务业营业收入首次突破3000亿元，增长18%左右，已成为支柱产业之一 [39]  。2017年实现金融业增加值1998.76亿元，同比增长8.6%，占GDP的比重达9.3%，成为广州市第五大支柱产业和第四大经济增长引擎 [43]  。广州智能装备及机器人产业规模已近500亿元，机器人生产量在全国排第二位，已形成从上游关键零部件、中游整机到下游系统集成的机器人完整产业链条 [44]  。广州市邮政业业务总量突破600亿元，其中快递业务量完成28.67亿件，居全国第一 [45]  。跨境电子商务规模居全国第一。</p>
              </div>
              <div class="experience-top">
                <h5>2016</h5>
                <h4>综述</h4>
                <p class="my-3 text-white">广州新增高新技术企业4000家以上，增量仅次于北京，总数超过8700家。2017年广州专利申请量11.8332万件，同比增长33.3%，其中发明专利申请量3.6941万件，同比增长29.5%；PCT国际专利申请量2441件，同比增长48.7%；发明专利授权量9345件，同比增长21.9%。 [50-51]  广州硬科技发展指数居全国前三位 [52]  。2018年1－6月，广州专利申请量达85526件，同比增长52.8%。</p>
                </div>
					</div>
					<div class="column2">
            <h3 class="mb-5">三大产业</h3>
            <div class="experience-top">
              <h5>第一产业</h5>
              <h4>农业</h4>
              <p class="my-3 text-white">2019年广州都市农业总收入2353.98亿元，增长8.6%。都市农业总产值1672.23亿元，增长6.9%。市级以上农业龙头企业达到233家，其中，国家级龙头企业11家，省级龙头企业73家。农业产业化产值74.58亿元，增长3.4%；农业产业化规模达20.8%，提高3.5个百分点。</p>
              </div>
              <div class="experience-top">
                <h5>第二产业</h5>
                <h4>工业</h4>
                <p class="my-3 text-white">2019年，广州工业增加值5722.94亿元，比上年增长4.8%。规模以上高技术制造业增加值增长21.0%，其中，医药制造业增长16.8%，航空航天器制造业增长10.4%，电子及通信设备制造业增长24.1%，电子计算机及办公设备制造业下降 10.5%，医疗设备及仪器仪表制造业增长33.0%。规模以上汽车制造业、电子产品制造业和石油化工制造业三大支柱产业工业总产值增长1.5%，占全市规模以上工业总产值的比重51.4%。其中，汽车制造业下降0.5%，电子产品制造业增长5.2%，石油化工制造业增长2.2%。</p>
                </div>
                <div class="experience-top">
                  <h5>第三产业</h5>
                  <h4>商业</h4>
                  <p class="my-3 text-white">广州五次被福布斯评为中国大陆最佳商业城市第一位 [65]  。2017年，广州实现社会消费品零售总额9402.6亿元，同比增长8%，连续30年稳居全国第三 [66]  。住宿餐饮业零售额以1143.24亿元的总量位居全国第一 [67]  。人均消费品零售额居中国第一位。商品进出口总值9995.81亿元，比上年增长1.9%。其中，商品出口总值5257.98亿元，下降6.2%；商品进口总值4737.83亿元，增长12.7%。</p>
                    <p class="my-3 text-white">2017年，广州实现金融业增加值1998.76亿元，同比增长8.6%，占GDP的比重达9.3%，成为广州市第五大支柱产业和第四大经济增长引擎,比年初增加4325.25亿元.</p>
                  </div>
					</div>
			</div>
		</div>
	</div>
</section><!-- InstanceEndEditable -->
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
