<?php
	include("../../include/include.php");
	
	//�û��б�
	$user_query = mysql_query("SELECT userid,zname FROM brick_users");
	while($rec = mysql_fetch_assoc($user_query)){
		$userList[$rec['userid']] = $rec['zname'];
	}
	
	$sqlstr_tt="select * from action_log where 1 ";
	if ($_REQUEST['uid']){
		$sqlstr_tt.=" and uid = '".trim($_REQUEST['uid'])."'";
	}
	if (intval($_REQUEST['stype'])){
		$sqlstr_tt.=" and stype = '".intval($_REQUEST['stype'])."'";
	}
	
	if (trim($_REQUEST['addtime'])){
		$sqlstr_tt.=" and addtime like '".trim($_REQUEST['addtime'])."%'";
	}
	$sqlstr_tt.=" order by addtime desc";
	//echo $sqlstr_tt;
	$myrs_tt=@mysql_query($sqlstr_tt);
	$rec_tt= @mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------��ҳ����------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?uid=$uid&stype=$stype&addtime=$addtime";
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
<script type="text/javascript" src="../../js/date.js"></script>
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
          <TD colspan="2">������־����</TD>
		  <TD width="91%" >
		    <p>������������:   
			<select name="uid" id="uid">
			<option value='' selected>ȫ��</option>	
			<?php foreach ($userList as $key => $value){
						echo "<option value='$key'>$value</option>";
					}
			?>
			</select>
			�������ͣ�
			<select name="stype" id="stype">	
				<option value='0' selected>ȫ��</option>		
				<option value='1'>���</option>
				<option value='2'>ɾ��</option>
				<option value='3'>�༭</option>
				<option value='4'>��¼</option>
				<option value='5'>�˳�</option>
			</select>
			
			����ʱ�䣺
			<input type="text" name="addtime" id="addtime" onfocus='selectDate(this)' onclick='selectDate(this)' style='cursor:hand' readonly />
		       
		        <input type="submit" name="Submit" value="����">   ��	   ��
<a href="<?=$_SERVER["PHP_SELF"]?>"><FONT COLOR=RED>��ʾȫ��</FONT> </A></p>			</TD>
          </TR> </form>
		  <script language="javascript">
		  	document.getElementById("uid").value='<?=trim($_REQUEST['uid'])?>';
			document.getElementById("stype").value='<?=intval($_REQUEST['stype'])?>';
			document.getElementById("addtime").value='<?=trim($_REQUEST['addtime'])?>';
		  </script>
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
  <td width="5%">���</td>
  <td width="15%" align="center">������</td>
  <td>������ϸ</td>  
  <td width="15%" align="center">����ʱ��</td>
</tr>
<?
	while ($rec=mysql_fetch_array($myrs_qq))
	{	
?>
	<tr bgcolor="#F8F9FC">
	<td><?=$rec['id']?></td>
	<td><? echo $userList[$rec['uid']];?></td>
	<td><?php echo $rec['description']?></td>	
	<td><? echo substr($rec['addtime'],0,16);?></td>
	</tr>
<?
	}
?>
</table></td></tr></table>  </td>
              </tr>
            </table>				</td>
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
?>		  </TD>
		  </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
