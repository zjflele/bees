<?php
	include("../../include/include.php");
	checklogin();
	session_start();
	if(@$_GET["action"]=="del" && @$_GET["id"])
	{
		$obj = new EasyDB(article);
		$obj->IDVars="id";
		$obj->SetLimit(1);
		$ninfo = getrow("select title from ".TABLEPRE."article where id=".$_GET['id']);
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
	$s_date = trim($_GET['s_date']);
	$e_date = trim($_GET['e_date']);
	$username = trim($_REQUEST['username']);
	$adduser = trim($_POST['adduser']);
	$istop = intval($_REQUEST['istop']);
	$sqlstr_tt="select id,title,date,sortsid,sort_id,username,pass from ".TABLEPRE."article where id<>'' ";
	if ($_SESSION["bees_UserGroup"]<>1)
	$sqlstr_tt.=" and username = '$_SESSION[bees_UserName]'";
	if ($a_id<>"")
	$sqlstr_tt.=" and id = $a_id";
	if ($username<>"")
	$sqlstr_tt.=" and username = '$username'";	
	if ($update<>"")
	$sqlstr_tt.=" and date like '%$update%'";
	if ($title<>"")
	$sqlstr_tt.=" and title like '%$title%'";
	if ($s_date<>"")
	$sqlstr_tt.=" and date>='$s_date'";
	if ($e_date<>"")
	$sqlstr_tt.=" and date<='$e_date'";
	if ($sort_id<>"")
	{
	$sortname=GetValueFromTable("name","sort","id=$sort_id"); 
	$sqlstr_tt.=" and sort_f like '%|$sort_id|%'";
	}
	if ($istop<>"")
	$sqlstr_tt.=" and istop = ".($istop-1);
	$sqlstr_tt.=" order by date desc,id desc";
	//echo $sqlstr_tt;	
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------��ҳ����------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?title=$title&update=$update&category=$category&sort_id=$sort_id&username=$username&users=$users&s_date=$s_date&e_date=$e_date";
    $totalpage=ceil($i/$pagesize);
    if ($totalpage<$currentpage)
    $currentpage = $totalpage;
    $offset=($currentpage-1)*$pagesize;
    $offend=$offset+20;
//-----------��ҳ����----------
    $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
	//echo $sqlstr;
    $myrs_tt=mysql_query($sqlstr);
	
	//��ȡ�û��б�
	$userlist = getlist("select username,zname from ".TABLEPRE."users order by userid asc");	
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
		alert("��������");
	}
	else
	{
		var url = "news_allow.php";
		var para = "status=1&id="+bm_id;
		//alert(para);		
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
		var url = "news_allow.php";
		var para = "status=0&id="+bm_id;
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
	$('status'+bm_id).innerHTML = "<input type=image src='../images/refuse.gif' onclick='allow("+bm_id+")' style='border:0'>";
 }
 
 function ChangeToRefuse()
 {
 alert("��˳ɹ�");
	$('status'+bm_id).innerHTML = "<input type=image src='../images/allow.gif' onclick='refuse("+bm_id+")' style='border:0'>";
 }
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY><form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
        <TR class=header align=left>
          <TD colspan="2">���Ź���</TD>
		  <TD width="91%" >
		  ID   
		        <input type="text" name="a_id" value="<?=$a_id?>" size=5>
		    ����   
		        <input type="text" name="title" value="<?=$title?>" size=15>
           ��ʱ�䣺
           <input type="text" name="update" value="<?=$update?>" size=10>   
		   ����Ϣ����       
		   <select name="sort_id" id="sort_id">
		   <? ShowType_news();?>
		   </select>��
		   �û�
		   <select name="username" id="username">
		   <option value=''>��ѡ���û�</option>
		   <? 
		   foreach ($userlist as $k => $v){
		   	echo "<option value='".$v['username']."'>".$v['zname']."</option>";
			$ulist[$v['username']] = $v['zname'];
		   }?>
		   </select>
		   ����ͼ
		   <select name="istop" id="istop">
		   <option value='0'>ȫ��</option>
		   <option value='2'>��</option>
		   <option value='1'>��</option>
		   </select>��
		   <script language="javascript">
		   	document.form1.sort_id.value="<?=$sort_id?>";
		   	document.form1.username.value="<?=$username?>";
			document.form1.istop.value="<?=$istop?>";
		   </script>
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
                <td><table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">
<table border="0" cellspacing="1" cellpadding="4" width="100%">

<tr class="header"><td width="6%" align="center">���</td>
<td width="45%">����</td>
<td width="10%" align="center">�û���</td>
<td width="11%" align="center">�������</td>
<td width="11%" align="center">����</td>
<td width="5%" align="center">���</td>
</tr>
<?
	while ($rec=mysql_fetch_array($myrs_qq))
	{
?>
	<tr bgcolor="#F8F9FC"><td><?=$rec[id]?></td><td><a href="/show_article.php?id=<?=$rec[id]?>" target=_blank><?=$rec[title]?></a></td><td><a href="news_manage.php?username=<?=$rec[username]?>"><?=($rec[username]=='')?"����Ա":$ulist[$rec[username]]?></a></td><td><? echo $rec[date];?></td>
	<td align="center"><a href="news_edit.php?id=<?=$rec['id']?>">�༭</a>&nbsp;&nbsp;&nbsp;<a href="news_manage.php?action=del&id=<?=$rec['id']?>">ɾ��</a></td>
		<td align="center"><? echo "<div id=\"status$rec[id]\">";
//-----------------------------���------------------------
echo ($rec[pass]=='0')?"<input type=\"image\" src=\"../images/refuse.gif\" onclick=\"allow($rec[id])\" style=\"border:0\" />":"<input type=\"image\" src=\"../images/allow.gif\" onclick=\"refuse($rec[id])\" style=\"border:0\" />";
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
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
