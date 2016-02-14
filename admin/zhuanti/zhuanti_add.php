<?php
	include("../../include/include.php");
	checklogin();
	set_magic_quotes_runtime(0);
if ($_POST['action']=='add')
{
	 $title = trim($_POST['title']);
	 $weibo = trim($_POST['weibo']);
	 $is_menu = intval($_POST['is_menu']);
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
		// 构造文件名		
		$filename="../../upload/zhuanti/".$new_name;
		if (!@move_uploaded_file($_FILES['head_img']['tmp_name'],$filename))
		{		
			$xiaoxi="上传文件失败！";										
		}	
	}	
	
	 $sql="INSERT INTO `".TABLEPRE."zhuanti` (`id` , `title` ,`weibo` ,`htype` ,`head_img` ,`is_menu`,`description`,`addtime`) 
                VALUES (NULL,'$title','$weibo','$htype', '$new_name','$is_menu','$description','".date('Y-m-d H:i:s')."')";
	 $myrs=mysql_query($sql,$myconn);
	 $vid = mysql_insert_id();
	

// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("添加失败！")
</script>
<?
    exit();
  }
  else {
add_log(1,'zhuanti/zhuanti_add.php','添加专题->'.$title);
?>
<script language=javascript>
    alert('添加成功');
    location.href="manage.php?id=<?=$id?>";
</script>
<?
  }
}


?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/calendar.js"></script>
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
          <TD colspan="3">添加专题</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form action="" method="post" enctype="multipart/form-data" name="form">
					  <tr bgcolor="#FFFFFF">
                        <td width="23%">专题标题：</td>
                        <td width="77%"><input name="title" type="text" id="title" size="50"></td>
                      </tr>	
                     			  
					  <tr bgcolor="#FFFFFF">
                        <td width="23%">顶部图片：</td>
                        <td width="77%"><label>
                          <input type="file" name="head_img">
                        </label>(注：<font color="#FF0000">标准图片尺寸950*390px</font>)</td>
					  </tr>	
					   <!--tr bgcolor="#FFFFFF">
                        <td>是否显示导航：</td>
                        <td><input name="is_menu" id="is_menu" type="radio" value="1" checked>是<input name="is_menu" id="is_menu" type="radio" value="0">否</td>
                      </tr-->
					   <tr bgcolor="#FFFFFF">
                        <td>专题介绍：</td>
                        <td><textarea name="description" cols="120" rows="20"></textarea></td>
                      </tr>		
                       <tr bgcolor="#FFFFFF">
                        <td width="23%">公共尾部：</td>
                        <td width="77%"><textarea name="weibo" cols="120" rows="10"></textarea>
                        </td>
                      </tr>			  
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center"><input type="hidden" name="action" value="add"><input type="submit" value="提交" name="b1">
                            <input type="reset" name="Submit22" value="重写">                        </td>
                      </tr>
                    </form>
              </table>		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
