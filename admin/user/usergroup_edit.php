<?php
	include("../../include/include.php");
	checklogin();
if ($action=='action')
{
$privacy = serialize($_POST["privacy"]);
$sql="UPDATE `".TABLEPRE."usergroup` SET `groupname` = '$groupname',`privacy` = '$privacy',`status` = '$status' WHERE  `id` = '$id'";
//echo $sql;exit;
$myrs=mysql_query($sql,$myconn);
// ------------------------- ����У�� ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("�û����޸�ʧ�ܣ�")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('�û����޸ĳɹ���');
      location.href="usergroup_manage.php";
</script>
<?
  }
}
?>
<? 
	if(@$_GET["id"])
	{
		$obj = new EasyDB(usergroup);
		$obj->AcceptType="USER";
		$obj->User["id"] 		= $obj->Get["id"];		
		$obj->IDVars="id";
		$obj->Select();
		$obj->FetchLine();
		$privacy = unserialize($obj->GetField("privacy"));
	}
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
        <TBODY>
        <TR class=header align=left>
          <TD colspan="3">�û������</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=action">					
                      <tr bgcolor="#FFFFFF">
                        <td width="15%">�û������ƣ�</td>
                        <td width="85%"><input name="groupname" type="text" id="groupname"  size="20" value="<? echo $obj->GetField("groupname"); ?>"><input type=hidden name=id value="<?=$id?>">
                            <font color="#FF0000">*</font> </td>
                      </tr>
					 <tr> 
      <td  bgcolor="#FFFFFF">�û�Ȩ��</td>
      <td  height="30" bgcolor="#FFFFFF">
          <input name="privacy[basic]" type="checkbox" value="1" <?php if ($privacy[basic]) echo "checked"?>>��������
	  <input name="privacy[news]" type="checkbox" value="1" <?php if ($privacy[news]) echo "checked"?>>���ݹ���
	  <input name="privacy[picture]" type="checkbox" value="1" <?php if ($privacy[picture]) echo "checked"?>>ͼƬ����
	  <input name="privacy[yanzhengma]" type="checkbox" value="1" <?php if ($privacy[yanzhengma]) echo "checked"?>>��֤�����
	  <input name="privacy[user]" type="checkbox" value="1" <?php if ($privacy[user]) echo "checked"?>>�û�����
      </td>
    </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td>״����̬��</td>
                        <td><select name="status">
						<option value="1">����</option>
						<option value="0">��ͣ</option>
						</select>
						<script language=javascript>
						 document.form.status.value="<?=$obj->GetField("status")?>";
						</script>						</td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="submit" value="�ύ" name="b1">
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
