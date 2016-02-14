<?
	include("../../include/include.php");
	checklogin();
if ($action=='action')
{ 
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
				if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
				{		
					$xiaoxi="上传图片成功！";		
					chmod($filename,0777);
					$updimg = ",`imagepath` = '$new_name'";
				}							
		}
		
		
		$video_path_info = pathinfo($_FILES ['video']['name']);	
	if (in_array($video_path_info['extension'],array('flv','mp4','mp3'))){
		$videopath = $up_name . '.'.$video_path_info['extension'];
		// 构造文件名		
		$filename = "../../upload/video/" . $videopath;
		if (move_uploaded_file ( $_FILES ['video'] ['tmp_name'], $filename )) {
			$xiaoxi = "上传视频成功！";
			chmod ( $filename, 0777 );
			$updvideo = ",`videopath` = '$videopath'";
			}
		}
		
	$neirong = ereg_replace("\n", "<br>", $neirong);
	$sql="UPDATE `".TABLEPRE."video` SET `title` = '$title',`content` = '$neirong',`vtype` = '$vtype',`addtime` = '$shijian' $updimg $updvideo WHERE  `id` = '$id'";
	//echo $sql;
	$myrs=mysql_query($sql,$myconn);
// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("信息失败！")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('修改成功！');
      location.href="manage.php";
</script>
<?
  }
}

if(@$_GET["id"])
	{
		$obj = new EasyDB(video);
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
<script language="vbscript">
<!--
function checkform()
	tag=0
	if form.title.value=""  then
		msgbox("请填写视频标题")
		form.title.focus 
		tag=1	
	elseif form.video.value=""  then
		msgbox("请选择上传文件")
		form.video.focus 
		tag=1
  	elseif form.shijian.value=""  then
		msgbox("请添加发布时间")
		form.shijian.focus 
		tag=1
	elseif form.neirong.value=""  then
		msgbox("请添加视频简介")
		form.neirong.focus 
		tag=1
	end if
	if tag=0 then form.submit()
End Function
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
          <TD><font color="#FFFFFF"><strong>视频修改</strong></font></TD>
		   </TR>
        <TR>
          <TD height="543" bgColor=#f8f9fc valign="top">
		 <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form name="form" method="post" enctype="multipart/form-data" action="edit.php?action=action">
                    
                      <tr bgcolor="#FFFFFF"> 
                        <td width="14%">视频标题：</td>
                        <td width="86%"> <input name="title" type="text" id="title" size="50" value="<?=$obj->GetField("title")?>"> 
                          <font color="#FF0000">*</font> </td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td>视频截图：</td>
                        <td>
                        <?php if ($obj->GetField("imagepath")){?>
                        	<a href="/upload/images/<?=$obj->GetField("imagepath")?>" target="_blank">预览</a>
                        <?php }?>
                        <input name="upfile" size="20" type="file" />
								(注：<font color="#FF0000">图片尺寸600*380px,不上传为不修改图片</font>)</td>
					  </tr>
                      
                       <tr bgcolor="#FFFFFF">
								<td>视频文件：</td>
								<td><input name="video" size="20" type="file" />
								(如：<font color="#FF0000">支持flv,mp4,mp3格式</font>)</td>
						</tr>
					 
                      <tr bgcolor="#FFFFFF"> 
                        <td>发布时间：</td>
                        <td> <input name="shijian" type="text" id="shijian"  value="<?=$obj->GetField("addtime")?>" size="20">
                          <font color="#FF0000">*</font> </td>
                      </tr>
                      <tr bgcolor="#FFFFFF"> 
                        <td>视频简介：</td>
                        <td> <textarea name="neirong" cols="60" rows="8" id="neirong"><?=$obj->GetField("content")?></textarea><input type=hidden name="id" value="<?=$id?>"> 
                          <font color="#FF0000">*</font> </td>
                      </tr>
                      <tr bgcolor="#FFFFFF"> 
                        <td colspan="2" align="center"> <input type="button" value="提交" name="b1" onClick=checkform()> 
                          <input type="reset" name="Submit22" value="重写"> </td>
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
