<?php
	include("../../include/include.php");
	checklogin();
	if(@$_GET["action"]=="del" && @$_GET["userid"])
	{
		$obj = new EasyDB("users");
		$obj->IDVars="userid";
		$obj->SetLimit(1);
		
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
	//用户组
	$sql="select id,groupname from ".TABLEPRE."usergroup where id <>''";
	$myrs=mysql_query($sql,$myconn);
	while($rec=mysql_fetch_array($myrs)){
		$usergroup[$rec['id']] = $rec['groupname'];
	}
	$sqlstr_tt="select * from ".TABLEPRE."users where groupid=-1  ";	
	if ($username<>'')
	$sqlstr_tt.=" and username = '$username'";
	if ($zname<>'')
	$sqlstr_tt.=" and zname like '%$zname%'";
	if ($istop)
	$sqlstr_tt.=" and istop = ".($istop-1);
	if ($cityid)
	$sqlstr_tt.=" and cityid = ".$cityid;
	if ($stype)
	$sqlstr_tt.=" and stype = ".$stype;
	if ($slevel)
	$sqlstr_tt.=" and slevel = ".$slevel;
	
	$sqlstr_tt.=" order by userid desc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------分页设置------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?1=1&username=$username&zname=$zname&istop=$istop&cityid=$cityid&stype=$stype&slevel=$slevel";
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
          <TD colspan="2">用户管理</TD>
		  <TD width="91%" > 检索：用户名：   
		        <input type="text" name="username" value="<?=$username?>">
		        子站名称：
		        <input type="text" name="zname" value="<?=$zname?>"> 
                推荐：
                <select name="istop">
                	<option value="0">全部</option>
                	<option value="2">是</option>
                    <option value="1">否</option>
                </select>
                类型：
                <select name="stype">
                	<option value="0">全部</option>
				<?php
                    foreach ($siteTypes as $k => $type ) {
                        echo "<option value=$k>$type</option>\n";
                    }
                ?>
                </select>
                级别：
                <select name="slevel">
                	<option value="0">全部</option>
				<?php
                    foreach ($siteLevels as $k => $level ) {
                        echo "<option value=$k>$level</option>\n";
                    }
                ?>
                </select>
		       <input type="submit" name="Submit" value="检索">		   　
		   <a href="<?=$_SERVER["PHP_SELF"]?>"><FONT COLOR=RED>显示全部</FONT>	</A>	</TD>
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
  <td width="7%">编号</td>
  <td width="25%">用户名</td>
  <td width="25%">用户名称</td>
  <td width="15%">所属地区</td>
  <td width="10%">推荐</td>
  <td colspan="2" align="center">操作</td>
</tr>
<?
	while ($rec=mysql_fetch_array($myrs_qq))
	{
	$nn+=1;
?>
	<tr bgcolor="#F8F9FC"><td><?=$rec[userid]?></td>
	<td><? echo $rec[username]?></td>
	<td><a href="../../site/?siteid=<?=$rec[userid]?>" target="_blank"><? echo $rec[zname]?></a></td>
	<td><a href="<?=$filename?>&cityid=<?=$rec[cityid]?>"><? echo $citys[$rec[cityid]]?></a></td>
    <td><? echo $rec['istop']?'是':'否';?></td>
	<td width="8%" align="center"><a href="site_edit.php?id=<?=$rec[userid]?>">编辑</a></td>
	<td width="8%" align="center"><a href="site_manage.php?action=del&userid=<?=$rec[userid]?>">删除</a></td>
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
