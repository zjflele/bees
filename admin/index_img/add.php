<?php
	include("../../include/include.php");
	checklogin();
if ($action=='action')
{
	//print_r($_FILES);EXIT;
$max=rand(100000,999999);
$up_name=date("Ymd").$max.date("His");
if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=='image/jpg'  or $_FILES['upfile']['type']=="image/gif")
	{
	if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=='image/jpg' )
	{$l_name=".jpg";}
	if ($_FILES['upfile']['type']=="image/gif")
	{$l_name=".gif";}
		$new_name=$up_name.$l_name;
		// �����ļ���		
		$filename="../../upload/images/".$new_name;
		if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
		{		$xiaoxi="�ϴ�ͼƬ�ɹ���";		
		chmod($filename,0777);}
		else{	$xiaoxi="�ϴ�ͼƬ���ɹ���";}
}else{
?>
<script language=javascript>
     history.back()
     alert("��Ƭ��ʽ֧��.gif��.jpg���ļ���")
</script>
<?
exit;
}
$update=date("Y-m-d H:i:s");
$siteid = ($_SESSION['bees_CityId'])?$_SESSION['bees_UserId']:0;
$sql="INSERT INTO `".TABLEPRE."index_img` (`title` , `imgpath` ,`linkpath` ,`siteid` ,`update`) 
VALUES ('$title','$new_name', '$linkpath','$siteid', '$update')";
$myrs=mysql_query($sql,$myconn);
// ------------------------- ����У�� ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("<?=$xiaoxi?>")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
      alert('<?=$xiaoxi?>');
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
		if(document.form.title.value=='')
		{
			alert('����д����');
			document.form.title.focus();
			return false;
		}
		if(document.form.linkpath.value=='')
		{
			alert('����д����·��');
			document.form.linkpath.focus();
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
          <TD colspan="3">��ҳͼƬ�ֻ�����</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="add.php?action=action">					
					   <tr bgcolor="#FFFFFF">
                        <td width="14%">���⣺</td>
                        <td width="86%"><input name="title" type="text" id="title" size="50">
                          <font color="#FF0000">*</font>����
                          <label> </label></td></tr>
					  <tr bgcolor="#FFFFFF">
                        <td>����·����</td>
                        <td><input name="linkpath" type="text" id="linkpath" size="50"></td>
                      </tr>					 	
                      <tr bgcolor="#FFFFFF">
                        <td>���ͼƬ��</td>
                        <td><input type=file name=upfile size=35 value="">
                          <font color="#FF0000">*(ֻ�����ϴ�.gif��.jpgͼƬ,ͼƬ�ߴ磺700*330px;)</font>                          </td>
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
