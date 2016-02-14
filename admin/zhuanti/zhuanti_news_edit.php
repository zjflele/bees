<?php
	include("../../include/include.php");
	checklogin();
	include("../../include/fckeditor/fckeditor.php") ;
	set_magic_quotes_runtime(0);
if ($_POST['action']=='edit')
{
	 $title = trim($_POST['title']);	
	 $sid = intval($_POST['sid']);	 	 
	 $stype = intval($_POST['stype']);
	 $is_main = intval($_POST['is_main']);	
	 $ntype = intval($_POST['ntype']);	
	 $display = intval($_POST['display']);	
	
	 if ($ntype)
			$content = trim($_POST['art_id']);
	else
	 		$content = trim($_POST['content']);
	
	//print_r($_FILES);
	if ($_FILES['picture']['type']=="image/pjpeg" or $_FILES['picture']['type']=="image/jpeg" or $_FILES['picture']['type']=="image/gif"){
	
			if ($_FILES['picture']['type']=="image/pjpeg" or $_FILES['picture']['type']=="image/jpeg")
				{
					$l_name=".jpg";	
				}
			if ($_FILES['picture']['type']=="image/gif")
				{	
					$l_name=".gif";	
				}
			$new_name=time().$l_name;
			// 构造文件名		
			$filename="../../upload/zhuanti/".$new_name;
			if (!@move_uploaded_file($_FILES['picture']['tmp_name'],$filename))
			{		
				$xiaoxi="上传文件失败！";										
			}	
			$picture = $new_name;
	}	
	
	if ($content) $sets .= ",`content` = '$content'";
	if ($picture) $sets .= ",`picture` = '$picture'";
	$sql="UPDATE `".TABLEPRE."zhuanti_news` SET `title` = '$title',`is_main` = '$is_main',`display` = '$display',`ntype` = '$ntype' $sets WHERE  `nid` = '$nid'";
	 $myrs=mysql_query($sql,$myconn);
	 $vid = mysql_insert_id();
	

// ------------------------- 进行校验 ------------------------------------
  if (!$myrs) {
?>
<script language=javascript>
     history.back()
     alert("修改失败！")
</script>
<?
    exit();
  }
  else {
?>
<script language=javascript>
    alert('修改成功');
    location.href="zhuanti_news.php?id=<?=$id?>";
</script>
<?
  }
}
	if(@$_GET["id"])
	{
		//获取专题名称
		$zhuanti_name = GetValueFromTable('title',TABLEPRE.'zhuanti',"id=".intval($_GET["id"]));	
	}
	
	if(@$_GET["nid"])
	{
		//获取内容
		$zhuanti_news_sql = "select n.*,s.stype,s.sname from ".TABLEPRE."zhuanti_news n left join ".TABLEPRE."zhuanti_sort s on n.sid=s.sid where n.nid=".intval($_GET["nid"]);
		$zhuanti_news_myrs = mysql_query($zhuanti_news_sql,$myconn);
		$arrNew = mysql_fetch_array($zhuanti_news_myrs);
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
          <TD colspan="3"><?=$zhuanti_name?>--专题内容修改</TD>
          </TR>
        <TR>
          <TD height="500" colspan="3" bgColor=#f8f9fc valign="top">
		  <table width="98%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#9999FF">
                    <form action="zhuanti_news_edit.php?id=<?=intval($_GET['id'])?>" method="post" enctype="multipart/form-data" name="form">
					<tr bgcolor="#FFFFFF">
                        <td width="109">所属分类：</td>
                        <td width="1023">
						<?=$arrNew['sname'];?>						</td>
                      </tr>
					  <tr bgcolor="#FFFFFF">
                        <td width="109">标题：</td>
                        <td><input name="title" type="text" id="title" size="50" value="<?=$arrNew['title'];?>"></td>
                      </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td width="109">排序号：</td>
                        <td><input name="display" type="text" id="display" size="25"  value="<?=$arrNew['display'];?>"></td>
                      </tr>	
					 
						  <? if ($arrNew["picture"]!=""){ ?>
						  <tr bgcolor="#FFFFFF">
							<td colspan="2">  
							<? 
								echo "当前为：".$arrNew['picture']."&nbsp;&nbsp;&nbsp;&nbsp;";
								echo "<a href='../../upload/zhuanti/".$arrNew['picture']."' border=0 target='_blank'>[预览]</a><br>";
							?>
							</td>
						  </tr>
						  <? }?>			  
					  <tr bgcolor="#FFFFFF">
                        <td width="109">上传图片：</td>
                        <td><label>
                          <input type="file" name="picture">
                        </label></td>
					  </tr>	
					  <!--tr bgcolor="#FFFFFF">
                        <td width="109">是否显示在主栏：</td>
                        <td><label>
                          <input type="radio" name="is_main" id="is_main" value="1" <? if ($arrNew['is_main']) echo "checked";?>>是
						  <input type="radio" name="is_main" id="is_main" value="0" <? if (!$arrNew['is_main']) echo "checked";?>> 否
                        </label></td>
					  </tr-->	
					  
					   <?php if ($arrNew['stype']!=4) {?>	
					  <tr bgcolor="#FFFFFF">
                        <td width="109" valign="top">内容填写方式：</td>
                        <td><label>
                        <input type="radio" name="ntype" id="ntype" value="1" onClick="javascript:document.getElementById('show_id').style.display='block';document.getElementById('show_area').style.display='none';" <?php if ($arrNew['ntype']) echo 'checked';?>>文章ID号
                            <input type="radio" name="ntype" id="ntype" value="0" onClick="javascript:document.getElementById('show_id').style.display='none';document.getElementById('show_area').style.display='block';" <?php if (!$arrNew['ntype']) echo 'checked';?>>编辑器
                        </label>
						<div  id="show_id" style="display:<?php if ($arrNew['ntype']) echo 'block'; else echo 'none';?>">
					  <input name="art_id" type="text" id="art_id" size="20" value="<? if ($arrNew['ntype']) echo $arrNew['content'];?>">
					  </div>
						</td>
					  </tr>
					   <tr bgcolor="#FFFFFF">
                         <td colspan="2">		  
					  <div  id="show_area" style="display:<?php if ($arrNew['ntype']) echo 'none'; else echo 'block';?>">
					  <?php
					  	if (!$arrNew['ntype']) 
						$content = $arrNew['content'];
						$sBasePath = '/include/fckeditor/';
						$oFCKeditor = new FCKeditor('content') ;
						$oFCKeditor->BasePath	= $sBasePath ;
						$oFCKeditor->Height	= 500;
						$oFCKeditor->Value		= $content ;
						$oFCKeditor->Create() ;
						?>					  
					  </div>						
						</td>
                      </tr>
					  <?php }?>
					 					  
                      <tr bgcolor="#FFFFFF">
                        <td colspan="2" align="center">
						<input type="hidden" name="action" value="edit">
						<input type="hidden" name="nid" value="<?=$arrNew['nid']?>">
						<input type="hidden" name="stype" value="<?=$arrNew['stype']?>">
						<input type="submit" value="提交" name="b1">
                        <input type="reset" name="Submit22" value="重写">  
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
