<?php	
	include("../../include/include.php");	
	checklogin();
	set_magic_quotes_runtime(0);
	$cachefile = "../../include/ads_date.conf";
	$temparr = unserialize(FileIO::getFileContent($cachefile));
	//print_r($temparr);exit;
if ($action=='action')
{
if ($_FILES['upfile_left']['type']=="image/pjpeg" or $_FILES['upfile_left']['type']=="image/jpeg" or $_FILES['upfile_left']['type']=="image/gif" or $_FILES['upfile_left']['type']=="application/x-shockwave-flash"){

		if ($_FILES['upfile_left']['type']=="image/pjpeg" or $_FILES['upfile_left']['type']=="image/jpeg")
			{
				$l_name=".jpg";
				$temparr['index_bottom_ads_left_type'] = 'img';
			}
		if ($_FILES['upfile_left']['type']=="image/gif")
			{	$l_name=".gif";
				$temparr['index_bottom_ads_left_type'] = 'img';
			}
		if ($_FILES['upfile_left']['type']=="application/x-shockwave-flash")
			{
				$l_name=".swf";
				$temparr['index_bottom_ads_left_type'] = 'flash';
			}
		$new_name='index_bottom_ads_left'.$l_name;
		// �����ļ���		
		$filename="../../upload/index_ads/".$new_name;
		if (!@move_uploaded_file($_FILES['upfile_left']['tmp_name'],$filename))
		{		
			$xiaoxi="�ϴ��ļ�ʧ�ܣ�";										
		}else{
			$temparr['index_bottom_ads_left_filename'] = $new_name;			
		}
}

$temparr['index_bottom_ads_left_show'] = $_POST['ads_left_show'];
$temparr['index_bottom_a_href_left'] = $_POST['a_href_left'];
//print_r($temparr);exit;
if (FileIO::writeFile($cachefile,serialize($temparr)))
{
	$status = 1;
}
// ------------------------- ����У�� ------------------------------------
  if (!$status) {
?>
<script language=javascript>
     history.back()
     alert("�޸�ʧ��")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('�޸ĳɹ�');     
</script>
<?
  }
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
          <TD colspan="3">��ҳ���λ���£�����</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form enctype="multipart/form-data" name="form" method="post" action="?action=action">
					  <tr bgcolor="#FFFFFF">
                        <td colspan="2"><?php 
						if (FileIO::isFileExists("../../upload/index_ads/".$temparr['index_bottom_ads_left_filename'])){
							echo "[ <a href=\"../../upload/index_ads/".$temparr['index_bottom_ads_left_filename']."\" target=_blank>Ԥ��</a> ]" ;
						}?></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="14%">�Ƿ���ʾ��</td>
                        <td width="86%"><input name="ads_left_show" type="checkbox" id="ads_left_show" size="50" value="1" <?php if ($temparr['index_bottom_ads_left_show']==1) echo 'checked';?>></td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="14%">���ӵ�ַ��</td>
                        <td width="86%"><input name="a_href_left" type="text" id="a_href_left" size="50" value="<?php echo ($temparr['index_bottom_a_href_left']=='')?'http://':$temparr['index_bottom_a_href_left'];?>">
                        <font color="#FF0000">(��FLASH��Ч)</font></td>
                      </tr>
                      <tr bgcolor="#FFFFFF">
                        <td>��ظ�����</td>
                        <td><input type=file name=upfile_left size=35 value="">
                          <font color="#FF0000">*(ֻ�����ϴ�.gif/.jpgͼƬ��FLASH�ļ�,��Ϊ���޸�,�Ƽ���С��980*100px)</font>                          </td>
                      </tr>					 
					   <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="left"><font color="#FF0000">*(�ļ������/upload/index_bottom_adsĿ¼��)</font></td>
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
