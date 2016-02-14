<?php 
	include("../include/include.php");
	checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>后台系统</title>
<link rel="stylesheet" href="css.css">
<SCRIPT language=javascript1.2>
function showsubmenu(sid)
{
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none")
{
eval("submenu" + sid + ".style.display=\"\";");
}
else
{
eval("submenu" + sid + ".style.display=\"none\";");
}
}
</SCRIPT>
<base target="main">
</head>

<?
	$showid=$_REQUEST["action"];
	if($showid=="") $showid=0;
?>

<body bgcolor="#DAE6F3" style="margin-left:7px;">

<div class="til bai cu"><a href="/" target="_top">网站首页</a> | <a href="./index.php" target="_top">后台首页</a></div>

<?
if($showid==0)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(1);" style="cursor:hand;">::基本设置::</div>
	<div class="lmemo hei" id='submenu1'>
	<ul>
		<li><a href="index_set/index_menu1.php">首页导航管理</a></li>
		<li><a href="index_img/add.php">轮换图添加</a></li>
		<li><a href="index_img/manage.php">轮换图管理</a></li>		
		<li><a href="flash/flash.php">首页FLASH添加</a></li>
		<li><a href="flash/manage.php">首页FLASH管理</a></li>
		<li><a href="../site/index_set.php" target="_blank">首页版块设置</a></li>
        <li><a href="site/sub_site_edit.php">本站相关设置</a></li>
		
	</ul>
  </div>
</div>
<?
}
if($showid==1)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(2);" style="cursor:hand;">::用户系统::</div>
	<div class="lmemo hei" id='submenu2'>
	<ul>
		<li><a href="user/user_add.php">添加用户</a></li>
		<li><a href="user/user_manage.php">用户管理</a></li>
		<li><a href="user/usergroup.php">用户组添加</a></li>
		<li><a href="user/usergroup_manage.php">用户组管理</a></li>
	</ul>
	</div>
</div>
<?
}
if($showid==2)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(3);" style="cursor:hand;">::文章管理::</div>
	<div class="lmemo hei" id='submenu3'>
	<ul>
		<li><a href="news/news.php?type=1">文章添加</a></li>
		<li><a href="news/news_manage.php">文章管理</a></li>		
	</ul>
  </div>
</div>

</div>
<?
}
if($showid==3)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(4);" style="cursor:hand;">::图片管理::</div>
	<div class="lmemo hei" id='submenu4'>
	<ul>
		<li><a href="picture/pic_manage.php?ptype=1"><?=$pictureType[1]?></a></li>         
	  </ul>
	</div>
</div>
<?
}
if($showid==4)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(5);" style="cursor:hand;">::视频管理::</div>
	<div class="lmemo hei" id='submenu5'>
	<ul>
		<li><a href="video/add.php">添加视频</a></li>
		<li><a href="video/manage.php">管理视频</a></li>
	</ul>
	</div>
</div>
<?
}
if($showid==5)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(6);" style="cursor:hand;">::广告位管理::</div>
	<div class="lmemo hei" id='submenu6'>
	<ul>
		<li><a href="index_ads/manage.php">对联广告位</a></li>
        <li><a href="index_ads/down_manage.php">首页广告位(上)</a></li>
        <li><a href="index_ads/bottom_manage.php">首页广告位(下)</a></li>
		
	</ul>
	</div>
</div>
<?
}
if($showid==7)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(6);" style="cursor:hand;">::市场行情::</div>
	<div class="lmemo hei" id='submenu6'>
	<ul>
            <li><a href="market/add.php">市场行情添加</a></li>
            <li><a href="market/manage.php">市场行情管理</a></li>	
	</ul>
	</div>
</div>
<?
}
if($showid==8)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(6);" style="cursor:hand;">::供求信息::</div>
	<div class="lmemo hei" id='submenu6'>
	<ul>
            <li><a href="buysell/manage.php">供求信息管理</a></li>	
	</ul>
	</div>
</div>
<?
}

if($showid==9)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(8);" style="cursor:hand;">::数据查询::</div>
	<div class="lmemo hei" id='submenu8'>
	<ul>
		<li><a href="visit/index.php">查看流量</a></li>
		<li><a href="count/index.php">数据查询统计</a></li>
	</ul>
	</div>
</div>
<?
}
?>

<div class="til bai cu"><a href="logout.php" target="_top">退  出</a></div>

</body>

</html>