<?php
	include("../../include/include.php");
	checklogin();
if ($_POST['action']=='edit')
{
	 $title = trim($_POST['title']);	 
	 $weibo = trim($_POST['weibo']);
	 $is_menu = intval($_POST['is_menu']);	
	 $id = intval($_POST['id']);	
	 $description = trim($_POST['description']);
	
	if ($_FILES['head_img']['type']=="image/pjpeg" or $_FILES['head_img']['type']=="image/jpeg" or $_FILES['head_img']['type']=="image/gif" or $_FILES['head_img']['type']=="application/x-shockwave-flash"){

		if ($_FILES['head_img']['type']=="image/pjpeg" or $_FILES['head_img']['type']=="image/jpeg")
			{
				$l_name=".jpg";		
				$htype = 1;
			}
		if ($_FILES['head_img']['type']=="image/gif")
			{	
				$l_name=".gif";
				$htype = 1;
			}
		if ($_FILES['head_img']['type']=="application/x-shockwave-flash")
			{
				$l_name=".swf";	
				$htype = 2;
			}
		$new_name=time().$l_name;
		// �����ļ���		
		$filename="../../upload/zhuanti/".$new_name;
		if (!@move_uploaded_file($_FILES['head_img']['tmp_name'],$filename))
		{		
			$xiaoxi="�ϴ��ļ�ʧ�ܣ�";										
		}	
	}	
	
if ($filename<>'')
{
$sql="UPDATE `".TABLEPRE."zhuanti` SET `title` = '$title',`weibo` = '$weibo',`head_img` = '$new_name',`htype` = '$htype',`is_menu` = '$is_menu',`description` = '$description' WHERE  `id` = '$id'";
} else {
$sql="UPDATE `".TABLEPRE."zhuanti` SET `title` = '$title',`weibo` = '$weibo',`is_menu` = '$is_menu',`description` = '$description'  WHERE  `id` = '$id'";
}
$myrs=mysql_query($sql,$myconn);


// ------------------------- ����У�� ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("�޸�ʧ�ܣ�<?=$xiaoxi?>")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('�޸ĳɹ���<?=$xiaoxi?>');
      location.href="<?="manage.php"?>";
</script>
<?
  }
}	

if(@$_GET["id"])
	{
		$obj = new EasyDB(TABLEPRE.'zhuanti');
		$obj->AcceptType="USER";
		$obj->User["id"] 		= $obj->Get["id"];		
		$obj->IDVars="id";
		$obj->Select();
		$obj->FetchLine();		
	}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
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
          <TD colspan="3">ר���޸� [<a href="manage.php">�����б�</a>]</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top"><br>
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form action="zhuanti_edit.php?id=<?php echo $obj->Get["id"];?>" method="post" enctype="multipart/form-data" name="form">
					  <tr bgcolor="#FFFFFF">
                        <td width="24%">���⣺</td>
                        <td width="77%"><input name="title" type="text" id="title" size="50" value="<? echo $obj->GetField("title");?>"></td>
                      </tr>
					  	
					  <? if ($obj->GetField("head_img")!=""){?>
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2">  <? echo "��ǰΪ��".$obj->GetField("head_img")."&nbsp;&nbsp;&nbsp;&nbsp;";

						echo "<a href='../../upload/zhuanti/".$obj->GetField("head_img")."' border=0 target='_blank'>[Ԥ��]</a><br>";

						?></td>
                      </tr>
					  <? }?>	
					  					  
					  <tr bgcolor="#FFFFFF">
                        <td width="24%" height="37">����ͼƬ��</td>
                        <td width="77%"><label>
                          <input type="file" name="head_img">
                        </label>(ע��<font color="#FF0000">��׼ͼƬ�ߴ�950*390px</font>)</td>
					  </tr>
                      <!--tr bgcolor="#FFFFFF">
                        <td>�Ƿ���ʾ������</td>
                        <td><input name="is_menu" id="is_menu" type="radio" value="1" <? if($obj->GetField("is_menu")) echo "checked";?>>��<input name="is_menu" id="is_menu" type="radio" value="0" <? if(!$obj->GetField("is_menu")) echo "checked";?>>��</td>
                      </tr-->	
					   <tr bgcolor="#FFFFFF">
                        <td>ר����ܣ�</td>
                        <td><textarea name="description" cols="120" rows="20"><? echo $obj->GetField("description");?></textarea></td>
                      </tr>	
                      <tr bgcolor="#FFFFFF">
                        <td width="23%">����β����</td>
                        <td width="77%">
                        <textarea name="weibo" cols="120" rows="10"><? echo $obj->GetField("weibo");?></textarea>
                         
                        </td>
                      </tr>					  
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="hidden" name="id" value="<?php echo $obj->Get["id"];?>"><input type="hidden" name="action" value="edit"><input type="submit" value="�ύ" name="b1">
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
