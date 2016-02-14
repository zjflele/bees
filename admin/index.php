<?php 
	include("../include/include.php");
	checklogin();
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=gb2312">
<title><?php echo TITLE;?>>后台管理系统</title>
</head>

<?php if ($_SESSION['bees_UserGroup'] == -1) {?>
<frameset framespacing="0" border="0" frameborder="0" rows="65,*">
	<frame name="banner" scrolling="no" noresize target="contents" src="top_site.php">
	<frameset cols="165,*">
		<frame name="contents" target="main" src="menu_site.php" scrolling="yes">
		<frame name="main" src="help.php" scrolling="yes" target="_self">
	</frameset>
	<noframes>
	<body>

	<p>此网页使用了框架，但您的浏览器不支持框架。</p>

	</body>
	</noframes>
</frameset>
<?php }ELSE{?>
<frameset framespacing="0" border="0" frameborder="0" rows="65,*">
	<frame name="banner" scrolling="no" noresize target="contents" src="top.php">
	<frameset cols="165,*">
		<frame name="contents" target="main" src="menu.php" scrolling="yes">
		<frame name="main" src="help.php" scrolling="yes" target="_self">
	</frameset>
	<noframes>
	<body>

	<p>此网页使用了框架，但您的浏览器不支持框架。</p>

	</body>
	</noframes>
</frameset>
<?php }?>
</html>