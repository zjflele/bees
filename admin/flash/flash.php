<?php
	include("../../include/include.php");
	checklogin();
	set_magic_quotes_runtime(0);
	if ($action=='action')
{
$max=rand(100000,999999);
$up_name=date("Ymd").$max.date("His");
if ($_FILES['upfile']['type']=="application/x-shockwave-flash")
	{
		$l_name=".swf";
		$new_name=$up_name.$l_name;
		// 构造文件名		
		$filename=WEB_PATH."/upload/flash/".$new_name;
		if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
		{		$xiaoxi="上传文件成功！";		
		        chmod($filename,0777);
		}
		else{		$xiaoxi="上传文件不成功！";}
	}
	else
	{
	$xiaoxi="没有上传文件！";
	}
$sql="INSERT INTO `".TABLEPRE."flash` (`groupid` , `upfile` ,`other` ,`isshow` ,`siteid` ,`show_time` ,`add_time`) 
VALUES ('$group','$new_name', '$other', '$isshow', '".$_SESSION['bees_SiteId']."','$shijian', '$shijian')";
$myrs=mysql_query($sql,$myconn);
// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("发送文件失败！<?=$xiaoxi?>")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('发送文件成功！<?=$xiaoxi?>');
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
		
		if(document.form.shijian.value=='')
		{
			alert('请填写发送时间');
			document.form.shijian.focus();
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
    <TD><BR><BR>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY>
        <TR class=header align=left>
          <TD colspan="3">首页ＦＡＬＳＨ发布</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="flash.php?action=action">					
					   <tr bgcolor="#FFFFFF">
                        <td width="14%">是否替换：</td>
                        <td width="86%"><label>
                          <input name="isshow" type="radio" value="1" checked>
                          是 　 <input type="radio" name="isshow" value="0">
                          否 　 </label></td></tr>					
                      <tr bgcolor="#FFFFFF">
                        <td>时间日期：</td>
                        <td><input name="shijian" type="text" id="shijian" value="<?=date("Y-m-d H:i:s")?>" size="20">
                            <font color="#FF0000">*</font> </td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td>相关说明：</td>
                        <td><input name="other" type="text" id="other" size="50"></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td>相关附件：</td>
                        <td><input type=file name=upfile size=35 value="">
                          <font color="#FF0000">*(只可以上传.swf文件)</font>                          </td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td colspan="2"><font color="#FF0000">说明：标准尺寸：980*160px 　　</font></td>
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
