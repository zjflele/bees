<?php
	include("../../include/include.php");
	checklogin();	
	$arr = getlist("select * from ".TABLEPRE."index_set order by fid asc");
	foreach ($arr as $v){
		$arrResult[$v[fid]] = $v;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>首页设置</title>
<link rel="stylesheet" href="/js/nyroModal/nyroModal.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/nyroModal/jquery.min.js"></script>
<script type="text/javascript" src="/js/nyroModal/jquery.nyroModal.pack.js"></script>

</head>

<body>
<table width="200" border="1">
  <tr>
    <td><?=$arrResult[1]['ftitle']?></td>
    <td>&nbsp;</td>
    <td><a href="./news_set.php?id=1" target="_blank" class="nyroModal STYLE1">设置</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>


<table width="200" border="1">
  <tr>
    <td><?=$arrResult[2]['ftitle']?>[<a href="./sort_set.php?id=2" target="_blank" class="nyroModal STYLE1">设置</a>]</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="200" border="1">
  <tr>
    <td><?=$arrResult[3]['ftitle']?>[<a href="./sort_set.php?id=3" target="_blank" class="nyroModal">设置</a>]</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<table width="200" border="1">
  <tr>
    <td><?=$arrResult[4]['ftitle']?>[<a href="./html_set.php?id=4" target="_blank" class="nyroModal">设置</a>]</td>
    <td>&nbsp;</td>
    <td><a href="<?=$arrResult[4]['flink']?>">更多</a></td>
  </tr>
 <?=$arrResult[4]['fcontent']?>
</table>
</body>
</html>
