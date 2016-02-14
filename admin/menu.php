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
		<li><a href="group/news_group.php">种类设置</a></li> 
		<li><a href="webset.php">网站相关设置</a></li>
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
	<div class="til1 bai cu" onClick="showsubmenu(3);" style="cursor:hand;">::数据管理::</div>
	<div class="lmemo hei" id='submenu3'>
	<ul>
		<li><a href="news/news.php?type=1">数据添加</a></li>
		<li><a href="news/news_manage.php">数据管理</a></li>		
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
	<div class="til1 bai cu" onClick="showsubmenu(4);" style="cursor:hand;">::图片审核::</div>
	<div class="lmemo hei" id='submenu4'>
	<ul>
		<li><a href="picture/pic_manage.php">图片审核</a></li>
		
	  </ul>
	</div>
</div>
<?
}
if($showid==4)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(5);" style="cursor:hand;">::验证码管理::</div>
	<div class="lmemo hei" id='submenu5'>
	<ul>
		<li><a href="yanzhengma/add.php">验证码添加</a></li>
		<li><a href="yanzhengma/manage.php">验证码管理</a></li>
	</ul>
	</div>
</div>
<?
}
?>

<div class="til bai cu"><a href="logout.php" target="_top">退  出</a></div>

</body>

</html>