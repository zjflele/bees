<?php
	include("../../include/include.php");
	checklogin();
	if(@$_GET["action"]=="del" && @$_GET["id"])
	{
		$obj = new EasyDB(video);
		$obj->IDVars="id";
		$obj->SetLimit(1);
		$ninfo = getrow("select title from ".TABLEPRE."video where id=".$_GET['id']);
		if($obj->Delete())
		{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("ɾ����Ϣ�ɹ�!");
			$js->GoToUrl($_SERVER["PHP_SELF"]);
			$js->End();
		}
		else
		{
			Error("ɾ����Ϣʧ�ܡ�", $_SERVER["PHP_SELF"]);
		}
		exit();
	}	
	if(@$_GET["action"]=="top" && @$_GET["id"]){
			$sql="UPDATE ".TABLEPRE."video SET `istop` = 1  WHERE id=".intval($_GET["id"]);	
			mysql_query($sql,$myconn);		
	}
	if(@$_GET["action"]=="notop" && @$_GET["id"]){
			$sql="UPDATE ".TABLEPRE."video SET `istop` = 0  WHERE id=".intval($_GET["id"]);	
			mysql_query($sql,$myconn);		
	}
	$swhere = ($_SESSION['bees_SiteId'])? "and siteid=".$_SESSION['bees_SiteId']:'';
	$sqlstr_tt="select * from ".TABLEPRE."video where id<>'' ".$swhere;	
	if ($vtype<>"")
		$sqlstr_tt.=" and vtype = ".intval($vtype);	
	if ($title<>"")
		$sqlstr_tt.=" and title like '%$title%'";
	if ($username<>"")
		$sqlstr_tt.=" and username = '$username'";	
	if ($update<>"")
		$sqlstr_tt.=" and addtime like '%$update%'";	
	if ($s_date)
		$sqlstr_tt.=" and addtime>='$s_date'";
	if ($e_date)
		$sqlstr_tt.=" and addtime<='$e_date'";
	
	$sqlstr_tt.=" order by istop desc ,addtime desc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------��ҳ����------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?title=$title&update=$update&username=$username";
    $totalpage=ceil($i/$pagesize);
    if ($totalpage<$currentpage)
    $currentpage = $totalpage;
    $offset=($currentpage-1)*$pagesize;
    $offend=$offset+20;
//-----------��ҳ����----------
    $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
	//echo $sqlstr;
    $myrs_tt=mysql_query($sqlstr);
	
//-----------�û���Ϣ�б�----------
	$arrUserList = getUserList();
	//print_r($arrUserList);
		
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
          <TD colspan="2">��Ƶ����</TD>
		  <TD width="91%" >          	
		   ���������˵��   
		        <input type="text" name="title" value="<?=$title?>">
           ʱ�䣺
           <input type="text" name="update" value="<?=$update?>">����          
		   <?php if (!$_SESSION['bees_SiteId']){ ?>
           �����ߣ�
           <select name="username" id="username">
		   <option value=''>��ѡ���û�</option>
		   <? 
		   foreach ($arrUserList as $k => $v){
			   	$selected = ($username == $v['username'])?'selected':'';
		   		echo "<option value='".$v['username']."' $selected>".$v['zname']."</option>";			
		   }?>
		   </select>
           <?php }?>
		   <input type="submit" name="Submit" value="����">		   ��
		   <a href="<?=$_SERVER["PHP_SELF"]?>"><FONT COLOR=RED>��ʾȫ��</FONT>	</A>	  </TD>
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
                <td>
                
<table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">

<table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr class="header">
  <td width="5%">���</td>
  <td>��Ƶ����</td>
  <td>������</td>
  <td width="12%" align="center">�������</td>
<td colspan="3" align="center">��������</td>
</tr>
<?
	while ($rec=mysql_fetch_array($myrs_qq))
	{
	$nn+=1;
?>
	<tr bgcolor="#F8F9FC"><td><?=$rec[id]?></td>
	<td><a href="../../show_video.php?id=<?=$rec[id]?>" target=_blank><? echo $rec[title]?></a></td>
    <td><? echo ($rec[siteid])?$arrUserList[$rec[siteid]]['zname']:'';?></td>
	<td><? echo $rec[addtime];?></td>
    
    <?php  if ($rec['istop']){?>
    	<td width="9%" align="center">
    		<a href="manage.php?action=notop&currentpage=<?=$currentpage?>&id=<?=$rec[id]?>">ȡ���ö�</a>
        </td>	
    <?php }else{?>
    	<td width="9%" align="center">
    		<a href="manage.php?action=top&currentpage=<?=$currentpage?>&id=<?=$rec[id]?>">�ö�</a>
        </td>
    <?php }?>
    <td width="9%" align="center"><a href="edit.php?id=<?=$rec[id]?>">�༭</a></td>
	<td width="7%" align="center"><a href="manage.php?action=del&id=<?=$rec[id]?>">ɾ��</a></td>
	</tr>
<?
	}
?>
</table>

</td></tr></table>  

</td>
              </tr>
            </table>
				</td>
              </tr>
            </table>
            
			<? } else { echo "û����Ϣ";}?>
<?
//��ʼ������ҳ��ʾ------------------------------------------------------ 
$start=$currentpage*$pagesize; 
$n=$totalpage;
 echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";
 echo "<form method=Post action=$filename ><tr><td align=right height=25>";
 echo "��ѯ�����<b><font color=#ff0000>$i</font></b>�� ";
  if ($currentpage<2 )
    echo "��ҳ ��һҳ ";
  else
    echo "<a href=".$filename."&&currentpage=1>��ҳ</a> <a href=".$filename."&&currentpage=".($currentpage-1).">��һҳ</a>  ";
  if ($n-$currentpage<1)
    echo " ��һҳ βҳ ";
  else
    echo " <a href=".$filename."&&currentpage=".($currentpage+1).">��һҳ</a> <a href=".$filename."&&currentpage=$n>βҳ</a> ";

   echo  "<strong><font color=#ff0000>$currentpage</font>/$n</strong>ҳ  ";
   echo  "<b><font color=#ff0000>$pagesize</font></b>��/ҳ ";
   echo  " ת����<input type='text' name='currentpage' size=2 maxlength=10 class=smallInput value='$currentpage'>";
   echo  "&nbsp;<input class=buttonface type='submit'  value='Go'  name='cndok'></td></tr></form></table>";
?>			
		  </TD>
		  </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
