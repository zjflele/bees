<?
	include("../../include/include.php");
	 checklogin();
?>
<?
if ($action=='del')
{
  $sqlstr="delete from ".TABLEPRE."liuyan where id=".$id." ";
  $myrs=mysql_query($sqlstr,$myconn);
 if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("ɾ��ʧ�ܣ�")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('ɾ���ɹ���');
    location.href="liuyan_manage.php?tt=<? echo $tt?>&nn=<? echo $nn?>&ww=<? echo $ww?>&currentpage=<? echo $currentpage?>";
</script>
<?
  }
}
  $title = $_REQUEST['title'];
  $update = $_REQUEST['update'];
  $y_n = $_REQUEST['y_n'];
  $sqlstr_tt="SELECT * FROM ".TABLEPRE."liuyan WHERE id<>'' ";
  if ($title) $sqlstr_tt=$sqlstr_tt." AND title like '%".$title."%' ";
  if ($update) $sqlstr_tt=$sqlstr_tt." AND shijian like '%".$update."%'  ";
  if ($y_n==1) $sqlstr_tt=$sqlstr_tt." AND huifu =='' ";
  if ($y_n==2) $sqlstr_tt=$sqlstr_tt." AND huifu !='' ";
  $sqlstr_tt=$sqlstr_tt."ORDER BY shijian DESC ";
  $myrs_tt=mysql_query($sqlstr_tt,$myconn);
  $rec_tt=mysql_num_rows($myrs_tt);
  $i=$rec_tt;
  mysql_free_result($myrs_tt);
//--------------------��ҳ����---------------
  $pagesize=20;//ÿҳ��ʾ��������
  if (empty($currentpage))$currentpage=1;
  $filename="liuyan_manage.php?title=$title&update=$update";
  $totalpage=ceil($i/$pagesize);
  if ($totalpage<$currentpage)
  $currentpage =$totalpage;
  $offset=($currentpage-1)*$pagesize;
//--------------------��ҳ����---------------
  $sqlstr2=$sqlstr_tt."limit $offset,$pagesize";
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
</head>
<script language=javascript>
<!--
function del(http)
{
 if (window.confirm("���Ƿ����Ҫɾ����ɾ��֮��Ͳ��ָܻ�") ){
 location.href=http;
 }
}
function winopen(url)                    
     {                    
window.open(url,"search","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=420,top=80,left=100");
}
//-->
</script>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR>
      <BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY><form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>">
        <TR class=header align=left>
          <TD colspan="2">���Թ���</TD>
		  <TD width="91%" >
		    ����������   
		        <input type="text" name="title" value="<?=$title?>">
           ʱ�䣺
           <input type="text" name="update" value="<?=$update?>"> 
		   �ظ�״̬��
           <select name="y_n" id="y_n">
		   		<option value="">ȫ��</option>
				<option value="1">δ�ظ�</option>
				<option value="2">�ѻظ�</option>
		   </select>        
		 	<script>document.getElementById('y_n').value='<?=$y_n?>';</script>
                   		    <input type="submit" name="Submit" value="����" />��
<a href="<?=$_SERVER["PHP_SELF"]?>"><FONT COLOR=RED>��ʾȫ��</FONT>	</A>	  </TD>
          </TR> </form>
        <TR>
          <TD height="543" colspan="3" valign="top" bgColor=#f8f9fc>
		  <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR>
      <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                    
                    <tr> 
                      <td> 
                        <?
   if ($i != 0)  //--------------if01--------------------
{
   $myrs_qq=mysql_query($sqlstr2,$myconn);
   //echo $sqlstr2;
   $ii=$offset+1;
?>
                        <table width="100%" border="1" cellspacing="1" cellpadding="0" align="center" class="table1" bgcolor="#3399CC" bordercolor="#FFFFFF">
                          <tr bgcolor="#E9F8FE"> 
                            <td width="42" height="20" align="center">ID</td>
                            <td height="20" > <div align="center">�� 
                                ��</div></td>
							<td width="100" height="20"> <div align="center">������</div></td>
                            <td width="100" height="20"> <div align="center">ʱ��</div></td>
                            <td width="48" height="20"> <div align="center">�� 
                                ��</div></td>
                            <td width="48" height="20"> <div align="center">ɾ 
                                ��</div></td>
                          </tr>
                          <?
   while ($rec=mysql_fetch_array($myrs_qq))
{ 
?>
                          <tr bgcolor="#FFFFFF"> 
                            <td height="25" align="center" width="42"> <?echo $rec[id];?>                            </td>
                            <td height="25" > <?=$rec[title];?> 
                              <?
						$show_n=$rec["huifu"];
						if ($show_n=="")
						echo "<font color=#ff0000>new</font>"
						?>                            </td>
                            <td height="25" width="100"> <div align="center"> 
                                <?=$rec[name];?></div></td>
							<td height="25" width="100"> <div align="center"> 
                                <?echo substr($rec[shijian],0,16);?></div></td>
                            <td height="25" width="48"> <div align="center"><a href="javascript:winopen('liuyan_edit.php?id=<?echo $rec[id]?>')">�ظ�</a></div></td>
                            <td height="25" width="48"> <div align="center"><a href="javascript:del('liuyan_manage.php?action=del&id=<?echo $rec[id]?>&currentpage=<?echo $currentpage?>')">ɾ��</a></div></td>
                          </tr>
                          <?} // while?>
                        </table>
                        <?
mysql_free_result($myrs_qq);
}  //------------------------- end if01-----------------------------------
else echo "û����Ϣ��";
//---------------------------------------------------------------------- 

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
   mysql_close($myconn);
?>                      </td>
                    </tr>
                  </table>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>		  </TD>
	    </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>

</body>
</html>
