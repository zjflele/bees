<?
	include("../../include/include.php");
	checklogin();
if ($action=='action')
{ 
$path = GetValueFromTable("videopath","video","videopath='".$videopath."'"); 
if($path<>'')
{
?>
<script language=javascript>
     history.back()
     alert("��Ƶ����������������ģ�")
</script>
<?
    exit();
}  
$neirong = ereg_replace("\n", "<br>", $neirong);
$username=$_SESSION["bees_UserName"];
$groupid=$_SESSION["bees_UserGroup"];
$up_name=date("Ymd").$max.date("His");

	if ($_FILES ['upfile'] ['type'] == "image/pjpeg" or $_FILES ['upfile'] ['type'] == "image/jpeg" or $_FILES ['upfile'] ['type'] == 'image/jpg' or $_FILES ['upfile'] ['type'] == "image/gif") {
		if ($_FILES ['upfile'] ['type'] == "image/pjpeg" or $_FILES ['upfile'] ['type'] == "image/jpeg" or $_FILES ['upfile'] ['type'] == 'image/jpg') {
			$l_name = ".jpg";
		}
		if ($_FILES ['upfile'] ['type'] == "image/gif") {
			$l_name = ".gif";
		}
		$new_name = $up_name . $l_name;
		// �����ļ���		
		$filename = "../../upload/images/" . $new_name;
		if (move_uploaded_file ( $_FILES ['upfile'] ['tmp_name'], $filename )) {			
			chmod ( $filename, 0777 );
		}
	}
	
	$video_path_info = pathinfo($_FILES ['video']['name']);	
	if (in_array($video_path_info['extension'],array('flv','mp4','mp3'))){
		$videopath = $up_name . '.'.$video_path_info['extension'];
		// �����ļ���		
		$filename = "../../upload/video/" . $videopath;
		if (move_uploaded_file ( $_FILES ['video'] ['tmp_name'], $filename )) {
			$xiaoxi = "�ϴ���Ƶ�ɹ���";
			chmod ( $filename, 0777 );
		}
	}
	
	//$videopath = $_POST['videopath'];
	$siteid = $_SESSION['bees_SiteId'];
if ($videopath){
	$sql="INSERT INTO `".TABLEPRE."video` (`username` ,`groupid` ,`title` ,  `imagepath`,  `videopath` ,`content` ,`vtype` ,`siteid` , `addtime` ) VALUES ('$username' ,'$groupid' ,'$title' ,  '$new_name',  '$videopath', '$neirong','$vtype','$siteid', '$shijian')";	
}else{
	$sql="INSERT INTO `".TABLEPRE."video` (`username` ,`groupid` ,`title` ,  `videopath` ,`content` ,`vtype` , `siteid` ,`addtime` ) VALUES ('$username' ,'$groupid' ,'$title' ,  '$videopath', '$neirong','$vtype', '$siteid', '$shijian')";
}
//echo $sql;
$myrs=mysql_query($sql,$myconn);
// ------------------------- ����У�� ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("��Ϣʧ�ܣ�")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('�����ɹ���');
      location.href="manage.php";
</script>
<?
  }
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
		msgbox("����д��Ƶ����")
		form.title.focus 
		tag=1	
	elseif form.video.value=""  then
		msgbox("��ѡ���ϴ��ļ�")
		form.video.focus 
		tag=1
  	elseif form.shijian.value=""  then
		msgbox("����ӷ���ʱ��")
		form.shijian.focus 
		tag=1
	elseif form.neirong.value=""  then
		msgbox("�������Ƶ���")
		form.neirong.focus 
		tag=1
	end if
	if tag=0 then form.submit()
End Function
//-->
</script>
</head>
<BODY text=#000000 topMargin=10 #DDE3EC background-color:>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=center
	bgColor=#ffffff border=0>
	<TBODY>
		<TR>
			<TD><BR>
			<BR>
			<TABLE class=tableout cellSpacing=1 cellPadding=6 width="95%"
				align=center border=0>
				<TBODY>
					<TR class=header align=left>
						<TD><font color="#FFFFFF"><strong>��Ƶ���</strong></font></TD>
					</TR>
					<TR>
						<TD height="543" bgColor=#f8f9fc valign="top">
						<table width="80%" border="0" align="center" cellpadding="4"
							cellspacing="1" bgcolor="#9999FF">
							<form name="form" method="post" enctype="multipart/form-data"  action="add.php?action=action">
                            
							<tr bgcolor="#FFFFFF">
								<td width="14%">��Ƶ���⣺</td>
								<td width="86%"><input name="title" type="text" id="title"
									size="50"> <font color="#FF0000">*</font></td>
							</tr>
							 <tr bgcolor="#FFFFFF">
                        		<td>��Ƶ��ͼ��</td>
                        		<td><input name="upfile" size="20" type="file" />
								(ע��<font color="#FF0000">ͼƬ�ߴ�600*380px</font>)</td>
					  		</tr>
							<tr bgcolor="#FFFFFF">
								<td>��Ƶ�ļ���</td>
								<td><input name="video" size="20" type="file" />
								(�磺<font color="#FF0000">֧��flv,mp4,mp3��ʽ</font>)</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>����ʱ�䣺</td>
								<td><input name="shijian" type="text" id="shijian"
									value="<?=date("Y-m-d")?>" size="20"> <font color="#FF0000">*</font>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td>��Ƶ��飺</td>
								<td><textarea name="neirong" cols="60" rows="8" id="neirong"></textarea>
								<font color="#FF0000">*</font></td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td colspan="2" align="center"><input type="button" value="�ύ"
									name="b1" onClick=checkform()> <input type="reset"
									name="Submit22" value="��д"></td>
							</tr>
							</form>
						</table>

						</TD>
					</tr>
				</TBODY>
			</TABLE>
		
		
		<TR bgColor=#ffffff>
			<TD align=middle><BR>
			<BR>
			<BR>
			</TD>
		</TR>
	</TBODY>
</TABLE>
</body>
</html>
