<?php
	include("../../include/include.php");
	checklogin();
if ($action=='action')
{
$privacy = serialize($_POST["privacy"]);
$sql="INSERT INTO `".TABLEPRE."usergroup` (`groupname` , `privacy`, `status` ) VALUES ('$groupname', '$privacy', '$status')";
//echo $sql;exit;
$myrs=mysql_query($sql,$myconn);
// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("用户组添加失败！")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('用户组添加成功！');
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
			alert('请填写用户组名称');
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
          <TD colspan="3">用户组添加</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="usergroup.php?action=action">					
                      <tr bgcolor="#FFFFFF">
                        <td width="14%">用户组名称：</td>
                        <td width="86%"><input name="groupname" type="text" id="groupname"  size="20">
                            <font color="#FF0000">*</font> </td>
                      </tr>
                       <tr> 
      <td  bgcolor="#FFFFFF">用户权限</td>
      <td  height="30" bgcolor="#FFFFFF">
	  <input name="privacy[basic]" type="checkbox" value="1">基本设置
	  <input name="privacy[news]" type="checkbox" value="1">数据管理
	  <input name="privacy[picture]" type="checkbox" value="1">图片管理
	  <input name="privacy[yanzhengma]" type="checkbox" value="1">验证码管理
	  <input name="privacy[user]" type="checkbox" value="1">用户管理
    </tr>						  
					  <tr bgcolor="#FFFFFF">
                        <td>状　　态：</td>
                        <td><select name="status">
						<option value="1">正常</option>
						<option value="0">暂停</option>
						</select></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="button" value="提交" name="b1"  onClick="winalert()">
                            <input type="reset" name="Submit22" value="重写">                        </td>
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
