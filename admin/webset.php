<?
	include("../include/include.php");
	checklogin();
	$cachefile = "../include/webset.conf";
	$webset = unserialize(FileIO::getFileContent($cachefile));
	if (submitcheck('submit'))
	{
		$up_name=date("Ymd").$max.date("His");
		if ($_FILES['bottom_bg']['type']=="image/pjpeg" or $_FILES['bottom_bg']['type']=="image/jpeg"  or $_FILES['bottom_bg']['type']=='image/jpg'  or $_FILES['bottom_bg']['type']=="image/gif")
		{
			if ($_FILES['bottom_bg']['type']=="image/pjpeg" or $_FILES['bottom_bg']['type']=="image/jpeg"  or $_FILES['bottom_bg']['type']=='image/jpg' )
				{$l_name=".jpg";}
			if ($_FILES['bottom_bg']['type']=="image/gif")
				{$l_name=".gif";}
				$new_name=$up_name.$l_name;
				// �����ļ���		
				$filename="../upload/images/".$new_name;
				if (move_uploaded_file($_FILES['bottom_bg']['tmp_name'],$filename))
				{		
					$xiaoxi="�ϴ�ͼƬ�ɹ���";		
					chmod($filename,0777);
					$webset['bottom_bg'] = $new_name;
				}							
		}

		$webset['isclose'] = intval($_POST['isclose']);
		$webset['close_notice'] = trim($_POST['close_notice']);		
		$webset['isblank'] = intval($_POST['isblank']);
		$webset['islink'] = trim($_POST['islink']);
		$webset['bbs_fid'] = intval($_POST['bbs_fid']);
		$webset['friendlink'] = trim($_REQUEST['friendlink']);
		
		
		FileIO::writeFile($cachefile,serialize($webset));
		alertmessage('���óɹ���',3);
	}
	
	//print_r($webset);exit;
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="./admin_css.css" rel="stylesheet" type="text/css">
<title><?=TITLE?></title>
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
          <TD width="11%" colspan="1">��վȫ������</TD>
		  <TD width="89%" colspan="2">&nbsp;</TD>
        </TR>
        <TR>
          <TD height="300" colspan="3" bgColor=#f8f9fc valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">              
              <tr> 
                <td align="center"><form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
				<table width="700" border="0" bgcolor="#9999FF" align="center" cellpadding="4" cellspacing="1">
  <tr>
    <td width="160" bgcolor="#FFFFFF">�Ƿ�رգ�</td>
    <td bgcolor="#FFFFFF" width="540"><label>
      <input type="radio" name="isclose" value="1" onClick="javascript:document.getElementById('close_notice').style.display='block';" <?php if($webset['isclose']) echo 'checked';?>>
    ��<input type="radio" name="isclose" value="0" onClick="javascript:document.getElementById('close_notice').style.display='none';" <?php if(!$webset['isclose']) echo 'checked';?>>
    ��</label>
	<input style="display:<?php echo ($webset['isclose'])?'block':'none';?>" type="text" size="60" name="close_notice" id="close_notice" value="<?=$webset['close_notice']?>" />	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">�Ƿ��ң�</td>
    <td bgcolor="#FFFFFF"><label>
      <input type="radio" name="isblank" value="1" <?php if($webset['isblank']) echo 'checked';?>>
    ��<input type="radio" name="isblank" value="0" <?php if(!$webset['isblank']) echo 'checked';?>>
    ��</label></td>
  </tr> 
 
 
  <!--tr>
    <td bgcolor="#FFFFFF">��̳���ID��</td>
    <td bgcolor="#FFFFFF"><label>
      <input type="input" name="bbs_fid" value="<?=$webset['bbs_fid']?>" >
    </label></td>
  </tr--> 
   <!--tr>
    <td bgcolor="#FFFFFF">��ҳ���������ʾ��</td>
    <td bgcolor="#FFFFFF"><label>
      <input type="radio" name="islink" value="1" <?php if($webset['islink']) echo 'checked';?>>
    ��<input type="radio" name="islink" value="0" <?php if(!$webset['islink']) echo 'checked';?>>
    ��</label></td>
  </tr-->  
  <tr>
    <td height="28" colspan="3" align="center" bgcolor="#FFFFFF"><input type="submit" name="submit" value="�ύ" id="submit" >��
      <input type="reset" name="Submit2" value="����"></td>
  </tr>
</table> 
                </form>

				</td>
              </tr>
            </table>
			</TD>
		  </tr>
          </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>

