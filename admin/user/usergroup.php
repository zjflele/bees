<?php
	include("../../include/include.php");
	checklogin();
if ($action=='action')
{
$privacy = serialize($_POST["privacy"]);
$sql="INSERT INTO `".TABLEPRE."usergroup` (`groupname` , `privacy`, `status` ) VALUES ('$groupname', '$privacy', '$status')";
//echo $sql;exit;
$myrs=mysql_query($sql,$myconn);
// ------------------------- ����У�� ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("�û������ʧ�ܣ�")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('�û�����ӳɹ���');
      location.href="<?=$_SERVER["PHP_SELF"]?>";
</script>
<?
  }
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
<script language="javascript">
	function winalert()
	{
		if(document.form.groupname.value=='')
		{
			alert('����д�û�������');
			document.form.groupname.focus();
			return false;
		}
		document.form.submit();
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
        <TBODY>
        <TR class=header align=left>
          <TD colspan="3">�û������</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="usergroup.php?action=action">					
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">�û������ƣ�</td>
                        <td width="86%"><input name="groupname" type="text" id="groupname"  size="20">
                            <font color="#FF0000">*</font> </td>
                      </tr>
                       <tr> 
      <td  bgcolor="#FFFFFF">�û�Ȩ��</td>
      <td  height="30" bgcolor="#FFFFFF">
	  <input name="privacy[basic]" type="checkbox" value="1">��������
	  <input name="privacy[news]" type="checkbox" value="1">���ݹ���
	  <input name="privacy[picture]" type="checkbox" value="1">ͼƬ����
	  <input name="privacy[yanzhengma]" type="checkbox" value="1">��֤�����
	  <input name="privacy[user]" type="checkbox" value="1">�û�����
    </tr>						  
					  <tr bgcolor="#FFFFFF">
                        <td>״����̬��</td>
                        <td><select name="status">
						<option value="1">����</option>
						<option value="0">��ͣ</option>
						</select></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="button" value="�ύ" name="b1"  onClick="winalert()">
                            <input type="reset" name="Submit22" value="��д">                        </td>
                      </tr>
                    </form>
                </table>
		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
