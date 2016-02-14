<? include("include/include.php");
	$sqlstr_tt="select * from brick_article where id<>'' and pass=1 ";
	if ($sortid<>'')
	{
	$book=GetValueFromTable("book","sort","id=".$sortid);
	if ($book<>'' and $book<>0)
	{ header("location:menu/index.php?id=$book");exit;}
   $usergroupname=GetValueFromTable("name","sort","id=".$sortid);
   $groupname=$usergroupname;
   $usergroupname=news_href($usergroupname);
   if ($usergroupname=='生态工程')
   {
    $sqlstr_tt=$sqlstr_tt." and sortsid like '%00002%' or sortsid like '%00003%' or sortsid like '%00006%' or sortsid like '%00010%' or sortsid like '%00011%' or sortsid like '%00075%' or sortsid like '%00086%' or sortsid like '%00007%' or sortsid like '%00009%' or sort_id = $sortid";  
    $ishref=1;
   }
   if ($usergroupname=='林板产业')
   {
   $sqlstr_tt=$sqlstr_tt." and sortsid like '%00121%' or sortsid like '%00122%' or sortsid like '%00123%' or sort_id = $sortid";
   $ishref=1;
   }
    if ($usergroupname=='集体林权改革')
   {
   $sqlstr_tt=$sqlstr_tt." and sortsid like '%00203%' or sortsid like '%00202%' or sortsid like '%00204%' or sortsid like '%00199%' or sort_id = $sortid";
   $ishref=1;
   }
   if ($ishref<>1)
   {
  // echo $usergroupname;
  $sortsid=GetValueFromTable("categoriseid","brick_categorise","categorisename = '$usergroupname'");
  $myrange=strlen($sortsid);
	if($myrange<5){
		$u=5-$myrange;
		for($mmm=0;$mmm<$u;$mmm++){
			$ling.='0';
			
		}
	}
  $sqlstr_tt=$sqlstr_tt." and sortsid like '%".$ling.$sortsid."%' or sort_id = $sortid";
  }  
  }
  if ($keyword<>'')
  $sqlstr_tt=$sqlstr_tt." and (title like '%".addslashes($keyword)."%' or text like '%".addslashes($keyword)."%')";  
  $sqlstr_tt=$sqlstr_tt."  order by date desc"; 
 // echo $sqlstr_tt;
  ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=TITLE?></title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="images/index.css" rel="stylesheet" type="text/css" />
<link href="images/index_css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
-->
</style></head>

<body>
<table width="980" height="155" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><? include("include/head.php")?></td>
  </tr>
</table>
<table width="980" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#FFFFDA"></td>
  </tr>
</table>
<table width="980" height="619" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="207" valign="top" bgcolor="#E0FFC5"><? include("include/left.php")?></td>
    <td width="773" valign="top" bgcolor="#FFFFDA" class="bj">
    <? if ($keyword<>'') {?>
    搜索关键字：<font color=red><?=$keyword?></font><? } else {?>
	当前位置：<a href="/index.php">首页</a>-><a href="list.php?sortid=<?=$sortid?>"><?=$groupname?></a>
	<? }?>
	<TABLE cellSpacing=1 cellPadding=0 width="99%" align=center border=0 bgcolor="#000000">
  <TBODY>
    <TR> <br>   
      <TD align=middle vAlign=top bgColor=#ffffda>
	  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
             <td>
			 <?
  $myrs_tt=mysql_query($sqlstr_tt);
  $myrs=mysql_query($sqlstr_tt,$myconn);
  $rec_tt=mysql_num_rows($myrs_tt);
  $i=$rec_tt;
//--------------------分页设置---------------
  $pagesize=20;//每页显示的贴数！
  if (empty($currentpage))$currentpage=1;
  $filename="list.php?1=1&sortid=$sortid&keyword=$keyword";
  $totalpage=ceil($i/$pagesize);
  if ($currentpage > $totalpage)
  $currentpage =$totalpage;
  $offset=($currentpage-1)*$pagesize;
//--------------------分页设置---------------
  $sqlstr2=$sqlstr_tt." limit $offset,$pagesize";
  //echo $sqlstr2;
if ($i==0)
echo "<div align=left>&nbsp;&nbsp;&nbsp;无信息！</div>";
else if ($i<>0)
{
$myrs=mysql_query($sqlstr2,$myconn);
//---------------------------------------------------------
echo "<table border=0 cellpadding=2 cellspacing=0 width=100%>\n";

$ii=0;
while ($row=mysql_fetch_array($myrs))
{ 
echo "<tr style=\"LINE-HEIGHT: 120%\"><td class=\"f14-140\" height=15>\n";
echo "<font style=\"FONT-SIZE: 9px; FONT-FAMILY: wingdings\">※ </font> ";

echo "<a href=showarticle.php?id=$row[id] title=\"点击查看\" target=_blank>";
echo "$row[title]</a> ";
echo "<font color=#999999> (".substr($row[date],0,10).")点击次数：".$row["counts"]."</font><br>\n";
$ii++;
if ($ii==5)
{
$ii=0;
echo "<font color=#CCCCCC>-----------------------------------------------------------------------------</font><br>";
}

echo "</td>\n";
echo "</tr>\n";
} // while
echo "</table>\n";
}
   if ($i != 0)  //--------------if01--------------------
{
$start=$currentpage*$pagesize; 
$n=$totalpage;
echo "<table border=0 cellpadding=0 cellspacing=0 class=pc1 width=100%>";
echo "<form method=Post action=$filename >";
echo "<tr><td class=pc1 colspan=3 height=26>";

  echo "<div align=center><strong>分页显示:</strong> <font color=red> 第".$currentpage."页/总".$n."页 | 总".$i."条</font> ";
  if ($currentpage<2 )
    echo "| <font color=#999999>首页</font> | <font color=#999999>上一页</font> ";
  else
    echo "| <a href=".$filename."&&currentpage=1>首页</a> | <a href=".$filename."&&currentpage=".($currentpage-1).">上一页</a> ";
  if ($n-$currentpage<1)
    echo "| <font color=#999999>下一页</font> | <font color=#999999>尾页</font> ";
  else
    echo "| <a href=".$filename."&&currentpage=".($currentpage+1).">下一页</a> | <a href=".$filename."&&currentpage=$n>尾页</a> ";
   echo  " 转到：<input type='text' name='currentpage' size=2 maxlength=10 class=smallInput value='$currentpage'>";
   echo  "&nbsp;<input class=buttonface type='submit'  value='GoTo'  name='cndok'>";
echo "</td></tr>";
echo "</form>";
echo "</table>";
}//-----------end if------------
?>
			 </td>
          </tr>
        </table>
      </TD>
    </TR>
  </TBODY>
</TABLE>
	</td>
  </tr>
</table>
<table width="980" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><? include("include/foot.php")?></td>
  </tr>
</table>
</body>
</html>
