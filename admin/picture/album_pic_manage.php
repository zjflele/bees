<?php
	include("../../include/include.php");
	$obj = new EasyDB("picture");	
	if ($_GET['ptype']){		
	    $obj->AddSession("bees_picture_type",intval($_GET['ptype'])); 
	}
	if ($_GET['aid']){		
	    $obj->AddSession("bees_picture_aid",intval($_GET['aid'])); 
	}
	$ptype = ($_GET['ptype'])?intval($_GET['ptype']):intval($_SESSION["bees_picture_type"]);
	$aid = ($_GET['aid'])?intval($_GET['aid']):intval($_SESSION["bees_picture_aid"]);
	if(@$_GET["action"]=="del" && @$_GET["id"])
	{
		$obj = new EasyDB(picture);
		$obj->IDVars="id";
		$obj->SetLimit(1);
		if($obj->Delete())
		{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("ɾ����Ϣ�ɹ�!");
			$js->GoToUrl($_SERVER["PHP_SELF"]);
			$js->End();
		}
		else
		{
			Error("ɾ����Ϣʧ�ܡ�", $_SERVER["PHP_SELF"]);
		}
		exit();
	}
	if(@$_GET["action"]=="edit")
	{
		if ($_POST['pid']){
			if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=="image/gif")
			{
				if ($_FILES['upfile']['type']=="image/gif"){$l_name=".gif";}
	   			if ($_FILES['upfile']['type']=="image/pjpeg" || $_FILES['upfile']['type']=="image/jpeg"){$l_name=".jpg";}
				// �����ļ���
				$ff=$HTTP_REFERER;
				$datetime = date("YmdHis");
				$imagename=$datetime.$l_name;
				if (!file_exists("../../upload/a_photo")){
					mkdir("../../upload/a_photo",0777);
				}
				$filename = "../../upload/a_photo/".$imagename;
				$b_filename = "../../upload/a_photo/b_".$imagename;
				$s_filename = "../../upload/a_photo/s_".$imagename;
				// ���ļ���ŵ�������
				if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename)){
					$upload_img="ͼƬ�ϴ��ɹ�";
					makethumb($filename,$b_filename,940,525);
					makethumb($filename,$s_filename,155,100);
				}
				$imgUpdSql = ",`imgpath` = '".$imagename."'";
				
			}
			$pid = $_POST['pid'];
			$title = $_POST['title'];
			$description = trim($_POST['description']);
			$updtime=date("Y-m-d H:i:s");
			$sql="UPDATE ".TABLEPRE."picture SET `title` = '".$title."',`description` = '".$description."',`updtime` = '".$updtime."'{$imgUpdSql} WHERE id=".$pid;	
			//echo $sql;exit;
			$myrs=mysql_query($sql,$myconn);
		}else{
			$pinfo = getrow("select * from ".TABLEPRE."picture where id=".intval($_REQUEST['pid']));	
		}
	}
	
	if(@$_GET["action"]=="top" && @$_GET["pid"])
	{
				
			$sql="UPDATE ".TABLEPRE."picture SET `istop` = 1  WHERE id=".intval($_REQUEST['pid']);	
			mysql_query($sql,$myconn);			
		
	}
	
	if(@$_GET["action"]=="notop" && @$_GET["pid"])
	{
				
			$sql="UPDATE ".TABLEPRE."picture SET `istop` = 0  WHERE id=".intval($_REQUEST['pid']);	
			mysql_query($sql,$myconn);			
		
	}
	
	if(@$_GET["action"]=="add")
	{
	//print_r($_FILES);exit;
	if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=="image/gif")
	{	
	  	if ($_FILES['upfile']['type']=="image/gif"){$l_name=".gif";}
	   	if ($_FILES['upfile']['type']=="image/pjpeg" || $_FILES['upfile']['type']=="image/jpeg"){$l_name=".jpg";}

		// �����ļ���
		$ff=$HTTP_REFERER;
		$datetime = date("YmdHis");
		$imagename=$datetime.$l_name;
		if (!file_exists("../../upload/a_photo")){
			mkdir("../../upload/a_photo",0777);
		}
		$filename = "../../upload/a_photo/".$imagename;
		$b_filename = "../../upload/a_photo/b_".$imagename;
		$s_filename = "../../upload/a_photo/s_".$imagename;
		//echo $upfile."<br>".$filename;exit;
		// ���ļ���ŵ�������
		if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename)){
			$upload_img="ͼƬ�ϴ��ɹ�";
			//chmod($filename, 0777);//�趨�ϴ����ļ�������
			makethumb($filename,$b_filename,940,525);
			makethumb($filename,$s_filename,155,100);
		}
			
		$updtime=date("Y-m-d H:i:s");	
		$title = $_POST['title'];
		//echo $filename;exit;
		$sql="insert into ".TABLEPRE."picture ( `title` ,`imgpath` ,`aid`,`ptype`,`description`, `updtime`, `showtime`)VALUES ( '$title','$imagename','$aid','$ptype','$description','$updtime','$updtime')";
		//echo $sql;exit;
		$myrs=mysql_query($sql,$myconn);
		if ($myrs)
		{
		?>
		<script language=javascript>    
		 alert("ͼƬ�ϴ��ɹ���");
		 //window.location="album_pic_manage.php";
		</script>
		<?
		}
	}else { ?>
	<script language=javascript>    
     alert("��Ƭ��ʽ֧��.gif��.jpg���ļ���")
    </script>
	<? }	
	}
	$arrAlbums = getList("select aid,title from ".TABLEPRE."album order by updtime desc");
	foreach ($arrAlbums as $k => $album){
		$arrAlbum[$album['aid']] = $album['title'];	
	}
	$selectAlbum = CreateSelect('aid',$arrAlbum,$aid);
	$sqlstr_tt="select * from ".TABLEPRE."picture where ptype=$ptype and aid=$aid ";	
	$sqlstr_tt.=" order by istop desc, showtime asc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------��ҳ����------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?1=1&ptype={$ptype}&aid={$aid}";
    $totalpage=ceil($i/$pagesize);
    if ($totalpage<$currentpage)
    $currentpage = $totalpage;
    $offset=($currentpage-1)*$pagesize;
    $offend=$offset+20;
//-----------��ҳ����----------
    $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
	//echo $sqlstr;
    $myrs_tt=mysql_query($sqlstr);
	
    $albumInfo = getrow('select * from '.TABLEPRE.'album where aid='.$aid);
	


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
    <TD>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY>
        <?php if ($pinfo){?>
        <form enctype="multipart/form-data" name="form" method="post" action="album_pic_manage.php?action=edit">
        <TR class=header align=left>
          <TD colspan="2"><?=$albumInfo['title']?>����</TD>
		  <TD width="91%" >                      
                  ���⣺<input type="text" name="title" size="20"  value="<?=$pinfo['title']?>">
		  ͼƬ��<input type="file" name="upfile" size="40">��
		    <input type="submit" name="Submit" value="�޸�">		   ��		<br />
				������<br /><textarea name="description" cols="160" rows="10"><?=$pinfo['description']?></textarea>
                <input name="pid" type="hidden" value="<?=$pinfo['id']?>">
		   	  </TD>
          </TR> 
          </form>
         <?php }else{?>
        <form enctype="multipart/form-data" name="form" method="post" action="album_pic_manage.php?action=add&ptype=<?=$ptype?>&aid=<?=$aid?>">
        <TR class=header align=left>
          <TD colspan="2"><?=$albumInfo['title']?>����</TD>
		  <TD width="91%" >                      
                  ���⣺<input type="text" name="title" size="20">
		  ͼƬ��<input type="file" name="upfile" size="40">��
		    <input type="submit" name="Submit" value="�ϴ�">		   ��		<br />
				������<br /><textarea name="description" cols="160" rows="10"></textarea>
		   	  </TD>
          </TR> 
          </form>
          <?php }?>
        <TR>
          <TD height="543" colspan="3" valign="top" bgColor=#f8f9fc>
<?
   if ($i != 0)  //--------------if01--------------------
{
   $myrs_qq=mysql_query($sqlstr,$myconn);
   //echo $sqlstr2;
   $ii=$offset+1;
   $n=1;
?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr> 
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="word-break:break-all;" class="tableout">
<tr><td bgcolor="#DDE3EC">
<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#FFFFFF" border="1">
                                              <tr bgcolor="#ffffff"> 
                                                <?
   
   while ($rec=@mysql_fetch_array($myrs_qq))
   {
	$image_path="../../upload/a_photo/s_".$rec["imgpath"];
   echo "<td width=17% valign=top>";
   echo "<form name=\"formedit\" method=\"post\" action=\"album_pic_manage.php?action=edit\">
   <input type='hidden' name='pid' id='pid' value='".$rec['id']."'>
   <div align=center><img src=$image_path alt=$image_path border=0 width=180 height=120>";
   echo "<br>"; 
   //echo "���⣺<input type='text' size=12 name='title' id='title' value='".$rec["title"]."'>";
   //echo "<br>"; 
   //echo "��᣺".$selectAlbum;
   //echo "<br>"; 
   echo $rec["title"]."<br />";
    if ($rec['istop']){
	   echo "<a title=ȡ���ö� href='album_pic_manage.php?action=notop&ptype={$ptype}&aid={$aid}&pid=$rec[id]'>ȡ���ö�</a>|";
   }else{
		echo "<a title=�ö� href='album_pic_manage.php?action=top&ptype={$ptype}&aid={$aid}&pid=$rec[id]'>�ö�</a>|";   
	}
   echo "<a title='�޸�' href='album_pic_manage.php?action=edit&ptype={$ptype}&aid={$aid}&pid=$rec[id]'>�޸�</a>|<a title=ɾ�� href='album_pic_manage.php?action=del&ptype={$ptype}&aid={$aid}&id=$rec[id]'>ɾ��</a>";
   
   echo "</div></form></td>";
  if ($n%4==0)
  echo "</tr><tr bgcolor=#ffffff>";
  $n=$n+1;
  }
  @mysql_free_result($myrs_qq);
?>
                                              </tr>
                                            </table>

</td></tr></table>  </td>
              </tr>
            </table>
				</td>
              </tr>
            </table>
			<? } else { echo "û����Ϣ";}?>
<?
//��ʼ������ҳ��ʾ------------------------------------------------------ 
$start=$currentpage*$pagesize; 
$n=$totalpage;
 echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";
 echo "<form method=Post action=$filename ><tr><td align=right height=25>";
 echo "��ѯ�����<b><font color=#ff0000>$i</font></b>�� ";
  if ($currentpage<2 )
    echo "��ҳ ��һҳ ";
  else
    echo "<a href=".$filename."&&currentpage=1>��ҳ</a> <a href=".$filename."&&currentpage=".($currentpage-1).">��һҳ</a>  ";
  if ($n-$currentpage<1)
    echo " ��һҳ βҳ ";
  else
    echo " <a href=".$filename."&&currentpage=".($currentpage+1).">��һҳ</a> <a href=".$filename."&&currentpage=$n>βҳ</a> ";

   echo  "<strong><font color=#ff0000>$currentpage</font>/$n</strong>ҳ  ";
   echo  "<b><font color=#ff0000>$pagesize</font></b>��/ҳ ";
   echo  " ת����<input type='text' name='currentpage' size=2 maxlength=10 class=smallInput value='$currentpage'>";
   echo  "&nbsp;<input class=buttonface type='submit'  value='Go'  name='cndok'></td></tr></form></table>";
?>			
		  </TD>
		  </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
