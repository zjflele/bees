<?php
	include("../../include/include.php");
	$obj = new EasyDB("picture");	
	if ($_GET['ptype']){		
	    $obj->AddSession("bees_picture_type",intval($_GET['ptype'])); 
	}
	$ptype = ($_GET['ptype'])?intval($_GET['ptype']):intval($_SESSION["bees_picture_type"]);
	if(@$_GET["action"]=="del" && @$_GET["id"])
	{
		$obj = new EasyDB(picture);
		$obj->IDVars="id";
		$obj->SetLimit(1);
		$ninfo = getrow("select title from ".TABLEPRE."picture where id=".$_GET['id']);
		if($obj->Delete())
		{
			$js=new Javascript();
			$js->Begin();
			$js->Alert("删除信息成功!");
			$js->GoToUrl($_SERVER["PHP_SELF"]);
			$js->End();
		}
		else
		{
			Error("删除信息失败。", $_SERVER["PHP_SELF"]);
		}
		exit();
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
	
	if(@$_GET["action"]=="edit")
	{
		
		if ($_POST){		
			//处理上传图片
			if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=="image/gif")
			{	
				  if ($_FILES['upfile']['type']=="image/gif")
					{$l_name=".gif";}
				  if ($_FILES['upfile']['type']=="image/pjpeg" || $_FILES['upfile']['type']=="image/jpeg")
					{$l_name=".jpg";}
		
				// 构造文件名
				$ff=$HTTP_REFERER;
				$datetime = date("YmdHis");
				$imagename=$datetime.$l_name;
				if (!file_exists("../../upload/a_photo")){
					mkdir("../../upload/a_photo",0777);
				}
				$filename = "../../upload/a_photo/".$imagename;
				$s_filename = "../../upload/a_photo/s_".$imagename;
				$b_filename = "../../upload/a_photo/b_".$imagename;
				//echo $upfile."<br>".$filename;exit;
				// 将文件存放到服务器
				if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
					{
						$upload_img="图片上传成功";
						$updfields = ",`imgpath` = '".$imagename."'";
						makethumb($filename,$b_filename,940,525);
						makethumb($filename,$s_filename,170,140);
					}
				
			}
			$pid = intval($_POST['pid']);
			$title = trim($_POST['title']);
			$description = trim($_POST['description']);
			$sql="UPDATE ".TABLEPRE."picture SET `title` = '".$title."',`description` = '".$description."'".$updfields." WHERE id=".$pid;	
			//print_r($_POST);exit;
			mysql_query($sql,$myconn);
			?>
			<script language=javascript>    
			 alert("图片修改成功！");
			</script>
			<?
		}else{
			$pid = intval($_REQUEST['pid']);
			$pinfo = getrow("select * from ".TABLEPRE."picture where id=".$pid);
			//print_r($pinfo);			
		}
	}
	if(@$_GET["action"]=="add")
	{
		
		if ($_FILES['upfile']['type']=="image/pjpeg" or $_FILES['upfile']['type']=="image/jpeg"  or $_FILES['upfile']['type']=="image/gif")
		{	
		  if ($_FILES['upfile']['type']=="image/gif")
			{$l_name=".gif";}
		  if ($_FILES['upfile']['type']=="image/pjpeg" || $_FILES['upfile']['type']=="image/jpeg")
			{$l_name=".jpg";}

	// 构造文件名
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
	// 将文件存放到服务器
	if (move_uploaded_file($_FILES['upfile']['tmp_name'],$filename))
		{$upload_img="图片上传成功";}
		//chmod($filename, 0777);//设定上传的文件的属性
		makethumb($filename,$b_filename,940,525);
		makethumb($filename,$s_filename,170,140);
	$updtime=date("Y-m-d H:i:s");	
	$title = trim($_POST['title']);
	$description = trim($_POST['description']);
	$siteid = $_SESSION['bees_SiteId'];
	$userid=$_SESSION["bees_UserId"];
	$sql="insert into ".TABLEPRE."picture ( `title` ,`imgpath` , `description`,`ptype` ,`userid`,`siteid`,`updtime`, `showtime`)VALUES ( '$title','$imagename','$description','$ptype','$userid','$siteid','$updtime','$updtime')";
	//echo $sql;
	$myrs=mysql_query($sql,$myconn);
	if ($myrs)
	{
	?>
	<script language=javascript>    
     alert("图片上传成功！");
     window.location="pic_manage.php";
    </script>
	<?
	}
	}else { ?>
	<script language=javascript>    
     alert("照片格式支持.gif和.jpg的文件！")
    </script>
	<? }	
	}
	$swhere = ($_SESSION['bees_SiteId'])? " and siteid=".$_SESSION['bees_SiteId']:'';
	$sqlstr_tt="select * from ".TABLEPRE."picture where ptype=".$ptype.$swhere;	
	if ($suserid<>"")
		$sqlstr_tt.=" and userid = ".intval($suserid);	
	$sqlstr_tt.=" order by istop desc, showtime asc";
	//echo $sqlstr_tt;
	$myrs_tt=mysql_query($sqlstr_tt);
	$rec_tt=mysql_num_rows($myrs_tt);
	$i=$rec_tt;
//------------分页设置------------------
    $pagesize=20;
    if (empty($currentpage)) $currentpage=1;
    $filename=$PHP_SELF."?1=1&suserid=".$suserid;
    $totalpage=ceil($i/$pagesize);
    if ($totalpage<$currentpage)
    $currentpage = $totalpage;
    $offset=($currentpage-1)*$pagesize;
    $offend=$offset+20;
//-----------分页设置----------
    $sqlstr=$sqlstr_tt." limit $offset,$pagesize";	
	//echo $sqlstr;
    $myrs_tt=mysql_query($sqlstr);
	
//-----------用户信息列表----------
	$arrUserList = getUserList();
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
    <TD>
      <TABLE class=tableout cellSpacing=1 cellPadding=6 width="98%" align=center 
      border=0>
        <TBODY>
		<?php if ($pinfo) {?>
			<form enctype="multipart/form-data" name="form" method="post" action="pic_manage.php?action=edit">
			<TR class=header align=left>
			  <TD colspan="2" rowspan="2">图片赏析管理</TD>
			  <TD width="91%" valign="top">标题：<input type="text" name="title" size="20" value="<?=$pinfo['title']?>">
				图片：<input type="file" name="upfile" size="40">
                <input type="submit" name="Submit" value="上传" style="width:80px;">
               			
				<input name="pid" type="hidden" value="<?=$pinfo['id']?>">
						   　
				  </TD>
			  </TR>
              </form>
        <?php } else {?>
        	<form enctype="multipart/form-data" name="form" method="post" action="pic_manage.php?action=add">
			<TR class=header align=left>
			  <TD colspan="2" rowspan="2">图片赏析管理</TD>
			  <TD width="91%" valign="top">标题：<input type="text" name="title" size="20" value="">
				图片：<input type="file" name="upfile" size="40">
                <input type="submit" name="Submit" value="上传" style="width:80px;">
               							   　
				  </TD>
			  </TR>
              </form>
        <?php }?>
              
        <TR class=header align=left>
          <TD width="91%" valign="top">
         <form name="form1" method="post" action="<?=$_SERVER["PHP_SELF"]?>"> 
		<?php if (!$_SESSION['bees_SiteId']){ ?>
           发布者：
           <select name="suserid" id="suserid">
		   <option value='' selected>请选择用户</option>
		   <? 
		   foreach ($arrUserList as $k => $v){
			   	$selected = ($suserid == $v['userid'])?'selected':'';
		   		echo "<option value='".$v['userid']."' $selected>".$v['zname']."</option>";			
		   }?>
		   </select>
           <input type="submit" name="Submit" value="查询" style="width:80px;">
            <?php }?>
           <form>
           </TD>
			  </TR>
             
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
	$imagepath="../../upload/a_photo/".$rec["imgpath"];
   echo "<td width=17% valign=top>";
   echo "<div align=center><a href='/list_pic.php?action=show&id=".$rec["id"]."' target=_blank><img src=$image_path alt=$image_path border=0 width=180 height=120></a>";
   echo "<br>"; 
   echo $rec[title];
   echo "<br>"; 
   if ($rec['istop']){
	   echo "<a title=取消置顶 href='pic_manage.php?action=notop&pid=$rec[id]'>取消置顶</a>|";
   }else{
		echo "<a title=置顶 href='pic_manage.php?action=top&pid=$rec[id]'>置顶</a>|";   
	}
   echo "<a title='修改' href='pic_manage.php?action=edit&pid=$rec[id]'>修改</a>|<a title=删除 href='pic_manage.php?action=del&id=$rec[id]'>删除</a><br>"; 
   echo "</div></td>";
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
			<? } else { echo "没有信息";}?>
<?
//开始构建分页显示------------------------------------------------------ 
$start=$currentpage*$pagesize; 
$n=$totalpage;
 echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";
 echo "<form method=Post action=$filename ><tr><td align=right height=25>";
 echo "查询结果：<b><font color=#ff0000>$i</font></b>个 ";
  if ($currentpage<2 )
    echo "首页 上一页 ";
  else
    echo "<a href=".$filename."&&currentpage=1>首页</a> <a href=".$filename."&&currentpage=".($currentpage-1).">上一页</a>  ";
  if ($n-$currentpage<1)
    echo " 下一页 尾页 ";
  else
    echo " <a href=".$filename."&&currentpage=".($currentpage+1).">下一页</a> <a href=".$filename."&&currentpage=$n>尾页</a> ";

   echo  "<strong><font color=#ff0000>$currentpage</font>/$n</strong>页  ";
   echo  "<b><font color=#ff0000>$pagesize</font></b>个/页 ";
   echo  " 转到：<input type='text' name='currentpage' size=2 maxlength=10 class=smallInput value='$currentpage'>";
   echo  "&nbsp;<input class=buttonface type='submit'  value='Go'  name='cndok'></td></tr></form></table>";
?>			
		  </TD>
		  </tr>
          <td width="13%"></TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
</body>
</html>
