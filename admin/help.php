<?php 
	include("../include/include.php");
	checklogin();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̨BEESϵͳ</title>
<link rel="stylesheet" href="body.css">
<base target="_self">
</head>

<body>

<table width="100%" height="28" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:1px solid #525C3D;">
  <tr>
    <td>&nbsp;&nbsp;<a href="help.php" class="hei">ϵͳ������ҳ</a> ����̨��ҳ</td>
  </tr>
</table>
<br>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #525C3D;">
    <tr>
      <td height="31" colspan="2" background="images/bg_menu.gif" class="bai cu" style="border-bottom:1px solid #525C3D;">&nbsp;&nbsp;ϵͳ��Ϣ</td>
    </tr>
    <tr>
      <td width="25%" class="tdbg1 tddi ge">����ϵͳ�� PHP</td>
      <td class="tdbg1 tddi ge"><? echo PHP_OS; ?>&nbsp;/&nbsp;PHP <? echo phpversion(); ?></td>
    </tr>
    <tr>
      <td width="25%" class="tdbg2 tddi ge">MySQL �汾</td>
      <td class="tdbg2 tddi ge"><?=mysql_get_server_info();?></td>
    </tr>
   <tr>
      <td width="25%" class="tdbg1 tddi ge">����֧��</td>
      <td class="tdbg1 tddi ge">�ӱ�ʡ��ҵ��Ϣ���� </td>
    </tr>
    <tr>
      <td class="tdbg2 ge">����˵��</td>
      <td class="tdbg2 ge">��ѡ����๦�ܲ˵����в���.�����ʱ�䲻����,�������µ�¼.</td>
    </tr>
  </table>
<? include "foot.php"; ?>

</body>

</html>