<?php 
	include("../include/include.php");
	checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̨ϵͳ</title>
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

<div class="til bai cu"><a href="/" target="_top">��վ��ҳ</a> | <a href="./index.php" target="_top">��̨��ҳ</a></div>

<?
if($showid==0)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(1);" style="cursor:hand;">::��������::</div>
	<div class="lmemo hei" id='submenu1'>
	<ul>
		<li><a href="group/news_group.php">��������</a></li> 
		<li><a href="webset.php">��վ�������</a></li>
	</ul>
  </div>
</div>

<?
}
if($showid==1)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(2);" style="cursor:hand;">::�û�ϵͳ::</div>
	<div class="lmemo hei" id='submenu2'>
	<ul>
		<li><a href="user/user_add.php">����û�</a></li>
		<li><a href="user/user_manage.php">�û�����</a></li>
		<li><a href="user/usergroup.php">�û������</a></li>
		<li><a href="user/usergroup_manage.php">�û������</a></li>
	</ul>
	</div>
</div>
<?
}
if($showid==2)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(3);" style="cursor:hand;">::���ݹ���::</div>
	<div class="lmemo hei" id='submenu3'>
	<ul>
		<li><a href="news/news.php?type=1">�������</a></li>
		<li><a href="news/news_manage.php">���ݹ���</a></li>		
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
	<div class="til1 bai cu" onClick="showsubmenu(4);" style="cursor:hand;">::ͼƬ���::</div>
	<div class="lmemo hei" id='submenu4'>
	<ul>
		<li><a href="picture/pic_manage.php">ͼƬ���</a></li>
		
	  </ul>
	</div>
</div>
<?
}
if($showid==4)
{
?>
<div class="larea">
	<div class="til1 bai cu" onClick="showsubmenu(5);" style="cursor:hand;">::��֤�����::</div>
	<div class="lmemo hei" id='submenu5'>
	<ul>
		<li><a href="yanzhengma/add.php">��֤�����</a></li>
		<li><a href="yanzhengma/manage.php">��֤�����</a></li>
	</ul>
	</div>
</div>
<?
}
?>

<div class="til bai cu"><a href="logout.php" target="_top">��  ��</a></div>

</body>

</html>