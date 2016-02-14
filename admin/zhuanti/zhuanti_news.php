<?php
	include("../../include/include.php");
	if(@$_GET["action"]=="del" && @$_GET["nid"])
	{		
		$obj = new EasyDB('zhuanti_news');
		$obj->IDVars="nid";
		$obj->SetLimit(1);
		
		if($obj->Delete())
		{	
			$js=new Javascript();
			$js->Begin();
			$js->Alert("删除信息成功!");
			$js->End();
		}
	}
	
	
	if(@$_GET["id"])
	{
		$zid = intval($_GET["id"]);
		//获取专题名称
		$zhuanti_name = GetValueFromTable('title',TABLEPRE.'zhuanti',"id=".$zid);
		//获取专题分类
		$zhuanti_sort_sql = "select sid,sname from ".TABLEPRE."zhuanti_sort where isshow=1 and zid=".$zid;
		$zhuanti_sort_myrs = mysql_query($zhuanti_sort_sql,$myconn);
		while($row = mysql_fetch_array($zhuanti_sort_myrs)){
			$arrSortList[$row['sid']] = $row['sname']; 
		}
	}
	
	
	
	$sqlstr_tt="select * from ".TABLEPRE."zhuanti_news where sid in (select sid from ".TABLEPRE."zhuanti_sort where isshow=1 and zid=$zid)";
	if ($title<>"")
	$sqlstr_tt.=" and title like '%$title%'";
	
	$sqlstr_tt.=" order by addtime desc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------分页设置------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?id=$zid&title=$title";
    $totalpage=ceil($i/$pagesize);
    if ($totalpage<$currentpage)
    $currentpage = $totalpage;
    $offset=($currentpage-1)*$pagesize;
    $offend=$offset+20;
//-----------分页设置----------
    $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
	//echo $sqlstr;
    $myrs_tt=mysql_query($sqlstr);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY><form name="form1" method="post" action="zhuanti_news.php?id=<?=intval($_GET['id'])?>">
        <TR class=header align=left>
          <TD colspan="2"><?=$zhuanti_name?> --专题内容管理</TD>
		  <TD width="74%" >
		    检索：标题   
		        <input type="text" name="title" value="<?=$title?>">
		        <input type="submit" name="Submit" value="检索">	
				<input type="button" onClick="javascript:window.location.href='zhuanti_news.php?id=<?=intval($_GET['id'])?>';" value="显示全部">	
				<input type="button" onClick="javascript:window.location.href='zhuanti_news_add.php?id=<?=intval($_GET['id'])?>';" value="添加内容">    　
		    </TD>
          </TR> </form>
        <TR>
          <TD height="543" colspan="3" valign="top" bgColor=#f8f9fc>
		     <?
   if ($i != 0)  //--------------if01--------------------
{
   $myrs_qq=mysql_query($sqlstr,$myconn);
   //echo $sqlstr2;
   $ii=$offset+1;
?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr> 
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">
<table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr class="header">
  <td width="8%">编号</td>
  <td width="37%">标题</td>
  <td width="20%">分类</td>
  <td width="15%" align="center">添加日期</td>
<td width="20%" align="center">操作</td>
</tr>
<?
	while ($rec=mysql_fetch_assoc($myrs_qq))
	{	
	//print_r($rec);exit;
?>
	<tr bgcolor="#F8F9FC"><td><?=$rec[nid]?></td><td><a href="/zhuanti/index.php?ac=show&id=<?=intval($_GET['id'])?>&nid=<?=$rec[nid]?>" target="_blank"><?=$rec[title]?></a></td>
	<td><?=$arrSortList[$rec['sid']]?></td>
	<td><? echo substr($rec[addtime],0,10);?></td>
	<td align="center"><a href="zhuanti_news_edit.php?id=<?=intval($_GET['id'])?>&nid=<?=$rec[nid]?>">编辑</a> | <a href="zhuanti_news.php?action=del&id=<?=intval($_GET['id'])?>&nid=<?=$rec[nid]?>">删除</a></td>
	</tr>
<?
	}
?>
</table></td></tr></table>  </td>
              </tr>
            </table>
				</td>
              </tr>
            </table>
			<? } else { echo "没有信息";}?>
<?
//开始构建分页显示------------------------------------------------------ 
$start=$currentpage*$pagesize; 
$n=$totalpage;
 echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";
 echo "<form method=Post action=$filename ><tr><td align=right height=25>";
 echo "查询结果：<b><font color=#ff0000>$i</font></b>个 ";
  if ($currentpage<2 )
    echo "首页 上一页 ";
  else
    echo "<a href=".$filename."&&currentpage=1>首页</a> <a href=".$filename."&&currentpage=".($currentpage-1).">上一页</a>  ";
  if ($n-$currentpage<1)
    echo " 下一页 尾页 ";
  else
    echo " <a href=".$filename."&&currentpage=".($currentpage+1).">下一页</a> <a href=".$filename."&&currentpage=$n>尾页</a> ";

   echo  "<strong><font color=#ff0000>$currentpage</font>/$n</strong>页  ";
   echo  "<b><font color=#ff0000>$pagesize</font></b>个/页 ";
   echo  " 转到：<input type='text' name='currentpage' size=2 maxlength=10 class=smallInput value='$currentpage'>";
   echo  "&nbsp;<input class=buttonface type='submit'  value='Go'  name='cndok'></td></tr></form></table>";
?>			
		  </TD>
		  </tr>
          <td width="11%">
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
