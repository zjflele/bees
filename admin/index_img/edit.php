<?php
	include("../../include/include.php");
	checklogin();
	if ($action=='action')
{
if ($_FILES['upfile']['tmp_name'])
{
$max=rand(100000,999999);
$up_name=date("Ymd").$max.date("His");
if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=='image/jpg'  or $_FILES['upfile']['type']=="image/gif")
	{
	if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=='image/jpg' )
	{$l_name=".jpg";}
	if ($_FILES['upfile']['type']=="image/gif")
	{$l_name=".gif";}
	
		$new_name=$up_name.$l_name;
		// 构造文件名		
		$filename="../../upload/images/".$new_name;
		if (!file_exists("../../upload/images"))
		{
	    mkdir("../../upload/images",0777);
	     }
		//echo $upfile."<br>".$filename;exit;
		if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
		{		$xiaoxi="上传图片成功！";		
		chmod($filename, 0777);//设定上传的文件的属性
		}
		else{		$xiaoxi="上传图片不成功！";}
}else{
?>
<script language=javascript>
     history.back()
     alert("照片格式支持.gif和.jpg的文件！")
</script>
<?
exit;
}
}
$update=date("Y-m-d H:i:s");
if ($new_name<>'')
{
$sql="UPDATE `".TABLEPRE."index_img` SET `title` = '$title',`imgpath` = '$new_name',`linkpath` = '$linkpath' WHERE  `id` = '$id'";
} else {
$sql="UPDATE `".TABLEPRE."index_img` SET `title` = '$title',`linkpath` = '$linkpath' WHERE  `id` = '$id'";
}
$myrs=mysql_query($sql,$myconn);
// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("修改失败！<?=$xiaoxi?>")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('修改成功！<?=$xiaoxi?>');
      location.href="<?="manage.php"?>";
</script>
<?
  }
}	

if(@$_GET["id"])
	{
		$obj = new EasyDB(index_img);
		$obj->AcceptType="USER";
		$obj->User["id"] 		= $obj->Get["id"];		
		$obj->IDVars="id";
		$obj->Select();
		$obj->FetchLine();
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
			alert('请填写标题');
			document.form.title.focus();
			return false;
		}
		if(document.form.linkpath.value=='')
		{
			alert('请填写链接路径');
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
          <TD colspan="3">首页图片轮换发布</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="edit.php?action=action">					
					   <tr bgcolor="#FFFFFF">
                        <td width="14%">标题：</td>
                        <td width="86%"><input name="title" type="text" id="title" size="50" value="<? echo $obj->GetField("title");?>" >
                          <font color="#FF0000">*</font>　　
                          <label> </label></td></tr>
					  <tr bgcolor="#FFFFFF">
                        <td>链接路径：</td>
                        <td><input name="linkpath" type="text" id="linkpath" size="50" value="<? echo $obj->GetField("linkpath");?>" ></td>
                      </tr>	
					  <? if ($obj->GetField("imgpath")!=""){?>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2">  <? echo "当前图片为：".$obj->GetField("imgpath")."&nbsp;&nbsp;&nbsp;&nbsp;";

						echo "<a href='../../upload/images/".$obj->GetField("imgpath")."' border=0 target='_blank'>[预览图片]</a><br>";

						?></td>
                      </tr>
					  <? }?>				 	
                      <tr bgcolor="#FFFFFF">
                        <td>相关图片：</td>
                        <td><input type=file name=upfile size=35 value=""><input type=hidden name="id" value="<?=$id?>">
                          <font color="#FF0000">*(只可以上传.gif和.jpg图片,图片尺寸：700*330px;)</font>                          </td>
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
