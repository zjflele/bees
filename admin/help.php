<?php 
	include("../include/include.php");
	checklogin();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>后台BEES系统</title>
<link rel="stylesheet" href="body.css">
<base target="_self">
</head>

<body>

<table width="100%" height="28" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:1px solid #525C3D;">
  <tr>
    <td>&nbsp;&nbsp;<a href="help.php" class="hei">系统设置首页</a> 》后台首页</td>
  </tr>
</table>
<br>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #525C3D;">
    <tr>
      <td height="31" colspan="2" background="images/bg_menu.gif" class="bai cu" style="border-bottom:1px solid #525C3D;">&nbsp;&nbsp;系统信息</td>
    </tr>
    <tr>
      <td width="25%" class="tdbg1 tddi ge">操作系统及 PHP</td>
      <td class="tdbg1 tddi ge"><? echo PHP_OS; ?>&nbsp;/&nbsp;PHP <? echo phpversion(); ?></td>
    </tr>
    <tr>
      <td width="25%" class="tdbg2 tddi ge">MySQL 版本</td>
      <td class="tdbg2 tddi ge"><?=mysql_get_server_info();?></td>
    </tr>
   <tr>
      <td width="25%" class="tdbg1 tddi ge">技术支持</td>
      <td class="tdbg1 tddi ge">河北省林业信息中心 </td>
    </tr>
    <tr>
      <td class="tdbg2 ge">程序说明</td>
      <td class="tdbg2 ge">请选择左侧功能菜单进行操作.如果长时间不操作,请您重新登录.</td>
    </tr>
  </table>
<? include "foot.php"; ?>

</body>

</html>