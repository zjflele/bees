<?php
	include("../../include/include.php");
	checklogin();
	include("../../include/fckeditor/fckeditor.php") ;
	set_magic_quotes_runtime(0);
if ($_POST['action']=='add')
{
	 $title = trim($_POST['title']);	
	 $sid = intval($_POST['sid']);	 	 
	 $stype = intval($_POST['stype']);	
	 $is_main = intval($_POST['is_main']);	
	 $display = intval($_POST['display']);
	 $ntype = intval($_POST['ntype']);	
	 if (!$stype){
	 	if ($ntype)
			$content = trim($_POST['art_id']);
		else
	 		$content = trim($_POST['content']);
	 } else {	 		
		if ($_FILES['content']['type']=="image/pjpeg" or $_FILES['content']['type']=="image/jpeg" or $_FILES['content']['type']=="image/gif"){
	
			if ($_FILES['content']['type']=="image/pjpeg" or $_FILES['content']['type']=="image/jpeg")
				{
					$l_name=".jpg";	
				}
			if ($_FILES['content']['type']=="image/gif")
				{	
					$l_name=".gif";	
				}
			$new_name=time().$l_name;
			// 构造文件名		
			$filename="../../upload/zhuanti/".$new_name;
			if (!@move_uploaded_file($_FILES['content']['tmp_name'],$filename))
			{		
				$xiaoxi="上传文件失败！";										
			}	
			$content = $new_name;
		}	
	}
	 $sql="INSERT INTO `".TABLEPRE."zhuanti_news` (`nid` , `sid` ,`title` ,`content` ,`ntype` ,`is_main` ,`display` ,`addtime`) 
VALUES (NULL,'$sid','$title', '$content','$ntype','$is_main','$display','".date('Y-m-d H:i:s')."')";
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
?>
<script language=javascript>
    alert('添加成功');
    location.href="zhuanti_news.php?id=<?=$id?>";
</script>
<?
  }
}
	if(@$_GET["id"])
	{
		//获取专题名称
		$zhuanti_name = GetValueFromTable('title',TABLEPRE.'zhuanti',"id=".intval($_GET["id"]));
		//获取专题分类
		$arrSortList[0] = '请先选择分类';
		$zhuanti_sort_sql = "select sid,sname from ".TABLEPRE."zhuanti_sort where isshow=1";
		$zhuanti_sort_myrs = mysql_query($zhuanti_sort_sql,$myconn);
		while($row = mysql_fetch_array($zhuanti_sort_myrs)){
			$arrSortList[$row['sid']] = $row['sname']; 
		}		
	}
	
	if(@$_GET["sid"])
	{
		//获取分类类型
		$stype = GetValueFromTable('stype',TABLEPRE.'zhuanti_sort',"sid=".intval($_GET["sid"]));	
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
          <TD colspan="3"><?=$zhuanti_name?>--专题内容添加</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form action="zhuanti_news_add.php?id=<?=intval($_GET['id'])?>" method="post" enctype="multipart/form-data" name="form">
					<tr bgcolor="#FFFFFF">
                        <td width="23%">请先选择分类：</td>
                        <td width="77%">
						<select name="sid" id="sid" onChange="javascript:window.location.href='zhuanti_news_add.php?id=<?=intval($_GET['id'])?>&sid='+this.value;">
							<?php
								echo CreateSelectOption($arrSortList);
							?>
						</select>
						<script language="javascript">
							document.getElementById('sid').value='<?=intval($_GET['sid'])?>';
						</script>
						</td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="23%">标题：</td>
                        <td width="77%"><input name="title" type="text" id="title" size="50"></td>
                      </tr>	
					  <?php if ($stype) {?>				  
					  <tr bgcolor="#FFFFFF">
                        <td width="23%">上传图片：</td>
                        <td width="77%"><label>
                          <input type="file" name="content">
                        </label></td>
					  </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="23%">是否显示在主栏：</td>
                        <td width="77%"><label>
                          <input type="radio" name="is_main" id="is_main" value="1">是
						  <input type="radio" name="is_main" id="is_main" value="0" checked>否
                        </label></td>
					  </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td width="23%">排序号：</td>
                        <td width="77%"><input name="display" type="text" id="display" size="25"></td>
                      </tr>	
					  <?php }else{?>
					  
					   <tr bgcolor="#FFFFFF">
                        <td width="23%" valign="top">内容：
						 <input type="radio" name="ntype" id="ntype" value="1" onClick="javascript:document.getElementById('show_id').style.display='block';document.getElementById('show_area').style.display='none';" checked>ID号
						  <input type="radio" name="ntype" id="ntype" value="0" onClick="javascript:document.getElementById('show_id').style.display='none';document.getElementById('show_area').style.display='block';" >编辑器
                         </td>
                        <td width="77%">
					  <div  id="show_id" style="display:block">
					  <input name="art_id" type="text" id="art_id" size="50">
					  </div>					  
					  <div  id="show_area" style="display:block">
					   <?php
						$sBasePath = '/include/fckeditor/';
						$oFCKeditor = new FCKeditor('content') ;
						$oFCKeditor->BasePath	= $sBasePath ;
						$oFCKeditor->Value		= '' ;
						$oFCKeditor->Create() ;
						?>
					  </div>
						</td>
					  </tr>	
					  				 
					  <?php }?>					 					  
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center">
						<input type="hidden" name="action" value="add">
						<input type="hidden" name="stype" value="<?=$stype?>">
						<?php if ($_GET['sid']) {?>
						<input type="submit" value="提交" name="b1">
                        <input type="reset" name="Submit22" value="重写">  
						<?php }?>                      
						</td>
                      </tr>
                    </form>
              </table>		  </TD>
		  </tr>
        </TBODY></TABLE>
  <TR bgColor=#ffffff>
    <TD align=middle><BR><BR>      <BR></TD></TR></TBODY></TABLE>
				   
</body>
</html>
