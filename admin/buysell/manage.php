<?php
	include("../../include/include.php");
	checklogin();	
	if(@$_GET["action"]=="del" && @$_GET["sellid"])
	{
		$obj = new EasyDB(TABLEPRE.buysell);
		$obj->IDVars="sellid";
		$obj->SetLimit(1);
		$ninfo = getrow("select title from ".TABLEPRE."buysell where sellid=".$_GET['sellid']);
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
	
	$sqlstr_tt="select * from ".TABLEPRE."buysell where sellid<>'' ";	
	if ($_SESSION['bees_SiteId'])
	$sqlstr_tt.=" and siteid = ".$_SESSION['bees_SiteId'];
	if ($typesort<>'')	
	$sqlstr_tt.=" and typesort like '%$typesort%'";
	if ($title<>'')
	$sqlstr_tt.=" and title like '%$title%'";
	if ($update<>'')
	$sqlstr_tt.=" and startdate like '%$update%'";	
	if ($status<>'')
	$sqlstr_tt.=" and pass = '$status'";
	$sqlstr_tt.=" order by sellid desc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------��ҳ����------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename="manage.php?title=$title&update=$update&typesort=$typesort&status=$status";
    $totalpage=ceil($i/$pagesize);
    if ($totalpage<$currentpage)
    $currentpage = $totalpage;
    $offset=($currentpage-1)*$pagesize;
    $offend=$offset+20;
//-----------��ҳ����----------
    $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
	//echo $sqlstr;
    $myrs_tt=mysql_query($sqlstr);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script type="text/javascript" src="../../include/prototype.js"></script>
<script language="javascript">
var bm_id;
 function allow(id)
 {
	bm_id = id;
 	if(id=='')
	{
		alert("��������");
	}
	else
	{
		var url = "allow.php";
		var para = "status=y&id="+bm_id;
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
 
 function refuse(id)
 {
	bm_id = id;
 	if(id=='')
	{
		alert("��������");
	}
	else
	{
		var url = "allow.php";
		var para = "status=n&id="+bm_id;		
		var mystatus = new Ajax.Request(
			url,
			{
				method:'get',
				parameters:para,
				onComplete:ChangeToAllow
			}	
		);
	}
 }
 
 function ChangeToAllow() 
 {
    alert("ȡ����˳ɹ�");
	$('status'+bm_id).innerHTML = "<img src='../images/refuse.gif' onclick='allow("+bm_id+")' style='border:0'>";
 }
 
 function ChangeToRefuse()
 {
 alert("��˳ɹ�");
	$('status'+bm_id).innerHTML = "<img src='../images/allow.gif' onclick='refuse("+bm_id+")' style='border:0'>";
 }
 
</script>
<script type="text/javascript">
 function checkall(o)
 {
	for (var i=1;i<=20;i++)
	{
	  var name="xz["+i+"]";
	  //alert (name);
	  document.getElementById(name).checked=o.checked;
	}
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
          <TD colspan="1">�������</TD>
		  <TD width="91%" colspan=2>����������
            <input type="text" name="title" value="<?=$title?>">
��״̬<select name="status" id="status">
<option value="">��ѡ��</option>
<option value="y">�����</option>
<option value="n">δ���</option>
</select><script language=javascript>
document.form1.status.value="<?=$status?>";
</script>��ʱ�䣺
<input type="text" name="update" value="<?=$update?>">
(��ʽ��2007-01-01)
<input type="submit" name="Submit" value="����">
�� <a href="<?=$_SERVER["PHP_SELF"]?>"><FONT COLOR=RED>��ʾȫ��</FONT> </A> </TD>
          </TR></form>
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
<form name="form1" method="post" action="manage_action.php" target="_blank">
  <div align="right"><a href="###" onClick="if(confirm('ȷ��ɾ������δ�����Ϣ��?')){location.href = 'gqdel.php?ac=del_no_allow';}">ɾ������δ�����Ϣ</a> | <a href="gqdel.php" target=_blank>������ڹ�����Ϣ</a>��<input type=checkbox value="Check All" onClick="checkall(this)">
ȫѡ
                                  <input type="radio" name="caozuo" value="tj">
                                        ��ͨ��Ϣ 
                                        <input type="radio" name="caozuo" value="del">
                                        ɾ����Ϣ ��
										<input type="submit" name="Submit" value="�ύ">��
  </div><table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr class="header">
  <td width="8%">���</td>
  <td width="10%">��������</td>
  <td width="63%">����</td>  
  <td width="5%" align="center">ѡ��</td>
  <td width="7%" align="center">ɾ��</td>
  <td width="7%" align="center">���</td>
</tr>
<?
	while ($rec=mysql_fetch_array($myrs_qq))
	{
	$nn+=1;
?>
	<tr bgcolor="#F8F9FC"><td><?=$rec[sellid]?></td><td><?="[<a href=$filename&typesort=$rec[typesort]>$rec[typesort]</a>]";?></td><td><a href="../../gq_show.php?id=<?=$rec[sellid]?>" title="<?=$rec[content]?>" target=_blank><? echo $rec[title]?></a><font color=#606060>����<?="(".$rec[startdate].")"?></font></td>
	 <td align="center"><input type="checkbox" name="xz[<?=$nn?>]" id="xz[<?=$nn?>]" value="<?=$rec[sellid]?>"></td>
	  <td align="center"><a href="manage.php?action=del&sellid=<?=$rec[sellid]?>">ɾ��</a></td>
	<td align="center"><? echo "<div id=\"status$rec[sellid]\">";
//-----------------------------���------------------------
echo ($rec[pass]=='n')?"<img src=\"../images/refuse.gif\" onclick=\"allow($rec[sellid])\" style=\"border:0\" />":"<img src=\"../images/allow.gif\" onclick=\"refuse($rec[sellid])\" style=\"border:0\" />";
echo "</div>";?></td>
	</tr>
<?
	}
?>
</table>
<div align="right">
  <input type=checkbox value="Check All" onClick="checkall(this)">
ȫѡ
                                  <input type="radio" name="caozuo" value="tj">
                                        ��ͨ��Ϣ 
                                        <input type="radio" name="caozuo" value="del">
                                        ɾ����Ϣ ��
										<input type="submit" name="Submit" value="�ύ">��
  </div>
</form></td></tr></table>  </td>
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
          <td width="9%">
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
