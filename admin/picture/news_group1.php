<?
	include("../../include/include.php");
	checklogin();

if ($action=='action')
{
if ($dirname=="")
  { ?>
<script language=javascript>
     history.back()
     alert("����ӷ��࣡")
</script>
  <? 
  exit();
  }
$sql = "INSERT INTO sort(name,parentid,hight) VALUES ('$dirname',$pid,$hight+1)";
//echo $sql;
$myrs=mysql_query($sql,$conn);

$sql="select * from sort order by id desc";
$myrs=mysql_query($sql,$conn);
$rec=mysql_fetch_array($myrs);
$nid=$rec["id"];

$sql="select * from sort where id=".$pid."";
$myrs=mysql_query($sql,$conn);
$rec=mysql_fetch_array($myrs);
$ndirlist=$rec["parentlist"]."->[<a href=P_S?pid=".$nid.">".$dirname."</a>]";
$ndiridlist=$rec["idlist"].$nid."|";


$sql = "update sort set parentlist='$ndirlist',idlist='$ndiridlist',yn_mo=1 where id=$nid";
$myrs=mysql_query($sql,$conn);
$sql = "update sort set yn_mo=0 where id=$pid";
$myrs=mysql_query($sql,$conn);

  // ------------------------- ��Ϣ����У�� ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("���ʧ�ܣ�")
</script>
<?
  exit();
  }
  else {
?>
<script language=javascript>
    alert('��ӳɹ���');
	location.href="news_group.php?pid=<?echo $pid;?>";
</script>
<?
  exit();
  }
  }
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script language=javascript>
<!--
function del(http)
{
 if (window.confirm("���Ƿ����Ҫɾ����ɾ��֮��Ͳ��ָܻ�") ){
 window.open(http,"ɾ��","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,width=100,height=200,top=990,left=1025") 
 }
}
function winopen(url)                    
     {                    
        window.open(url,"search","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=440,height=175,top=80,left=100");
}
//-->
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center bgColor=#ffffff 
border=0>
  <TBODY>
  <TR>
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="95%" align=center 
      border=0>
        <TBODY>
        <TR class=header align=left>
          <TD><font color="#FFFFFF"><strong>��ӷ���</strong></font><a href="<?=$_SERVER['PHP_SELF']."?action=edit"?>"></a></TD>
		   </TR>
        <TR>
          <TD height="543" bgColor=#f8f9fc valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="100%" height="20" align="left">���ർ���� 
                                    <?
$i=0;
if ($pid=='')
$pid=1;
$sql="select * from sort where id=".$pid."";
$myrs=mysql_query($sql,$conn);
$rec=mysql_fetch_array($myrs);
$parentid = $rec["id"];
$hight=$rec["hight"];
if ($rec["parentlist"] <> ""):
$text = $rec["parentlist"];
$text = str_replace("P_A", "news_group.php", $text);
$text = str_replace("P_S", "news_group.php", $text);
endif;
echo $text;
				?>
                                  </td>
                                </tr>
                                <tr> 
                                  <td height="20"></td>
                                </tr>
                                <tr> 
                                  <td> <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td bgcolor="#FFFFFF"> <table width="100%" cellpadding="3" cellspacing="0" border="0">
                                            <tr> 
                                              <?
					$sql="select * from sort where parentid=".$pid." order by id ";
					//echo  $sql;
					$myrs=mysql_query($sql,$conn);
					while($rec=mysql_fetch_array($myrs))
					{
				  ?>
                                              <td height="23" align="left"> 
                                                <?
					  if ($rec["hight"]<10)
					  {
					  echo "<img src=../images/dian.gif align=absmiddle> <a href=news_group.php?pid=".$rec["id"].">".$rec["name"]."</a>";
					  }
					  else
					  {
					  echo "<img src=../images/dian.gif align=absmiddle> ".$rec["name"]."";
					  }
					  ?>
                                                <a href="javascript:winopen('group_edit.php?id=<?=$rec["id"]?>')"><img src="../images/edit.png" alt="�༭" width="12" height="13" border="0" align="absmiddle"></a> 
                                                <a onClick="del('group_del.php?id=<?=$rec["id"]?>')" href="#"><img src="../images/del.png" alt="ɾ��" width="11" height="13" border="0" align="absmiddle"></a> 
                                              </td>
                                              <?
        			if (($i%4)==3) echo "</tr>\n";
   					 $i+=1;
  					}	
					?>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr> 
                                  <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td> <table width="100%" border="1" cellspacing="1" cellpadding="0" bgcolor="#3399CC" bordercolor="#FFFFFF">
                                      <tr> 
                                        <td align="left" bgcolor="#E9F8FE"><font color="#FF0000">������</font></td>
                                      </tr>
                                      <tr> 
                                        <form name="form1" method="post" action="news_group.php?action=action">
                                          <td bgcolor="#FFFFFF"> <div align="center"> 
                                              <table width="100%" border="0">
                                                <tr>
                                                  <td width="33%" align=right>
													<input type="hidden" name="pid" value="<?echo $parentid;?>">
                                                    <input type="hidden" value="<?echo $hight;?>" name="hight">
���</td>
                                                  <td width="67%" align=left><input type="text" name="dirname" size="20" onMouseOver=this.focus() onFocus=this.select()>
                                                    ����
                                                    <input type="submit" name="Submit" value="������"></td>
                                                </tr>
                                                <tr align=center>
                                                  <td colspan="2">&nbsp;</td>
                                                </tr>
                                              </table>
                                          </div></td>
                                        </form>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></TD>
		  </tr>
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
