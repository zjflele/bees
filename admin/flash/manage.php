<?php
	include("../../include/include.php");
	if(@$_GET["action"]=="del" && @$_GET["id"])
	{
		$obj = new EasyDB(flash);
		$obj->IDVars="id";
		$obj->SetLimit(1);
		$ninfo = getrow("select other from ".TABLEPRE."flash where id=".$_GET['id']);
		if($obj->Delete())
		{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("删除信息成功!");
			$js->GoToUrl($_SERVER["PHP_SELF"]);
			$js->End();
		}
		else
		{
			Error("删除信息失败。", $_SERVER["PHP_SELF"]);
		}
		exit();
	}
	$sqlstr_tt="select * from ".TABLEPRE."flash where id<>'' and siteid=".$_SESSION['bees_SiteId'];
	if ($other<>"")
	$sqlstr_tt.=" and other like '%$other%'";
	if ($add_time<>"")
	$sqlstr_tt.=" and add_time = '$add_time'";	
	$sqlstr_tt.=" order by show_time desc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------分页设置------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?other=$other&add_time=$add_time";
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
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="../../include/prototype.js"></script>
<script language="javascript">
var bm_id;
 function allow(id)
 {
	bm_id = id;
 	if(id=='')
	{
		alert("参数错误");
	}
	else
	{
		var url = "allow.php";
		var para = "id="+bm_id;		
		var mystatus = new Ajax.Request(
			url,
			{
				method:'get',
				parameters:para,
				onComplete:ChangeToRefuse
			}	
		);
	}
 }
 
 
 function ChangeToRefuse()
 {
 alert("flash替换成功");
 document.location.reload();	
 }
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY><form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
        <TR class=header align=left>
          <TD colspan="2">ＦＬＡＳＨ管理</TD>
		  <TD width="91%" >
		    检索：相关说明   
		        <input type="text" name="other" value="<?=$other?>">
           时间：
           <input type="text" name="add_time" value="<?=$add_time?>">          
		   <input type="submit" name="Submit" value="检索">		   　
		   <a href="<?=$_SERVER["PHP_SELF"]?>"><FONT COLOR=RED>显示全部</FONT>	</A>	  </TD>
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
  <td width="5%">编号</td>
  <td width="67%">相关说明</td>
  <td width="12%" align="center">添加日期</td>
<td width="9%" align="center">操作</td>
<td width="7%" align="center">更新</td>
</tr>
<?
	while ($rec=mysql_fetch_array($myrs_qq))
	{
	$nn+=1;
?>
	<tr bgcolor="#F8F9FC"><td><?=$rec[Id]?></td><td><a href="../../upload/flash/<?=$rec[upfile]?>" target=_blank><?=$rec[other]?></a> <? if ($nn==1 and $rec[isshow]==1) echo "<font color=red>(正在使用)</font>";?></td><td><? echo $rec[add_time];?></td>
	<td align="center"><a href="manage.php?action=del&id=<?=$rec[Id]?>">删除</a></td>
	<td align="center"><? echo "<div id=\"status$rec[Id]\">";
//-----------------------------审核------------------------
echo "<input type=\"image\" src=\"../images/allow.gif\" onclick=\"allow($rec[Id])\" style=\"border:0\" />";
echo "</div>";?></td>
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
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
