<?php
	include("../../include/include.php");
	$s_date = trim($_GET['s_date']);
	$e_date = trim($_GET['e_date']);
	$uname = trim($_GET['username']);
	$arrList = getSqlList("select count(*) as total_num,(select s.name from ".TABLEPRE."sort s where s.id=b.sort_id) as sort_name from ".TABLEPRE."article b where b.username='$uname' AND b.date>='$s_date' AND b.date<='$e_date' group by b.sort_id ");
	
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<table border="0" cellspacing="1" cellpadding="4" width="600" align="center">
  <tr class="header">
    <td width="300">分类名称</td>
    <td width="200" align="center">发布条数</td>
    <td width="100"v>查看</td>
  </tr>
  <?php if ($arrList){
			foreach ($arrList as $u => $arr){
?>
  <tr bgcolor="#F8F9FC">
    <td><?=$arr['sort_name']?></td>
    <td align="right"><?=$arr['total_num']?></td>
    <td align="right"><? if ($arr['total_num']) {?>
      [<a href="../news/news_manage.php?username=<?=$uname?>&s_date=<?=$s_date?>&e_date=<?=$e_date?>">详细数据</a>]
      <?php }?></td>
  </tr>
  <?
	}}
?>
</table>
</body>
</html>
